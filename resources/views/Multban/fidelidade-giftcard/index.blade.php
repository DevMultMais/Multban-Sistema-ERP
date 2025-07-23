@extends('layouts.app-master')
@section('page.title', 'Cartão Fidelidade / Gift')
@push('script-head')
<!-- Select2 -->
<link rel="stylesheet" href="/assets/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-select/css/select.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />
@endpush
@section('content')
<!-- Main content -->
<section class="content">
    @if(session()->get('success'))
    <div class="col-sm-12">
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Sucesso!</h5>
            {{ session()->get('success') }}
    </div>
    </div>
    @endif

    @if(session()->get('warning'))
    <div class="col-sm-12">
        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Alerta!</h5>
            {{ session()->get('warning') }}
    </div>
    </div>
    @endif


    <div class="card card-outline card-primary">

        <div class="card-body">

            <!-- PRIMEIRA LINHA DO FORMULÁRIO DE PESQUISA -->
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="emp_id">Empresa:</label>
                    <select id="emp_id" name="emp_id" class="form-control select2 select2-hidden-accessible"
                        data-placeholder="Pesquise a Empresa" style="width: 100%;" aria-hidden="true">
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Modalidade do Cartão:</label>
                    <select id="card_mod" name="card_mod" class="form-control select2"
                        data-placeholder="Selecione" style="width: 100%;" required aria-hidden="true">
                        <option></option>
                        <option value="OP">Buscar dados da tabela TBDM_CARD_MOD</option>
                    </select>
                </div>
            </div>

            <!-- SEGUNDA LINHA DO FORMULÁRIO DE PESQUISA -->
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="prg_nome">Nome do Programa:</label>
                    <div class="input-group">
                        <input type="text" id="prg_nome" class="form-control" placeholder="Digite o nome do programa">
                    </div>
                </div>
                <div class="form-group col-md-3 align-self-end d-flex">
                    <button type="button" id="btnPesquisar" class="btn btn-primary"><i class="fa fa-search"></i> Pesquisar</button>
                </div>
            </div>

        </div>
    </div>

    <!-- QUADRO DO GRID DE CARTÕES -->
    <div class="card card-outline card-primary">

        <!-- BOTÃO PARA CRIAR NOVO PROGRAMA -->
        @can('usuario.create')
            <div class="card-header">
                <a href="#" data-toggle="modal" data-target="#modalCriarCartao" class="btn btn-primary"><i class="fa fa-plus"></i> Criar novo</a>
            </div>
        @endcan

        <!-- CORPO DO QUADRO DO GRID DE CARTÕES -->
        <div class="card-body">

            <div class="table-responsive">
                <table id="gridtemplate" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>Ações</th>
                            <th>Categoria do Cartão</th>
                            <th>Nome do Programa</th>
                            <th>Valor do Programa</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <b>FONTE:</b>
        TBDM_CARTOES_PRE<br>
        <b>FILTROS:</b>
        EMP_ID = FILTRO DE EMPRESA (variável empresa_id)<br>
        CARD_MOD = FILTRO DE MODALIDADE DO CARTÃO (variável card_mod)<br>
        <br>
        O FILTRO DE EMPRESA TEM QUE SER OBRIGATÓRIO E TEM QUE SER IGUAL AOS DEMAIOS FILTRO DE EMPRESA DAS DEMAIS PÁGINAS ONDE,<br>
        DIGITANDO UM NOME DE USUÁRIO, DEVE APRESENTAR UMA LISTA DE OPÇÕES QUE TENHA A MESMA TAG DIGITADA, DAR A OPÇÃO DE<br>
        SELECIONAR APENAS A TAG OU SELECIOAR UMA OPÇÃO APRESENTADA NO FILTRO<br>
        <br>
        O FILTRO DE EMPRESA TEM SER SOBRE O CAMPO EMP_NMULT da TABELA TBDM_EMPRESA_GERAL
        <br>
        CORRIGIR O BOTÃO PESQUISAR

        <!-- MODAL DE CRIAÇÃO DO NOVO PROGRAMA -->
        <div class="modal fade" id="modalCriarCartao" tabindex="-1" role="dialog" aria-labelledby="modalCriarCartaoLabel modalCriarProgramaLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCriarCartaoLabel">Criar Novo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formCriarPrograma">
                            <div class="form-group">
                                <label>Modalidade do Cartão:</label>
                                <select id="card_mod" name="card_mod" class="form-control select2"
                                    data-placeholder="Selecione" style="width: 100%;" required aria-hidden="true">
                                    <option></option>
                                    <option value="OP">Buscar dados da tabela TBDM_CARD_MOD</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="prg_nome">Nome do Programa:</label>
                                <input type="text" class="form-control" id="prg_nome" name="prg_nome" placeholder="Digite o nome do programa" required>
                            </div>
                            <div class="form-group">
                                <label for="prg_valor">Valor do Programa:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">R$</span>
                                    </div>
                                    <input type="text" class="form-control" id="prg_valor" name="prg_valor" placeholder="Digite o valor do programa" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="card_sts">Status:</label>
                                <select class="form-control" id="card_sts" name="card_sts" required>
                                    <option value="" disabled selected>Selecione o status</option>
                                    <option value="ativo">Ativo</option>
                                    <option value="inativo">Inativo</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secundary-multban" data-dismiss="modal"><i class="icon fas fa-times"></i> Fechar</button>
                        <button type="button" class="btn btn-primary" id="btnSalvarPrograma"><i class="icon fas fa-save"></i> Salvar Cartão</button>
                    </div>
                </div>
            </div>
        </div>
