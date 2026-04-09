

<?php $__env->startSection('title', 'Dashboard - Smart Medical Inventory'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<!-- Statistics Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <div>
                <div class="stat-value"><?php echo e($totalItems); ?></div>
                <div class="stat-label">Total Items</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-boxes"></i>
            </div>
        </div>
    </div>

    <div class="stat-card danger">
        <div class="stat-header">
            <div>
                <div class="stat-value"><?php echo e($lowStockItems); ?></div>
                <div class="stat-label">Low Stock Items</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>
    </div>

    <div class="stat-card warning">
        <div class="stat-header">
            <div>
                <div class="stat-value"><?php echo e($expiringItems); ?></div>
                <div class="stat-label">Expiring Soon</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-calendar-times"></i>
            </div>
        </div>
    </div>

    <div class="stat-card info">
        <div class="stat-header">
            <div>
                <div class="stat-value">৳<?php echo e(number_format($totalValue, 2)); ?></div>
                <div class="stat-label">Total Inventory Value</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Visualizations -->
<div class="grid-2 mb-4">
    <!-- Stock by Category -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Stock by Category</h3>
        </div>
        <div class="card-body">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Total Quantity</th>
                            <th>Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $totalStock = $stockByCategory->sum('total');
                        ?>
                        <?php $__currentLoopData = $stockByCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><strong><?php echo e($category->category); ?></strong></td>
                            <td><?php echo e(number_format($category->total)); ?></td>
                            <td>
                                <span class="badge badge-primary">
                                    <?php echo e($totalStock > 0 ? number_format(($category->total / $totalStock) * 100, 1) : 0); ?>%
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Alerts by Severity -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Active Alerts</h3>
            <a href="<?php echo e(route('alerts.index')); ?>" class="btn btn-sm btn-primary">View All</a>
        </div>
        <div class="card-body">
            <div class="stats-grid" style="grid-template-columns: repeat(2, 1fr);">
                <?php
                    $severityCounts = [
                        'critical' => 0,
                        'high' => 0,
                        'medium' => 0,
                        'low' => 0
                    ];
                    foreach($alertsBySeverity as $alert) {
                        $severityCounts[$alert->severity] = $alert->count;
                    }
                ?>

                <div class="stat-card danger" style="margin: 0;">
                    <div class="stat-value"><?php echo e($severityCounts['critical']); ?></div>
                    <div class="stat-label">Critical</div>
                </div>

                <div class="stat-card warning" style="margin: 0;">
                    <div class="stat-value"><?php echo e($severityCounts['high']); ?></div>
                    <div class="stat-label">High</div>
                </div>

                <div class="stat-card info" style="margin: 0;">
                    <div class="stat-value"><?php echo e($severityCounts['medium']); ?></div>
                    <div class="stat-label">Medium</div>
                </div>

                <div class="stat-card" style="margin: 0;">
                    <div class="stat-value"><?php echo e($severityCounts['low']); ?></div>
                    <div class="stat-label">Low</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Critical Stock Items (ICU/ER) -->
<?php if($criticalItems->count() > 0): ?>
<div class="card mb-4">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-heartbeat"></i> Critical Stock Items (ICU/ER)
        </h3>
        <span class="badge badge-danger"><?php echo e($criticalItems->count()); ?> Items</span>
    </div>
    <div class="card-body">
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Current Stock</th>
                        <th>Min Level</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $criticalItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><strong><?php echo e($item->item_name); ?></strong></td>
                        <td><?php echo e($item->category); ?></td>
                        <td><?php echo e($item->quantity); ?> <?php echo e($item->unit_of_measure); ?></td>
                        <td><?php echo e($item->minimum_stock_level); ?></td>
                        <td>
                            <?php if($item->is_low_stock): ?>
                                <span class="badge badge-danger">Low Stock</span>
                            <?php else: ?>
                                <span class="badge badge-success">Adequate</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?php echo e(route('stock.add.form')); ?>?item=<?php echo e($item->id); ?>" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus"></i> Add Stock
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Recent Alerts and Transactions -->
<div class="grid-2">
    <!-- Recent Alerts -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Recent Alerts</h3>
            <a href="<?php echo e(route('alerts.index')); ?>" class="btn btn-sm btn-secondary">View All</a>
        </div>
        <div class="card-body">
            <?php if($recentAlerts->count() > 0): ?>
            <div style="max-height: 400px; overflow-y: auto;">
                <?php $__currentLoopData = $recentAlerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div style="padding: 1rem; border-left: 4px solid 
                    <?php if($alert->severity === 'critical'): ?> var(--danger-color)
                    <?php elseif($alert->severity === 'high'): ?> var(--warning-color)
                    <?php elseif($alert->severity === 'medium'): ?> var(--info-color)
                    <?php else: ?> var(--text-light)
                    <?php endif; ?>; 
                    background: var(--bg-secondary); border-radius: 0.5rem; margin-bottom: 0.75rem;">
                    <div style="display: flex; align-items: start; justify-content: space-between; margin-bottom: 0.5rem;">
                        <span class="badge badge-<?php echo e($alert->severity === 'critical' ? 'danger' : ($alert->severity === 'high' ? 'warning' : 'info')); ?>">
                            <?php echo e(ucfirst($alert->severity)); ?>

                        </span>
                        <small style="color: var(--text-light);"><?php echo e($alert->created_at->diffForHumans()); ?></small>
                    </div>
                    <p style="margin: 0; color: var(--text-secondary); font-size: 0.875rem;"><?php echo e($alert->message); ?></p>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php else: ?>
            <p style="text-align: center; color: var(--text-light); padding: 2rem;">No recent alerts</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Recent Transactions</h3>
            <a href="<?php echo e(route('inventory.index')); ?>" class="btn btn-sm btn-secondary">View All</a>
        </div>
        <div class="card-body">
            <?php if($recentTransactions->count() > 0): ?>
            <div style="max-height: 400px; overflow-y: auto;">
                <?php $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div style="padding: 1rem; background: var(--bg-secondary); border-radius: 0.5rem; margin-bottom: 0.75rem;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.5rem;">
                        <strong style="color: var(--text-primary);"><?php echo e($transaction->inventoryItem->item_name ?? 'N/A'); ?></strong>
                        <span class="badge badge-<?php echo e($transaction->transaction_type === 'add' ? 'success' : ($transaction->transaction_type === 'consume' ? 'danger' : 'info')); ?>">
                            <?php echo e(ucfirst(str_replace('_', ' ', $transaction->transaction_type))); ?>

                        </span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.875rem; color: var(--text-secondary);">
                        <span>Qty: <?php echo e($transaction->quantity); ?></span>
                        <span>By: <?php echo e($transaction->user->name ?? 'N/A'); ?></span>
                        <span><?php echo e($transaction->created_at->format('d M, H:i')); ?></span>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php else: ?>
            <p style="text-align: center; color: var(--text-light); padding: 2rem;">No recent transactions</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title">Quick Actions</h3>
    </div>
    <div class="card-body">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <a href="<?php echo e(route('inventory.create')); ?>" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Add New Item
            </a>
            <a href="<?php echo e(route('stock.add.form')); ?>" class="btn btn-success">
                <i class="fas fa-box"></i> Add Stock
            </a>
            <a href="<?php echo e(route('stock.consume.form')); ?>" class="btn btn-warning">
                <i class="fas fa-minus-circle"></i> Consume Stock
            </a>
            <a href="<?php echo e(route('stock.transfer.form')); ?>" class="btn btn-info">
                <i class="fas fa-exchange-alt"></i> Transfer Stock
            </a>
            <a href="<?php echo e(route('export.index')); ?>" class="btn btn-secondary">
                <i class="fas fa-file-export"></i> Export Data
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Auto-refresh dashboard every 5 minutes
    setTimeout(function() {
        location.reload();
    }, 300000);
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\smartmedicalinventory\resources\views/dashboard.blade.php ENDPATH**/ ?>