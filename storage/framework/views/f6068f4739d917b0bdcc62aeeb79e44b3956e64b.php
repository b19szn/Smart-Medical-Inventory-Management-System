

<?php $__env->startSection('title', 'Transfer Stock - Smart Medical Inventory'); ?>
<?php $__env->startSection('page-title', 'Transfer Stock'); ?>

<?php $__env->startSection('content'); ?>
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header">
        <h3 class="card-title">Transfer Stock to Another Location</h3>
        <a href="<?php echo e(route('stock.transfers')); ?>" class="btn btn-secondary">
            <i class="fas fa-history"></i> Transfer History
        </a>
    </div>

    <div class="card-body">
        <form method="POST" action="<?php echo e(route('stock.transfer')); ?>">
            <?php echo csrf_field(); ?>

            <div class="form-group">
                <label for="inventory_item_id" class="form-label">Select Item *</label>
                <select name="inventory_item_id" id="inventory_item_id" class="form-control item-select" required>
                    <option value="">-- Select an item --</option>
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($item->id); ?>" 
                                data-current-stock="<?php echo e($item->quantity); ?>"
                                data-unit="<?php echo e($item->unit_of_measure); ?>">
                            <?php echo e($item->item_name); ?> (<?php echo e($item->item_code); ?>) - Available: <?php echo e($item->quantity); ?> <?php echo e($item->unit_of_measure); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                <label for="quantity" class="form-label">Quantity to Transfer *</label>
                <input type="number" 
                       name="quantity" 
                       id="quantity" 
                       class="form-control" 
                       min="1" 
                       required
                       placeholder="Enter quantity">
            </div>

            <div class="form-group">
                <label for="transfer_to" class="form-label">Transfer To (Hospital/Location) *</label>
                <input type="text" 
                       name="transfer_to" 
                       id="transfer_to" 
                       class="form-control" 
                       required
                       placeholder="e.g., Chittagong Medical College Hospital">
                <small style="color: var(--text-light);">Enter the name of the destination hospital or location</small>
            </div>

            <div class="form-group">
                <label for="reference_number" class="form-label">Reference/Tracking Number</label>
                <input type="text" 
                       name="reference_number" 
                       id="reference_number" 
                       class="form-control"
                       placeholder="e.g., TR-2024-001">
            </div>

            <div class="form-group">
                <label for="notes" class="form-label">Transfer Notes</label>
                <textarea name="notes" 
                          id="notes" 
                          class="form-control" 
                          rows="3"
                          placeholder="Add reason for transfer, special instructions, or any additional notes..."></textarea>
            </div>

            <div class="card" style="background: #fef3c7; border: 1px solid #f59e0b; padding: 1rem; margin-bottom: 1.5rem;">
                <div style="display: flex; align-items: start; gap: 0.75rem;">
                    <i class="fas fa-info-circle" style="color: #f59e0b; font-size: 1.25rem; margin-top: 0.125rem;"></i>
                    <div style="font-size: 0.875rem; color: #92400e;">
                        <strong>Transfer Request:</strong> This will create a pending transfer request. 
                        The stock will be deducted from your inventory immediately. 
                        The receiving location will need to confirm receipt.
                    </div>
                </div>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn btn-info" style="flex: 1;">
                    <i class="fas fa-exchange-alt"></i> Create Transfer Request
                </button>
                <a href="<?php echo e(route('inventory.index')); ?>" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\smartmedicalinventory\resources\views/stock/transfer.blade.php ENDPATH**/ ?>