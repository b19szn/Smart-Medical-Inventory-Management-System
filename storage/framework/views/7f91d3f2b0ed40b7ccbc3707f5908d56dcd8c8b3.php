

<?php $__env->startSection('title', 'User Management - Smart Medical Inventory'); ?>
<?php $__env->startSection('page-title', 'User Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h2>User Management</h2>
    <p>Manage system users and their roles</p>
</div>

<div class="card">
    <div class="card-header">
        <h3>All Users</h3>
        <div class="card-actions">
            <a href="<?php echo e(route('users.create')); ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New User
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php if($users->count() > 0): ?>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Phone</th>
                        <th>Hospital/Department</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <div class="user-info-cell">
                                <div class="user-avatar-small">
                                    <?php echo e(substr($user->name, 0, 1)); ?>

                                </div>
                                <strong><?php echo e($user->name); ?></strong>
                            </div>
                        </td>
                        <td><?php echo e($user->email); ?></td>
                        <td>
                            <span class="badge badge-<?php echo e($user->role === 'superadmin' ? 'danger' : ($user->role === 'admin' ? 'primary' : 'info')); ?>">
                                <?php echo e(ucfirst($user->role)); ?>

                            </span>
                        </td>
                        <td><?php echo e($user->phone ?? '-'); ?></td>
                        <td>
                            <?php if($user->hospital_name): ?>
                                <strong><?php echo e($user->hospital_name); ?></strong><br>
                                <small class="text-muted"><?php echo e($user->department); ?></small>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($user->is_active): ?>
                                <span class="badge badge-success">Active</span>
                            <?php else: ?>
                                <span class="badge badge-secondary">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="<?php echo e(route('users.edit', $user->id)); ?>" class="btn btn-sm btn-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if($user->id !== auth()->id()): ?>
                                <form action="<?php echo e(route('users.destroy', $user->id)); ?>" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        
        <div class="pagination-wrapper">
            <?php echo e($users->links()); ?>

        </div>
        <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-users"></i>
            <h3>No Users Found</h3>
            <p>Start by adding your first user.</p>
            <a href="<?php echo e(route('users.create')); ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add First User
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.user-info-cell {
    display: flex;
    align-items: center;
    gap: 10px;
}

.user-avatar-small {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 14px;
}

.action-buttons {
    display: flex;
    gap: 5px;
}
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\smartmedicalinventory\resources\views/users/index.blade.php ENDPATH**/ ?>