<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Smart Medical Inventory System'); ?></title>
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <?php if(auth()->guard()->check()): ?>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <i class="fas fa-hospital-alt"></i>
                <span>Smart Medical Inventory</span>
            </div>
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <nav class="sidebar-nav">
            <a href="<?php echo e(route('dashboard')); ?>" class="nav-item <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </a>

            <a href="<?php echo e(route('inventory.index')); ?>" class="nav-item <?php echo e(request()->routeIs('inventory.*') ? 'active' : ''); ?>">
                <i class="fas fa-boxes"></i>
                <span>Inventory</span>
            </a>

            <div class="nav-group">
                <div class="nav-group-title">Stock Management</div>
                <a href="<?php echo e(route('stock.add.form')); ?>" class="nav-item <?php echo e(request()->routeIs('stock.add*') ? 'active' : ''); ?>">
                    <i class="fas fa-plus-circle"></i>
                    <span>Add Stock</span>
                </a>
                <a href="<?php echo e(route('stock.consume.form')); ?>" class="nav-item <?php echo e(request()->routeIs('stock.consume*') ? 'active' : ''); ?>">
                    <i class="fas fa-minus-circle"></i>
                    <span>Consume Stock</span>
                </a>
                <a href="<?php echo e(route('stock.transfer.form')); ?>" class="nav-item <?php echo e(request()->routeIs('stock.transfer*') ? 'active' : ''); ?>">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Transfer Stock</span>
                </a>
                <a href="<?php echo e(route('stock.transfers')); ?>" class="nav-item">
                    <i class="fas fa-history"></i>
                    <span>Transfer History</span>
                </a>
            </div>

            <div class="nav-group">
                <div class="nav-group-title">Alerts</div>
                <a href="<?php echo e(route('alerts.index')); ?>" class="nav-item <?php echo e(request()->routeIs('alerts.index') ? 'active' : ''); ?>">
                    <i class="fas fa-bell"></i>
                    <span>All Alerts</span>
                </a>
                <a href="<?php echo e(route('alerts.shortage')); ?>" class="nav-item <?php echo e(request()->routeIs('alerts.shortage') ? 'active' : ''); ?>">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Shortage Alerts</span>
                </a>
                <a href="<?php echo e(route('alerts.expiry')); ?>" class="nav-item <?php echo e(request()->routeIs('alerts.expiry') ? 'active' : ''); ?>">
                    <i class="fas fa-calendar-times"></i>
                    <span>Expiry Alerts</span>
                </a>
            </div>

            <?php if(auth()->user()->hasRole(['superadmin', 'admin'])): ?>
            <a href="<?php echo e(route('users.index')); ?>" class="nav-item <?php echo e(request()->routeIs('users.*') ? 'active' : ''); ?>">
                <i class="fas fa-users"></i>
                <span>User Management</span>
            </a>
            <?php endif; ?>

            <a href="<?php echo e(route('export.index')); ?>" class="nav-item <?php echo e(request()->routeIs('export.*') ? 'active' : ''); ?>">
                <i class="fas fa-file-export"></i>
                <span>Export Data</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">
                    <?php echo e(substr(auth()->user()->name, 0, 1)); ?>

                </div>
                <div class="user-details">
                    <div class="user-name"><?php echo e(auth()->user()->name); ?></div>
                    <div class="user-role"><?php echo e(ucfirst(auth()->user()->role)); ?></div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <header class="topbar">
            <div class="topbar-left">
                <button class="mobile-menu-toggle" id="mobileMenuToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="page-title"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h1>
            </div>
            <div class="topbar-right">
                <div class="notification-bell">
                    <i class="fas fa-bell"></i>
                    <span class="badge"><?php echo e(\App\Models\Alert::unread()->count()); ?></span>
                </div>
                <form action="<?php echo e(route('logout')); ?>" method="POST" style="display: inline;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn-logout">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- Page Content -->
        <main class="content">
            <?php if(session('success')): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <?php echo e(session('success')); ?>

            </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo e(session('error')); ?>

            </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
    <?php endif; ?>

    <?php if(auth()->guard()->guest()): ?>
    <?php echo $__env->yieldContent('content'); ?>
    <?php endif; ?>

    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\smartmedicalinventory\resources\views/layouts/app.blade.php ENDPATH**/ ?>