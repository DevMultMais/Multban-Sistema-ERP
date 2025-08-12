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
                        <select id="parcela_sts" name="parcela_sts" class="form-control select2 select2-hidden-accessible"
                            data-placeholder="Pesquise o Status" style="width: 100%;" aria-hidden="true">
                        </select>
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

                    <div class="form-group col-md-2 align-self-end input-group-sm">
                        <button type="button" class="form-control form-control-sm btn btn-primary" id="btnPesquisarTitulo">
                            <i class="fa fa-search"></i> Pesquisar</button>
                    </div>

                </div>

            </div>

        </div>

        <!-- QUADRO DO GRID DE EMPRESAS -->
        <div class="card card-outline card-primary">

            <!-- CORPO DO QUADRO DO GRID DE EMPRESAS -->
            <div class="card-body">

                <!-- AÇÕES GERAIS -->
                <div class="form-row">
                    <div class="form-group col-md-2 align-self-end input-group-sm">
                        <button type="button" class="form-control form-control-sm btn btn-primary" id="btnImprimirTudo">
                            <i class="fas fa-shredder"></i> Imprimir Boletos</button>
                    </div>

                    <div class="form-group col-md-2 align-self-end input-group-sm">
                        <button type="button" class="form-control form-control-sm btn btn-primary" id="btnAlterarTudo">
                            <i class="fas fa-sync-alt"></i> Alteração em Massa</button>
                    </div>
                    <div class="form-group col-md-2 align-self-end input-group-sm">
                        <button type="button" class="form-control form-control-sm btn btn-primary" id="btnEnviarLinkCompra">
                            <i class="fas fa-money-check-edit-alt"></i> Enviar Link de Pagto</button>
                    </div>
                    <div class="form-group col-md-2 align-self-end input-group-sm">
                        <button type="button" class="form-control form-control-sm btn btn-primary" id="btnEnviarLinkFatura">
                            <i class="fas fa-credit-card"></i> Enviar Link da Fatura</button>
                    </div>
                </div>

                <div class="table-responsive table-sm">
                    <table id="gridtemplate" class="table table-striped table-bordered nowrap table-sm">
                        <thead>
                            <tr>
                                <th style="width: 20px;">
                                    <input type="checkbox" id="selectAll" class="mr-2" title="Selecionar Todos" />
                                </th>
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
                                    <td>2</td>
                                    <td>R$ 100,00</td>
                                    <td>R$ 1,50</td>
                                    <th>R$ 101,50</th>
                                    <td>Cartão</td>
                                    <td>10/05/2025</td>
                                    <td>10/07/2025</td>
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
                <br>
                Botão de Ação - Imprimir<br>
                    1. Imprimi o comprovante de pagamento referente ao título selecionado<br>
                <br>
                Botão de Ação - Manutenção de Título<br>
                    1. Abre uma nova tela, esta tela deverá ser criara no edit.blade pois terá todas as informações do título<br>
                    2. Nesta tela poderemos editar os dampos:<br>
                       Data de Vencimento (TABELA tbtr_p_titulos_ab / CAMPO data_venc)<br>
                       Desconto Manual (TABELA tbtr_p_titulos_ab / CAMPO vlr_desc_mn)<br>
                       Acréscimo Manual (TABELA tbtr_p_titulos_ab / CAMPO vlr_acr_mn)<br>
                <br>
                Botão de Ação - Pagar<br>
                    1. Deve abrir o link de pagamento do Título, neste link deve conter as informações para pagamento<br>
                       permitindo que o usuário possa escolhar PIX ou BOLETO<br>
                       Precisamos criar uma tela para este link, customizada e com a identidade visual da Multban<br>
                <br>
                Botão de Ação - Cancelar<br>
                    1. Para Cancelar, é obrigatório dar um motivo.
                    2. Se o cancelamento for de uma parcela de cartão de crédito e que não seja a última, o sistema deve informar ao usuário<br>
                       que todas as outras parcelas serão canceladas, pois não podemos cancelar uma única parcela de uma venda<br>
                       Se o cancelamento for de um boleto parcelado, o sistema deve perguntar se o usuário quer cancelar as demais parcelas<br>
                       se o usuário selecionar que SIM, todas as demais parcelas deverão ser canceladas<br>
                <br>
                Botão de Ação - Baixa Manual<br>
                    1. Abre um rela para Baixa Manual do Título, se for um lançamento de Cartão de Crédito, o sistema deve gerar<br>
                       um débito no valor do MDR do título e uma msg deve aparecer na tela informando que o MDR será cobrando<br>
                       se o cliente for optante de uma Wallet, o sistema deverá lançar um débito na Wallet, se o cliente for optante<br>
                       de uma Conta Digital, o sistema deverá criar um título em nome do cliente para que ele efetue o pagamento<br>
                    2. Se for um lançamento de um Boleto e este boleto já foi gerado pelo cliente final, o sistema deve gerar um débito<br>
                       na wallet com o valor do Boleto+PIX registrado no sistema, ou cria um título para pagamento com este valor,<br>
                       se for um lançamento de um Boleto ainda não gerado, o sistema apenas cancela o lançamento<br>
                <br>
                Botão de Ação - Cobrança<br>
                    1. Direciona para a tela de cobrança já com os filtros do título selecionado
            </div>

        </div>

    </section>

    <!-- Modal de Alteração em Massa -->
    <div class="modal fade" id="modalAlteracaoMassa" tabindex="-1" role="dialog" aria-labelledby="modalAlteracaoMassaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAlteracaoMassaLabel">
                        <i class="fas fa-sync-alt"></i> Alteração em Massa
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formAlteracaoMassa">
                        <div class="form-group">
                            <label for="nova_data_venc">Data de Vencimento:</label>
                            <input type="date" id="nova_data_venc" name="nova_data_venc" class="form-control form-control-sm" placeholder="Selecione a nova data de vencimento">
                            <small class="form-text text-muted">Deixe em branco para não alterar a data de vencimento</small>
                        </div>

                        <div class="form-group" id="tipoDataVencimentoGroup" style="display: none;">
                            <label>Tipo de Aplicação da Data de Vencimento:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo_data_vencimento" id="data_mesma" value="mesma_data" checked>
                                <label class="form-check-label" for="data_mesma">
                                    Utilizar a mesma data de vencimento para todos os títulos
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo_data_vencimento" id="data_base" value="data_base">
                                <label class="form-check-label" for="data_base">
                                    Utilizar a data selecionada como base para a primeira parcela e calcular as demais
                                </label>
                            </div>
                            <small class="form-text text-muted">Selecione como a data de vencimento será aplicada nos títulos selecionados</small>
                        </div>

                        <div class="form-group">
                            <label for="vlr_desc">Desconto:</label>
                            <input type="text" id="vlr_desc" name="vlr_desc" class="form-control form-control-sm money" placeholder="R$ 0,00">
                            <small class="form-text text-muted">Deixe em branco para não aplicar desconto</small>
                        </div>

                        <div class="form-group" id="tipoDescontoGroup" style="display: none;">
                            <label>Tipo de Aplicação do Desconto:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo_desconto" id="desconto_mesmo_valor" value="mesmo_valor" checked>
                                <label class="form-check-label" for="desconto_mesmo_valor">
                                    Aplicar o mesmo valor de desconto em todos os títulos
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo_desconto" id="desconto_dividir" value="dividir">
                                <label class="form-check-label" for="desconto_dividir">
                                    Dividir o valor igualmente para todos os títulos
                                </label>
                            </div>
                            <small class="form-text text-muted">Selecione como o desconto será aplicado nos títulos selecionados</small>
                        </div>

                        <div class="form-group">
                            <label for="negociacao_obs">Detalhes da Negociação:</label>
                            <textarea id="negociacao_obs" name="negociacao_obs" class="form-control form-control-sm" rows="8" placeholder="Descreva os detalhes das negociações e atendimento..."></textarea>
                            <small class="form-text text-muted">Informe todos os detalhes sobre as negociações realizadas</small>
                        </div>
                        <div class="alert alert-info" style="background-color: #ecba41; border-color: #ecba41; color: #000;">
                            <i class="fas fa-info-circle"></i>
                            <strong>Atenção:</strong> As alterações serão aplicadas apenas aos títulos selecionados na tabela.
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm" data-dismiss="modal" style="background-color: #a702d8; color: white; border-color: #a702d8;">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-primary btn-sm" id="btnExecutarMudancas">
                        <i class="fas fa-sync-alt"></i> Executar Mudanças
                    </button>
                </div>
            </div>
        </div>
    </div>

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
    <!-- jQuery Mask Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

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

            // Funcionalidade do checkbox "Selecionar Todos"
            $(document).on('click', '#selectAll', function() {
                var isChecked = $(this).is(':checked');
                $('#gridtemplate tbody input[type="checkbox"]').prop('checked', isChecked);
            });

            // Se algum checkbox individual for desmarcado, desmarcar o "Selecionar Todos"
            $(document).on('change', '#gridtemplate tbody input[type="checkbox"]', function() {
                var totalCheckboxes = $('#gridtemplate tbody input[type="checkbox"]').length;
                var checkedCheckboxes = $('#gridtemplate tbody input[type="checkbox"]:checked').length;

                if (totalCheckboxes > 0) {
                    if (checkedCheckboxes === totalCheckboxes) {
                        $('#selectAll').prop('checked', true);
                    } else {
                        $('#selectAll').prop('checked', false);
                    }
                }
            });

            // Botão Imprimir Todos
            $('#btnImprimirTudo').on('click', function() {
                var checkedCheckboxes = $('#gridtemplate tbody input[type="checkbox"]:checked').length;

                if (checkedCheckboxes === 0) {
                    Swal.fire({
                        title: 'Atenção!',
                        text: 'Selecione pelo menos um título para realizar a impressão.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Aqui você implementaria a lógica de impressão
                console.log(`Imprimindo ${checkedCheckboxes} título(s) selecionado(s)`);

                // Exemplo de confirmação
                Swal.fire({
                    title: 'Imprimir Títulos',
                    text: `Deseja imprimir ${checkedCheckboxes} título(s) selecionado(s)?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, imprimir',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // TODO: Implementar lógica de impressão
                        Swal.fire({
                            title: 'Sucesso!',
                            text: `${checkedCheckboxes} título(s) enviado(s) para impressão.`,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            // Botão Enviar Link de Pagamento da Compra
            $('#btnEnviarLinkCompra').on('click', function() {
                var checkedCheckboxes = $('#gridtemplate tbody input[type="checkbox"]:checked').length;

                if (checkedCheckboxes === 0) {
                    Swal.fire({
                        title: 'Atenção!',
                        text: 'Selecione pelo menos um título para enviar o link de pagamento da compra.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Confirmação antes de enviar
                Swal.fire({
                    title: 'Enviar Link de Pagamento da Compra',
                    text: `Deseja enviar o link de pagamento da compra para ${checkedCheckboxes} título(s) selecionado(s)?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, enviar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // TODO: Implementar lógica de envio do link da compra
                        console.log(`Enviando link de pagamento da compra para ${checkedCheckboxes} título(s)`);

                        Swal.fire({
                            title: 'Sucesso!',
                            text: `Link de pagamento da compra enviado para ${checkedCheckboxes} título(s).`,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            // Botão Enviar Link de Pagamento da Fatura
            $('#btnEnviarLinkFatura').on('click', function() {
                var checkedCheckboxes = $('#gridtemplate tbody input[type="checkbox"]:checked').length;

                if (checkedCheckboxes === 0) {
                    Swal.fire({
                        title: 'Atenção!',
                        text: 'Selecione pelo menos um título para enviar o link de pagamento da fatura.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Confirmação antes de enviar
                Swal.fire({
                    title: 'Enviar Link de Pagamento da Fatura',
                    text: `Deseja enviar o link de pagamento da fatura para ${checkedCheckboxes} título(s) selecionado(s)?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, enviar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // TODO: Implementar lógica de envio do link da fatura
                        console.log(`Enviando link de pagamento da fatura para ${checkedCheckboxes} título(s)`);

                        Swal.fire({
                            title: 'Sucesso!',
                            text: `Link de pagamento da fatura enviado para ${checkedCheckboxes} título(s).`,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            // Botão de Alteração em Massa
            $('#btnAlterarTudo').on('click', function() {
                var checkedCheckboxes = $('#gridtemplate tbody input[type="checkbox"]:checked').length;

                if (checkedCheckboxes === 0) {
                    Swal.fire({
                        title: 'Atenção!',
                        text: 'Selecione pelo menos um título para realizar a alteração em massa.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Limpa os campos do modal
                $('#nova_data_venc').val('');
                $('#desconto').val('');
                $('#tipoDataVencimentoGroup').hide();

                // Abre o modal
                $('#modalAlteracaoMassa').modal('show');
            });

            // Controlar visibilidade dos radio buttons de tipo de desconto
            $('#vlr_desc').on('input keyup', function() {
                var valor = $(this).val().trim();
                if (valor && valor !== '' && valor !== 'R$ 0,00') {
                    $('#tipoDescontoGroup').slideDown(300);
                } else {
                    $('#tipoDescontoGroup').slideUp(300);
                }
            });

            // Controlar visibilidade dos radio buttons de tipo de data de vencimento
            $('#nova_data_venc').on('input change', function() {
                var data = $(this).val().trim();
                if (data && data !== '') {
                    $('#tipoDataVencimentoGroup').slideDown(300);
                } else {
                    $('#tipoDataVencimentoGroup').slideUp(300);
                }
            });

            // Botão Executar Mudanças
            $('#btnExecutarMudancas').on('click', function() {
                var novaDataVencimento = $('#nova_data_venc').val();
                var desconto = $('#vlr_desc').val();
                var tipoDataVencimento = $('input[name="tipo_data_vencimento"]:checked').val();
                var checkedTitulos = [];

                // Coleta os títulos selecionados
                $('#gridtemplate tbody input[type="checkbox"]:checked').each(function() {
                    var row = $(this).closest('tr');
                    var tituloId = row.find('td:eq(3)').text(); // Título está na 4ª coluna
                    checkedTitulos.push(tituloId);
                });

                // Validação
                if (!novaDataVencimento && !desconto) {
                    Swal.fire({
                        title: 'Atenção!',
                        text: 'Preencha pelo menos um campo para realizar a alteração.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Validação de data futura
                if (novaDataVencimento) {
                    var hoje = new Date().toISOString().split('T')[0];
                    if (novaDataVencimento <= hoje) {
                        Swal.fire({
                            title: 'Data Inválida!',
                            text: 'A data de vencimento deve ser uma data futura.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }
                }

                // Confirmação antes de executar
                Swal.fire({
                    title: 'Confirmar Alteração',
                    text: `Deseja realmente alterar ${checkedTitulos.length} título(s) selecionado(s)?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, alterar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Aqui você faria a chamada AJAX para o backend
                        // Exemplo de estrutura de dados para enviar:
                        var dadosAlteracao = {
                            titulos: checkedTitulos,
                            nova_data_vencimento: novaDataVencimento,
                            tipo_data_vencimento: tipoDataVencimento,
                            desconto: desconto,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        };

                        // TODO: Implementar chamada AJAX
                        console.log('Dados para alteração:', dadosAlteracao);

                        // Simula sucesso - remover quando implementar AJAX real
                        $('#modalAlteracaoMassa').modal('hide');
                        Swal.fire({
                            title: 'Sucesso!',
                            text: `${checkedTitulos.length} título(s) alterado(s) com sucesso.`,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });

                        // Desmarcar todos os checkboxes
                        $('#gridtemplate tbody input[type="checkbox"]').prop('checked', false);
                        $('#selectAll').prop('checked', false);
                    }
                });
            });

            // Formatação de moeda para o campo desconto
            $('#desconto').mask('#.##0,00', {
                reverse: true,
                translation: {
                    '#': {pattern: /[0-9]/}
                }
            });
        });
    </script>
@endpush
