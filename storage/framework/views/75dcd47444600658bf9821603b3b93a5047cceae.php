

<?php $__env->startSection('title', 'Transfer History - Smart Medical Inventory'); ?>
<?php $__env->startSection('page-title', 'Transfer History'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h2>Stock Transfer History</h2>
    <p>View all stock transfers between locations</p>
</div>

<div class="card">
    <div class="card-header">
        <h3>All Transfers</h3>
        <div class="card-actions">
            <a href="<?php echo e(route('stock.transfer.form')); ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> New Transfer
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php if($transfers->count() > 0): ?>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Item</th>
                        <th>From Location</th>
                        <th>To Location</th>
                        <th>Quantity</th>
                        <th>Transferred By</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $transfers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transfer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($transfer->created_at->format('M d, Y H:i')); ?></td>
                        <td>
                            <strong><?php echo e($transfer->inventoryItem->name); ?></strong><br>
                            <small class="text-muted"><?php echo e($transfer->inventoryItem->sku); ?></small>
                        </td>
                        <td>
                            <span class="badge badge-info"><?php echo e($transfer->from_location); ?></span>
                        </td>
                        <td>
                            <span class="badge badge-success"><?php echo e($transfer->to_location); ?></span>
                        </td>
                        <td>
                            <strong><?php echo e($transfer->quantity); ?></strong> <?php echo e($transfer->inventoryItem->unit); ?>

                        </td>
                        <td><?php echo e($transfer->user->name); ?></td>
                        <td><?php echo e($transfer->notes ?? '-'); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        
        <div class="pagination-wrapper">
            <?php echo e($transfers->links()); ?>

        </div>
        <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-exchange-alt"></i>
            <h3>No Transfers Yet</h3>
            <p>No stock transfers have been recorded.</p>
            <a href="<?php echo e(route('stock.transfer.form')); ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create First Transfer
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\smartmedicalinventory\resources\views/stock/transfers.blade.php ENDPATH**/ ?>