<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    // Show Add Stock Form
    public function showAddForm()
    {
        $items = InventoryItem::orderBy('item_name')->get();
        return view('stock.add', compact('items'));
    }

    // Add Stock
    public function add(Request $request)
    {
        $validated = $request->validate([
            'inventory_item_id' => 'required|exists:inventory_items,id',
            'quantity' => 'required|integer|min:1',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $item = InventoryItem::findOrFail($validated['inventory_item_id']);
            
            // Update inventory quantity
            $item->quantity += $validated['quantity'];
            $item->save();

            // Create transaction record
            StockTransaction::create([
                'inventory_item_id' => $item->id,
                'user_id' => Auth::id(),
                'transaction_type' => 'add',
                'quantity' => $validated['quantity'],
                'balance_after' => $item->quantity,
                'reference_number' => $validated['reference_number'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'status' => 'completed',
            ]);

            DB::commit();
            return redirect()->route('inventory.index')
                ->with('success', 'Stock added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to add stock: ' . $e->getMessage());
        }
    }

    // Show Consume Stock Form
    public function showConsumeForm()
    {
        $items = InventoryItem::where('quantity', '>', 0)->orderBy('item_name')->get();
        return view('stock.consume', compact('items'));
    }

    // Consume Stock
    public function consume(Request $request)
    {
        $validated = $request->validate([
            'inventory_item_id' => 'required|exists:inventory_items,id',
            'quantity' => 'required|integer|min:1',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $item = InventoryItem::findOrFail($validated['inventory_item_id']);
            
            // Check if sufficient stock available
            if ($item->quantity < $validated['quantity']) {
                return back()->with('error', 'Insufficient stock available!');
            }

            // Update inventory quantity
            $item->quantity -= $validated['quantity'];
            $item->save();

            // Create transaction record
            StockTransaction::create([
                'inventory_item_id' => $item->id,
                'user_id' => Auth::id(),
                'transaction_type' => 'consume',
                'quantity' => $validated['quantity'],
                'balance_after' => $item->quantity,
                'reference_number' => $validated['reference_number'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'status' => 'completed',
            ]);

            DB::commit();
            return redirect()->route('inventory.index')
                ->with('success', 'Stock consumed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to consume stock: ' . $e->getMessage());
        }
    }

    // Show Transfer Stock Form
    public function showTransferForm()
    {
        $items = InventoryItem::where('quantity', '>', 0)->orderBy('item_name')->get();
        return view('stock.transfer', compact('items'));
    }

    // Transfer Stock
    public function transfer(Request $request)
    {
        $validated = $request->validate([
            'inventory_item_id' => 'required|exists:inventory_items,id',
            'quantity' => 'required|integer|min:1',
            'transfer_to' => 'required|string|max:255',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $item = InventoryItem::findOrFail($validated['inventory_item_id']);
            
            // Check if sufficient stock available
            if ($item->quantity < $validated['quantity']) {
                return back()->with('error', 'Insufficient stock available for transfer!');
            }

            // Update inventory quantity
            $item->quantity -= $validated['quantity'];
            $item->save();

            // Create transfer out transaction
            StockTransaction::create([
                'inventory_item_id' => $item->id,
                'user_id' => Auth::id(),
                'transaction_type' => 'transfer_out',
                'quantity' => $validated['quantity'],
                'balance_after' => $item->quantity,
                'transfer_from' => Auth::user()->hospital_name ?? 'Current Location',
                'transfer_to' => $validated['transfer_to'],
                'reference_number' => $validated['reference_number'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'status' => 'pending',
            ]);

            DB::commit();
            return redirect()->route('stock.transfers')
                ->with('success', 'Transfer request created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create transfer: ' . $e->getMessage());
        }
    }

    // View Transfer History
    public function transfers()
    {
        $transfers = StockTransaction::with(['inventoryItem', 'user'])
            ->where('transaction_type', 'transfer')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('stock.transfers', compact('transfers'));
    }
}
