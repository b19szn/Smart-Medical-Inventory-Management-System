<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ExportController extends Controller
{
    // Show export center
    public function index()
    {
        return view('export.index');
    }

    // Export to PDF
    public function exportPDF(Request $request)
    {
        $type = $request->input('type', 'inventory');
        $data = $this->getExportData($type);

        // For now, we'll create a simple HTML that can be printed as PDF
        // In production, you'd use a library like DomPDF or Snappy
        
        $html = $this->generateHTML($data, $type);
        
        return Response::make($html, 200, [
            'Content-Type' => 'text/html',
            'Content-Disposition' => 'inline; filename="' . $type . '_report.html"'
        ]);
    }

    // Export to Excel (CSV format)
    public function exportExcel(Request $request)
    {
        return $this->exportCSV($request);
    }

    // Export to CSV
    public function exportCSV(Request $request)
    {
        $type = $request->input('type', 'inventory');
        $data = $this->getExportData($type);

        $filename = $type . '_export_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($data, $type) {
            $file = fopen('php://output', 'w');
            
            // Add headers based on type
            $headers = $this->getCSVHeaders($type);
            fputcsv($file, $headers);

            // Add data rows
            foreach ($data as $row) {
                fputcsv($file, $this->formatRowForCSV($row, $type));
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    // Get export data based on type
    private function getExportData($type)
    {
        switch ($type) {
            case 'inventory':
                return InventoryItem::all();
            
            case 'low_stock':
                return InventoryItem::lowStock()->get();
            
            case 'expiring':
                return InventoryItem::expiring(30)->get();
            
            case 'expired':
                return InventoryItem::expired()->get();
            
            case 'transactions':
                return StockTransaction::with(['inventoryItem', 'user'])
                    ->orderBy('created_at', 'desc')
                    ->get();
            
            case 'transfers':
                return StockTransaction::with(['inventoryItem', 'user'])
                    ->whereIn('transaction_type', ['transfer_out', 'transfer_in'])
                    ->orderBy('created_at', 'desc')
                    ->get();
            
            default:
                return InventoryItem::all();
        }
    }

    // Get CSV headers based on type
    private function getCSVHeaders($type)
    {
        if ($type === 'transactions' || $type === 'transfers') {
            return [
                'ID',
                'Date',
                'Item Name',
                'Transaction Type',
                'Quantity',
                'Balance After',
                'User',
                'Reference Number',
                'Notes'
            ];
        }

        return [
            'ID',
            'Item Code',
            'Item Name',
            'Category',
            'Quantity',
            'Unit',
            'Min Stock Level',
            'Unit Price',
            'Total Value',
            'Supplier',
            'Batch Number',
            'Expiry Date',
            'Storage Location'
        ];
    }

    // Format row for CSV export
    private function formatRowForCSV($row, $type)
    {
        if ($type === 'transactions' || $type === 'transfers') {
            return [
                $row->id,
                $row->created_at->format('Y-m-d H:i:s'),
                $row->inventoryItem->item_name ?? 'N/A',
                $row->transaction_type,
                $row->quantity,
                $row->balance_after,
                $row->user->name ?? 'N/A',
                $row->reference_number ?? '',
                $row->notes ?? ''
            ];
        }

        return [
            $row->id,
            $row->item_code,
            $row->item_name,
            $row->category,
            $row->quantity,
            $row->unit_of_measure,
            $row->minimum_stock_level,
            $row->unit_price,
            $row->quantity * $row->unit_price,
            $row->supplier_name ?? '',
            $row->batch_number ?? '',
            $row->expiry_date ? $row->expiry_date->format('Y-m-d') : '',
            $row->storage_location ?? ''
        ];
    }

    // Generate HTML for PDF export
    private function generateHTML($data, $type)
    {
        $title = ucfirst(str_replace('_', ' ', $type)) . ' Report';
        $date = date('Y-m-d H:i:s');

        $html = "<!DOCTYPE html>
<html>
<head>
    <title>{$title}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #2c3e50; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #3498db; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .header { margin-bottom: 20px; }
        .footer { margin-top: 20px; font-size: 12px; color: #7f8c8d; }
    </style>
</head>
<body>
    <div class='header'>
        <h1>Smart Medical Inventory System</h1>
        <h2>{$title}</h2>
        <p>Generated on: {$date}</p>
    </div>
    
    <table>
        <thead>
            <tr>";

        $headers = $this->getCSVHeaders($type);
        foreach ($headers as $header) {
            $html .= "<th>{$header}</th>";
        }

        $html .= "</tr></thead><tbody>";

        foreach ($data as $row) {
            $html .= "<tr>";
            $rowData = $this->formatRowForCSV($row, $type);
            foreach ($rowData as $cell) {
                $html .= "<td>{$cell}</td>";
            }
            $html .= "</tr>";
        }

        $html .= "</tbody></table>
    
    <div class='footer'>
        <p>© " . date('Y') . " Smart Medical Inventory System. All rights reserved.</p>
    </div>
</body>
</html>";

        return $html;
    }
}
