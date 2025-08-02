@extends('layouts.app-master')
@section('page.title', 'Empresa')
@push('script-head')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-select/css/select.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />
@endpush
@section('content')
    <!-- Main content -->
    <section class="content">
        @if (session()->get('success'))
            <div class="col-sm-12">
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Sucesso!</h5>
                    {{ session()->get('success') }}
                </div>
            </div>
        @endif

        @if (session()->get('warning'))
            <div class="col-sm-12">
                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Alerta!</h5>
                    {{ session()->get('warning') }}
                </div>
            </div>
        @endif

        <!-- QUADRO DO FORMULÁRIO DE PESQUISA -->
        <div class="card card-outline card-primary">

            <div class="card-body" id="filtro-pesquisa">

                <!-- PRIMEIRA LINHA DO FORMULÁRIO DE PESQUISA -->
                <div class="form-row">

                    <!-- FILTRO DO CÓDIGO DA FRANQUEADORA -->
                    <div class="form-group col-md-3">
                        <label for="cod_franqueadora">Código da Franqueadora:</label>
                        <select id="cod_franqueadora" name="cod_franqueadora"
                            class="form-control select2 select2-hidden-accessible"
                            data-placeholder="Pesquise a Franqueadora" style="width: 100%;" aria-hidden="true">
                            <option></option>
                        </select>
                    </div>

                    <!-- FILTRO DO NOME DA EMPRESA -->
                    <div class="form-group col-md-3">
                        <label for="Empresa">Empresa:</label>
                        <select id="empresa_id" name="empresa_id" class="form-control select2 select2-hidden-accessible"
                            data-placeholder="Pesquise a Empresa" style="width: 100%;" aria-hidden="true">
                        </select>
                    </div>

                </div>

                <!-- SEGUNDA LINHA DO FORMULÁRIO DE PESQUISA -->
                <div class="form-row">

                    <!-- FILTRO DO NOME FANTASIA -->
                    <div class="form-group col-md-3">
                        <label for="nome_fantasia">Nome Fantasia:</label>
                        <select id="nome_fantasia" name="nome_fantasia"
                            class="form-control select2 select2-hidden-accessible"
                            data-placeholder="Pesquise o Nome Fantasia" style="width: 100%;" aria-hidden="true">
                        </select>
                    </div>

                    <!-- FILTRO DO CNPJ -->
                    <div class="form-group col-md-3">
                        <label for="empresa_cnpj">CNPJ:</label>
                        <input type="text" id="empresa_cnpj" name="empresa_cnpj" class="form-control cnpj form-control-sm"
                            placeholder="Digite o CNPJ" />
                    </div>

                    <!-- BOTÃO PESQUISAR -->
                    <div class="form-group col-md-3 mt-4">
                        <button type="button" id="btnPesquisar" class="btn btn-primary mt-2" style=""><i
                                class="fa fa-search"></i> Pesquisar</button>
                    </div>

                </div>

            </div>

        </div>

        <!-- QUADRO DO GRID DE EMPRESAS -->
        <div class="card card-outline card-primary">

            <!-- BOTÃO PARA CRIAR NOVA EMPRESA -->
            @can('empresa.create')
                <div class="card-header">
                    <a href="/empresa/inserir" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Criar novo</a>
                </div>
            @endcan

            <!-- CORPO DO QUADRO DO GRID DE EMPRESAS -->
            <div class="card-body">

                <div class="table-responsive">
                    <table id="gridtemplate" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>Ações</th>
                                <th>Código</th>
                                <th>Razão Social</th>
                                <th>CNPJ</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                O FILTRO CÓDIGO DA FRANQUEADORA DEVE TRAZER NAS OPÇÕES DE SELEÇÃO, APENAS EMPRESAS QUE TENHAM O CAMPO EMP_FRQ SELECIONADO</br>
                PORÉM, AO FAZER O FILTRO NA BASE, DEVE FILTRAR A TABELA TBDM_EMPRESA_GERAL PELO CAMPO EMP_FRQMST</br>
                E TRAZER TODAS AS EMPRESAS QUE FOREM FRANQUEADAS DA EMPRESA SELECIONADA</br>
                </br>
                TROCAR O FILTRO EMPRESA PARA NOME MULTBAN, CAMPO EMP_NMULT DA TABELA TBDM_EMPRESA_GERAL</br>
                <br>
                ACRESCENTAR FILTRO DE STATUS DA EMPRESA CAMPO EMP_STS DA TABELA TBDM_EMPRESA_GERAL</br>
                </br>
                DEIXAR TODOS OS FILTROS, QUANDO PREENCHIDOS, COMO 'E' .. E NÃO COMO 'OU'</br>
                </br>
                TODOS OS FILTROS TEM QUE SER NO MESMO ESQUEMA DAS TAGS, ONDE A TAG DIGITADA TB PODE SER UMA OPÇÃO PARA FILTRAR

            </div>

        </div>

    </section>

@endsection

@push('scripts')
    <!-- Select2 -->
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/i18n/pt-BR.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-select/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/app.js') }}"></script>
    <script src="{{ asset('assets/dist/js/pages/empresa/gridempresa.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            @if ($message = Session::get('success'))
                $("#empresa_id").val({{ Session::get('idModeloInserido') }})
                toastr.success("{{ $message }}", "Sucesso");
            @endif
            @if ($message = Session::get('error'))
                toastr.error("{{ $message }}", "Erro");
            @endif
            @if (count($errors) > 0)
                @foreach ($errors->all() as $error)
                    toastr.error("{{ $error }}", "Erro");
                @endforeach
            @endif
                                        });
    </script>
@endpush
