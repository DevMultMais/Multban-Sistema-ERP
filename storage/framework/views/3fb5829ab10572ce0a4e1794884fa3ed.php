
<?php $__env->startSection('page.title', 'Perfil'); ?>
<?php $__env->startPush('script-head'); ?>
<link href="<?php echo e(asset('assets/plugins/select2/css/select2.min.css')); ?>" rel="stylesheet" />
<!-- summernote -->
<link rel="stylesheet" href="<?php echo e(asset('assets/plugins/summernote/summernote-bs4.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- Main content -->
<section class="content">
    <form class="form-horizontal" id="formPrincipal" role="form" method="POST" action="<?php echo e(route('usuario.update', $usuario->user_id)); ?>">
        <?php echo method_field('PATCH'); ?>
        <?php echo csrf_field(); ?>
        <?php echo $__env->make('Multban.template.updatetemplate', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Perfil</h3>
            </div>
            <div class="card-body">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="id">ID:</label>
                                <div class="input-group">
                                    <input type="number" disabled name="id" value="<?php echo e($usuario->user_id ?? ''); ?>" placeholder="0" disabled class="form-control">
                                </div>
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="name">Nome:</label>
                                <input class="form-control" placeholder="Digite o nome du usuário" autofocus="autofocus" maxlength="60" name="name" type="text" id="name" value="<?php echo e($usuario->name); ?>">
                            </div>


                            <div class="form-group col-md-4">
                                <label for="username">Username:</label>
                                <input class="form-control" placeholder="Digite o nome du usuário" autofocus="autofocus" maxlength="60" name="username" type="text" id="username" value="<?php echo e($usuario->username); ?>">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="email">E-mail:</label>
                                <input class="form-control" placeholder="Digite o nome Fantasia" autofocus="autofocus" name="email" type="email" id="email" value="<?php echo e($usuario->email); ?>">
                            </div>
                        </div>

                        <div class="form-row">

                            <div class="form-group col-md-4">
                                <label for="password">Senha:</label>
                                <div class="input-group mb-3">
                                    <input type="password" autofocus="autofocus" class="form-control" id="password" name="password" required placeholder="Digite a senha">
                                    <span class="input-group-append">
                                        <button type="button" id="showPassword" class="btn btn-default"><i class="fa fa-eye-slash"></i></button>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="confirm-password">Confirmar senha:</label>
                                <div class="input-group mb-3">
                                    <input type="password" autofocus="autofocus" class="form-control" id="confirm-password" name="confirm-password" required placeholder="Confirme a senha">
                                    <span class="input-group-append">
                                        <button type="button" id="showConfirmPassword" class="btn btn-default"><i class="fa fa-eye-slash"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="roles">Permissão:</label>
                                <select class="form-control select2" id="roles" name="roles" multiple data-placeholder="Selecione" style="width: 100%;">
                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option id="<?php echo e($role); ?>" <?php $__currentLoopData = $userRole; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php if($role==$u): ?> selected="selected" <?php endif; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> value="<?php echo e($role); ?>">
                                        <?php echo e($role); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <div class="card card-widget card-outline card-primary">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-4">
                                <img id="image-product" class="img-circle elevation-2 m-3" src="<?php echo e(empty($usuario->image) ? url('/assets/image/') . '/' . 'no-product-image.png' : url('/storage/images/usuario') . '/' . $usuario->image); ?>" alt="<?php echo e($usuario->image); ?>" style="
                                border-radius: 50%;
                                position: relative;
                                height: 117px;
                                width: 117px;
                                overflow: hidden;
                                float: left;
                                margin-right: 10px;
                            ">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" accept=".jpeg,.png,.jpg,.gif,.webp" name="image" id="customFile">
                                    <label class="custom-file-label" for="customFile" data-browse="<?php echo e(empty($usuario->image) ? 'Adicionar Imagem' : 'Alterar Imagem'); ?>"><?php echo e(!empty($usuario->image) ? $usuario->image : 'Nenhuma imagem selecionada'); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </form>

</section>
<!-- /.content -->

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

<script type="text/javascript">
    function readURLProduct(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#image-product').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#customFile").change(function() {
        readURLProduct(this);
    });

    $(document).ready(function(e) {
    <?php if(session()->get('success')): ?>
        toastr.success('<?php echo e(session()->get('success')); ?>')
        setTimeout(() => {
            window.location = '/'
        }, 800);
    <?php endif; ?>





        $("body").on("keyup change", "input[type='text'],input[type='password'],input[type='email']", function(e) {
            $(this).removeClass('is-invalid');
        });
        $('body').on('click', '#showPassword', function(e) {
            $(this).find("i").toggleClass("fa-eye fa-eye-slash");
            $('#showConfirmPassword').find("i").toggleClass("fa-eye fa-eye-slash");
            var type = $('#password')
            if (type.attr('type') == 'password') {
                type.attr('type', 'text')
                $('#confirm-password').attr('type', 'text')
            } else {
                type.attr('type', 'password')
                $('#confirm-password').attr('type', 'password')
            }
        });

        $('body').on('click', '#showConfirmPassword', function(e) {
            $(this).find("i").toggleClass("fa-eye fa-eye-slash");
            $('#showPassword').find("i").toggleClass("fa-eye fa-eye-slash");
            var type = $('#confirm-password')
            if (type.attr('type') == 'password') {
                type.attr('type', 'text')
                $('#password').attr('type', 'text')
            } else {
                type.attr('type', 'password')
                $('#password').attr('type', 'password')
            }
        });
        // $(".alert-dismissible")
        //         .fadeTo(10000, 500)
        //         .slideUp(500, function() {
        //             $(".alert-dismissible").alert("close");
        //         });

        ns.iniciarlizarMascaras();
        bsCustomFileInput.init();
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "progressBar": true,
            "preventDuplicates": false,
            "positionClass": "toast-top-right",
            "onclick": null,
            "showDuration": "400",
            "hideDuration": "5500",
            "timeOut": "5500",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        $('#message').css('display', 'none');

    });
</script>
<script src="<?php echo e(asset('assets/plugins/jquery-validation/jquery.validate.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugins/jquery-validation/localization/messages_pt_BR.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugins/select2/js/select2.full.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugins/select2/js/i18n/pt-BR.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js')); ?>"></script>
<!-- InputMask -->
<script src="<?php echo e(asset('assets/plugins/moment/moment.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugins/inputmask/min/jquery.inputmask.bundle.min.js')); ?>"></script>
<!-- Summernote -->
<script src="<?php echo e(asset('assets/plugins/summernote/summernote-bs4.min.js')); ?>"></script>
<link rel="stylesheet" href="<?php echo e(asset('assets/dist/css/app.css')); ?>" />
<script src="<?php echo e(asset('assets/dist/js/app.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app-master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Marcio Bomfim\Desktop\novo\system\multban\resources\views/Multban/perfil/edit.blade.php ENDPATH**/ ?>