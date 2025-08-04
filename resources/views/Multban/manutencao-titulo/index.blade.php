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

                    <!-- FILTRO DO NOME DA EMPRESA -->
                    <div class="form-group col-md-3">
                        <label for="emp_id">Empresa:</label>
                        <select id="emp_id" name="emp_id" class="form-control select2 select2-hidden-accessible"
                            data-placeholder="Pesquise a Empresa" style="width: 100%;" aria-hidden="true">
                        </select>
                    </div>

                </div>

                <!-- SEGUNDA LINHA DO FORMULÁRIO DE PESQUISA -->
                <div class="form-row">

                    <!-- FILTRO DO USUÁRIO -->
                    <div class="form-group col-md-3">
                        <label for="user_id">Usuário:</label>
                        <select id="user_id" name="user_id" class="form-control select2 select2-hidden-accessible"
                            data-placeholder="Pesquise o Usuário" style="width: 100%;" aria-hidden="true">
                        </select>
                    </div>

                    <!-- NÚMERO DO TÍTULO -->
                    <div class="form-group col-md-3">
                        <label for="titulo">Número do Título:</label>
                        <input type="text" id="titulo" name="titulo" class="form-control cnpj form-control-sm"
                            placeholder="Digite o Título" />
                    </div>

                    <!-- NÚMERO DO TÍTULO -->
                    <div class="form-group col-md-3">
                        <label for="meio_pag">Meio de Pagamento:</label>
                        <select id="meio_pag" name="meio_pag" class="form-control select2 select2-hidden-accessible"
                            data-placeholder="Pesquise o Meio de Pagamento" style="width: 100%;" aria-hidden="true">
                        </select>
                    </div>

                </div>

                <!-- TERCEIRA LINHA DO FORMULÁRIO DE PESQUISA -->
                <div class="form-row">

                    <div class="form-group col-md-3">
                        <label for="cliente_doc">CPF/CNPJ - Do Cliente:</label>
                        <div class="input-group input-group-sm">
                            <input type="text" id="cliente_doc" name="cliente_doc" class="form-control  form-control-sm" placeholder="Digite o CPF ou CNPJ">
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="parcela_sts">Status:</label>
                        <div class="input-group input-group-sm">
                            <input type="text" id="parcela_sts" name="parcela_sts" class="form-control  form-control-sm" placeholder="Digite o CPF ou CNPJ">
                        </div>
                    </div>

                    <div class="form-group col-md-3 d-flex align-items-center mt-3">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="check_reemb" id="check_reemb">
                            <label for="check_reemb" class="custom-control-label">Reembolso</label>
                        </div>
                    </div>

                </div>

                <!-- QUARTA LINHA DO FORMULÁRIO DE PESQUISA -->
                <div class="form-row">

                    <div class="form-group col-md-3 input-group-sm">
                        <label for="data_mov">Data da Venda:</label>
                        <input type="date" id="data_mov" class="form-control">
                    </div>

                    <div class="form-group col-md-3 input-group-sm">
                        <label for="data_venc">Datra de Vencimento:</label>
                        <input type="date" id="data_venc" class="form-control">
                    </div>

                    <div class="form-group col-md-3 input-group-sm">
                        <label for="data_pgto">Datra do Pagamento:</label>
                        <input type="date" id="data_pgto" class="form-control">
                    </div>

                    <div class="form-group col-md-3 align-self-end input-group-sm">
                        <button type="button" class="form-control form-control-sm btn btn-primary" id="btnPesquisarTitulo" data-toggle="modal" data-target="#modalCartoesFD">
                            <i class="fa fa-search"></i> Pesquisar</button>
                    </div>

                </div>

            </div>

        </div>

        <!-- QUADRO DO GRID DE EMPRESAS -->
        <div class="card card-outline card-primary">

            <!-- CORPO DO QUADRO DO GRID DE EMPRESAS -->
            <div class="card-body">

                <div class="table-responsive">
                    <table id="gridtemplate" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th style="width: 20px;"></th>
                                <th style="width: 230px;">Ações</th>
                                <th>ID Emp.</th>
                                <th>Título</th>
                                <th>Cliente</th>
                                <th>Parcela</th>
                                <th>Vlr. Init.</th>
                                <th>Vlr. Jrs.</th>
                                <th>Vlr. Tot.</th>
                                <th>Meio Pgto</th>
                                <th>Data Venda</th>
                                <th>Data Venc.</th>
                                <th>Status</th>
                            </tr>

                            <!-- Exemplo de dados estáticos -->
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="mr-2" />
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary mt-1" title="Imprimir Comprovante">
                                            <i class="fas fa-print"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary mt-1" title="Manutenção de Título">
                                            <i class="fas fa-wrench"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary mt-1" title="Pagar">
                                            <i class="fas fa-usd-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary mt-1" title="Cancelar">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary mt-1" title="Baixa Manual">
                                            <i class="fas fa-hands-usd"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary mt-1" title="Cobrança">
                                            <i class="far fa-file-invoice-dollar"></i>
                                        </button>
                                    </td>
                                    <td>1</td>
                                    <td>12345</td>
                                    <td>Cliente Teste</td>
                                    <td>1</td>
                                    <td>R$ 100,00</td>
                                    <td>R$ 1,50</td>
                                    <th>R$ 101,50</th>
                                    <td>Cartão</td>
                                    <td>10/05/2025</td>
                                    <td>10/06/2025</td>
                                    <td><span class="badge badge-success">Pago</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="mr-2" />
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary mt-1" title="Imprimir Comprovante">
                                            <i class="fas fa-print"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary mt-1" title="Manutenção de Título">
                                            <i class="fas fa-wrench"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary mt-1" title="Pagar">
                                            <i class="fas fa-usd-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary mt-1" title="Cancelar">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary mt-1" title="Baixa Manual">
                                            <i class="fas fa-hands-usd"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary mt-1" title="Cobrança">
                                            <i class="far fa-file-invoice-dollar"></i>
                                        </button>
                                    </td>
                                    <td>1</td>
                                    <td>12345</td>
                                    <td>Cliente Teste</td>
                                    <td>2</td>
                                    <td>R$ 100,00</td>
                                    <td>R$ 1,50</td>
                                    <th>R$ 101,50</th>
                                    <td>Cartão</td>
                                    <td>10/05/2025</td>
                                    <td>10/07/2025</td>
                                    <td><span class="badge badge-danger">Vencido</span></td>
                                </tr>

                            </tbody>
                        </thead>
                    </table>
                </div>

                O CAMPO EMPRESA DEVERÁ VIR PREENCHIDO COM A EMPRESA DO USUÁRIO LOGADO, SOMENTE<br>
                NO CASO DO USUÁRIO SER DA MULTBAN OU DE UMA EMPRESA WHITE LABEL, ESTE CAMPO PODERÁ ESTAR DISPONÍVEL<br>
                PARA SELECIONAR ALGUMA EMPRESA, NESTE CASO, ELE DEVE SEGUIR O PADRÃO DE CONSULTA, PESQUISANDO SOBRE O<br>
                NOME MULTBAN<br>
                <br>
                AO SELECIONAR UM CLIENTE, O SISTEMA DEVE ARMAZENAR O CLIENTE_ID E O CLIENT_DOC DA TABELA TBDM_CLIENTES_GERAL<br>
                <br>
                AO CLICAR EM PESQUISAR, O SISTEMA DEVE UTILIZAR OS CAMPOS DO FILTRO PARA ACESSAR AS TABELAS DE VENDA<br>
                E TRAZER PARA A LISTA TODOS OS LANÇAMENTOS QUE CONDIZEM COM OS FILTROS<br>
                <br>
                OS BOTÕES QUE TEMOS NO CAMPO AÇÃO, SERÃO PARA:<br>
                IMPRIMIR - IMPRIME O COMPROVANTE DE PAGAMENTO REFERENTE AO TÍTULO SELECIONADO<br>
                MANUTENÇÃO DE TÍTULO - ABRE UMA NOVA TELA, ESTA TELA DEVERÁ SER CRIADA NO EDIT.BLADE POIS TERÁ TODAS AS INFORMAÇÕES<br>
                                       DO TÍTULO SELECIONADO, E NESTA TELA PODEREMOS EDITAR OS CAMPOS DATA DE VENCIMENTO (SOMENTE DATA FUTURA)<br>
                                       DESCONTO, ACRÉSCIMO<br>
                PAGAR - DEVE ABRIR O LINK PARA PAGAMENTO DO TÍTULO<br>
                CABCELAR - CANCELA O TÍTULO, PARA CANCELAR, É OBRIGATÓRIO DAR UM MOTIVO, SE O CANCELAMENTO FOR DE UMA PARCELA<br>
                           QUE NÃO SEJA A ÚLTIMA, O SISTEMA DEVE INFORMAR SE O RESTANTE DA VENDA TAMBÉM SERÁ CANCELADA<br>
                BAIXA MANUAL - ABRE UMA TELA PARA BAIXA MANUAL DO TÍTULO, NESTE CASO, SE FOR LANÇAMENTO DE CARTÃO DE CRÉDITO<br>
                               O SISTEMA DEVE GERAR UM DÉBITO NO VALOR DO MDR DO TÍTULO E UMA MSG DEVE APARCER NA TELA,<br>
                               INFORMANDO QUE O MDR SERÁ COBRADO
                COBRANÇA - ABRE UMA TELA PARA COBRANÇA DO TÍTULO, AO INICIAR UM FLUXO DE COBRANÇA, OS DADOS SERÃO GRAVADOS EM UMA TABELA<br>
                           ESPECÍFICA, PORTANTO, SE CLICAR NESTE BOTÃO E NÃO TIVER NENHUM FLUXO DE COBRANÇA INICIADO, O SISTEMA<br>
                           DEVERÁ QUESTIONAR SE O USUÁRIO DESEJA REALMENTE INICIAR O FLUXO DE COBRANÇA



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
