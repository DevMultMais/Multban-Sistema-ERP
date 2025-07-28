
<?php if($errors->any()): ?>
<div class="row">
  <div class="col-md-12">
      <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h5><i class="icon fas fa-ban"></i> Alerta!</h5>
          <ul>
              <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li><?php echo e($error); ?></li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
      </div>
      <?php endif; ?>

      <?php if($message = Session::get('success')): ?>
      <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h5><i class="icon fas fa-check"></i> Sucesso!</h5>
          <?php echo e($message); ?>

      </div>

  </div>
</div>
<?php endif; ?>


<div class="row" id="row-top" style="">
  <div class=" navbar-fixed-top fixed nav-opcoes">
    <button id="btnSalvar" type="button" class="btn btn-primary"><i class="icon fas fa-save"></i> Salvar</button>
    <?php if(!request()->is('*/inserir')): ?>
    <button id="btnInativar" type="button" class="btn btn-primary"><i class="icon fas fa-times"></i> Inativar</button>
    <button id="btnExcluir" type="button" class="btn btn-primary"><i class="icon fas fa-trash"></i> Exluir</button>
    <?php endif; ?>
    <button id="btnCancelar" onclick="location.href='<?php echo e(url($route)); ?>'" type="button" class="btnCancelar btn btn-secundary-multban"><i class="icon fas fa-arrow-left"></i> Voltar</button>



  </div>
</div>
<?php /**PATH C:\Users\Marcio Bomfim\Desktop\novo\system\multban\resources\views/Multban/template/updatetemplate.blade.php ENDPATH**/ ?>