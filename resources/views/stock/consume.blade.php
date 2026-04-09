@extends('layouts.app')

@section('title', 'Consume Stock - Smart Medical Inventory')
@section('page-title', 'Consume Stock')

@section('content')
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header">
        <h3 class="card-title">Consume/Use Stock</h3>
        <a href="{{ route('inventory.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('stock.consume') }}">
            @csrf

            <div class="form-group">
                <label for="inventory_item_id" class="form-label">Select Item *</label>
                <select name="inventory_item_id" id="inventory_item_id" class="form-control item-select" required>
                    <option value="">-- Select an item --</option>
                    @foreach($items as $item)
                        <option value="{{ $item->id }}" 
                                data-current-stock="{{ $item->quantity }}"
                                data-unit="{{ $item->unit_of_measure }}">
                            {{ $item->item_name }} ({{ $item->item_code }}) - Available: {{ $item->quantity }} {{ $item->unit_of_measure }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div id="itemInfo" style="display: none; padding: 1rem; background: var(--bg-secondary); border-radius: 0.5rem; margin-bottom: 1.5rem;">
                <div class="grid-2">
                    <div>
                        <strong>Available Stock:</strong>
                        <span id="currentStock">-</span>
                    </div>
                    <div>
                        <strong>Unit:</strong>
                        <span id="unit">-</span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="quantity" class="form-label">Quantity to Consume *</label>
                <input type="number" 
                       name="quantity" 
                       id="quantity" 
                       class="form-control" 
                       min="1" 
                       required
                       placeholder="Enter quantity">
                <small style="color: var(--text-light);">Make sure not to exceed available stock</small>
            </div>

            <div class="form-group">
                <label for="reference_number" class="form-label">Reference Number</label>
                <input type="text" 
                       name="reference_number" 
                       id="reference_number" 
                       class="form-control"
                       placeholder="e.g., Patient ID, Ward Number">
            </div>

            <div class="form-group">
                <label for="notes" class="form-label">Notes</label>
                <textarea name="notes" 
                          id="notes" 
                          class="form-control" 
                          rows="3"
                          placeholder="Add reason for consumption or any additional notes..."></textarea>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn btn-warning" style="flex: 1;">
                    <i class="fas fa-minus-circle"></i> Consume Stock
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
    const itemSelect = document.getElementById('inventory_item_id');
    const quantityInput = document.getElementById('quantity');
    
    itemSelect.addEventListener('change', function() {
        const option = this.options[this.selectedIndex];
        const itemInfo = document.getElementById('itemInfo');
        
        if (this.value) {
            const currentStock = option.dataset.currentStock;
            document.getElementById('currentStock').textContent = currentStock;
            document.getElementById('unit').textContent = option.dataset.unit;
            itemInfo.style.display = 'block';
            
            // Set max quantity
            quantityInput.max = currentStock;
        } else {
            itemInfo.style.display = 'none';
            quantityInput.max = '';
        }
    });

    // Validate quantity on input
    quantityInput.addEventListener('input', function() {
        const max = parseInt(this.max);
        const value = parseInt(this.value);
        
        if (max && value > max) {
            this.value = max;
            alert('Quantity cannot exceed available stock (' + max + ')');
        }
    });
</script>
@endpush
