@extends('layouts.app')

@section('title', 'Inventory - Smart Medical Inventory')
@section('page-title', 'Inventory Management')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Inventory Items</h3>
        <a href="{{ route('inventory.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Item
        </a>
    </div>

    <div class="card-body">
        <!-- Search and Filter -->
        <form method="GET" action="{{ route('inventory.index') }}" class="mb-4">
            <div class="grid-3">
                <div class="form-group" style="margin-bottom: 0;">
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="Search by name, code, or category..." 
                           value="{{ request('search') }}">
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <select name="category" class="form-control">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <select name="stock_status" class="form-control">
                        <option value="">All Status</option>
                        <option value="low" {{ request('stock_status') === 'low' ? 'selected' : '' }}>Low Stock</option>
                        <option value="expiring" {{ request('stock_status') === 'expiring' ? 'selected' : '' }}>Expiring Soon</option>
                        <option value="expired" {{ request('stock_status') === 'expired' ? 'selected' : '' }}>Expired</option>
                        <option value="critical" {{ request('stock_status') === 'critical' ? 'selected' : '' }}>Critical (ICU/ER)</option>
                    </select>
                </div>
            </div>

            <div style="margin-top: 1rem; display: flex; gap: 0.5rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Search
                </button>
                <a href="{{ route('inventory.index') }}" class="btn btn-secondary">
                    <i class="fas fa-redo"></i> Reset
                </a>
            </div>
        </form>

        <!-- Inventory Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Item Code</th>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Min Level</th>
                        <th>Unit Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    <tr>
                        <td><strong>{{ $item->item_code }}</strong></td>
                        <td>
                            {{ $item->item_name }}
                            @if($item->is_critical)
                                <span class="badge badge-danger" style="margin-left: 0.5rem;">
                                    <i class="fas fa-heartbeat"></i> Critical
                                </span>
                            @endif
                        </td>
                        <td>{{ $item->category }}</td>
                        <td>
                            <strong>{{ $item->quantity }}</strong> {{ $item->unit_of_measure }}
                        </td>
                        <td>{{ $item->minimum_stock_level }}</td>
                        <td>৳{{ number_format($item->unit_price, 2) }}</td>
                        <td>
                            @if($item->is_expired)
                                <span class="badge badge-danger">Expired</span>
                            @elseif($item->is_expiring)
                                <span class="badge badge-warning">Expiring Soon</span>
                            @elseif($item->is_low_stock)
                                <span class="badge badge-warning">Low Stock</span>
                            @else
                                <span class="badge badge-success">Good</span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('inventory.show', $item->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('inventory.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('inventory.destroy', $item->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" data-confirm-delete>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 2rem; color: var(--text-light);">
                            No inventory items found. <a href="{{ route('inventory.create') }}">Add your first item</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($items->hasPages())
        <div class="pagination">
            {{ $items->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
