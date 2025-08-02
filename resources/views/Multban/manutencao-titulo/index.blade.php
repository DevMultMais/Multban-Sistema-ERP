@extends('layouts.app-master')
@section('page.title', 'Manutenção de Títulos')
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

            <div class="card-body">

                <!-- PRIMEIRA LINHA DO FORMULÁRIO DE PESQUISA -->
                <div class="form-row">

                    <!-- FILTRO DO NOME DA EMPRESA -->
                    <div class="form-group col-md-3">
                        <label for="Empresa">Empresa:</label>
                        <select id="empresa_id" name="empresa_id" class="form-control select2 select2-hidden-accessible"
                            data-placeholder="Pesquise a Empresa" style="width: 100%;" aria-hidden="true">
                        </select>
                    </div>

                </div>

            </div>

        </div>

        <!-- QUADRO DOS RESULTADOS DE PESQUISA -->
        <div class="card card-primary card-outline card-outline-tabs">

            <!-- CABEÇALHO DA ABA -->
            <div class="card-header p-0 pt-1 border-bottom-0">

                <!-- ABAS -->
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="tabs-conexao-tab" data-toggle="pill" href="#tabs-conexao" role="tab"
                            aria-controls="tabs-conexao" aria-selected="true">Conexão BD</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="tabs-alias-tab" data-toggle="pill" href="#tabs-alias" role="tab"
                            aria-controls="tabs-alias" aria-selected="false">Alias de Tabelas</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="tabs-apis-tab" data-toggle="pill" href="#tabs-apis" role="tab"
                            aria-controls="tabs-apis" aria-selected="false">APIs</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="tabs-white-label-tab" data-toggle="pill" href="#tabs-white-label" role="tab"
                            aria-controls="tabs-white-label" aria-selected="false">White Label</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="tabs-work-flow-tab" data-toggle="pill" href="#tabs-work-flow" role="tab"
                            aria-controls="tabs-work-flow" aria-selected="false">Work Flow</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="tabs-padrao-msg-tab" data-toggle="pill" href="#tabs-padrao-msg" role="tab"
                            aria-controls="tabs-padrao-msg" aria-selected="false">Padrão de Mensagens</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="tabs-dados-mestres-tab" data-toggle="pill" href="#tabs-dados-mestres"
                            role="tab" aria-controls="tabs-dados-mestres" aria-selected="false">Dados Mestres</a>
                    </li>

                </ul>
            </div>

            <!-- CORPO DAS ABAS -->
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-two-tabContent">

                    <!---------------------------->
                    <!---- ABA CONEXÃO COM BD ---->
                    <!---------------------------->
                    <div class="tab-pane fade active show" id="tabs-conexao" role="tabpanel"
                        aria-labelledby="tabs-conexao-tab">

                        <!-- PRIMEIRA LINHA DO FORMULÁRIO DE PESQUISA -->
                        <div class="form-row">

                            <!-- FILTRO DO FORNECEDOR -->
                            <div class="form-group col-md-3">
                                <label for="Fornecedor-bd">Fornecedor:</label>
                                <select id="fornec_bd" name="fornec_bd"
                                    class="form-control select2 select2-hidden-accessible"
                                    data-placeholder="Pesquise o Fornecedor" style="width: 100%;" aria-hidden="true">
                                </select>
                            </div>

                            <!-- BOTÃO PESQUISAR -->
                            <div class="form-group col-md-3 mt-4">
                                <button type="button" id="btnPesquisarFbd" class="btn btn-primary mt-2" style=""><i
                                        class="fa fa-search"></i> Pesquisar</button>
                            </div>

                        </div>

                        <div class="card card-primary">

                            <b>AO CLICAR EM PESQUISAR:</b><br>
                            <b>FONTE:</b>
                            TBCF_CONEXOES_BC_EMP<br>
                            <b>FILTROS:</b>
                            EMP_ID = FILTRO DE EMPRESA (variável empresa_id)<br>
                            BC_FORNEC = FILTRO DE FORNECEDOR (variável fornec_bd)<br>
                            <br>
                            PLOTAR AQUI A TABELA DO BANCO DE DADOS COM OS DADOS GRAVADOS<br>
                            CASO NÃO TENHA NADA GRAVADO, PLOTAR A ESTRUTURA DA TABELA PARA QUE SEJA PREENCHICA<br>
                            <br>
                            PRECISAMOS ACRESCENTAR UM BOTÃO "SALVAR" QUE IRÁ GRAVAR OS DADOS NO BANCO DE DADOS

                        </div>

                    </div>

                    <!---------------------------->
                    <!--- ABA ALIAS DE TABELAS --->
                    <!---------------------------->
                    <div class="tab-pane fade" id="tabs-alias" role="tabpanel" aria-labelledby="tabs-alias-tab">

                        <!-- BOTÃO PESQUISAR -->
                        <div class="form-row">
                            <div class="form-group col-md-3 mt-4">
                                <button type="button" id="btnPesquisar-alias" class="btn btn-primary mt-2" style=""><i
                                        class="fa fa-search"></i> Carregar Dados</button>
                            </div>
                        </div>

                        <div class="card card-primary">

                            <b>AO CLICAR EM CARREGAR DADOS:</b><br>
                            <b>FONTE:</b>
                            TBCF_TAB_ALIAS<br>
                            <b>FILTROS:</b>
                            EMP_ID = FILTRO DE EMPRESA (variável empresa_id)<br>
                            <br>
                            PLOTAR AQUI A TABELA DO BANCO DE DADOS COM OS DADOS GRAVADOS<br>
                            <br>
                            CASO NÃO TENHA NADA GRAVADO, PLOTAR A ESTRUTURA DA TABELA PARA QUE SEJA PREENCHICA<br>
                            DURANTE O PREENCHIMENTO, AO CLICAR NO CAMPO EMP_TAB_NAME, DEVERÁ DAR UMA LISTA DE TODAS AS
                            TABELAS DO SISTEMA E POSSIBILITAR A SELEÇÃO DA TABELA DESEJADA<br>
                            <br>
                            PRECISAMOS ACRESCENTAR UM BOTÃO "SALVAR" QUE IRÁ GRAVAR OS DADOS NO BANCO DE DADOS

                        </div>

                    </div>

                    <!---------------------------->
                    <!--------- ABA APIS --------->
                    <!---------------------------->
                    <div class="tab-pane fade" id="tabs-apis" role="tabpanel" aria-labelledby="tabs-apis-tab">

                        <!-- PRIMEIRA LINHA DO FORMULÁRIO DE PESQUISA -->
                        <div class="form-row">

                            <!-- FILTRO DO FORNECEDOR -->
                            <div class="form-group col-md-3">
                                <label for="Fornecedor-api">Fornecedor:</label>
                                <select id="fornec_api" name="fornec_api"
                                    class="form-control select2 select2-hidden-accessible"
                                    data-placeholder="Pesquise o Fornecedor" style="width: 100%;" aria-hidden="true">
                                </select>
                            </div>

                            <!-- BOTÃO PESQUISAR -->
                            <div class="form-group col-md-3 mt-4">
                                <button type="button" id="btnPesquisar-fapi" class="btn btn-primary mt-2" style=""><i
                                        class="fa fa-search"></i> Pesquisar</button>
                            </div>

                        </div>

                        <div class="card card-primary">

                            <b>AO CLICAR EM PESQUISAR:</b><br>
                            <b>FONTE:</b>
                            TBCF_CONEXOES_API_EMP<br>
                            <b>FILTROS:</b>
                            EMP_ID = FILTRO DE EMPRESA (variável empresa_id)<br>
                            BC_FORNEC = FILTRO DE FORNECEDOR (variável fornec_api)<br>
                            <br>
                            PLOTAR AQUI A TABELA DO BANCO DE DADOS COM OS DADOS GRAVADOS<br>
                            CASO NÃO TENHA NADA GRAVADO, PLOTAR A ESTRUTURA DA TABELA PARA QUE SEJA PREENCHICA<br>
                            <br>
                            PRECISAMOS ACRESCENTAR UM BOTÃO "SALVAR" QUE IRÁ GRAVAR OS DADOS NO BANCO DE DADOS

                        </div>

                    </div>

                    <!---------------------------->
                    <!------- WHITE LABEL -------->
                    <!---------------------------->
                    <div class="tab-pane fade" id="tabs-white-label" role="tabpanel" aria-labelledby="tabs-white-label-tab">

                        <!-- BOTÃO PESQUISAR -->
                        <div class="form-row">
                            <div class="form-group col-md-3 mt-4">
                                <button type="button" id="btnPesquisar-wl" class="btn btn-primary mt-2" style=""><i
                                        class="fa fa-search"></i> Carregar Dados</button>
                            </div>
                        </div>

                        <div class="card card-primary">

                            <b>AO CLICAR EM CARREGAR DADOS:</b><br>
                            <b>FONTE:</b>
                            TBCF_CONFIG_WL<br>
                            <b>FILTROS:</b>
                            EMP_ID = FILTRO DE EMPRESA (variável empresa_id)<br>
                            <br>
                            PLOTAR AQUI A TABELA DO BANCO DE DADOS COM OS DADOS GRAVADOS<br>
                            CASO NÃO TENHA NADA GRAVADO, PLOTAR A ESTRUTURA DA TABELA PARA QUE SEJA PREENCHICA<br>
                            OS CAMPOS DA TABELA DEVEM TER AS OPÇÕES DE SELECIONAR COR / FONTES VÁLIDAS / FORMATOS DE TEXTO /
                            ETC<br>
                            <br>
                            PRECISAMOS ACRESCENTAR UM BOTÃO "SALVAR" QUE IRÁ GRAVAR OS DADOS NO BANCO DE DADOS

                        </div>

                    </div>

                    <!---------------------------->
                    <!-------- WORK FLOW --------->
                    <!---------------------------->
                    <div class="tab-pane fade" id="tabs-work-flow" role="tabpanel" aria-labelledby="tabs-work-flow-tab">

                        <!-- PRIMEIRA LINHA DO FORMULÁRIO DE PESQUISA -->
                        <div class="form-row">

                            <!-- FILTRO DAS TABELAS SENSIBILIZADAS -->
                            <div class="form-group col-md-3">
                                <label for="tabela-bd">Tabela Sensibilizada:</label>
                                <select id="tabela-bd" name="tabela-bd"
                                    class="form-control select2 select2-hidden-accessible"
                                    data-placeholder="Pesquise a Tabela Sensibilizada" style="width: 100%;"
                                    aria-hidden="true">
                                </select>
                            </div>

                            <!-- BOTÃO PESQUISAR -->
                            <div class="form-group col-md-3 mt-4">
                                <button type="button" id="btnPesquisar-tbd" class="btn btn-primary mt-2" style=""><i
                                        class="fa fa-search"></i> Pesquisar</button>
                            </div>

                        </div>

                        <div class="card card-primary">

                            <b>AO CLICAR EM PESQUISAR:</b><br>
                            <b>FONTE:</b>
                            TBCF_CONFIG_WF<br>
                            <b>FILTROS:</b>
                            EMP_ID = FILTRO DE EMPRESA (variável empresa_id)<br>
                            TABELA = FILTRO DA TABELA SENSIBILIZADA (variável tabela-bd)<br>
                            <br>
                            PLOTAR AQUI A TABELA DO BANCO DE DADOS COM OS DADOS GRAVADOS<br>
                            CASO NÃO TENHA NADA GRAVADO, PLOTAR A ESTRUTURA DA TABELA PARA QUE SEJA PREENCHICA<br>
                            <br>
                            PRECISAMOS ACRESCENTAR UM BOTÃO "SALVAR" QUE IRÁ GRAVAR OS DADOS NO BANCO DE DADOS

                        </div>

                    </div>

                    <!---------------------------->
                    <!--- PADRÃO DE MENSAGENS ---->
                    <!---------------------------->
                    <div class="tab-pane fade" id="tabs-padrao-msg" role="tabpanel" aria-labelledby="tabs-padrao-msg-tab">

                        <!-- PRIMEIRA LINHA DO FORMULÁRIO DE PESQUISA -->
                        <div class="form-row">

                            <!-- FILTRO DE CATEGORIA DE MENSAGEM -->
                            <div class="form-group col-md-3">
                                <label for="msg_categ">Categoria da Mensagem:</label>
                                <select id="msg_categ" name="msg_categ"
                                    class="form-control select2 select2-hidden-accessible"
                                    data-placeholder="Categoria" style="width: 100%;"
                                    aria-hidden="true">
                                </select>
                            </div>

                            <!-- FILTRO DE CANAL DE COMUNICAÇÃO -->
                            <div class="form-group col-md-3">
                                <label for="canal_id">Canal de Comunicação:</label>
                                <select id="canal_id" name="canal_id"
                                    class="form-control select2 select2-hidden-accessible"
                                    data-placeholder="Canal" style="width: 100%;"
                                    aria-hidden="true">
                                </select>
                            </div>

                            <!-- BOTÃO PESQUISAR -->
                            <div class="form-group col-md-3 mt-4">
                                <button type="button" id="btnPesquisar-tbdm" class="btn btn-primary mt-2" style=""><i
                                        class="fa fa-search"></i> Pesquisar</button>
                            </div>

                        </div>

                        <div class="card card-primary-2">

                            <!-- CAMPO TEXTO -->
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="msg_text">Mensagem:</label>
                                    <textarea id="msg_text" name="msg_text" class="form-control  form-control-sm"></textarea>
                                </div>

                                <button type="button" id="btnSalvarMensagem" class="btn btn-primary mt-2" style=""><i
                                        class="fa fa-save"></i> Salvar
                                </button>
                            </div>

                            <b>AO CLICAR EM PESQUISAR:</b><br>
                            <b>FONTE:</b>
                            TBCF_MSG_COMP<br>
                            <b>FILTROS:</b>
                            MSG_CATEG = FILTRO DE CATEGORIA DE MENSAGEM (variável msg_categ)<br>
                            CANAL_ID = FILTRO DA CANAL DE COMUNICAÇÃO (variável canal_id)<br>
                            <br>
                            PLOTAR NO QUADRO msg_text O TEXTO QUE ESTIVER GRAVADO NA TABELA<br>
                            CASO NÃO TENHA NADA GRAVADO, DEIXAR EM BRANCO PARA QUE O USUÁRIO PREENCHA E SALVE NA TABELA<br>

                        </div>

                    </div>

                    <!---------------------------->
                    <!------- DADOS MESTRES ------>
                    <!---------------------------->
                    <div class="tab-pane fade" id="tabs-dados-mestres" role="tabpanel" aria-labelledby="tabs-dados-mestres-tab">

                        <!-- PRIMEIRA LINHA DO FORMULÁRIO DE PESQUISA -->
                        <div class="form-row">

                            <!-- FILTRO DE TABELA DE DADOS MESTRES -->
                            <div class="form-group col-md-3">
                                <label for="tabela-bdm">Tabela de Dados Mestre:</label>
                                <select id="tabela-bdm" name="tabela-bdm"
                                    class="form-control select2 select2-hidden-accessible"
                                    data-placeholder="Pesquise a Tabela de Dados Mestre" style="width: 100%;"
                                    aria-hidden="true">
                                </select>
                            </div>

                            <!-- BOTÃO PESQUISAR -->
                            <div class="form-group col-md-3 mt-4">
                                <button type="button" id="btnPesquisar-tbdm" class="btn btn-primary mt-2" style=""><i
                                        class="fa fa-search"></i> Pesquisar</button>
                            </div>

                        </div>

                        <div class="card card-primary">

                            <b>AO CLICAR EM PESQUISAR:</b><br>
                            <b>FONTE:</b>
                            TABELAS DO SISTEMA: DAR A OPÇÃO APENAS DAS TABELAS COM PREFIXO TBDM<br>
                            <br>
                            AO SELECIONAR UMA TABELA, O SISTEMA DEVE PLOTAR A ESTRUTURA DA TABELA NESTE ESPAÇO<br>
                            SE TIVER DADOS, FEVERÁ MOSTRAR O QUE JÁ TEM GRAVADO<br>
                            SE NÃO TIVER DADOS, FEVERÁ MOSTRAR O CABEÇÁLHO DA TABELA<br>
                            <br>
                            DEVEMOS TER A OPÇÃO DE INSERIR UM NOVO REGISTRO NA TABELA<br>
                            PRECISAMOS ACRESCENTAR UM BOTÃO "SALVAR" QUE IRÁ GRAVAR OS DADOS NO BANCO DE DADOS

                        </div>

                    </div>

                </div>
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
    <script src="{{ asset('assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/datatables-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/app.js') }}"></script>

    <!-- Carregar CKEditor 5 via CDN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#msg_text'))
            .catch(error => {
                console.error(error);
            });
    </script>

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
