@extends('layouts.app-master')
@section('page.title', 'Produtos')
@push('script-head')
<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<!-- Main content -->
<section class="content">
    @if($routeAction)
    <form class="form-horizontal" id="formPrincipal" role="form" method="POST"
        action="{{ route('produtos.update', $produto->produto_id) }}">
        @method('PATCH')
        @else

        <form class="form-horizontal" id="formPrincipal" role="form" method="POST"
            action="{{ route('produtos.store') }}">
            @method('POST')
            @endif

            @include('Multban.template.updatetemplate')
            <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-header p-0 pt-1 border-bottom-0">
                    <!--ABA/TAB-->
                    <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="tabs-dados-tab" data-toggle="pill" href="#tabs-dados" role="tab" aria-controls="tabs-dados" aria-selected="true">Dados Gerais</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-two-tabContent">

                        <div class="tab-pane fade active show" id="tabs-dados" role="tabpanel" aria-labelledby="tabs-dados-tab">

                            <div class="card card-primary">

                                <div class="card-body">
                                    <!-- PRIMEIRA LINHA DE DADOS -->
                                    <div class="form-row">

                                        <div class="form-group col-md-2">
                                            <label for="produto_id">Código do Produto:</label>
                                            <div class="input-group input-group-sm">
                                                <input autocomplete="off" type="text" class="form-control  form-control-sm" id="produto_id" name="produto_id" placeholder="Código do Produto" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="dthr_cr">Data de Cadastro:</label>
                                            <input autocomplete="off" readonly class="form-control  form-control-sm" placeholder="Data de cadastro" name="dthr_cr" type="text" id="dthr_cr"
                                            value="">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="dthr_ch">Última atualização:</label>
                                            <input autocomplete="off" readonly class="form-control  form-control-sm" placeholder="Última atualização" name="dthr_ch" type="text" id="dthr_ch"
                                            value="">
                                        </div>

                                    </div>

                                    <!-- SEGUNDA LINHA DE DADOS -->
                                    <div class="form-row">

                                        <div class="form-group col-md-2">
                                            <label for="produto_tipo">Tipo de Produto:</label>
                                            <div class="input-group input-group-sm">
                                                <select class="form-control select2" id="produto_tipo" name="produto_tipo" data-placeholder="Selecione o Status" style="width: 100%;">
                                                    <option></option>
                                                    <option value="op">Buscar dados da tabela TBDM_PRODUTO_TP</option>
                                                    <option value="1">Produto</option>
                                                    <option value="2">Serviço</option>
                                                    <option value="3">Participante</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="produto_sts">Status:</label>
                                            <div class="input-group input-group-sm">
                                                <select class="form-control select2" id="produto_sts" name="produto_sts" data-placeholder="Selecione o Status" style="width: 100%;">
                                                    <option></option>
                                                    <option value="op">Buscar dados da tabela TBDM_PRODUTO_STS</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="produto_vlr">Preço de Venda:</label>
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">R$</span>
                                                </div>
                                                <input type="text" class="form-control  form-control-sm" id="produto_vlr" name="produto_vlr" placeholder="Valor de Venda" required>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- TERCEIRA LINHA DE DADOS -->
                                    <div class="form-row">

                                        <div class="form-group col-md-2">
                                            <label for="produto_dc">Descrição Curta:</label>
                                            <div class="input-group input-group-sm">
                                                <input autocomplete="off" type="text" class="form-control  form-control-sm" id="produto_dc" name="produto_dc" placeholder="Descrição Curta" required maxlength="15">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="produto_dm">Descrição Média:</label>
                                            <div class="input-group input-group-sm">
                                                <input autocomplete="off" type="text" class="form-control  form-control-sm" id="produto_dm" name="produto_dm" placeholder="Descrição Média" required maxlength="100">
                                            </div>
                                        </div>

                                    </div>

                                    <!-- QUARTA LINHA DE DADOS -->
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="produto_dl">Descrição Longa:</label>
                                            <div class="input-group input-group-sm">
                                                <input autocomplete="off" type="text" class="form-control  form-control-sm" id="produto_dl" name="produto_dl" placeholder="Descrição Longa" required maxlength="255">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="produto_dt">Descrição Técnica:</label>
                                            <div class="input-group input-group-sm">
                                                <input autocomplete="off" type="text" class="form-control  form-control-sm" id="produto_dt" name="produto_dt" placeholder="Descrição Técnica" maxlength="255">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- QUINTA LINHA DE DADOS -->
                                    <div class="form-row">

                                    </div>

                                    <!-- Campos Adicionais -->
                                    <div id="camposAdicionais" style="display: none;">

                                        <!-- Campos para Participante -->
                                        <div id="camposParticipante" style="display: none;">
                                            <div class="row">
                                                <div class="form-group col-md-2">
                                                    <label for="partcp_pvlaor">% de Participação:</label>
                                                    <input type="number" class="form-control  form-control-sm" id="partcp_pvlaor" name="partcp_pvlaor" placeholder="% de Participação" step="0.01">
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label for="partcp_seller">Id de Integração - Seller:</label>
                                                    <input type="text" class="form-control  form-control-sm" id="partcp_seller" name="partcp_seller" placeholder="Id de Integração">
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label>Pagar Por:</label><br>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="pagarPor" id="partcp_pgsplit" value="partcp_pgsplit">
                                                        <label class="form-check-label" for="partcp_pgsplit">Split</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="pagarPor" id="partcp_pgtransf" value="partcp_pgtransf">
                                                        <label class="form-check-label" for="partcp_pgtransf">Transferência Bancária</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-2" id="campoBanco" style="display: none;">
                                                    <label for="partcp_cdgbc">Cdg Banco:</label>
                                                    <select class="form-control select2" id="partcp_cdgbc" name="partcp_cdgbc" data-placeholder="Selecione o Status" style="width: 100%;">
                                                        <option></option>
                                                        <option value="01">Banco 1</option>
                                                        <option value="02">Banco 2</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-2" id="campoAgencia" style="display: none;">
                                                    <label for="partcp_agbc">Agência:</label>
                                                    <input type="text" class="form-control  form-control-sm" id="partcp_agbc" name="partcp_agbc" placeholder="Agência">
                                                </div>

                                                <div class="form-group col-md-2" id="campoConta" style="display: none;">
                                                    <label for="partcp_ccbc">Conta:</label>
                                                    <input type="text" class="form-control  form-control-sm" id="partcp_ccbc" name="partcp_ccbc" placeholder="Conta">
                                                </div>

                                                <div class="form-group col-md-3" id="campoChavePix" style="display: none;">
                                                    <label for="partcp_pix">Chave PIX:</label>
                                                    <input type="text" class="form-control  form-control-sm" id="partcp_pix" name="partcp_pix" placeholder="Chave PIX" maxlength="100">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Campos para Produto-->
                                        <div id="camposProduto" style="display: none;">
                                            <div class="row">
                                                <div class="form-group col-md-2">
                                                    <label for="produto_ncm">NCM:</label>
                                                    <input type="text" class="form-control  form-control-sm" id="produto_ncm" name="produto_ncm" placeholder="NCM" required maxlength="10">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="produto_peso">Peso em Kg:</label>
                                                    <input type="text" class="form-control  form-control-sm" id="produto_peso" name="produto_peso" placeholder="Peso em Kg" required >
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="produto_cdgb">QR Code:</label>
                                                    <input type="text" class="form-control  form-control-sm" id="produto_cdgb" name="produto_cdgb" placeholder="Digite o QR Code" required maxlength="255">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label>Controlar Estoque:</label><br>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="produto_ctrl" name="produto_ctrl">
                                                        <label class="form-check-label" for="produto_ctrl">Sim</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

