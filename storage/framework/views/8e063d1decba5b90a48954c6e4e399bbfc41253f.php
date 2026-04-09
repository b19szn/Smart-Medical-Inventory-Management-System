

<?php $__env->startSection('title', 'Shortage Alerts - Smart Medical Inventory'); ?>
<?php $__env->startSection('page-title', 'Shortage Alerts'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h2>Shortage Alerts</h2>
    <p>Items with low stock levels</p>
</div>

<div class="alert-stats">
    <div class="stat-card critical">
        <i class="fas fa-exclamation-circle"></i>
        <div class="stat-info">
            <h3><?php echo e($criticalCount); ?></h3>
            <p>Critical</p>
        </div>
    </div>
    <div class="stat-card high">
        <i class="fas fa-exclamation-triangle"></i>
        <div class="stat-info">
            <h3><?php echo e($highCount); ?></h3>
            <p>High Priority</p>
        </div>
    </div>
    <div class="stat-card medium">
        <i class="fas fa-info-circle"></i>
        <div class="stat-info">
            <h3><?php echo e($mediumCount); ?></h3>
            <p>Medium Priority</p>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Shortage Alerts</h3>
    </div>
    <div class="card-body">
        <?php if($alerts->count() > 0): ?>
        <div class="alerts-list">
            <?php $__currentLoopData = $alerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="alert-item severity-<?php echo e($alert->severity); ?>">
                <div class="alert-icon">
                    <?php if($alert->severity === 'critical'): ?>
                        <i class="fas fa-exclamation-circle"></i>
                    <?php elseif($alert->severity === 'high'): ?>
                        <i class="fas fa-exclamation-triangle"></i>
                    <?php else: ?>
                        <i class="fas fa-info-circle"></i>
                    <?php endif; ?>
                </div>
                <div class="alert-content">
                    <h4><?php echo e($alert->inventoryItem->name); ?></h4>
                    <p><?php echo e($alert->message); ?></p>
                    <div class="alert-meta">
                        <span><i class="fas fa-box"></i> Current Stock: <?php echo e($alert->inventoryItem->quantity); ?> <?php echo e($alert->inventoryItem->unit); ?></span>
                        <span><i class="fas fa-layer-group"></i> Reorder Level: <?php echo e($alert->inventoryItem->reorder_level); ?></span>
                        <span><i class="fas fa-clock"></i> <?php echo e($alert->created_at->diffForHumans()); ?></span>
                    </div>
                </div>
                <div class="alert-actions">
                    <a href="<?php echo e(route('stock.add.form')); ?>?item=<?php echo e($alert->inventoryItem->id); ?>" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Add Stock
                    </a>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        <div class="pagination-wrapper">
            <?php echo e($alerts->links()); ?>

        </div>
        <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-check-circle"></i>
            <h3>No Shortage Alerts</h3>
            <p>All items are adequately stocked!</p>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\smartmedicalinventory\resources\views/alerts/shortage.blade.php ENDPATH**/ ?>