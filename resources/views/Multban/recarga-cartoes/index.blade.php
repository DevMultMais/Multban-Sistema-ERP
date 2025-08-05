@extends('layouts.app-master')
@section('page.title', 'Recarga Cartões')
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
                        <label for="Empresa">Empresa:</label>
                        <select id="empresa_id" name="empresa_id" class="form-control select2 select2-hidden-accessible"
                            data-placeholder="Pesquise a Empresa" style="width: 100%;" aria-hidden="true">
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
                        <div class="input-group input-group-sm">
                            <input type="text" id="cliente_doc" name="cliente_doc" class="form-control  form-control-sm" placeholder="Digite o CPF ou CNPJ">
                        </div>
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
                        <a class="nav-link active" id="tabs-fidelidade-tab" data-toggle="pill" href="#tabs-fidelidade" role="tab"
                            aria-controls="tabs-fidelidade" aria-selected="true">Cartão Fidelidade</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="tabs-gift-tab" data-toggle="pill" href="#tabs-gift" role="tab"
                            aria-controls="tabs-gift" aria-selected="false">Gift Card</a>
                    </li>

                </ul>
            </div>

            <!-- CORPO DAS ABAS -->
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-two-tabContent">

                    <!------------------------------->
                    <!---- ABA CARTÃO FIDELIDADE ---->
                    <!------------------------------->
                    <div class="tab-pane fade active show" id="tabs-fidelidade" role="tabpanel"
                        aria-labelledby="tabs-fidelidade-tab">

                        <!-- PRIMEIRA LINHA DO FORMULÁRIO DE PESQUISA -->
                        <div class="form-row">
                            <!-- BOTÃO PESQUISAR -->
                            <div class="form-group align-self-end">
                                <button type="button" class="form-control form-control-sm btn btn-primary" id="btnPesquisarFD" data-toggle="modal" data-target="#modalCartoesFD">
                                    <i class="fa fa-search"></i> Pesquisar</button>
                            </div>

                            <!-- CAMPO PARA APRESENTAR O NÚMERO DO CARTÃO -->
                            <div class="form-group col-md-2">
                                <label for="cliente_cardn">Número do Cartão Fidelidade:</label>
                                <input autocomplete="off" type="text" maxlength="20" class="form-control form-control-sm"
                                    id="cliente_cardn_fd" name="cliente_cardn" readonly>
                                <span id="cliente_cardncError" class="text-danger text-sm"></span>
                            </div>

                            <div class="form-group col-md-5 d-flex align-items-end">
                                <label id="card_desc_fd" class="mb-0 ml-3 font-weight-bold text-secondary">
                                    <!-- Aqui será exibida a descrição do cartão -->
                                    Descrição do Cartão Selecionado ...
                                </label>
                            </div>
                        </div>

                        <!-- BOTÃO CARREGAR CARTÃO FIDELIDADE -->
                        <div class="form-row mb-3">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" id="btnCarregarCartaoFD" data-toggle="modal" data-target="#modalCarregarCartaoFD">
                                    <i class="fa fa-credit-card"></i> Carregar Cartão Fidelidade
                                </button>
                            </div>
                        </div>

                        <div class="card card-primary">

                            <div class="table-responsive">
                                <table cid="gridtemplate" class="table table-striped table-bordered nowrap">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Data de Vencimento</th>
                                            <th>Valor</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Exemplo de dados estáticos -->
                                        <tr>
                                            <td>10/08/2025</td>
                                            <td>R$ 150,00</td>
                                            <td><span class="badge badge-success">Pago</span></td>
                                        </tr>
                                        <tr>
                                            <td>10/09/2025</td>
                                            <td>R$ 150,00</td>
                                            <td><span class="badge badge-warning">Pendente</span></td>
                                        </tr>
                                        <tr>
                                            <td>10/10/2025</td>
                                            <td>R$ 150,00</td>
                                            <td><span class="badge badge-danger">Vencido</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            O CAMPO EMPRESA DEVERÁ VIR PREENCHIDO COM A EMPRESA DO USUÁRIO LOGADO, SOMENTE<br>
                            NO CASO DO USUÁRIO SER DA MULTBAN OU DE UMA EMPRESA WHITE LABEL, ESTE CAMPO PODERÁ ESTAR DISPONÍVEL<br>
                            PARA SELECIONAR ALGUMA EMPRESA, NESTE CASO, ELE DEVE SEGUIR O PADRÃO DE CONSULTA, PESQUISANDO SOBRE O<br>
                            NOME MULTBAN<br>
                            <br>
                            AO SELECIONAR UM CLIENTE, O SISTEMA DEVE ARMAZENAR O CLIENTE_ID E O CLIENT_DOC DA TABELA TBDM_CLIENTES_GERAL<br>
                            <br>
                            AO CLICAR EM PESQUISAR, O SISTEMA DEVE UTILIZAR OS CAMPOS EMPRESA / CLIENTE_ID / CLIENTE_DOC PARA ACESSAR A TABELA<br>
                            TBDM_CLIENTES_CARD E TRAZER PARA A LISTA DO MODAL APENAS OS CARTÕES QUE TENHAM O CARD_MOD = FIDL<br>
                            <br>
                            AO SELECIONAR UM CARTÃO, O SISTEMA DEVE BUSCAR NAS TABELAS DE VENDAS, TODOS OS LANÇAMETNOS JÁ REALIZADOS PARA<br>
                            O CARTÃO SELECIONADO E MOSTRAR NA LISTAGEM LOGO ABAIXO<br>
                            <br>
                            PARA CLICAR EM CARREGAR CARTÃO, AO MENOS UM CARTÃO DEVE ESTAR SELECIONARO<br>
                            <br>
                            AO CLICAR EM CARREGAR CARTÃO, O SISTEMA ABRE UM MODAL COM O VALOR PRÉ-ESTABELECIDO DO CARTÃO SELECIONADO<br>
                            (ESTE VALOR ESTARA GRAVADO NA TABELA tbdm_cartoes_pre, NO CAMPO prg_valor)<br>
                            E OS CAMPOS DE QUANTIDADE DE MENSALIDADE E DATA DE VENCIMENTO. AO CLICAR EM FINALZIAR, O SISTEMA DEVE GERAR<br>
                            OS LANÇAMENTOS DE VENDAS NAS TABELAS PERTINENTES

                        </div>

                    </div>

                    <!--------------------->
                    <!--- ABA GIFT CARD --->
                    <!--------------------->
                    <div class="tab-pane fade" id="tabs-gift" role="tabpanel" aria-labelledby="tabs-gift-tab">

                        <!-- PRIMEIRA LINHA DO FORMULÁRIO DE PESQUISA -->
                        <div class="form-row">
                            <!-- BOTÃO PESQUISAR -->
                            <div class="form-group align-self-end">
                                <button type="button" class="form-control form-control-sm btn btn-primary" id="btnPesquisarGF" data-toggle="modal" data-target="#modalCartoesGF">
                                    <i class="fa fa-search"></i> Pesquisar</button>
                            </div>

                            <!-- CAMPO PARA APRESENTAR O NÚMERO DO CARTÃO -->
                            <div class="form-group col-md-2">
                                <label for="cliente_cardn">Número do Gift Card:</label>
                                <input autocomplete="off" type="text" maxlength="20" class="form-control form-control-sm"
                                    id="cliente_cardn_gf" name="cliente_cardn" readonly>
                                <span id="cliente_cardncError" class="text-danger text-sm"></span>
                            </div>

                            <div class="form-group col-md-5 d-flex align-items-end">
                                <label id="card_desc_gf" class="mb-0 ml-3 font-weight-bold text-secondary">
                                    <!-- Aqui será exibida a descrição do cartão -->
                                    Descrição do Cartão Selecionado ...
                                </label>
                            </div>
                        </div>

                        <!-- BOTÃO CARREGAR CARTÃO GIFT -->
                        <div class="form-row mb-3">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" id="btnCarregarCartaoGF" data-toggle="modal" data-target="#modalCarregarCartaoGF">
                                    <i class="fa fa-credit-card"></i> Carregar Gift Card
                                </button>
                            </div>
                        </div>

                        <div class="card card-primary">

                            <div class="table-responsive">
                                <table cid="gridtemplate" class="table table-striped table-bordered nowrap">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Data da Recarga</th>
                                            <th>Valor</th>
                                            <th>Saldo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Exemplo de dados estáticos -->
                                        <tr>
                                            <td>10/08/2025</td>
                                            <td>R$ 150,00</td>
                                            <td>R$ 150,00</td>
                                        </tr>
                                        <tr>
                                            <td>10/09/2025</td>
                                            <td>R$ 150,00</td>
                                            <td>R$ 0,00</td>
                                        </tr>
                                        <tr>
                                            <td>10/10/2025</td>
                                            <td>R$ 150,00</td>
                                            <td>R$ 0,00</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            O CAMPO EMPRESA DEVERÁ VIR PREENCHIDO COM A EMPRESA DO USUÁRIO LOGADO, SOMENTE<br>
                            NO CASO DO USUÁRIO SER DA MULTBAN OU DE UMA EMPRESA WHITE LABEL, ESTE CAMPO PODERÁ ESTAR DISPONÍVEL<br>
                            PARA SELECIONAR ALGUMA EMPRESA, NESTE CASO, ELE DEVE SEGUIR O PADRÃO DE CONSULTA, PESQUISANDO SOBRE O<br>
                            NOME MULTBAN<br>
                            <br>
                            AO SELECIONAR UM CLIENTE, O SISTEMA DEVE ARMAZENAR O CLIENTE_ID E O CLIENT_DOC DA TABELA TBDM_CLIENTES_GERAL<br>
                            <br>
                            AO CLICAR EM PESQUISAR, O SISTEMA DEVE UTILIZAR OS CAMPOS EMPRESA / CLIENTE_ID / CLIENTE_DOC PARA ACESSAR A TABELA<br>
                            TBDM_CLIENTES_CARD E TRAZER PARA A LISTA DO MODAL APENAS OS CARTÕES QUE TENHAM O CARD_MOD = FIDL<br>
                            <br>
                            AO SELECIONAR UM CARTÃO, O SISTEMA DEVE BUSCAR NAS TABELAS DE VENDAS, TODOS OS LANÇAMETNOS JÁ REALIZADOS PARA<br>
                            O CARTÃO SELECIONADO E MOSTRAR NA LISTAGEM LOGO ABAIXO<br>
                            <br>
                            PARA CLICAR EM CARREGAR CARTÃO, AO MENOS UM CARTÃO DEVE ESTAR SELECIONARO<br>
                            <br>
                            AO CLICAR EM CARREGAR CARTÃO, O SISTEMA ABRE UM MODAL COM O VALOR PRÉ-ESTABELECIDO DO CARTÃO SELECIONADO<br>
                            E OS CAMPOS DE QUANTIDADE DE MENSALIDADE E DATA DE VENCIMENTO. AO CLICAR EM FINALZIAR, O SISTEMA DEVE GERAR<br>
                            OS LANÇAMENTOS DE VENDAS NAS TABELAS PERTINENTES

                        </div>

                    </div>

                    <!-- Modal Lista de Cartões Fidelidade -->
                    <div class="modal fade" id="modalCartoesFD" tabindex="-1" role="dialog" aria-labelledby="modalCartoesFDLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Selecione um Cartão</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-hover" id="tabelaCartoesFD">
                                        <thead>
                                            <tr>
                                                <th>Tipo do Cartão</th>
                                                <th>Modalidade</th>
                                                <th>Descrição</th>
                                                <th>Status</th>
                                                <th>Número do Cartão</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <!-- Exemplo de dados estáticos -->
                                            <tr class="linha-cartao-fd" data-numero="1234.5678.9012.3456" data-descricao="Cartão Fidelidade - Plano de Saúde">
                                                <td>Pré Pago</td>
                                                <td>Fidelidade</td>
                                                <td>Cartão Fidelidade - Plano de Saúde</td>
                                                <td>Ativo</td>
                                                <td>1234.5678.9012.3456</td>
                                            </tr>
                                            <tr class="linha-cartao-fd" data-numero="9876.5432.1098.7654" data-descricao="Cartão Fidelidade - Plano Odontológico">
                                                <td>Pré Pago</td>
                                                <td>Fidelidade</td>
                                                <td>Cartão Fidelidade - Plano Odontológico</td>
                                                <td>Bloqueado</td>
                                                <td>9876.5432.1098.7654</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Lista de Cartões Gift -->
                    <div class="modal fade" id="modalCartoesGF" tabindex="-1" role="dialog" aria-labelledby="modalCartoesGFLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Selecione um Cartão</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-hover" id="tabelaCartoesGF">
                                        <thead>
                                            <tr>
                                                <th>Tipo do Cartão</th>
                                                <th>Modalidade</th>
                                                <th>Descrição</th>
                                                <th>Status</th>
                                                <th>Número do Cartão</th>
                                                <th>Saldo</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <!-- Exemplo de dados estáticos -->
                                            <tr class="linha-cartao-gf" data-numero="1234.5678.9012.3456" data-descricao="Cartão Gift - Dia das Mães">
                                                <td>Pré Pago</td>
                                                <td>Gift Card</td>
                                                <td>Cartão Gift - Dia das Mães</td>
                                                <td>Ativo</td>
                                                <td>1234.5678.9012.3456</td>
                                                <td>R$ 10,00</td>
                                            </tr>
                                            <tr class="linha-cartao-gf" data-numero="9876.5432.1098.7654" data-descricao="Cartão Gift - Dia dos Namorados">
                                                <td>Pré Pago</td>
                                                <td>Gift Card</td>
                                                <td>Cartão Gift - Dia dos Namorados</td>
                                                <td>Ativo</td>
                                                <td>9876.5432.1098.7654</td>
                                                <td>R$ 0,00</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Carregar Cartão Fidelidade -->
                    <div class="modal fade" id="modalCarregarCartaoFD" tabindex="-1" role="dialog" aria-labelledby="modalCarregarCartaoFDLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form>
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Carregar Cartão</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Valor (não editável) -->
                                        <div class="form-group">
                                            <label for="card_limite">Valor:</label>
                                            <input type="text" id="card_limite" class="form-control" value="R$ 150,00" readonly>
                                        </div>
                                        <!-- Quantidade de Mensalidades -->
                                        <div class="form-group">
                                            <label for="qtd_mensalidades">Quantidade de Mensalidades:</label>
                                            <input type="number" id="qtd_mensalidades" class="form-control" min="1" value="1">
                                        </div>
                                        <!-- Vencimento Para -->
                                        <div class="form-group">
                                            <label for="vencimento_para">Vencimento Para:</label>
                                            <input type="date" id="vencimento_para" class="form-control">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" id="btnFinalizarCarregamento">
                                            <i class="fa fa-check"></i> Finalizar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Modal Carregar Cartão Gift -->
                    <div class="modal fade" id="modalCarregarCartaoGF" tabindex="-1" role="dialog" aria-labelledby="modalCarregarCartaoGFLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form>
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Carregar Gift Card</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Valor (não editável) -->
                                        <div class="form-group">
                                            <label for="card_limite">Valor da Recarga:*</label>
                                            <input autocomplete="off" type="text" class="form-control money form-control-sm" id="card_limite"
                                                name="card_limite" placeholder="0,00">
                                            <span id="card_limiteError" class="text-danger text-sm"></span>
                                        </div>
                                        <!-- Vencimento Para -->
                                        <div class="form-group">
                                            <label for="vencimento_para">Vencimento Para:</label>
                                            <input type="date" id="vencimento_para" class="form-control">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" id="btnFinalizarCarregamento">
                                            <i class="fa fa-check"></i> Finalizar
                                        </button>
                                    </div>
                                </div>
                            </form>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
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

            $(function() {
                // Ao clicar em uma linha da tabela do modal
                $('#tabelaCartoesFD').on('click', '.linha-cartao-fd', function() {
                    var numero = $(this).data('numero');
                    var descricao = $(this).data('descricao');
                    $('#cliente_cardn_fd').val(numero);
                    $('#card_desc_fd').text(descricao);
                    $('#modalCartoesFD').modal('hide');
                });
            });

            $(function() {
                // Ao clicar em uma linha da tabela do modal
                $('#tabelaCartoesGF').on('click', '.linha-cartao-gf', function() {
                    var numero = $(this).data('numero');
                    var descricao = $(this).data('descricao');
                    $('#cliente_cardn_gf').val(numero);
                    $('#card_desc_gf').text(descricao);
                    $('#modalCartoesGF').modal('hide');
                });
            });

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

            $('#cliente_cardn').mask('0000.0000.0000.0000');
                                                                                                                                                                                                                                                                                                                                                            });
    </script>
@endpush
