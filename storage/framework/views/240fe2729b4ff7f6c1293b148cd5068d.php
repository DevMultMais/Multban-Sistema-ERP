<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <?php
        $temEmpresas = false;
        $temEmpresas = !empty($empresa);

        ?>

        <?php if($empresa->whiteLabel): ?>
            <?php if($empresa->whiteLabel->mini_logo): ?>
                <img src="<?php echo e(asset('storage/white-label/empresa-'.$empresa->emp_id. '/mini-logo.png')); ?>"
                alt="<?php echo e($temEmpresas ? $empresa->emp_rzsoc : 'Empresa não cadastrada'); ?>"
                title="<?php echo e($temEmpresas ? $empresa->emp_rzsoc : 'Sem cadastro'); ?>" class="brand-image" style="opacity: .8">
            <?php else: ?>
                <img src="<?php echo e(asset('assets/dist/img/logo-amarela-min.png')); ?>"
                alt="<?php echo e($temEmpresas ? $empresa->emp_rzsoc : 'Empresa não cadastrada'); ?>"
                title="<?php echo e($temEmpresas ? $empresa->emp_rzsoc : 'Sem cadastro'); ?>" class="brand-image" style="opacity: .8">
            <?php endif; ?>
        <?php else: ?>
            <img src="<?php echo e(asset('assets/dist/img/logo-amarela-min.png')); ?>"
            alt="<?php echo e($temEmpresas ? $empresa->emp_rzsoc : 'Empresa não cadastrada'); ?>"
            title="<?php echo e($temEmpresas ? $empresa->emp_rzsoc : 'Sem cadastro'); ?>" class="brand-image" style="opacity: .8">
        <?php endif; ?>



        <span class="brand-text">
            <?php if($empresa->whiteLabel): ?>
            <?php if($empresa->whiteLabel->logo_h): ?>
                <img src="<?php echo e(asset('storage/white-label/empresa-'.$empresa->emp_id. '/logo-h.png')); ?>" alt="Logo multmais"
                class="logo-multmais">
            <?php else: ?>
                <img src="<?php echo e(asset('assets/dist/img/logo-amarela.png')); ?>" alt="Logo multmais" class="logo-multmais">
            <?php endif; ?>

            <?php else: ?>
            <img src="<?php echo e(asset('assets/dist/img/logo-amarela.png')); ?>" alt="Logo multmais" class="logo-multmais">
            <?php endif; ?>
        </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php echo e($menus); ?>

        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<?php /**PATH C:\Users\Marcio Bomfim\Desktop\novo\system\multban\resources\views/Multban/menu/menu.blade.php ENDPATH**/ ?>