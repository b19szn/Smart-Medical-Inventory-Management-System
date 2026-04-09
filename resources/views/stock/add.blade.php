@extends('layouts.app')

@section('title', 'Add Stock - Smart Medical Inventory')
@section('page-title', 'Add Stock')

@section('content')
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header">
        <h3 class="card-title">Add Stock to Inventory</h3>
        <a href="{{ route('inventory.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('stock.add') }}">
            @csrf

            <div class="form-group">
                <label for="inventory_item_id" class="form-label">Select Item *</label>
                <select name="inventory_item_id" id="inventory_item_id" class="form-control item-select" required>
                    <option value="">-- Select an item --</option>
                    @foreach($items as $item)
                        <option value="{{ $item->id }}" 
                                data-current-stock="{{ $item->quantity }}"
                                data-unit="{{ $item->unit_of_measure }}">
                            {{ $item->item_name }} ({{ $item->item_code }}) - Current: {{ $item->quantity }} {{ $item->unit_of_measure }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div id="itemInfo" style="display: none; padding: 1rem; background: var(--bg-secondary); border-radius: 0.5rem; margin-bottom: 1.5rem;">
                <div class="grid-2">
                    <div>
                        <strong>Current Stock:</strong>
                        <span id="currentStock">-</span>
                    </div>
                    <div>
                        <strong>Unit:</strong>
                        <span id="unit">-</span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="quantity" class="form-label">Quantity to Add *</label>
                <input type="number" 
                       name="quantity" 
                       id="quantity" 
                       class="form-control" 
                       min="1" 
                       required
                       placeholder="Enter quantity">
            </div>

            <div class="form-group">
                <label for="reference_number" class="form-label">Reference Number</label>
                <input type="text" 
                       name="reference_number" 
                       id="reference_number" 
                       class="form-control"
                       placeholder="e.g., PO-2024-001, Invoice #12345">
            </div>

            <div class="form-group">
                <label for="notes" class="form-label">Notes</label>
                <textarea name="notes" 
                          id="notes" 
                          class="form-control" 
                          rows="3"
                          placeholder="Add any additional notes..."></textarea>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn btn-success" style="flex: 1;">
                    <i class="fas fa-check"></i> Add Stock
                </button>
                <a href="{{ route('inventory.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('inventory_item_id').addEventListener('change', function() {
        const option = this.options[this.selectedIndex];
        const itemInfo = document.getElementById('itemInfo');
        
        if (this.value) {
            document.getElementById('currentStock').textContent = option.dataset.currentStock;
            document.getElementById('unit').textContent = option.dataset.unit;
            itemInfo.style.display = 'block';
        } else {
            itemInfo.style.display = 'none';
        }
    });
</script>
@endpush
