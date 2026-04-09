

<?php $__env->startSection('title', 'Inventory - Smart Medical Inventory'); ?>
<?php $__env->startSection('page-title', 'Inventory Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Inventory Items</h3>
        <a href="<?php echo e(route('inventory.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Item
        </a>
    </div>

    <div class="card-body">
        <!-- Search and Filter -->
        <form method="GET" action="<?php echo e(route('inventory.index')); ?>" class="mb-4">
            <div class="grid-3">
                <div class="form-group" style="margin-bottom: 0;">
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="Search by name, code, or category..." 
                           value="<?php echo e(request('search')); ?>">
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <select name="category" class="form-control">
                        <option value="">All Categories</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category); ?>" <?php echo e(request('category') === $category ? 'selected' : ''); ?>>
                                <?php echo e($category); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <select name="stock_status" class="form-control">
                        <option value="">All Status</option>
                        <option value="low" <?php echo e(request('stock_status') === 'low' ? 'selected' : ''); ?>>Low Stock</option>
                        <option value="expiring" <?php echo e(request('stock_status') === 'expiring' ? 'selected' : ''); ?>>Expiring Soon</option>
                        <option value="expired" <?php echo e(request('stock_status') === 'expired' ? 'selected' : ''); ?>>Expired</option>
                        <option value="critical" <?php echo e(request('stock_status') === 'critical' ? 'selected' : ''); ?>>Critical (ICU/ER)</option>
                    </select>
                </div>
            </div>

            <div style="margin-top: 1rem; display: flex; gap: 0.5rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Search
                </button>
                <a href="<?php echo e(route('inventory.index')); ?>" class="btn btn-secondary">
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
                    <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><strong><?php echo e($item->item_code); ?></strong></td>
                        <td>
                            <?php echo e($item->item_name); ?>

                            <?php if($item->is_critical): ?>
                                <span class="badge badge-danger" style="margin-left: 0.5rem;">
                                    <i class="fas fa-heartbeat"></i> Critical
                                </span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($item->category); ?></td>
                        <td>
                            <strong><?php echo e($item->quantity); ?></strong> <?php echo e($item->unit_of_measure); ?>

                        </td>
                        <td><?php echo e($item->minimum_stock_level); ?></td>
                        <td>৳<?php echo e(number_format($item->unit_price, 2)); ?></td>
                        <td>
                            <?php if($item->is_expired): ?>
                                <span class="badge badge-danger">Expired</span>
                            <?php elseif($item->is_expiring): ?>
                                <span class="badge badge-warning">Expiring Soon</span>
                            <?php elseif($item->is_low_stock): ?>
                                <span class="badge badge-warning">Low Stock</span>
                            <?php else: ?>
                                <span class="badge badge-success">Good</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="<?php echo e(route('inventory.show', $item->id)); ?>" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo e(route('inventory.edit', $item->id)); ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="<?php echo e(route('inventory.destroy', $item->id)); ?>" method="POST" style="display: inline;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-danger" data-confirm-delete>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 2rem; color: var(--text-light);">
                            No inventory items found. <a href="<?php echo e(route('inventory.create')); ?>">Add your first item</a>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if($items->hasPages()): ?>
        <div class="pagination">
            <?php echo e($items->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\smartmedicalinventory\resources\views/inventory/index.blade.php ENDPATH**/ ?>