</section>

@endsection
@push('scripts')
<!-- Select2 -->
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatables-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{asset('assets/dist/js/app.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function(){

        $('#modalCriarCartao').on('show.bs.modal', function () {
            $('#formCriarPrograma')[0].reset();
            // Se estiver usando Select2, reseta também:
            $('#formCriarPrograma .select2').val(null).trigger('change');
        });

        $('#prg_valor').mask('#.##0,00', {reverse: true});

        $('#inputPesquisa').on('keyup', function(e){
            if(e.keyCode == 13 /*Enter*/){
                $("#btnPesquisar").trigger("click");
            }
        })

        $(".alert-dismissible")
        .fadeTo(10000, 500)
        .slideUp(500, function() {
            $(".alert-dismissible").alert("close");
        });


        @if ($message = Session::get('success'))
            toastr.success("{{ $message }}", "Sucesso");
            console.log('idModeloInserido', "{{Session::get('idModeloInserido')}}")
            $("#inputPesquisa").val("{{Session::get('idModeloInserido')}}")
            setTimeout(function(){
                $("#btnPesquisar").trigger("click");
                $("#inputPesquisa").val("");
            }, 200);
        @endif


        @if($message=Session::get('error'))
            toastr.error("{{ $message }}", "Erro");
        @endif
        @if (count($errors)> 0)
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}", "Erro");
        @endforeach
        @endif

        $('#btnPesquisar').click(function(){
            var totaliza = {};
            totaliza.totaliza = false;
            $('#gridtemplate').DataTable().clear().destroy();
            ns.gridDataTable(colunas, colunasconfig, false, "single", "cartao-fidelidade-gift", totaliza);
        });

        //Initialize Select2 Elements
        $('.select2').select2();

        var colunas = [
            {
                data: 'id',
                name: 'id'
            },
            {
                data:'name',
                name:'name',
                autoWidth: true
            },
            {
                data:'email',
                name:'email'
            },
            {
                data:'username',
                name:'username',
                autoWidth: true
            },
            {
                data:'role',
                name:'role'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }];

        var colunasconfig = [
            { width: 20, targets: 0 },
            { width: "auto", targets: 1 },
            { width: "auto", targets: 2 },
            { width: "auto", targets: 3 }
        ];

        var selecao = true;

        $(document).on('click', '#delete_grid_id', function(e){
            var id = $(this).data('id');
            ns.swalDelete(id, 'usuario');
            e.preventDefault();
        });

    });

</script>
@endpush