</section>

<!-- /.content -->
@endsection

@push('scripts')

<script type="text/javascript">
    $(document).ready(function () {
    $(".alert-dismissible")
            .fadeTo(10000, 500)
            .slideUp(500, function() {
                $(".alert-dismissible").alert("close");
            });
  });

</script>
<!--Campos do Tipo de Produto = Participante -->
    <script>
        $(document).ready(function() {

            $('#produto_vlr').mask('#.##0,00', {reverse: true});

            $('#produto_tipo').change(function() {
                $('#camposParticipante').hide();
                $('#camposProduto').hide();
                $('#camposAdicionais').hide();

                var tipoSelecionado = $(this).val();

                if (tipoSelecionado === '3') {
                    $('#camposParticipante').show();
                    $('#camposAdicionais').show();
                } else if (tipoSelecionado === '1') {
                    $('#camposProduto').show();
                    $('#camposAdicionais').show();
                } else {
                    $('#camposParticipante').hide();
                    $('#camposProduto').hide();
                    $('#camposAdicionais').hide();
                }
            });

            $('input[name="pagarPor"]').change(function() {
                var valorSelecionado = $(this).val();
                if (valorSelecionado === 'partcp_pgtransf') {
                    $('#campoBanco').show();
                    $('#campoAgencia').show();
                    $('#campoConta').show();
                    $('#campoChavePix').show();
                } else {
                    $('#campoBanco').hide();
                    $('#campoAgencia').hide();
                    $('#campoConta').hide();
                    $('#campoChavePix').hide();
                }
            });
        });
</script>
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/js/i18n/pt-BR.js') }}"></script>
<script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<!-- InputMask -->
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
<link rel="stylesheet" href="{{asset('assets/dist/css/app.css') }}" />
<script src="{{asset('assets/dist/js/app.js') }}"></script>

@endpush
