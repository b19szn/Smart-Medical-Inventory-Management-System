<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    // List all inventory items
    public function index(Request $request)
    {
        $query = InventoryItem::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('item_name', 'like', "%{$search}%")
                  ->orWhere('item_code', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by stock status
        if ($request->filled('stock_status')) {
            if ($request->stock_status === 'low') {
                $query->lowStock();
            } elseif ($request->stock_status === 'expiring') {
                $query->expiring(30);
            } elseif ($request->stock_status === 'expired') {
                $query->expired();
            } elseif ($request->stock_status === 'critical') {
                $query->critical();
            }
        }

        $items = $query->orderBy('item_name')->paginate(20);
        $categories = InventoryItem::distinct()->pluck('category');

        return view('inventory.index', compact('items', 'categories'));
    }

    // Show create form
    public function create()
    {
        return view('inventory.create');
    }

    // Store new inventory item
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'item_code' => 'required|string|max:255|unique:inventory_items',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'unit_of_measure' => 'required|string|max:50',
            'quantity' => 'required|integer|min:0',
            'minimum_stock_level' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'supplier_name' => 'nullable|string|max:255',
            'batch_number' => 'nullable|string|max:255',
            'manufacturing_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after:manufacturing_date',
            'storage_location' => 'nullable|string|max:255',
            'is_critical' => 'boolean',
        ]);

        InventoryItem::create($validated);

        return redirect()->route('inventory.index')
            ->with('success', 'Inventory item created successfully!');
    }

    // Show single item
    public function show($id)
    {
        $item = InventoryItem::with(['stockTransactions.user', 'alerts'])
            ->findOrFail($id);
        
        return view('inventory.show', compact('item'));
    }

    // Show edit form
    public function edit($id)
    {
        $item = InventoryItem::findOrFail($id);
        return view('inventory.edit', compact('item'));
    }

    // Update inventory item
    public function update(Request $request, $id)
    {
        $item = InventoryItem::findOrFail($id);

        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'item_code' => 'required|string|max:255|unique:inventory_items,item_code,' . $id,
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'unit_of_measure' => 'required|string|max:50',
            'minimum_stock_level' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'supplier_name' => 'nullable|string|max:255',
            'batch_number' => 'nullable|string|max:255',
            'manufacturing_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after:manufacturing_date',
            'storage_location' => 'nullable|string|max:255',
            'is_critical' => 'boolean',
        ]);

        $item->update($validated);

        return redirect()->route('inventory.index')
            ->with('success', 'Inventory item updated successfully!');
    }

    // Delete inventory item
    public function destroy($id)
    {
        $item = InventoryItem::findOrFail($id);
        $item->delete();

        return redirect()->route('inventory.index')
            ->with('success', 'Inventory item deleted successfully!');
    }
}
