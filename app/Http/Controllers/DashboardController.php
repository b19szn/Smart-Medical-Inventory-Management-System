<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\Alert;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $totalItems = InventoryItem::count();
        $lowStockItems = InventoryItem::lowStock()->count();
        $expiringItems = InventoryItem::expiring(30)->count();
        $expiredItems = InventoryItem::expired()->count();
        $totalValue = InventoryItem::sum(DB::raw('quantity * unit_price'));
        
        // Get recent alerts
        $recentAlerts = Alert::with('inventoryItem')
            ->unread()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Get critical stock items (ICU/ER)
        $criticalItems = InventoryItem::critical()
            ->orderBy('quantity', 'asc')
            ->limit(10)
            ->get();
        
        // Get recent transactions
        $recentTransactions = StockTransaction::with(['inventoryItem', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Stock by category for chart
        $stockByCategory = InventoryItem::select('category', DB::raw('SUM(quantity) as total'))
            ->groupBy('category')
            ->get();
        
        // Monthly consumption trend (last 6 months)
        $consumptionTrend = StockTransaction::where('transaction_type', 'consume')
            ->where('created_at', '>=', now()->subMonths(6))
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(quantity) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        // Low stock alerts by severity
        $alertsBySeverity = Alert::select('severity', DB::raw('COUNT(*) as count'))
            ->unread()
            ->groupBy('severity')
            ->get();

        return view('dashboard', compact(
            'totalItems',
            'lowStockItems',
            'expiringItems',
            'expiredItems',
            'totalValue',
            'recentAlerts',
            'criticalItems',
            'recentTransactions',
            'stockByCategory',
            'consumptionTrend',
            'alertsBySeverity'
        ));
    }
}
