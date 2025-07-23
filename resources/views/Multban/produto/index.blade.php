@extends('layouts.app-master')
@section('page.title', 'Produto')
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

        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                <div class="col-sm-12">
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-check"></i> Alerta!</h5>
                        {{ $error }}
                    </div>
                </div>

            @endforeach
        @endif

        <div class="card card-outline card-primary">

            <div class="card-body">
                <!-- PRIMEIRA LINHA DO FORMULÁRIO DE PESQUISA -->
                <div class="form-row">
                    <!-- FILTRO DO NOME DA EMPRESA -->
                    <div class="form-group col-md-3">
                        <label for="emp_id">Empresa:</label>
                        <select id="emp_id" name="emp_id" class="form-control select2 select2-hidden-accessible"
                            data-placeholder="Pesquise a Empresa" style="width: 100%;" aria-hidden="true">
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label id="produto_id">Código do Produto:</label>
                        <div class="input-group">
                            <input type="text" id="produto_id" class="form-control"
                                placeholder="Digite o código do produto">
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <label id="produto_tipo">Tipo de Produto:</label>
                        <select class="form-control select2" id="produto_tipo" data-placeholder="Selecione o Tipo de Produto"
                            style="width: 100%;">
                            <!--Exemplo de status-->
                            <option></option>
                            <option value="OP">Buscar dados da tabela TBDM_PRODUTO_TP</option>
                        </select>
                    </div>
                </div>
                <!-- SEGUNDA LINHA DO FORMULÁRIO DE PESQUISA -->
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label id="produto_dm">Descrição do Produto:</label>
                        <select id="produto_dm" name="produto_dm" class="form-control select2 select2-hidden-accessible"
                            data-placeholder="Pesquise o Nome do Produto" style="width: 100%;" aria-hidden="true">
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label id="produto_sts">Status:</label>
                        <select class="form-control select2" id="produto_sts" data-placeholder="Selecione o Status"
                            style="width: 100%;">
                            <!--Exemplo de status-->
                            <option></option>
                            <option value="OP">Buscar dados da tabela TBDM_PRODUTO_STS</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3 align-self-end d-flex">
                        <button type="button" id="btnPesquisar" class="btn btn-primary"><i class="fa fa-search"></i> Pesquisar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-outline card-primary">
            @can('usuario.create')
                <div class="card-header">
                    <a href="/produtos/inserir" class="btn btn-primary"><i class="fa fa-plus"></i> Criar novo</a>
                </div>
            @endcan

            <div class="card-body">
                <!--Tabela do resultado da pesquisa-->
                <div class="table-responsive">
                    <table id="gridtemplate" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>Ações</th>
                                <th>Código do Produto</th>
                                <th>Tipo de Produto</th>
                                <th>Descrição do Produto</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <b>FONTE:</b>
            TBDM_PRODUTOS_GERAL<br>
            <b>FILTROS:</b>
            EMP_ID = FILTRO DE EMPRESA (variável empresa_id)<br>
            PRODUTO_ID = FILTRO DE CÓDIGO DO PRODUTO (variável produto_id)<br>
            PRODUTO_STS = FILTRO DE STATUS DO PRODUTO (variável produto_sts)<br>
            PRODUTO_TIPO = FILTRO DE TIPO DO PRODUTO (variável produto_tipo)<br>
            <br>
            O FILTRO DE EMPRESA TEM QUE SER OBRIGATÓRIO E TEM QUE SER IGUAL AOS DEMAIOS FILTRO DE EMPRESA DAS DEMAIS PÁGINAS ONDE,<br>
            DIGITANDO UM NOME DE EMPRESA, DEVE APRESENTAR UMA LISTA DE OPÇÕES QUE TENHA A MESMA TAG DIGITADA, DAR A OPÇÃO DE<br>
            SELECIONAR APENAS A TAG OU SELECIOAR UMA OPÇÃO APRESENTADA NO FILTRO<br>
            <br>
            O FILTRO DO NOME DO PRODUTO TEM QUE SER IGUAL AOS DEMAIOS FILTRO DE EMPRESA DAS DEMAIS PÁGINAS ONDE,<br>
            DIGITANDO UM NOME DE PRODUTO, DEVE APRESENTAR UMA LISTA DE OPÇÕES QUE TENHA A MESMA TAG DIGITADA, DAR A OPÇÃO DE<br>
            SELECIONAR APENAS A TAG OU SELECIOAR UMA OPÇÃO APRESENTADA NO FILTRO<br>
            <br>
            O FILTRO DE EMPRESA TEM SER SOBRE O CAMPO EMP_NMULT da TABELA TBDM_EMPRESA_GERAL
            <br>
            CORRIGIR O BOTÃO PESQUISAR

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

        $(document).ready(function () {
            $('#inputPesquisa').on('keyup', function (e) {
                if (e.key === 'Enter') {
                    $("#btnPesquisar").trigger("click");
                }
            });

            $(".alert-dismissible")
                .fadeTo(10000, 500)
                .slideUp(500, function () {
                    $(".alert-dismissible").alert("close");
                });

            @if ($message = Session::get('success'))

                toastr.success("{{ $message }}", "Sucesso");
                console.log('idModeloInserido', "{{Session::get('idModeloInserido')}}")
                $("#inputPesquisa").val("{{Session::get('idModeloInserido')}}")
                setTimeout(function () {
                    $("#btnPesquisar").trigger("click");
                    $("#inputPesquisa").val("");
                }, 200);
            @endif

            @if($message = Session::get('error'))
                $("#inputPesquisa").val({{Session::get('idModeloInserido')}})
                toastr.error("{{ $message }}", "Erro");
                setTimeout(function () {
                    $("#btnPesquisar").trigger("click");
                    $("#inputPesquisa").val("");
                }, 200);
            @endif

            @if (count($errors) > 0)
                @foreach ($errors->all() as $error)
                    toastr.error("{{ $error }}", "Erro");
                @endforeach
            @endif


    });
    </script>
@endpush
