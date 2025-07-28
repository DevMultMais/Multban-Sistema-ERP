<?php $__env->startSection('page.title', 'Cliente'); ?>
<?php $__env->startPush('script-head'); ?>
<!-- Select2 -->
<link rel="stylesheet" href="/assets/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="<?php echo e(asset('assets/plugins/sweetalert2/sweetalert2.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/plugins/datatables-select/css/select.bootstrap4.min.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(asset('assets/plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.min.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')); ?>" />
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<!-- Main content -->
<section class="content">

    <?php if(count($errors) > 0): ?>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-sm-12">
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-check"></i> Alerta!</h5>
                <?php echo e($error); ?>

            </div>
        </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

    <div class="card card-outline card-primary">

        <div class="card-body" id="filtro-pesquisa">

            <!-- PRIMEIRA LINHA DO FORMULÁRIO DE PESQUISA -->
            <div class="form-row">

                <!-- FILTRO DO NOME DA EMPRESA -->
                <div class="form-group col-md-3">
                    <label for="Empresa">Nome Multban:</label>
                    <select id="empresa_id" name="empresa_id" class="form-control select2 select2-hidden-accessible"
                        data-placeholder="Pesquise a Empresa" style="width: 100%;" aria-hidden="true">
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label id="cliente_sts">Status:</label>
                    <select class="form-control select2" id="cliente_sts" name="cliente_sts" data-placeholder="Selecione o Status" style="width: 100%;">
                        <option></option>
                        <?php $__currentLoopData = $status; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $sta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($sta->cliente_sts); ?>"><?php echo e($sta->cliente_sts_desc); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label for="cliente_tipo">Tipo de cliente:*</label>
                        <select class="form-control select2" name="cliente_tipo" id="cliente_tipo" data-placeholder="Selecione o tipo" style="width: 100%;">
                        <option></option>
                        <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($tipo->cliente_tipo); ?>"><?php echo e($tipo->cliente_tipo_desc); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                </div>

            </div>

            <!-- SEGUNDA LINHA DO FORMULÁRIO DE PESQUISA -->
            <div class="form-row">

                <div class="form-group col-md-3">
                    <label id="cliente">Nome do Cliente:</label>
                    <select id="cliente_id" name="cliente_id" class="form-control select2 select2-hidden-accessible"
                        data-placeholder="Pesquise o Cliente" style="width: 100%;" aria-hidden="true">
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label for="cliente_doc">CPF/CNPJ:</label>
                    <div class="input-group">
                        <input type="text" id="cliente_doc" name="cliente_doc" class="form-control" placeholder="Digite o CPF ou CNPJ">
                    </div>
                </div>

                <div class="form-group col-md-3 d-flex align-items-end">
                    <button type="button" id="btnPesquisar" class="btn btn-primary"><i class="fa fa-search"></i> Pesquisar</button>
                </div>

            </div>

        </div>
    </div>

    <!-- QUADRO DO GRID DE CLIENTES -->
    <div class="card card-outline card-primary">

        <!-- BOTÃO PARA CRIAR NOVO CLIENTE -->
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('usuario.create')): ?>
            <div class="card-header">
                <a href="/cliente/inserir" class="btn btn-primary"><i class="fa fa-plus"></i> Criar novo</a>
            </div>
        <?php endif; ?>

        <!-- CORPO DO QUADRO DO GRID DE CLIENTES -->
        <div class="card-body">

            <div class="table-responsive">
                <table id="gridtemplate" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>Ações</th>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>CNPJ/CPF</th>
                            <th>Cliente Tipo</th>
                            <th>E-mail</th>
                            <th>Telefone</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                </table>
            </div>

            TROCAR O FILTRO EMPRESA PARA NOME MULTBAN, CAMPO EMP_NMULT DA TABELA TBDM_EMPRESA_GERAL</br>
            </br>
            OS FILTROS NOME MULTBAN E NOME DO CLIENTE TEM QUE SER NO MESMO ESQUEMA DAS TAGS, ONDE A TAG DIGITADA TB PODE SER UMA OPÇÃO PARA FILTRAR
            </br>
            O FILTRO STATUS DEVE TRAZER OS VALORES PARA OPÇÃO DE SELEÇÃO, DA TABELA TBDM_CLIENTE_TP</br>
            </br>
            O FILTRO TIPO DE CLIENTE DEVE TRAZER OS VALORES PARA OPÇÃO DE SELEÇÃO, DA TABELA TBDM_CLIENTE_STS</br>
            </br>
            AO CADASTRAR UM NOVO CLIENTE, O SISTEMA PRECISA GRAVAR OS DADOS NA TABELA TBDM_CLIENTES_EMP, ESTA TABELA INDICA</br>
            O RELACIONAMENTO ENTRE UM CLIENTE E UMA EMPRESA, ISSO É PARA QUE UMA EMPRESA SÓ POSSA ACESSAR OS CLIENTES QUE ELA CADASTROU</br>
            AO PESQUISAR UM CLIENTE, O SISTEMA DEVE FAZER OBRIGATORIAMENTE UM JOIN ENTRE AS TABELAS TBDM_CLIENTES_GERAL E TBDM_CLIENTES_EMP,</br>
            SE O CLIENTE NÃO ESTIVER RELACIONADO A EMPRESA DO USUÁRIO LOGADO, ELE NÃO PODE APARECER COMO UMA OPÇÃO DE FILTRO</br>
            </br>
            AO CRIAR UM NOVO CLIENTE, O STATUS DEVE NASCER SEMPRE "EM ANÁLISE", AO CLICAR EM "SALVAR", O SISTEMA DEVE ENVIAR UM EMAIL E UM WHATS</br>
            PARA O NOVO CLIENTE, COM OS CONTRATOS DE PRESTAÇÃO DE SERVIÇO DA MULTBAN, ALGUNS DIZERES QUE JÁ ESTARÃO CADASTRADOS NO "PADRÃO DE MENSAGENS"</br>
            E UM BOTÃO PARA QUE ELE ACEITE OS TERMOS DO CONTRATO E VALIDE O CADASTRO</br>
            QUANDO O CLIENTE CLICAR NO BOTÃO, O SISTEMA DEVE ALTERAR O STATUS DO CADATRO PARA "AUTORIZADO"</br>
            </br>
            AO CRIAR UM NOVO CLIENTE, QUANDO O USUÁRIO DIGITAR O CPF, O SISTEMA DEVE VERIFICAR SE ESTE CPF JÁ EXISTE NA BASE, SE JÁ EXISTIR</br>
            CADASTRADO PARA UMA OUTRA EMPRESA, O SISTEMA DEVE APRESENTAR UMA MSG NA TELA INFORMANDO QUE O CLIENTE JÁ POSSUÍ CADASTRO</br>
            EM OUTRA EMPRESA E PERGUNTANDO SE DESEJA SOLICITAR ACESSO AOS DADOS DO CLIENTE, SE O USUÁRIO CLICAR EM SIM, O SISTEMA</br>
            DEVE ENVIAR UM EMAIL E UMA MSG NO WHATS DO CLIENTE PARA QUE ELE AUTORIZE O ACESSO, QUANDO O CLIENTE CLICAR EM COMPARTILHAR</br>
            O SISTEMA DEVE CADASTRAR UM NOVO REGISTRO NA TABELA TBDM_CLIENTES_EMP COM O CÓDIGO NA EMPRESA QUE SOLICITOU ACESSO AO CADASTRO DELE

        </div>
    </div>

</section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

    <!-- Select2 -->
    <script src="<?php echo e(asset('assets/plugins/select2/js/select2.full.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugins/select2/js/i18n/pt-BR.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/sweetalert2/sweetalert2.all.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/datatables-select/js/dataTables.select.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/datatables-fixedheader/js/dataTables.fixedHeader.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/jquery-mask/jquery.mask.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/dist/js/app.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/dist/js/pages/cliente/gridcliente.js')); ?>"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            <?php if($message = Session::get('success')): ?>
                $("#empresa_id").val(<?php echo e(Session::get('idModeloInserido')); ?>)
                toastr.success("<?php echo e($message); ?>", "Sucesso");
            <?php endif; ?>
            <?php if($message = Session::get('error')): ?>
                toastr.error("<?php echo e($message); ?>", "Erro");
            <?php endif; ?>
            <?php if(count($errors) > 0): ?>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    toastr.error("<?php echo e($error); ?>", "Erro");
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
                                        });
    </script>

    <script type="text/javascript">
    $(document).ready(function(){

        // Inicializa o Select2
        $('#inputPesquisa').on('keyup', function(e){
            if(e.key === 'Enter'){
                $("#btnPesquisar").trigger("click");
            }
        });

        // Máscara dinâmica para CPF/CNPJ
        $('#cliente_doc').on('input', function() {
            var value = $(this).val().replace(/\D/g, '');

            console.log(value.length)
            if (value.length > 11) {
                $(this).removeClass('cpf');
                $(this).addClass('cnpj');
            } else {
                $(this).attr("maxlength", "")
                $(this).removeClass('cnpj');
                $(this).addClass('cpf');
            }

            $(".cpf").mask("000.000.000-00", { reverse: true });
            $(".cnpj").mask("00.000.000/0000-00", { reverse: true });
        });

        // Alerta
        $(".alert-dismissible")
            .fadeTo(10000, 500)
            .slideUp(500, function() {
                $(".alert-dismissible").alert("close");
            });
    });
    </script>

    <?php if($message = Session::get('success')): ?>
        <script>
            toastr.success("<?php echo e($message); ?>", "Sucesso");
            console.log('idModeloInserido', "<?php echo e(Session::get('idModeloInserido')); ?>");
            $("#inputPesquisa").val("<?php echo e(Session::get('idModeloInserido')); ?>");
            setTimeout(function(){
                $("#btnPesquisar").trigger("click");
                $("#inputPesquisa").val("");
            }, 200);
        </script>
    <?php endif; ?>

    <?php if($message = Session::get('error')): ?>
    <script>
        $("#inputPesquisa").val("<?php echo e(Session::get('idModeloInserido')); ?>");
        toastr.error("<?php echo e($message); ?>", "Erro");
        setTimeout(function(){
            $("#btnPesquisar").trigger("click");
            $("#inputPesquisa").val("");
        }, 200);
    </script>
    <?php endif; ?>

    <?php if(count($errors) > 0): ?>
        <script>
            var errors = <?php echo json_encode($errors->all()); ?>;
            errors.forEach(function(error) {
                toastr.error(error, "Erro");
            });
        </script>
    <?php endif; ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app-master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Marcio Bomfim\Desktop\novo\system\multban\resources\views/Multban/cliente/index.blade.php ENDPATH**/ ?>