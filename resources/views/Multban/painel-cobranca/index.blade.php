@extends('layouts.app-master')
@section('page.title', 'Painel de Cobrança')
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
                                <th style="width: 305px;">Ações</th>
                                <th>Emp.</th>
                                <th>Título</th>
                                <th>Cliente</th>
                                <th>Parcela</th>
                                <th>Vencimento</th>
                                <th>Dias em Atr.</th>
                                <th>Valor</th>
                                <th>Multa</th>
                                <th>Juros</th>
                                <th>Isentar M/J</th>
                                <th>Negociação</th>
                                <th>Status</th>
                            </tr>

                            <!-- Exemplo de dados estáticos -->
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="mr-2" />
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary mt-1 btn-negociacao-simples" title="Negociação Simples">
                                            <i class="fas fa-handshake-alt"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary mt-1 btn-desdobrar-parcela" title="Desdobrar a parcela">
                                            <i class="fas fa-share-all"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary mt-1 btn-isentar-multa-juros" title="Isentar multa e juros">
                                            <i class="fas fa-virus-slash"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary mt-1 btn-negociacao-multa-juros" title="Negociação Multa e Juros">
                                            <i class="fas fa-hand-holding-usd"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary mt-1 btn-reparcelar-titulo" title="Reparcelar Título">
                                            <i class="fas fa-sitemap"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary mt-1 btn-enviar-cobranca" title="Enviar Cobrança">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary mt-1 btn-atendimento" title="Atendimento">
                                            <i class="fas fa-user-friends"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary mt-1 btn-protestar-titulo" title="Protestar Título">
                                            <i class="fas fa-gavel"></i>
                                        </button>
                                    </td>
                                    <th>1</th>
                                    <th>1234</th>
                                    <th>Cliente</th>
                                    <th>02</th>
                                    <th>01/06/2025</th>
                                    <th>60</th>
                                    <th>R$ 100,00</th>
                                    <th>R$ 20,00</th>
                                    <th>R$ 11,50</th>
                                    <th></th>
                                    <th></th>
                                    <td><span class="badge badge-danger">Vencido</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="mr-2" />
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary mt-1 btn-negociacao-simples" title="Negociação Simples">
                                            <i class="fas fa-handshake-alt"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary mt-1 btn-desdobrar-parcela" title="Desdobrar a parcela">
                                            <i class="fas fa-share-all"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary mt-1 btn-isentar-multa-juros" title="Isentar multa e juros">
                                            <i class="fas fa-virus-slash"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary mt-1 btn-negociacao-multa-juros" title="Negociação Multa e Juros">
                                            <i class="fas fa-hand-holding-usd"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary mt-1 btn-reparcelar-titulo" title="Reparcelar Título">
                                            <i class="fas fa-sitemap"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary mt-1 btn-enviar-cobranca" title="Enviar Cobrança">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary mt-1 btn-atendimento" title="Atendimento">
                                            <i class="fas fa-user-friends"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary mt-1 btn-protestar-titulo" title="Protestar Título">
                                            <i class="fas fa-gavel"></i>
                                        </button>
                                    </td>
                                    <th>1</th>
                                    <th>5678</th>
                                    <th>Cliente</th>
                                    <th>03</th>
                                    <th>01/07/2025</th>
                                    <th>30</th>
                                    <th>R$ 100,00</th>
                                    <th>R$ 20,00</th>
                                    <th>R$ 11,50</th>
                                    <th></th>
                                    <th></th>
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
                PARA ESTA TELA DE COBRANÇA, O FLTRO DE STATUS DEVE VIR PRÉ-PREENCHIDO COM O O STATUS "VENCIDO", MAS DEVEMOS PERMITIR<br>
                QUE O USUÁRIO POSSA SELECIONAR OUTROS STATUS<br>
                <br>
                AO SELECIONAR UM CLIENTE, O SISTEMA DEVE ARMAZENAR O CLIENTE_ID E O CLIENT_DOC DA TABELA TBDM_CLIENTES_GERAL<br>
                <br>
                AO CLICAR EM PESQUISAR, O SISTEMA DEVE UTILIZAR OS CAMPOS DO FILTRO PARA ACESSAR AS TABELAS DE VENDA<br>
                E TRAZER PARA A LISTA TODOS OS LANÇAMENTOS QUE CONDIZEM COM OS FILTROS<br>
                <br>
                Botão de Ação - Negociação Simples<br>
                    1. Dar desconto total - proporciona nos itens<br>
                    2. Dar desconto unitário - em apenas um item<br>
                    3. Mudar a data de vencimento<br>
                <br>
                Botão de Ação - Desdobrar a parcela<br>
                    1. Reparcelar ( pega a parcela e divide em mais parcelas - recalcula o split apenas da parcela atual<br>
                       jogando para as demais parcelas criadas )<br>
                    2. Cria novas parcelas referenciadas ao ID original, cancelar a parcela original com o status "Negociação Desdobramento"<br>
                <br>
                Botão de Ação - Isentar multa e juros<br>
                    1. Flega o campo da tabela que indica esta condição<br>
                    2. Zera multa e juros - somente se o campo Negociação manual não estiver selecionado<br>
                <br>
                Botão de Ação - Negociação Multa e Juros<br>
                    4. Flega o campo que indica esta condição e desabilita o cálculo de multa e juros automático<br>
                    5. Mudar multa e juros por atraso<br>
                <br>
                Botão de Ação - Reparcelar Título<br>
                    1. Aumentar o número de parcelas - o sistema deve calcular o saldo devedor e dividir pelo novo número de parcelas<br>
                    2. Deve cancelar todas as parcelas em aberto com o status "Negociação Reparcelamento"<br>
                    3. Deve criar as novas parcelas, neste caso não precisa de referência pois estamos reparcelando o titulo<br>
                <br>
                Botão de Ação - Enviar Cobrança<br>
                    1. Deve abrir um modal para selecionar qual o canal de comunicação TBDM_CANAL_CMC<br>
                    2. Deve ter um segundo campo para selecionar qual categoria de texto de cobrança quer enviar TBDM_MSG_CATEG<br>
                    3. Deve puxar o padrão de texto da tabela tbcf_msg_comp<br>
                    4. Neste modal deve ter um campo de texto, que será preenchido com o padrão da msg selecionada<br>
                       e deve permitir que o usuário possa alterar<br>
                    5. Deve ter um botão ENVIAR e outro CANCELAR<br>
                <br>
                Botão de Ação - Atendimento<br>
                    1. Deve abrir um modal separado com duas áreas, uma primeira a direita, com um campo texto livre<br>
                       para que o usuário descreva os detalhes das negociações, e uma segunda a esquerda com uma tela<br>
                       emulando o WhatsApp, nesta tela deve ter o histórico de conversa realizada pelo Robo de Cobrança<br>
                       ou pelo atendente<br>
                    2. Nesta tela devemos permitir que o usuário interaja com o usuário e converse como se estivesse no WhatsApp<br>
                    3. Logo abaixo, devemos ter um campo de data indicando a data do próximo follow-up, esta data será<br>
                       utilizada pelo processo interno de lembrete<br>
                <br>
                Botão de Ação - Protestar Título<br>
                    1. Faz a integração com o Protesto 24 horas
            </div>

        </div>

    </section>

    <!-- Modal de Negociação Simples -->
    <div class="modal fade" id="modalNegociacaoSimples" tabindex="-1" role="dialog" aria-labelledby="modalNegociacaoSimplesLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalNegociacaoSimplesLabel">
                        <i class="fas fa-handshake-alt"></i> Negociação Simples
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formNegociacaoSimples">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="desconto_total">Desconto Total no Título:</label>
                                    <input type="text" id="desconto_total" name="desconto_total" class="form-control form-control-sm money" placeholder="R$ 0,00">
                                    <small class="form-text text-muted">Informe o valor do desconto a ser aplicado no título</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="data_venc">Data de Vencimento:</label>
                                    <input type="date" id="data_venc" name="data_venc" class="form-control form-control-sm">
                                    <small class="form-text text-muted">Selecione a nova data de vencimento</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h6><i class="fas fa-table"></i> Itens do Título</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th style="width: 150px;">Código do Item</th>
                                                <th style="width: 150px;">Valor Total</th>
                                                <th style="width: 150px;">Desconto</th>
                                            </tr>
                                        </thead>
                                        <tbody id="itensNegociacao">
                                            <tr>
                                                <td>ITEM001</td>
                                                <td>R$ 50,00</td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm money desconto-item" placeholder="R$ 0,00" data-item="ITEM001">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>ITEM002</td>
                                                <td>R$ 30,00</td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm money desconto-item" placeholder="R$ 0,00" data-item="ITEM002">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>ITEM003</td>
                                                <td>R$ 20,00</td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm money desconto-item" placeholder="R$ 0,00" data-item="ITEM003">
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr class="table-info">
                                                <th>Total:</th>
                                                <th id="valorTotalItens">R$ 100,00</th>
                                                <th id="descontoTotalItens">R$ 0,00</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="negociacao_obs">Observação:</label>
                                    <textarea id="negociacao_obs" name="negociacao_obs" class="form-control form-control-sm" rows="4" placeholder="Descreva os detalhes da negociação de multa e juros..."></textarea>
                                    <small class="form-text text-muted">Informe detalhes sobre os critérios e condições da negociação</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="follow_dt">Próxima Data de Follow Up:</label>
                                    <input type="date" id="follow_dt" name="follow_dt" class="form-control form-control-sm">
                                    <small class="form-text text-muted">Selecione a nova data</small>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info" style="background-color: #ecba41; border-color: #ecba41; color: #000;">
                            <i class="fas fa-info-circle"></i>
                            <strong>Atenção:</strong> O desconto pode ser aplicado de forma total no título ou individualmente por item. Se informar o desconto total, ele será distribuído proporcionalmente entre os itens.
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm" data-dismiss="modal" style="background-color: #a702d8; color: white; border-color: #a702d8;">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-primary btn-sm" id="btnSalvarNegociacao">
                        <i class="fas fa-save"></i> Salvar Negociação
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Desdobrar Parcela -->
    <div class="modal fade" id="modalDesdobrarParcela" tabindex="-1" role="dialog" aria-labelledby="modalDesdobrarParcelaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDesdobrarParcelaLabel">
                        <i class="fas fa-share-all"></i> Desdobrar Parcela
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formDesdobrarParcela">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="total_parcelas">Total de Parcelas:</label>
                                    <input type="number" id="total_parcelas" name="total_parcelas" class="form-control form-control-sm" min="2" max="99" placeholder="Ex: 3">
                                    <small class="form-text text-muted">Informe em quantas parcelas deseja dividir o valor atual (mínimo 2, máximo 99)</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="data_venc">Data da Primeira Parcela:</label>
                                    <input type="date" id="data_venc" name="data_venc" class="form-control form-control-sm">
                                    <small class="form-text text-muted">Selecione a nova data</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="negociacao_obs">Observação:</label>
                                    <textarea id="negociacao_obs" name="negociacao_obs" class="form-control form-control-sm" rows="4" placeholder="Descreva os detalhes da negociação de multa e juros..."></textarea>
                                    <small class="form-text text-muted">Informe detalhes sobre os critérios e condições da negociação</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="follow_dt">Próxima Data de Follow Up:</label>
                                    <input type="date" id="follow_dt" name="follow_dt" class="form-control form-control-sm">
                                    <small class="form-text text-muted">Selecione a nova data</small>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info" style="background-color: #ecba41; border-color: #ecba41; color: #000;">
                            <i class="fas fa-info-circle"></i>
                            <strong>Atenção:</strong> O valor da parcela atual será dividido igualmente entre o número de parcelas informado. A parcela original será cancelada com status "Negociação Desdobramento" e novas parcelas serão criadas.
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm" data-dismiss="modal" style="background-color: #a702d8; color: white; border-color: #a702d8;">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-primary btn-sm" id="btnSalvarDesdobramento">
                        <i class="fas fa-save"></i> Salvar Desdobramento
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Negociação Multa e Juros -->
    <div class="modal fade" id="modalNegociacaoMultaJuros" tabindex="-1" role="dialog" aria-labelledby="modalNegociacaoMultaJurosLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalNegociacaoMultaJurosLabel">
                        <i class="fas fa-hand-holding-usd"></i> Negociação Multa e Juros
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formNegociacaoMultaJuros">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="vlr_acr_mn">Valor de Acréscimo Negociado:</label>
                                    <input type="text" id="vlr_acr_mn" name="vlr_acr_mn" class="form-control form-control-sm money" placeholder="R$ 0,00">
                                    <small class="form-text text-muted">Informe o valor da multa e juros a ser aplicado manualmente</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="negociacao_obs">Observação:</label>
                                    <textarea id="negociacao_obs" name="negociacao_obs" class="form-control form-control-sm" rows="4" placeholder="Descreva os detalhes da negociação de multa e juros..."></textarea>
                                    <small class="form-text text-muted">Informe detalhes sobre os critérios e condições da negociação</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="follow_dt">Próxima Data de Follow Up:</label>
                                    <input type="date" id="follow_dt" name="follow_dt" class="form-control form-control-sm">
                                    <small class="form-text text-muted">Selecione a nova data</small>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info" style="background-color: #ecba41; border-color: #ecba41; color: #000;">
                            <i class="fas fa-info-circle"></i>
                            <strong>Atenção:</strong> Esta negociação desabilitará o cálculo automático de multa e juros por atraso.
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm" data-dismiss="modal" style="background-color: #a702d8; color: white; border-color: #a702d8;">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-primary btn-sm" id="btnSalvarNegociacaoMultaJuros">
                        <i class="fas fa-save"></i> Salvar Negociação
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Reparcelar Título -->
    <div class="modal fade" id="modalReparcelarTitulo" tabindex="-1" role="dialog" aria-labelledby="modalReparcelarTituloLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalReparcelarTituloLabel">
                        <i class="fas fa-sitemap"></i> Reparcelar Título
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formReparcelarTitulo">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="total_parcelas_reparcelar">Total de Parcelas:</label>
                                    <input type="number" id="total_parcelas_reparcelar" name="total_parcelas_reparcelar" class="form-control form-control-sm" min="2" max="999" placeholder="Ex: 12">
                                    <small class="form-text text-muted">Informe o novo número total de parcelas para o reparcelamento (mínimo 2, máximo 999)</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="data_venc">Data da Primeira Parcela:</label>
                                    <input type="date" id="data_venc" name="data_venc" class="form-control form-control-sm">
                                    <small class="form-text text-muted">Selecione a nova data</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="negociacao_obs">Observação:</label>
                                    <textarea id="negociacao_obs" name="negociacao_obs" class="form-control form-control-sm" rows="4" placeholder="Descreva os detalhes da negociação de multa e juros..."></textarea>
                                    <small class="form-text text-muted">Informe detalhes sobre os critérios e condições da negociação</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="follow_dt">Próxima Data de Follow Up:</label>
                                    <input type="date" id="follow_dt" name="follow_dt" class="form-control form-control-sm">
                                    <small class="form-text text-muted">Selecione a nova data</small>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info" style="background-color: #ecba41; border-color: #ecba41; color: #000;">
                            <i class="fas fa-info-circle"></i>
                            <strong>Atenção:</strong> O sistema calculará o saldo devedor e dividirá pelo novo número de parcelas. Todas as parcelas em aberto serão canceladas com status "Negociação Reparcelamento" e novas parcelas serão criadas.
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm" data-dismiss="modal" style="background-color: #a702d8; color: white; border-color: #a702d8;">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-primary btn-sm" id="btnSalvarReparcelamento">
                        <i class="fas fa-save"></i> Salvar Reparcelamento
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Atendimento -->
    <div class="modal fade" id="modalAtendimento" tabindex="-1" role="dialog" aria-labelledby="modalAtendimentoLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAtendimentoLabel">
                        <i class="fas fa-user-friends"></i> Atendimento da Cobrança
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Área da Esquerda - Campo de Texto e Data -->
                        <div class="col-md-6">
                            <form id="formAtendimento">
                                <div class="form-group">
                                    <label for="parcela_obs">Detalhes do Atendimento:</label>
                                    <textarea id="parcela_obs" name="parcela_obs" class="form-control form-control-sm" rows="5" placeholder="Descreva os detalhes das negociações e atendimento..."></textarea>
                                    <small class="form-text text-muted">Informe todos os detalhes sobre os atendimentos realizados</small>
                                </div>

                                <div class="form-group">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <label for="negociacao_obs" class="mb-0">Detalhes da Negociação:</label>
                                        <button type="button" id="btnExpandirNegociacao" class="btn btn-sm btn-outline-secondary" title="Expandir/Recolher campo">
                                            <i class="fas fa-plus" id="iconExpandirNegociacao"></i>
                                        </button>
                                    </div>
                                    <div id="campoNegociacaoObs" style="display: none;">
                                        <textarea id="negociacao_obs" name="negociacao_obs" class="form-control form-control-sm mt-2" rows="5" placeholder="Descreva os detalhes das negociações e atendimento..."></textarea>
                                        <small class="form-text text-muted">Informe todos os detalhes sobre as negociações realizadas</small>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="data_followup">Próximo Follow-up:</label>
                                    <input type="date" id="data_followup" name="data_followup" class="form-control form-control-sm">
                                    <small class="form-text text-muted">Data para próximo contato/lembrete</small>
                                </div>

                                <!-- Área de Arquivos da Negociação -->
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="mb-0">
                                                    <i class="fas fa-folder-open"></i> Arquivos da Negociação
                                                </h6>
                                            </div>
                                            <div class="card-body p-3">

                                                <!-- Upload de Arquivos -->
                                                <div class="row">
                                                    <div>
                                                        <div class="form-group">
                                                            <label for="arquivos_negociacao">Selecionar Arquivos:</label>
                                                            <input type="file" id="arquivos_negociacao" name="arquivos_negociacao[]" class="form-control-file" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.txt,.xlsx,.xls">
                                                            <small class="form-text text-muted">Formatos aceitos: PDF, DOC, DOCX, JPG, PNG, TXT, XLS, XLSX (máx. 10MB por arquivo)</small>
                                                        </div>
                                                        <button type="button" class="btn btn-sm btn-primary" id="btnAdicionarArquivo">
                                                            <i class="fas fa-plus"></i> Adicionar Arquivo
                                                        </button>
                                                    </div>
                                                </div>

                                                <!-- Lista de Arquivos -->
                                                <div class="row">
                                                    <div>
                                                        <label>Arquivos Adicionados:</label>
                                                        <div id="listaArquivos" class="border rounded p-2" style="min-height: 120px; max-height: 200px; overflow-y: auto; background-color: #f8f9fa;">
                                                            <div class="text-muted text-center p-3" id="msgSemArquivos">
                                                                <i class="fas fa-folder-open fa-2x mb-2"></i><br>
                                                                Nenhum arquivo adicionado
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </form>
                        </div>

                        <!-- Área da Direita - Simulação WhatsApp -->
                        <div class="col-md-6">
                            <div class="card" style="height: 500px;">
                                <div class="card-header bg-success text-white" style="background-color: #25d366 !important;">
                                    <i class="fab fa-whatsapp"></i> <strong>Histórico de Conversas</strong>
                                </div>

                                <!-- Área de Mensagens -->
                                <div class="card-body p-2" id="whatsapp-chat" style="height: 380px; overflow-y: auto; background-color: #ece5dd;">

                                    <!-- Mensagem do Robô -->
                                    <div class="message-container mb-2">
                                        <div class="message robot-message" style="background-color: #ffffff; padding: 8px 12px; border-radius: 10px; margin-bottom: 5px; max-width: 80%; float: left; clear: both;">
                                            <small class="text-muted"><i class="fas fa-robot"></i> Robô de Cobrança</small><br>
                                            Olá! Identificamos que você possui uma parcela em atraso. Gostaria de negociar?
                                            <br><small class="text-muted">10:30</small>
                                        </div>
                                        <div style="clear: both;"></div>
                                    </div>

                                    <!-- Mensagem do Cliente -->
                                    <div class="message-container mb-2">
                                        <div class="message client-message" style="background-color: #dcf8c6; padding: 8px 12px; border-radius: 10px; margin-bottom: 5px; max-width: 80%; float: right; clear: both;">
                                            <small class="text-muted"><i class="fas fa-user"></i> Cliente</small><br>
                                            Sim, gostaria de negociar. Qual o valor atual?
                                            <br><small class="text-muted">10:35</small>
                                        </div>
                                        <div style="clear: both;"></div>
                                    </div>

                                    <!-- Mensagem do Atendente -->
                                    <div class="message-container mb-2">
                                        <div class="message attendant-message" style="background-color: #e3f2fd; padding: 8px 12px; border-radius: 10px; margin-bottom: 5px; max-width: 80%; float: left; clear: both;">
                                            <small class="text-muted"><i class="fas fa-headset"></i> Atendente</small><br>
                                            O valor atual com juros é R$ 131,50. Posso oferecer um desconto para pagamento à vista.
                                            <br><small class="text-muted">10:40</small>
                                        </div>
                                        <div style="clear: both;"></div>
                                    </div>

                                </div>

                                <!-- Campo de Nova Mensagem -->
                                <div class="card-footer p-2">
                                    <div class="input-group">
                                        <input type="text" id="nova_mensagem" class="form-control form-control-sm" placeholder="Digite sua mensagem...">
                                        <div class="input-group-append">
                                            <button class="btn btn-success btn-sm" type="button" id="btnEnviarMensagem">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="alert alert-info mt-3" style="background-color: #ecba41; border-color: #ecba41; color: #000;">
                                <i class="fas fa-info-circle"></i>
                                <strong>Atenção:</strong> Use a área de chat para interagir com o cliente e a área de texto para registrar detalhes das negociações. A data de follow-up será usada para lembretes automáticos.
                            </div>
                            <button type="button" class="btn btn-sm" data-dismiss="modal" style="background-color: #a702d8; color: white; border-color: #a702d8;">
                                <i class="fas fa-times"></i> Cancelar
                            </button>
                            <button type="button" class="btn btn-primary btn-sm" id="btnSalvarAtendimento">
                                <i class="fas fa-save"></i> Salvar Atendimento
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

            // Botão de Negociação Simples
            $(document).on('click', '.btn-negociacao-simples', function() {
                // Limpa os campos do modal
                $('#desconto_total').val('');
                $('#data_vencimento_negociacao').val('');
                $('.desconto-item').val('');
                $('#descontoTotalItens').text('R$ 0,00');

                // Abre o modal
                $('#modalNegociacaoSimples').modal('show');
            });

            // Função para atualizar o total de descontos dos itens
            function atualizarTotalDescontos() {
                var totalDesconto = 0;
                $('.desconto-item').each(function() {
                    var valor = $(this).val().replace(/[^\d,]/g, '').replace(',', '.');
                    if (valor && !isNaN(parseFloat(valor))) {
                        totalDesconto += parseFloat(valor);
                    }
                });

                $('#descontoTotalItens').text('R$ ' + totalDesconto.toFixed(2).replace('.', ','));
            }

            // Eventos para recalcular total quando os descontos dos itens mudarem
            $(document).on('blur', '.desconto-item', function() {
                atualizarTotalDescontos();
            });

            // Função para distribuir desconto total proporcionalmente entre os itens
            $('#desconto_total').on('blur', function() {
                var descontoTotal = $(this).val().replace(/[^\d,]/g, '').replace(',', '.');
                if (descontoTotal && !isNaN(parseFloat(descontoTotal))) {
                    var valorTotalItens = 100; // R$ 100,00 no exemplo
                    var percentualDesconto = parseFloat(descontoTotal) / valorTotalItens;

                    // Aplicar desconto proporcional em cada item
                    $('#itensNegociacao tr').each(function() {
                        var valorItem = $(this).find('td:eq(1)').text().replace(/[^\d,]/g, '').replace(',', '.');
                        if (valorItem && !isNaN(parseFloat(valorItem))) {
                            var descontoItem = parseFloat(valorItem) * percentualDesconto;
                            $(this).find('.desconto-item').val('R$ ' + descontoItem.toFixed(2).replace('.', ','));
                        }
                    });

                    atualizarTotalDescontos();
                }
            });

            // Botão Salvar Negociação
            $('#btnSalvarNegociacao').on('click', function() {
                var descontoTotal = $('#desconto_total').val();
                var dataVencimento = $('#data_venc').val();
                var itensComDesconto = [];

                // Coleta os descontos dos itens
                $('.desconto-item').each(function() {
                    var desconto = $(this).val();
                    var item = $(this).data('item');
                    if (desconto && desconto !== 'R$ 0,00') {
                        itensComDesconto.push({
                            item: item,
                            desconto: desconto
                        });
                    }
                });

                // Validação - pelo menos um campo deve ser preenchido
                if (!descontoTotal && !dataVencimento && itensComDesconto.length === 0) {
                    Swal.fire({
                        title: 'Atenção!',
                        text: 'Preencha pelo menos um campo para realizar a negociação.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Validação de data futura
                if (dataVencimento) {
                    var hoje = new Date().toISOString().split('T')[0];
                    if (dataVencimento <= hoje) {
                        Swal.fire({
                            title: 'Data Inválida!',
                            text: 'A data de vencimento deve ser uma data futura.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }
                }

                // Confirmação antes de salvar
                Swal.fire({
                    title: 'Confirmar Negociação',
                    text: 'Deseja realmente salvar esta negociação?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, salvar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Dados para envio
                        var dadosNegociacao = {
                            desconto_total: descontoTotal,
                            data_vencimento: dataVencimento,
                            itens_desconto: itensComDesconto,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        };

                        // TODO: Implementar chamada AJAX para o backend
                        console.log('Dados da negociação:', dadosNegociacao);

                        // Simula sucesso - remover quando implementar AJAX real
                        $('#modalNegociacaoSimples').modal('hide');
                        Swal.fire({
                            title: 'Sucesso!',
                            text: 'Negociação salva com sucesso.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            // Botão de Desdobrar Parcela
            $(document).on('click', '.btn-desdobrar-parcela', function() {
                // Limpa os campos do modal
                $('#total_parcelas').val('');

                // Abre o modal
                $('#modalDesdobrarParcela').modal('show');
            });

            // Botão Salvar Desdobramento
            $('#btnSalvarDesdobramento').on('click', function() {
                var totalParcelas = $('#total_parcelas').val();

                // Validação - campo obrigatório
                if (!totalParcelas || totalParcelas === '') {
                    Swal.fire({
                        title: 'Atenção!',
                        text: 'Informe o total de parcelas para realizar o desdobramento.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Validação - valor mínimo
                if (parseInt(totalParcelas) < 2) {
                    Swal.fire({
                        title: 'Valor Inválido!',
                        text: 'O número mínimo de parcelas é 2.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Validação - valor máximo
                if (parseInt(totalParcelas) > 99) {
                    Swal.fire({
                        title: 'Valor Inválido!',
                        text: 'O número máximo de parcelas é 99.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Confirmação antes de salvar
                Swal.fire({
                    title: 'Confirmar Desdobramento',
                    text: `Deseja realmente desdobrar a parcela em ${totalParcelas} parcelas?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, desdobrar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Dados para envio
                        var dadosDesdobramento = {
                            total_parcelas: parseInt(totalParcelas),
                            _token: $('meta[name="csrf-token"]').attr('content')
                        };

                        // TODO: Implementar chamada AJAX para o backend
                        console.log('Dados do desdobramento:', dadosDesdobramento);

                        // Simula sucesso - remover quando implementar AJAX real
                        $('#modalDesdobrarParcela').modal('hide');
                        Swal.fire({
                            title: 'Sucesso!',
                            text: `Parcela desdobrada em ${totalParcelas} parcelas com sucesso.`,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            // Botão de Negociação Multa e Juros
            $(document).on('click', '.btn-negociacao-multa-juros', function() {
                // Limpa os campos do modal
                $('#valor_negociacao').val('');
                $('#observacao_negociacao').val('');

                // Abre o modal
                $('#modalNegociacaoMultaJuros').modal('show');
            });

            // Botão Salvar Negociação Multa e Juros
            $('#btnSalvarNegociacaoMultaJuros').on('click', function() {
                var valorNegociacao = $('#valor_negociacao').val();
                var observacao = $('#observacao_negociacao').val();

                // Validação - pelo menos um campo deve ser preenchido
                if (!valorNegociacao && !observacao) {
                    Swal.fire({
                        title: 'Atenção!',
                        text: 'Preencha pelo menos um campo para realizar a negociação.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Validação - valor da negociação deve ser informado
                if (!valorNegociacao || valorNegociacao.trim() === '' || valorNegociacao === 'R$ 0,00') {
                    Swal.fire({
                        title: 'Valor Obrigatório!',
                        text: 'Informe o valor da negociação de multa e juros.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Confirmação antes de salvar
                Swal.fire({
                    title: 'Confirmar Negociação',
                    text: 'Deseja realmente aplicar esta negociação de multa e juros? O cálculo automático será desabilitado.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, aplicar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Dados para envio
                        var dadosNegociacaoMultaJuros = {
                            valor_negociacao: valorNegociacao,
                            observacao: observacao,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        };

                        // TODO: Implementar chamada AJAX para o backend
                        console.log('Dados da negociação de multa e juros:', dadosNegociacaoMultaJuros);

                        // Simula sucesso - remover quando implementar AJAX real
                        $('#modalNegociacaoMultaJuros').modal('hide');
                        Swal.fire({
                            title: 'Sucesso!',
                            text: 'Negociação de multa e juros aplicada com sucesso.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            // Botão de Reparcelar Título
            $(document).on('click', '.btn-reparcelar-titulo', function() {
                // Limpa os campos do modal
                $('#total_parcelas_reparcelar').val('');

                // Abre o modal
                $('#modalReparcelarTitulo').modal('show');
            });

            // Botão Salvar Reparcelamento
            $('#btnSalvarReparcelamento').on('click', function() {
                var totalParcelas = $('#total_parcelas_reparcelar').val();

                // Validação - campo obrigatório
                if (!totalParcelas || totalParcelas === '') {
                    Swal.fire({
                        title: 'Atenção!',
                        text: 'Informe o total de parcelas para realizar o reparcelamento.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Validação - valor mínimo
                if (parseInt(totalParcelas) < 2) {
                    Swal.fire({
                        title: 'Valor Inválido!',
                        text: 'O número mínimo de parcelas é 2.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Validação - valor máximo
                if (parseInt(totalParcelas) > 999) {
                    Swal.fire({
                        title: 'Valor Inválido!',
                        text: 'O número máximo de parcelas é 999.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Confirmação antes de salvar
                Swal.fire({
                    title: 'Confirmar Reparcelamento',
                    text: `Deseja realmente reparcelar o título em ${totalParcelas} parcelas? Todas as parcelas em aberto serão canceladas e novas parcelas serão criadas.`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, reparcelar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Dados para envio
                        var dadosReparcelamento = {
                            total_parcelas: parseInt(totalParcelas),
                            _token: $('meta[name="csrf-token"]').attr('content')
                        };

                        // TODO: Implementar chamada AJAX para o backend
                        console.log('Dados do reparcelamento:', dadosReparcelamento);

                        // Simula sucesso - remover quando implementar AJAX real
                        $('#modalReparcelarTitulo').modal('hide');
                        Swal.fire({
                            title: 'Sucesso!',
                            text: `Título reparcelado em ${totalParcelas} parcelas com sucesso.`,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            // Botão de Atendimento
            $(document).on('click', '.btn-atendimento', function() {
                // Limpa os campos do modal
                $('#detalhes_negociacao').val('');
                $('#data_followup').val('');
                $('#nova_mensagem').val('');

                // Limpa os arquivos
                arquivosNegociacao = [];
                $('#listaArquivos').empty().append(`
                    <div class="text-muted text-center p-3" id="msgSemArquivos">
                        <i class="fas fa-folder-open fa-2x mb-2"></i><br>
                        Nenhum arquivo adicionado
                    </div>
                `);

                // Abre o modal
                $('#modalAtendimento').modal('show');

                // Foca na área de chat
                setTimeout(function() {
                    $('#whatsapp-chat').scrollTop($('#whatsapp-chat')[0].scrollHeight);
                    verificarConteudoInicialNegociacao();
                }, 500);
            });

            // Função para adicionar mensagem no chat
            function adicionarMensagem(tipo, texto) {
                var agora = new Date();
                var hora = agora.getHours().toString().padStart(2, '0') + ':' + agora.getMinutes().toString().padStart(2, '0');
                var icone = '';
                var classeCSS = '';
                var autor = '';
                var alinhamento = '';

                switch(tipo) {
                    case 'atendente':
                        icone = '<i class="fas fa-headset"></i>';
                        classeCSS = 'attendant-message';
                        autor = 'Atendente';
                        alinhamento = 'float: left;';
                        break;
                    case 'cliente':
                        icone = '<i class="fas fa-user"></i>';
                        classeCSS = 'client-message';
                        autor = 'Cliente';
                        alinhamento = 'float: right;';
                        break;
                    case 'robo':
                        icone = '<i class="fas fa-robot"></i>';
                        classeCSS = 'robot-message';
                        autor = 'Robô de Cobrança';
                        alinhamento = 'float: left;';
                        break;
                }

                var corFundo = '';
                if (tipo === 'cliente') {
                    corFundo = '#dcf8c6';
                } else if (tipo === 'atendente') {
                    corFundo = '#e3f2fd';
                } else {
                    corFundo = '#ffffff';
                }

                var htmlMensagem = `
                    <div class="message-container mb-2">
                        <div class="message ${classeCSS}" style="background-color: ${corFundo}; padding: 8px 12px; border-radius: 10px; margin-bottom: 5px; max-width: 80%; ${alinhamento} clear: both;">
                            <small class="text-muted">${icone} ${autor}</small><br>
                            ${texto}
                            <br><small class="text-muted">${hora}</small>
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                `;

                $('#whatsapp-chat').append(htmlMensagem);
                $('#whatsapp-chat').scrollTop($('#whatsapp-chat')[0].scrollHeight);
            }

            // Botão Enviar Mensagem
            $('#btnEnviarMensagem').on('click', function() {
                var mensagem = $('#nova_mensagem').val().trim();

                if (mensagem === '') {
                    Swal.fire({
                        title: 'Atenção!',
                        text: 'Digite uma mensagem antes de enviar.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Adiciona mensagem do atendente
                adicionarMensagem('atendente', mensagem);

                // Limpa o campo
                $('#nova_mensagem').val('');

                // Simula resposta do cliente (opcional - remover em produção)
                setTimeout(function() {
                    var respostasAuto = [
                        'Entendi, obrigado pela informação.',
                        'Posso fazer o pagamento hoje à tarde.',
                        'Qual seria o valor com desconto?',
                        'Preciso verificar minha disponibilidade financeira.',
                        'Vou providenciar o pagamento.'
                    ];
                    var respostaAleatoria = respostasAuto[Math.floor(Math.random() * respostasAuto.length)];
                    adicionarMensagem('cliente', respostaAleatoria);
                }, 2000);
            });

            // Enter para enviar mensagem
            $('#nova_mensagem').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#btnEnviarMensagem').click();
                }
            });

            // Funcionalidade de Arquivos da Negociação
            var arquivosNegociacao = [];

            // Botão para adicionar arquivos
            $('#btnAdicionarArquivo').on('click', function() {
                $('#arquivos_negociacao').click();
            });

            // Evento de mudança no input de arquivos
            $('#arquivos_negociacao').on('change', function() {
                var files = this.files;

                for (var i = 0; i < files.length; i++) {
                    var file = files[i];

                    // Validação de tamanho (10MB)
                    if (file.size > 10 * 1024 * 1024) {
                        Swal.fire({
                            title: 'Arquivo muito grande!',
                            text: `O arquivo "${file.name}" excede o tamanho máximo de 10MB.`,
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                        continue;
                    }

                    // Adicionar arquivo à lista
                    var arquivoObj = {
                        nome: file.name,
                        tamanho: file.size,
                        tipo: file.type,
                        arquivo: file
                    };

                    arquivosNegociacao.push(arquivoObj);
                    adicionarArquivoNaLista(arquivoObj, arquivosNegociacao.length - 1);
                }

                // Limpar o input
                $(this).val('');

                // Ocultar mensagem "sem arquivos"
                if (arquivosNegociacao.length > 0) {
                    $('#msgSemArquivos').hide();
                }
            });

            // Função para adicionar arquivo na lista visual
            function adicionarArquivoNaLista(arquivo, index) {
                var tamanhoFormatado = formatarTamanhoArquivo(arquivo.tamanho);
                var iconeArquivo = obterIconeArquivo(arquivo.nome);

                var htmlArquivo = `
                    <div class="arquivo-item mb-2 p-2 border rounded" data-index="${index}">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="${iconeArquivo} mr-2"></i>
                                <div>
                                    <div class="font-weight-bold text-truncate" style="max-width: 200px;" title="${arquivo.nome}">
                                        ${arquivo.nome}
                                    </div>
                                    <small class="text-muted">${tamanhoFormatado}</small>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-remover-arquivo" data-index="${index}">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                `;

                $('#listaArquivos').append(htmlArquivo);
            }

            // Remover arquivo da lista
            $(document).on('click', '.btn-remover-arquivo', function() {
                var index = $(this).data('index');

                // Remover do array
                arquivosNegociacao.splice(index, 1);

                // Remover da lista visual
                $(this).closest('.arquivo-item').remove();

                // Reindexar os elementos restantes
                $('#listaArquivos .arquivo-item').each(function(i) {
                    $(this).attr('data-index', i);
                    $(this).find('.btn-remover-arquivo').attr('data-index', i);
                });

                // Mostrar mensagem "sem arquivos" se necessário
                if (arquivosNegociacao.length === 0) {
                    $('#msgSemArquivos').show();
                }
            });

            // Função para formatar tamanho do arquivo
            function formatarTamanhoArquivo(bytes) {
                if (bytes === 0) return '0 Bytes';
                var k = 1024;
                var sizes = ['Bytes', 'KB', 'MB', 'GB'];
                var i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Função para obter ícone do arquivo baseado na extensão
            function obterIconeArquivo(nomeArquivo) {
                var extensao = nomeArquivo.split('.').pop().toLowerCase();

                switch (extensao) {
                    case 'pdf':
                        return 'fas fa-file-pdf text-danger';
                    case 'doc':
                    case 'docx':
                        return 'fas fa-file-word text-primary';
                    case 'xls':
                    case 'xlsx':
                        return 'fas fa-file-excel text-success';
                    case 'jpg':
                    case 'jpeg':
                    case 'png':
                        return 'fas fa-file-image text-info';
                    case 'txt':
                        return 'fas fa-file-alt text-secondary';
                    default:
                        return 'fas fa-file text-muted';
                }
            }

            // Botão Salvar Atendimento
            $('#btnSalvarAtendimento').on('click', function() {
                var detalhesNegociacao = $('#detalhes_negociacao').val();
                var dataFollowup = $('#data_followup').val();

                // Coleta o histórico de chat
                var historicoChat = [];
                $('#whatsapp-chat .message').each(function() {
                    var mensagem = $(this).clone();
                    mensagem.find('small').remove(); // Remove os elementos de hora e autor
                    historicoChat.push(mensagem.text().trim());
                });

                // Validação - pelo menos um campo deve ser preenchido
                if (!detalhesNegociacao && !dataFollowup && historicoChat.length <= 3) {
                    Swal.fire({
                        title: 'Atenção!',
                        text: 'Preencha os detalhes da negociação ou defina uma data de follow-up.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Validação de data futura para follow-up
                if (dataFollowup) {
                    var hoje = new Date().toISOString().split('T')[0];
                    if (dataFollowup <= hoje) {
                        Swal.fire({
                            title: 'Data Inválida!',
                            text: 'A data de follow-up deve ser uma data futura.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }
                }

                // Confirmação antes de salvar
                Swal.fire({
                    title: 'Confirmar Atendimento',
                    text: 'Deseja realmente salvar este registro de atendimento?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, salvar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Dados para envio
                        var dadosAtendimento = {
                            detalhes_negociacao: detalhesNegociacao,
                            data_followup: dataFollowup,
                            historico_chat: historicoChat,
                            arquivos_negociacao: arquivosNegociacao.map(function(arquivo) {
                                return {
                                    nome: arquivo.nome,
                                    tamanho: arquivo.tamanho,
                                    tipo: arquivo.tipo
                                };
                            }),
                            _token: $('meta[name="csrf-token"]').attr('content')
                        };

                        // TODO: Implementar chamada AJAX para o backend
                        console.log('Dados do atendimento:', dadosAtendimento);

                        // Simula sucesso - remover quando implementar AJAX real
                        $('#modalAtendimento').modal('hide');
                        Swal.fire({
                            title: 'Sucesso!',
                            text: 'Atendimento registrado com sucesso.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    }
                });
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
                $('#vlr_desc').val('');
                $('#tipoDescontoGroup').hide();
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
                var tipoDesconto = $('input[name="tipo_desconto"]:checked').val();
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
                            tipo_desconto: tipoDesconto,
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

            // Formatação de moeda para os campos do modal de negociação
            $('#desconto_total').mask('#.##0,00', {
                reverse: true,
                translation: {
                    '#': {pattern: /[0-9]/}
                }
            });

            // Formatação de moeda para os campos de desconto dos itens
            $(document).on('focus', '.desconto-item', function() {
                $(this).mask('#.##0,00', {
                    reverse: true,
                    translation: {
                        '#': {pattern: /[0-9]/}
                    }
                });
            });

            // Formatação de moeda para o campo de valor da negociação multa e juros
            $('#valor_negociacao').mask('#.##0,00', {
                reverse: true,
                translation: {
                    '#': {pattern: /[0-9]/}
                }
            });

            // Funcionalidade do campo expandível "Detalhes da Negociação"
            $('#btnExpandirNegociacao').on('click', function() {
                var campo = $('#campoNegociacaoObs');
                var icone = $('#iconExpandirNegociacao');

                if (campo.is(':visible')) {
                    // Verificar se há conteúdo antes de recolher
                    var conteudo = $('#negociacao_obs').val().trim();
                    if (conteudo) {
                        Swal.fire({
                            title: 'Atenção!',
                            text: 'Há conteúdo no campo. Deseja realmente recolher?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Sim, recolher',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                campo.slideUp(300);
                                icone.removeClass('fa-minus').addClass('fa-plus');
                            }
                        });
                    } else {
                        campo.slideUp(300);
                        icone.removeClass('fa-minus').addClass('fa-plus');
                    }
                } else {
                    campo.slideDown(300);
                    icone.removeClass('fa-plus').addClass('fa-minus');
                }
            });

            // Auto-expandir quando o usuário começar a digitar
            $('#negociacao_obs').on('input', function() {
                var campo = $('#campoNegociacaoObs');
                var icone = $('#iconExpandirNegociacao');

                if (!campo.is(':visible')) {
                    campo.slideDown(300);
                    icone.removeClass('fa-plus').addClass('fa-minus');
                }
            });

            // Função para verificar conteúdo inicial e expandir se necessário
            function verificarConteudoInicialNegociacao() {
                var conteudo = $('#negociacao_obs').val().trim();
                if (conteudo) {
                    var campo = $('#campoNegociacaoObs');
                    var icone = $('#iconExpandirNegociacao');
                    campo.show();
                    icone.removeClass('fa-plus').addClass('fa-minus');
                }
            }
        });
    </script>
@endpush
