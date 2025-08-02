@extends('layouts.app-master-pdv')
@section('page.title', 'PDV - Venda')
@push('script-head')
<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-select/css/select.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />

<style>

.text-multban-bold-secundary {
    font-weight: 700 !important;
    font-size: 19px;
    color: #a702d8;
}
.money-multban-bold-secundary {
    font-weight: 700 !important;
    font-size: 26px;
    color: #a702d8;
    margin-top: -10px;
    margin-right: 20px;
}

.payment-box {
    border-radius: .50rem;
    border-color: #86a1a5 !important;
    padding-top: 1rem !important;
    border: 1.6px solid #cbd1d5 !important;
    display: -ms-flexbox;
    display: flex;
    min-height: 40px;
    padding: .5rem;
    position: relative;
    width: 100%;
    text-align: center;
}

.payment-box:hover{
    cursor: pointer;
}

.payment-box .payment-box-content {
    margin-top: -9px;
    margin-left: 0px;
    padding: 6px;
    position: relative;
    text-align: center;
}

.payment-box .payment-box-icon {
    border-radius: .50rem;
    -ms-flex-align: center;
    align-items: center;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-pack: center;
    height: 20px;
}

.payment-box .payment-box-icon img{
    width: 30px;
}

.payment-box-active {
    border-radius: .50rem;
    padding-top: 1rem !important;
    border: 1px solid #1c0065 !important;
    background-color: #1c0065;
    color: #ffffff !important;
}

.total-box {
        border-radius: .50rem;
    border: 1px solid #1c0065 !important;
    background-color: #e0e0e0;
    min-height: 50px;
    height: 65px;
    padding: 5px;
}
.box-finalizar {
    border-radius: .50rem;
    border: 1px solid #1c0065 !important;
    background-color: #a702d8;
    min-height: 50px;
    height: 65px;
    padding: 19px;
    color: #ffffff;
    cursor: pointer;
}


</style>
@endpush

@section('content')
<iframe id="iframe_impressao" src="" style="display:none"></iframe>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <input id="idempresa" name="idempresa" value="{{auth()->user()->idempresafilial}}" type="hidden" />
        <input id="orcamento" name="orcamento" value="0" type="hidden" />
        <input id="pedidoID" name="pedidoID" value="" type="hidden" />
        <input id="idclientevendedor" name="idclientevendedor" value="{{auth()->user()->id}}" type="hidden" />
        <input id="faturar" name="faturar" value="0" type="hidden" />
        @method('POST')
        @csrf
        <div class="row align-items-start pt-3" id="listaDeProdutos">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                <div class="card card-widget widget-user-2 shadow">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-primary">
                        <div class="widget-user-image">
                        <img class="img-circle elevation-2"
                        src="{{url('/assets/dist/img/') . '/' . 'logo-amarela-min.png'}}"
                        alt="">
                    </div>
                        <h2 class="widget-user-username">PDV</h2>
                        <h5 class="widget-user-desc">{{$empresa->emp_rzsoc}}</h5>
                    </div>
                </div>
                <div class="card card-outline card-primary">
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header p-2">
                                        <label for="getCliente">CPF / CNPJ do Cliente: (F6)</label>
                                        <div class="input-group mb-3 input-group-sm">
                                            <input autocomplete="off" type="text" autofocus="autofocus"
                                                class="form-control form-control-lg" id="getCliente" name="getCliente"
                                                value="" placeholder="CPF / CNPJ do Cliente">
                                            <span class="input-group-append">
                                                <button type="button" id="btnPesquisarCliente"
                                                    class="btn btn-default btn-lg"><i class="fa fa-search"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-footer p-2">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <span class="text-bold">Cliente:</span> <span id="desProd"></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" name="blt_ctr" id="blt_ctr">
                                                    <label for="blt_ctr" class="custom-control-label">Procedimento de Reembolso:</label>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header p-2">
                                        <label for="getProduto">Código do produto: (F1)</label>
                                        <div class="input-group mb-3 input-group-sm">
                                            <input autocomplete="off" type="text" autofocus="autofocus"
                                                class="form-control form-control-lg" id="getProduto" name="getProduto"
                                                value="" placeholder="Código do produto">
                                            <span class="input-group-append">
                                                <button type="button" id="btnPesquisarProduto"
                                                    class="btn btn-default btn-lg"><i class="fa fa-search"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-footer p-2">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <span class="text-bold">Descrição:</span> <span id="desProd"></span>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row p-2">
                            <div class="form-group col">
                                <label>Quantidade: (F2)</label>
                                <input autocomplete="off" type="text" class="form-control form-control-sm money"
                                    id="item-quantity" value="1,00" placeholder="1">
                            </div>
                            <div class="form-group col">
                                <label>Desconto: (F3)</label>
                                <div class="input-group mb-3 input-group-sm">
                                     <input autocomplete="off" type="text" class="form-control form-control-sm money"
                                id="item-discount" value="0,00" placeholder="1">
                                    <span class="input-group-append">
                                        <button type="button" id="btn-change-discount"
                                            class="btn btn-primary btn-sm">%</button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col">
                                <label>Preço: (F4)</label>
                                <input autocomplete="off" type="text" class="form-control form-control-sm money"
                                    id="item-price" value="0,00" placeholder="1">
                            </div>
                            <div class="form-group col">
                                <label>Subtotal:</label>
                                <input autocomplete="off" type="text" readonly disabled class="form-control form-control-sm money"
                                    id="item-subtotal" value="0,00" placeholder="1">
                            </div>
                            <div class="form-group col mt-3">
                                <button type="button" id="btn-adicionar-item" class="btn btn-primary btn-sm btn-block mt-3"><i
                                        class="fas fa-plus"></i> Inserir</button>

                            </div>
                        </div>
                        <div class="form">
                            <div class="col">
                                <label>Observação:</label>
                                <textarea id="item-observacao" class="form-control form-control-sm" maxlength="500"></textarea>
                            </div>
                        </div>

                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 pull-right">
                <div class="card card-outline card-primary" style="margin-bottom: 0px;">
                    <div class="card-header">
                        <h3 class="card-title mt-2"><span class="badge badge-multban" id="totalItens">0</span> Itens
                            <span id="TableNo"> </span>
                        </h3>
                    </div>
                    <div class="card-body" id="car_items" style="padding: 5px;min-height: calc(100vh - 55.5vh);">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Descrição</th>
                                        <th scope="col">Qtde</th>
                                        <th scope="col">Preço</th>
                                        <th scope="col">Desconto</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Ação</th>
                                    </tr>
                                </thead>
                                <tbody id="CartHTML"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tbody>

                                <tr>
                                    <td>
                                        <h4>Subtotal:</h4>
                                    </td>
                                    <td class="text-right">
                                        <h4 id="p_subtotal">R$0,00</h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h4>Desconto:</h4>
                                    </td>
                                    <td class="text-right">
                                        <h4 id="p_discount">R$0,00</h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h3><strong>Total:</strong></h3>
                                    </td>
                                    <td class="text-right ">
                                        <h3 class="valorTotal">R$0,00</h3>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>

                <div class="card mt-2 p-1">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mt-3">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" name="gerarComprovanteSeparados" id="gerarComprovanteSeparados">
                                    <label for="gerarComprovanteSeparados" class="custom-control-label">Gerar Comprovante Separados Por Participante</label>
                                </div></div>
                            <div class="col-md-6">
                                <div class="btn-group" role="group" aria-label="Checkout">

                                    <button type="button" id="limparCarrinho" class="btn btn-danger btn-lg btn-flat mr-3"><i
                                    class="fas fa-ban"></i> Cancelar (F7)</button>
                                    <button type="button" id="checkout" class="btn btn-secundary-multban btn-lg btn-flat"><i
                                    class="fas fa-cash-register"></i> Finalizar venda(F9)</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row animated bounceInLeft" id="listaDePedidos" style="display:none;">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 pull-left">
                <div class="card p-1">
                    <table class="table table-striped table-bordered table-head-fixed" id="tablePed">
                        <thead>
                            <tr>
                                <th>ID Pedido</th>
                                <th>Cliente</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                <div class="card p-1" id="invoiceShow">
                    <div class="invoice p-3 mb-3">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    empresas razaosocia.
                                    <small class="float-right" id="dataped"></small>
                                </h4>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-primary">
                        </div>
                        <!-- /.row -->

                        <!-- Table row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header border-0 bg-light">
                                        <h3 class="card-title title-vendasituacao"></h3>
                                    </div>
                                    <div class="card-body" id="pedidos-by-cli">

                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->

@endsection
@push('scripts')
<div class="modal inmodal" id="impressaoModal" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false"
    data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <h4 class="modal-title">Imprimir Cupom</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <button type="button" id="imprimirCupom" class="btn btn-success btn-lg"><i class="fas fa-print"></i> Imprimir Cupom</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal" id="checkout-modal" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content animated bounceInDown">
            <div class="modal-header bg-primary">
                <h4 style="float:left;">Finalizar venda</h4>
            </div>
            <div class="modal-body clearfix">

                <input type="hidden" id="taxa" class="form-control  form-control-sm" value="0.00">
                <input type="hidden" id="delivery_cost" class="form-control  form-control-sm" value="0">
                <input type="hidden" id="total_amount" class="form-control  form-control-sm" value="0.00">
                <input type="hidden" id="idcliente" class="form-control  form-control-sm" value="">

                <div class="row">
                    <div class="col-md-6">
                        <p class="m-0 text-bold">Forma de Pagamento: <span class="font-weight-light">Nome completo do cliente</span></p>
                        <p class="text-bold">Pontos / CashBack: <span class="text-multban-bold-secundary">800</span></p>
                    </div>
                     <div class="col-md-6 text-right">
                        <button type="button" id="" class="btn btn-primary btn-sm">Resgatar Pontos/Cash Back</button>
                    </div>
                </div>

                <div class="card card-outline card-primary">
                    <div class="card-body p-3">
                       <div class="row m-0">
                            <div class="col-md-6">
                                <p class="m-0 text-bold">Total da Compra: <span class="float-right font-weight-light">R$ 822,00</span></p>
                                <p class="m-0 text-bold">Total de Pontos / CashBack Resgatado: <span class="float-right font-weight-light">0</span></p>
                                <p class="m-0 text-bold">Total de Desconto Concedido: <span class="float-right font-weight-light">R$ 100,00</span></p>
                            </div>
                             <div class="col-md-6 text-right">
                                <p class="mr-4 text-bold m-0" >Total a Pagar</p>
                                <p class="text-bold"><span class="money-multban-bold-secundary">R$ 722,60</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="blt_ctr" id="blt_ctr">
                            <label for="blt_ctr" class="custom-control-label">Pagamento Total:</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="blt_ctr" id="blt_ctr">
                            <label for="blt_ctr" class="custom-control-label">Mais de Um Meio de Pagamento:</label>
                        </div>
                    </div>

                </div>
                <hr>
                <div class="form-row" style="display:none">
                    <div class="form-group col-sm-12">
                        <select class="form-control select2" name="id_forma_pagto" id="id_forma_pagto"
                        data-placeholder="Selecione"
                            style="width: 100%;">
                            <option></option>
                            @foreach ($meioDePagamento as $meio)
                            <option value="{{$meio->meio_pag}}">
                                {{$meio->meio_pag_desc}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    @foreach($meioDePagamento as $meio)

                    <div class="col">
                        <div class="form-group text-center">
                            <div data-identificacao="{{$meio->meio_pag}}" id="{{$meio->meio_pag_desc}}" data-id="{{$meio->meio_pag_desc}}"
                                class="payment-box @if($meio->meio_pag == "DN") payment-box-active @endif">
                                <span class="payment-box-icon"><img src="{{ asset('assets/dist/img/payment/'). '/' . $meio->meio_pag_icon}}"/></span>
                                <div class="payment-box-content">
                                    <span>{{$meio->meio_pag_desc}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="card card-outline card-primary">
                    <div class="card-body p-3">
                       <div class="row m-0 text-center">
                            <div class="col-md-3">
                                <div class="total-box">
                                    <h5 class="text-bold m-0">Valor Pago</h5>
                                    <h5 class="text-bold m-0">R$ 730,00</h5>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="total-box">
                                    <h5 class="text-bold m-0">Saldo</h5>
                                    <h5 class="text-bold m-0">R$ 730,00</h5>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="total-box" style="display: none">
                                    <h5 class="text-bold m-0">Valor Pago</h5>
                                    <h5 class="text-bold m-0">R$ 730,00</h5>
                                </div>
                            </div>
                            <div class="col-md-3 float-right">
                                <div class="box-finalizar">
                                    <h5 class="text-bold m-0">Cobrar</h5>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!--<div class="clearfix"></div>
                <div class="form-row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="valorDescCento">Desconto %:</label>
                            <input type="text"id="valorDescCento" placeholder="Desconto%"
                                class="form-control money form-control-sm">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="valorDesconto">Desconto R$:</label>
                            <input type="text" id="valorDesconto" placeholder="Valor desconto"
                                class="form-control money form-control-sm">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="valorDesconto">Valor a pagar R$:</label>
                            <input type="text" id="valorAPagar" readonly="" placeholder="Valor desconto"
                                class="form-control money form-control-sm">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="valortotalpago">Valor Pago:</label>
                            <input type="text" id="valortotalpago" placeholder="Valor pago" class="form-control money form-control-sm">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="valortroco">Troco:</label>
                            <input type="text" id="valortroco" readonly="" placeholder="Troco"
                                class="form-control money form-control-sm">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <textarea id="observacao" value="" placeholder="Observações"
                                class="form-control  form-control-sm"></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 text-right">
                    <button type="button" class="btn btn-warning" id="gravarPedidoEmEspera">Pedido em espera
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar </button>
                    <input type="hidden" value="" id="id">
                    <button type="button" id="finalizarPedido" class="btn btn-primary btn-sm">Finalizar</button>
                </div>-->

            </div>

        </div>

    </div>

</div>

<div class="modal inmodal" id="pesquisar-cliente-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Pesquisa de cliente</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Digite o nome, CPF ou CNPJ do cliente.</p>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <select id="find-client" name="find-client" autofocus="autofocus"
                            class="form-control select2 select2-hidden-accessible"
                            data-placeholder="Digite o nome, CPF ou CNPJ do cliente" style="width: 100%;"
                            aria-hidden="true">
                                <option></option>

                        </select>
                    </div>
                </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary pull-right" id="btn-find-client" data-dismiss="modal"><i class="fa fa-check"></i> OK</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
  <!-- /.modal cliente-->

<div class="modal inmodal" id="pesquisar-produto-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Pesquisa de produto</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Digite o nome do produto.</p>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <select id="find-product" name="find-product" autofocus="autofocus"
                            class="form-control select2 select2-hidden-accessible"
                            data-placeholder="Digite o nome do produto" style="width: 100%;"
                            aria-hidden="true">
                                <option></option>

                        </select>
                    </div>
                </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary pull-right" id="btn-find-product" data-dismiss="modal"><i class="fa fa-check"></i> OK</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
  <!-- /.modal produto-->

<div class="modal inmodal" id="modalCliente" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <h4 class="modal-title" id="total_amount_modal">Cliente</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body clearfix">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="celular">Pesquisar Cliente:</label>
                        <select id="idsearchphone" autofocus="autofocus" name="idsearchphone"
                            class="form-control select2 select2-hidden-accessible"
                            data-placeholder="PESQUISE PELO TELEFONE" style="width: 100%;" aria-hidden="true">
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="razaosocial" id="labelrazaosocial">Nome:</label>
                        <input class="form-control  form-control-sm" placeholder="Digite o nome" name="razaosocial" type="text"
                            id="razaosocial" value="">

                        <input class="form-control  form-control-sm" placeholder="Digite o nome" name="nomefantasia" type="hidden"
                            id="nomefantasia" value="">

                    </div>
                    <div class="form-group col-md-4">
                        <label for="celular" id="labelcelular">Celular:</label>
                        <input class="form-control cell_with_ddd form-control-sm" placeholder="Digite o celular" name="celular"
                            type="text" id="celular" value="">

                    </div>
                    <div class="form-group col-md-4">
                        <label for="telefone" id="labeltelefone">Telefone:</label>
                        <input class="form-control phone_with_ddd form-control-sm" placeholder="Digite o telefone" name="telefone"
                            type="text" id="telefone" value="">

                    </div>
                </div>
                <hr>
                <div class="form-row">
                    <div class="form-goup col-md-3">
                        <label for='cep'>CEP</label>
                        <div class="input-group mb-3 input-group-sm">
                            <input type="text" autofocus="autofocus" class="form-control cep form-control-sm" id="cep" name="cep"
                                value="" placeholder="Digite o CEP">
                            <span class="input-group-append">
                                <button type="button" id="btnPesquisarCep" class="btn btn-default"><i
                                        class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for='endereco'>Endereço (Logradouro)</label>
                        <input class="form-control  form-control-sm" placeholder="Digite o Endereço" name="endereco" type="text"
                            id="endereco" value="">
                    </div>
                    <div class="form-group col-md-3">
                        <label for='numero'>Número</label>
                        <input class="form-control  form-control-sm" placeholder="Digite o Número" name="numero" type="text" id="numero"
                            value="">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for='complemento'>Complemento</label>
                        <input class="form-control  form-control-sm" placeholder="Digite o Complemento" name="complemento" type="text"
                            id="complemento" value="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for='bairro'>Bairro</label>
                        <input class="form-control  form-control-sm" placeholder="Digite o Bairro" name="bairro" type="text" id="bairro"
                            value="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for='pontoreferencia'>Ponto de referência</label>
                        <input class="form-control  form-control-sm" placeholder="Digite o Ponto de referência" name="pontoreferencia"
                            type="text" id="pontoreferencia" value="">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for='idcidade'>Cidade</label>
                        <select id="idcidade" name="idcidade" class="form-control select2 select2-hidden-accessible"
                            data-placeholder="PESQUISE A CIDADE" style="width: 100%;" aria-hidden="true">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for='idestado'>Estado</label>
                        <select id="idestado" name="idestado" class="form-control select2 select2-hidden-accessible"
                            data-placeholder="PESQUISE O ESTADO" style="width: 100%;" aria-hidden="true">
                            <option value=""></option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for='idenderecotipo'>Tipo</label>
                        <select id="idenderecotipo" name="idenderecotipo"
                            class="form-control select2 select2-hidden-accessible"
                            data-placeholder="SELECIONE O TIPO DE ENDEREÇO" style="width: 100%;" aria-hidden="true">

                        </select>
                    </div>
                </div>

                <div class="col-sm-12 text-right">
                    <button type="button" id="ClearForm" class="btn btn-danger">Cancelar</button>
                    <button type="button" id="salvarCliente" class="btn btn-primary btn-sm">OK</button>
                    <span id="errorMessage" style="color:red"> </span>
                </div>
            </div>
        </div>
    </div>

</div>

<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/js/i18n/pt-BR.js') }}"></script>

<script src="{{asset('assets/dist/js/app.js') }}"></script>
<script src="{{asset('assets/dist/js/pages/venda/pdv/updatevenda.js') }}"></script>

<script src="{{asset('assets/plugins/lodash/lodash.min.js') }}"></script>
<script src="{{asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!--script src="{{asset('assets/plugins/jquery-print/jQuery.print.min.js') }}"></script-->
<link rel="stylesheet" href="{{asset('assets/plugins/animate/animate.css') }}" />

<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatables-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>

<script type="text/javascript">
    //variaveis
    var products = new Array();
    var count_items = 0;
    var cart = new Array();
    var itens = {};
    var finalizarClick = false;
    var searchProduct = false;
    var discountType = '%';

    //status das mesas
    var mesaStatus = {}
    mesaStatus.OCUPADA = 0
    mesaStatus.LIVRE = 1

    //Venda Situação
    var vendaStatus = {}
    vendaStatus.ABERTA = 1;
    vendaStatus.EMPREPARACAO = 2;
    vendaStatus.EMENTREGA = 3;
    vendaStatus.CONCLUIDA = 4;

    //tipo de venda
    var vendaTipo = {}
    vendaTipo.NOLOCAL = 1
    vendaTipo.RETIRAR = 2
    vendaTipo.ENTREGAR = 3

    $("body").on("change", "#find-product", function(e) {
        var data = $(this).select2('data')[0];
        if (data) {
            if(!data.id){
                return;
            }
            var quantity = parseInt($('#item-quantity').val()) == 0 ? 1 : parseInt($('#item-quantity').val());

            $("#desProd").html(data.fardes);
            $("#item-price").val(data.farvre);
            $("#item-price").trigger('keyup');
            $('#btn-adicionar-item').data('id', data.id);

            $("#item-subtotal").val(Number(data.farvre * quantity).toFixed(2));
            $("#item-subtotal").trigger('keyup');

            $('#pesquisar-produto-modal').modal('hide');

            $("#item-quantity").val("1,00");
        }
    });

    $("body").on("keyup blur", "#item-quantity, #item-discount, #item-price", function(e) {

        var quantity = $.tratarValor($('#item-quantity').val());
        var discount = $.tratarValor($('#item-discount').val());
        var discountTotal = 0;

        if(quantity > 0){
            var price = $.tratarValor($("#item-price").val());

            if(discountType === "%"){
                discountTotal = quantity * ((discount * price) / 100);
            }else{
                discountTotal = quantity * discount;
            }

            $("#item-subtotal").val( $.toMoneySimples(Number((price * quantity) - discountTotal).toFixed(2)));
        }

    });

    $("body").on("keyup", "#item-quantity", function(e) {
        if(e.keyCode == 13){
            //$(this).blur();
            $('#item-discount').focus();
        }
    });

    $("body").on("keyup", "#item-discount", function(e) {
        if(e.keyCode == 13){
            //$(this).blur();
            $('#item-price').focus();
        }
    });

    $("body").on("keyup", "#item-price", function(e) {
        if(e.keyCode == 13){
            //$(this).blur();
            $('#btn-adicionar-item').trigger('click');
        }
    });

    $("body").on("click", "#btn-adicionar-item", async function(){

        var quantity = $.tratarValor($('#item-quantity').val());
        var price = $.tratarValor($('#item-price').val());
        var discount = $.tratarValor($('#item-discount').val());
        var discountValue = 0;

        console.log('quantity', quantity)
        console.log('price', price)
        console.log('discount', quantity)
        var id = $(this).data('id');
        var descricao = $("#desProd").html();

        if(discountType === "%"){
            discountValue = ((discount * price) / 100) * quantity;
            if(((discount * price) / 100) * quantity > price){
                toastr.error('O Desconto não pode ser maior que o Preço.');
                return;
            }
        }else{
            discountValue = discount;
            if(discount > price){
                toastr.error('O Desconto não pode ser maior que o Preço.');
                return;
            }
        }

        if(descricao.length === 0 || descricao === ""){
            toastr.error('Selecione um produto.');
            return;
        }

        if(quantity == 0){
            toastr.error('A Quantidade não pode ficar zerada.');
            return;
        }

        if(price == 0){
            toastr.error('O Preço não pode ficar zerado.');
            return;
        }

        var item = {
            id: parseInt(id),
            product_id: parseInt(id),
            price: price,
            name: descricao,
            quantity: quantity,
            discount: discount,
            discountType: discountType,
            discountValue: discountValue,
        };

        adicionarAoCarrinho(item);
        show_cart();

        $('#item-quantity').val('1,00');
        $('#item-discount').val('0,00');
        $('#item-price').val('0,00');
        $('#item-subtotal').val('0,00');
        $('#find-product').select2('data', null);
        $('#find-product').val(null);
        $('#find-product').trigger('change');
        $("#desProd").html('')

    });

    $("body").on("click", "#btn-change-discount", function(){
        if($(this).html() === "%"){
            $(this).html("R$");
            discountType = "R$";
        }else{
            $(this).html("%");
            discountType = "%";
        }
    });

    $("body").on("click", ".btn-change-discount", function(){
        if($(this).html() === "%"){
            $(this).html("R$");
            discountType = "R$";
        }else{
            $(this).html("%");
            discountType = "%";
        }

        var id = parseInt($(this).data('id'));


        var index = _.findIndex(cart, { id : id});
        cart[index].discountType = discountType;

        //$('#item-quantity-'+id).trigger('keyup');
        show_cart();
    });

    $("body").on("click", "#showModalCliente", function(){
        finalizarClick = false;
        $("#salvarCliente").html("OK")
        $("#modalCliente").modal('show');
    });

    $("body").on("click", "#btnPesquisarProduto", function(){
        $("#pesquisar-produto-modal").modal('show');
    });

    $("body").on("click", "#btnPesquisarCliente", function(){
        $("#pesquisar-cliente-modal").modal('show');
    });

    function formataNumeroTelefone(numero) {
        numero = numero.replace(" ", "").replace("-", "").replace("(", "").replace(")", "");
        console.log("numero", numero);
        if(numero.length == 0)
        return "Sem número";
        var length = numero.length;
        var telefoneFormatado;

        if (length === 10) {
        telefoneFormatado = '(' + numero.substring(0, 2) + ') ' + numero.substring(2, 6) + '-' + numero.substring(6, 10);
        } else if (length === 11) {
        telefoneFormatado = '(' + numero.substring(0, 2) + ') ' + numero.substring(2, 7) + '-' + numero.substring(7,11);
        }
        return telefoneFormatado;
    }


var html_pedidos_by_cli = '';

var carregaCliente = function(msg){
    var url = "/cliente/searchphone";
    var parametro = {
        parametro: msg.celular == null ? msg.telefone : msg.celular
    };
    $.get(url, parametro, function(item) {
        $("#idsearchphone").select2("trigger", "select", {
            data: item[0],
        });
    });
}

$("body").on("click", "#checkout", function() {
    finalizarClick = true;
    var total_pedido = $(".valorTotal").html().replace("R$", "");
    if (cart.length == 0) {
        toastr.error("Adicione ao menos um item no pedido.");
        //return;
    }

    var tipoDeVenda = $("#tipoDeVenda").val();
    var data = $.isNotNullAndNotEmpty($("#idcliente").val());

    $("#checkout-modal").modal("show");

    if (tipoDeVenda == vendaTipo.ENTREGAR) {
        if(!data){
            $("#salvarCliente").html("Próximo");
            $("#modalCliente").modal("show");
        }else {
            $("#checkout-modal").modal("show");
        }
        $("#motoboy_row").show();
    }
    if (tipoDeVenda == vendaTipo.RETIRAR) {
         $("#motoboy_row").hide();
         $("#checkout-modal").modal("show");
    }
    if (tipoDeVenda == vendaTipo.NOLOCAL) {
         $("#motoboy_row").hide();
         $("#checkout-modal").modal("show");
    }
});

function setarCidade(id) {
    var url = "/cliente/obtercidadeid";
    var parametro = {
        parametro: id
    };
    $.get(url, parametro, function(item) {
        $("#idcidade").select2("trigger", "select", {
            data: item[0],
        });
    });
};

function setarEstado(id) {
    var url = "/cliente/obterestadoid";
    var parametro = {
        parametro: id
    };
    $.get(url, parametro, function(item) {
        $("#idestado").select2("trigger", "select", {
            data: item[0],
        });
    });
};

$("body").on("change", "#idsearchphone", function(e) {
    var data = $(this).select2('data')[0];
    if (data) {
        $("#nomefantasia").val(data['nomefantasia']);
        $("#razaosocial").val(data['razaosocial']);
        $("#telefone").val(data['telefone']);
        $("#celular").val(data['celular']);
        $("#cep").val(data['cep']);
        $("#endereco").val(data['endereco']);
        $("#numero").val(data['numero']);
        $("#complemento").val(data['complemento']);
        $("#bairro").val(data['bairro']);
        $("#pontoreferencia").val(data['pontoreferencia']);
        $("#idenderecotipo").val(data['idenderecotipo']);
        $('#idenderecotipo').trigger('change');
        $("#id").val(data['id']);
        $("#idcliente").val(data['id']);
        var dataCidade = {
            "id": data['idcidade'],
            "text": data['cidadeDescricao'],
        }
        $("#idcidade").select2("trigger", "select", {
            data: dataCidade,
        });

        var dataEstado = {
            "id": data['idestado'],
            "text": data['estadoDescricao'],
        }
        $("#idestado").select2("trigger", "select", {
            data: dataEstado,
        });

    } else {
        $('#idcidade').val(''); // Select the option with a value of ''
        $('#idcidade').trigger('change'); // Notify any JS components that the value changed
        $('#idestado').val('');
        $('#idestado').trigger('change');
        $("#nomefantasia").val("");
        $("#razaosocial").val("");
        $("#telefone").val("");
        $("#celular").val("");
        $("#cep").val("");
        $("#endereco").val("");
        $("#numero").val("");
        $("#complemento").val("");
        $("#bairro").val("");
        $("#pontoreferencia").val("");
        $("#idenderecotipo").val("");
        $('#idenderecotipo').trigger('change');
        $("#id").val("");
        $("#idcliente").val("");
    }
});

$("body").on("click", ".deleteHoldOrder", function(e) {

    var id = $(this).data('id');
    var token = $('meta[name="csrf-token"]').attr("content");
    var url = "/pdv/" + id;
    Pace.restart();
    Pace.track(function () {
        $.ajax({
            header: {
                "X-CSRF-TOKEN": token,
            },
            url: url,
            type: "post",
            data: { id: id, _method: "delete", _token: token },
        }).done(function (response) {
            $(".emEspera").html(response.emespera);
            Swal.fire({
                title: response.title,
                text: response.text,
                type: response.type,
                showCancelButton: false,
                allowOutsideClick: false,
            }).then(function (result) {
                if (response.type === "error") return;
                if (result.value) {
                    $(".deleteHoldOrder").parents('tr').first().remove();
                    if($(".deleteHoldOrder").parents('tr').first().length <= 0)
                        $("#listaDePedidosModal").modal('hide');
                }
            });
        }).fail(function () {
            Swal.fire(
                "Oops...",
                "Algo deu errado ao tentar delatar!",
                "error"
            );
        });
    });

    e.preventDefault();
});

$(".form-control").on("keyup", function(){
    $(this).removeClass("is-invalid");
});

$("body").on("click", "#ClearForm", function() {
    $('#idsearchphone').val('');
    $('#idsearchphone').trigger('change');
    $("#modalCliente").modal("hide");
});

//Desconto
function calculaDescontoPorcentagem(){

    $("#valortotalpago").val("0,00");
    $("#valortroco").val("0,00");
    var valorDescCento = $.tratarValor($("#valorDescCento").val());
    var valortotal =  $.tratarValor($("#total_amount_modal").html());
    var valorAPagar =  $.tratarValor($("#valorAPagar").val());

    var valorDesconto = valortotal * (valorDescCento/100);

    $("#valorDesconto").val(valorDesconto.toFixed(2).replace('.', ','));
    $("#valorAPagar").val((valortotal - valorDesconto).toFixed(2).replace('.', ','));

    const tipo_pagto = document.querySelector("#cartao");
    if(tipo_pagto.classList.contains("text-success")){
        $("#valortotalpago").val($("#valorAPagar").val());
    }
    else{
        $("#valortotalpago").val("0,00");
    }
}

function calculaDescontoValor(){
    $("#valortroco").val("0,00");
    $("#valorDescCento").val("0");

    var valortotal = $("#total_amount_modal").html().replace("R$", "").replace(".", "").replace(",", ".");
    var valorDesconto = $("#valorDesconto").val().replace(".", "").replace(",", ".");
    var valorAPagar = (valortotal - valorDesconto).toFixed(2).replace('.', ',');
    $("#valorAPagar").val(valorAPagar);
    const tipo_pagto = document.querySelector("#cartao");
    if(tipo_pagto.classList.contains("text-success")){
        $("#valortotalpago").val(valorAPagar);
    }
    else{
        $("#valortotalpago").val("0,00");
    }
}

$("body").on("input", "#valorDescCento", function(){
    calculaDescontoPorcentagem();
});

$("body").on("keyup", "#valorDesconto", function(){
    calculaDescontoValor();
});

$("body").on("click", "#salvarCliente", function() {

    var form_data = {
        razaosocial: $("#razaosocial").val(),
        nomefantasia: $("#nomefantasia").val(),
        telefone: $("#telefone").val(),
        celular: $("#celular").val(),
        cep: $("#cep").val(),
        endereco: $("#endereco").val(),
        numero: $("#numero").val(),
        complemento: $("#complemento").val(),
        bairro: $("#bairro").val(),
        pontoreferencia: $("#pontoreferencia").val(),
        idcidade: $('#idcidade').val(),
        idestado: $('#idestado').val(),
        idenderecotipo: $("#idenderecotipo").val(),
        id: $("#id").val()
    }

    if ($("#razaosocial").val() == "") {
        toastr.error('O campo Nome deve ser preenchido')
        $("#razaosocial").addClass("is-invalid");
        return false;
    }

    var cel = $("#celular").val().replace(/[() -]/g, '');
    var tel = $("#telefone").val().replace(/[() -]/g, '');

    if ($("#celular").val() == "" && $("#telefone").val() == "")  {
        toastr.error('O campo Celular ou Telefone deve ser preenchido')
        $("#celular").addClass("is-invalid");
        return false;
    }

    if (cel.length < 11 && tel.length < 10) {
        toastr.error('O campo Celular ou Telefone contém um valor inválido')
        $("#celular").addClass("is-invalid");
        return false;
    }

    if ($("#endereco").val() == "") {
        toastr.error('O campo Endereço deve ser preenchido')
        $("#endereco").addClass("is-invalid");
        return false;
    }

    if ($("#idcidade").val() == "") {
        toastr.error('O campo Cidade deve ser preenchido')
        $("#idcidade").select2('open');
        $("#idcidade").select2('focus');
        $("#idcidade").addClass("is-invalid");
        $("#idcidade")
        .closest(".form-group")
        .find(".select2-selection")
        .css("border-color", "#dc3545")
        .addClass("text-danger");
        return false;
    }

    if ($("#idestado").val() == "") {
        toastr.error('O campo Estado deve ser preenchido')
        $("#idestado").select2('open');
        $("#idestado").select2('focus');
        $("#idestado").addClass("is-invalid");
        $("#idestado")
        .closest(".form-group")
        .find(".select2-selection")
        .css("border-color", "#dc3545")
        .addClass("text-danger");
        return false;
    }

    $(this).html('<i class="fa fa-spinner fa-spin" style="font-size:18px"></i> Processando...');
    $(this).prop("disabled", true);
    Pace.restart();
    Pace.track(function () {
        $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/pdv/storeclient',
            data: form_data,
            success: function(msg) {
                $("#salvarCliente").html('Próximo');
                $("#salvarCliente").prop("disabled", false);
                var obj = msg;
                if (obj['message'] == "OK") {
                    $("#modalCliente").modal("hide");

                    if(finalizarClick){
                        $("#checkout-modal").modal("show");
                    }

                    $("#idcliente").val(obj['id']);
                    $("#TableNo").html("(" +$("#razaosocial").val()+ ")");
                    $("#TableNoCart").html("(" + $("#razaosocial").val() + ")");
                } else {
                    toastr.error(msg.message,msg.title);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {

                if(XMLHttpRequest.status == 401){
                     Swal.fire({
                         title: "Erro",
                         text: "Sua sessão expirou, é preciso fazer o login novamente.",
                         type: "error",
                         showCancelButton: false,
                         allowOutsideClick: false,
                     }).then(function (result) {
                         $.limparBloqueioSairDaTela();
                         location.reload();
                     });
                    }
                    else if( XMLHttpRequest.status === 400 ) {
                        var errors = $.parseJSON(XMLHttpRequest.responseText);
                        //console.log(errors);
                        $.each(errors.message, function (key, val) {
                            toastr.error(val);
                        });
                    }else{
                        toastr.error("Opos, algo deu errado.");
                    }
                    $("#salvarCliente").html('Próximo');
                    $("#salvarCliente").prop("disabled", false);
                }
        });
    });
});

$('#impressaoModal').on('hidden.bs.modal', function() {
    $("#pedidoID").val("");
});

$('#checkout-modal').on('shown.bs.modal', function() {
    $(".payment-box-active").removeClass("payment-box-active");
    $("#valortotalpago").val("0,00");
    //$("#valorDescCento").val("0");
    //$("#valorDesconto").val("0,00");
    var valorTotal = $("#total_amount_modal").html().replace("R$", "");
    //$("#valorAPagar").val(valorTotal);
    $("#Dinheiro").addClass("payment-box-active");
    $("#valortroco").val("0,00");
    $("#valortotalpago").habilitar();
    $("#valortotalpago").focus();
    $("#valortotalpago").select();
});

$('#modalCliente').on('shown.bs.modal', function() {
    if($("#idsearchphone").isNullOrEmpty()){
        setTimeout(function(){
            $("#idsearchphone").select2('open');
            $("#idsearchphone").select2('focus');
        },950);
    }
});

$("body").on("click", ".payment-box", function() {
    $(".payment-box-active").removeClass("payment-box-active");
    $("#id_forma_pagto").val($(this).attr("data-identificacao"));
    $("#id_forma_pagto").trigger('change');

    $(this).addClass("payment-box-active");
    if ($(this).attr("data-id") == "Dinheiro") {
        $("#valortotalpago").val("0,00");
        $("#valortroco").val("0,00");
        $("#valortotalpago").habilitar();
        $("#valortotalpago").focus();
        $("#valortotalpago").select();
    } else {
        $("#valortotalpago").desabilitar();
        $("#valortotalpago").val($("#valorAPagar").val());
        $("#valortroco").val("0,00");
    }
});

$(function() {
    $(".navbar-minimalize").click();
});

var table = null;
$(document).ready(function() {

    $("#invoiceShow").css("height", $(window).height() -150)


$('body').addClass('layout-navbar-fixed');
var data = [];

$("#taxaDeEntrega").select2({
  data: data
});

$("body").on("click","#carrinhoIcon", function(){
    $('html,body').animate({scrollTop: document.body.scrollHeight},"fast");
});

    $("#btnPesquisarCep").on("click", function() {
        ns.cepOnClick();
    });
    ns.comboBoxSelect("idsearchphone", "/cliente/searchphone");
    ns.comboBoxSelect("idcidade", "/cliente/obtercidadeid");
    ns.comboBoxSelect("idestado", "/cliente/obterestadoid");
    ns.comboBoxSelect("find-product", "/produto/obterproduto", "id", 7, "findlist");
    //$('.numberPad').numpad();
    $('.tab-pane, .cart-table-wrap, .dataTables_scrollBody, #invoiceShow').overlayScrollbars({
        className: 'os-theme-dark',
        sizeAutoCapable: true,
        scrollbars: {
            clickScrolling: true
        },
        overflowBehavior: {
            x: "hidden",
            y: "scroll"
        },
    });

});

$("body").on("keyup", "#valortotalpago", function() {
    var total_amount = $("#total_amount").val();
    var valorAPagar = $("#valorAPagar").val().replace('.', '').replace(',', '.');
    var desconto = $("#valorDescCento").val().replace('.', '').replace(',', '.');
    var descontoValor = $("#valorDesconto").val().replace('.', '').replace(',', '.');
    var valortotalpago = $(this).val().replace('.', '').replace(',', '.');
    var valortroco = 0;
    if(desconto > 0 || descontoValor > 0)
        valortroco = Number(valortotalpago) - Number(valorAPagar);
    else
        valortroco = Number(valortotalpago) - Number(total_amount);

        $("#valortroco").val(valortroco.toFixed(2).replace('.', ','));

});

$("body").on("keyup", "#getCliente", function (e) {

        e.preventDefault();
        var texto = $(this).val();
        var url = "/produto/obterproduto?pdv='sim'&parametro=" + texto;
        var quantity = $.tratarValor($('#item-quantity').val());
        if (e.key == 'Enter' && texto ) {
            Pace.restart();
            Pace.track(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: url,
                    type: "GET",
                })
                .done(function (response) {

                     var item = {
                        id: parseInt(response.id),
                        product_id: parseInt(response.id),
                        price: response.farvre,
                        name: response.fardes,
                        quantity: quantity,
                        discount: 0,
                        discountType: discountType,
                        discountValue: 0,
                    };

                    if(response.farvre == 0){
                        Swal.fire(
                            "Oops...",
                            "Produto sem preço, contate o administrador.",
                            "error"
                        );

                        return;
                    }

                    $("#desProd").html(response.fardes);
                    $("#item-price").val($.toMoneySimples(response.farvre));

                    //console.log(item)
                    itens = item;
                    adicionarAoCarrinho(item);
                    show_cart();

                    $('#getProduto').val("");
                    $('#getProduto').focus();
                    $("#item-quantity").val("1,00");
                    $('#item-discount').val('0,00');
                    $('#item-price').val('0,00');
                    $('#item-subtotal').val('0,00');
                    $('#find-product').select2('data', null);
                    $('#find-product').val(null);
                    $('#find-product').trigger('change');
                    $("#desProd").html('');

                })
                .fail(function (xhr, status, error) {
                    $('#getProduto').val("");
                    $('#getProduto').focus();
                    $("#item-quantity").val("1,00");
                    $('#item-discount').val('0,00');
                    $('#item-price').val('0,00');
                    $('#item-subtotal').val('0,00');
                    $('#find-product').select2('data', null);
                    $('#find-product').val(null);
                    $('#find-product').trigger('change');
                    $("#desProd").html('');
                    discountType = "%";

                    if (xhr.status == 403) {
                        Swal.fire(
                            "Oops...",
                            "Você não tem permissão, contate o administrador!",
                            "error"
                        );
                    } else if (xhr.status == 404){
                        Swal.fire(
                            "Oops...",
                            "Produto não encontrado!",
                            "error"
                        );
                    }else if(xhr.status == 401 || xhr.status == 419){
                        Swal.fire({
                            title: "Erro",
                            text: "Sua sessão expirou, é preciso fazer o login novamente.",
                            type: "error",
                            showCancelButton: false,
                            allowOutsideClick: false,
                        }).then(function (result) {
                            $.limparBloqueioSairDaTela();
                            location.reload();
                        });
                    }else {
                        Swal.fire(
                            "Oops...",
                            "Algo deu errado!",
                            "error"
                        );
                    }
                });
            });
        }
    });

$("body").on("keyup", "#getProduto", function (e) {

        e.preventDefault();
        var texto = $(this).val();
        var url = "/produto/obterproduto?pdv='sim'&parametro=" + texto;
        var quantity = $.tratarValor($('#item-quantity').val());
        if (e.key == 'Enter' && texto ) {
            Pace.restart();
            Pace.track(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: url,
                    type: "GET",
                })
                .done(function (response) {

                     var item = {
                        id: parseInt(response.id),
                        product_id: parseInt(response.id),
                        price: response.farvre,
                        name: response.fardes,
                        quantity: quantity,
                        discount: 0,
                        discountType: discountType,
                        discountValue: 0,
                    };

                    if(response.farvre == 0){
                        Swal.fire(
                            "Oops...",
                            "Produto sem preço, contate o administrador.",
                            "error"
                        );

                        return;
                    }

                    $("#desProd").html(response.fardes);
                    $("#item-price").val($.toMoneySimples(response.farvre));

                    //console.log(item)
                    itens = item;
                    adicionarAoCarrinho(item);
                    show_cart();

                    $('#getProduto').val("");
                    $('#getProduto').focus();
                    $("#item-quantity").val("1,00");
                    $('#item-discount').val('0,00');
                    $('#item-price').val('0,00');
                    $('#item-subtotal').val('0,00');
                    $('#find-product').select2('data', null);
                    $('#find-product').val(null);
                    $('#find-product').trigger('change');
                    $("#desProd").html('');

                })
                .fail(function (xhr, status, error) {
                    $('#getProduto').val("");
                    $('#getProduto').focus();
                    $("#item-quantity").val("1,00");
                    $('#item-discount').val('0,00');
                    $('#item-price').val('0,00');
                    $('#item-subtotal').val('0,00');
                    $('#find-product').select2('data', null);
                    $('#find-product').val(null);
                    $('#find-product').trigger('change');
                    $("#desProd").html('');
                    discountType = "%";

                    if (xhr.status == 403) {
                        Swal.fire(
                            "Oops...",
                            "Você não tem permissão, contate o administrador!",
                            "error"
                        );
                    } else if (xhr.status == 404){
                        Swal.fire(
                            "Oops...",
                            "Produto não encontrado!",
                            "error"
                        );
                    }else if(xhr.status == 401 || xhr.status == 419){
                        Swal.fire({
                            title: "Erro",
                            text: "Sua sessão expirou, é preciso fazer o login novamente.",
                            type: "error",
                            showCancelButton: false,
                            allowOutsideClick: false,
                        }).then(function (result) {
                            $.limparBloqueioSairDaTela();
                            location.reload();
                        });
                    }else {
                        Swal.fire(
                            "Oops...",
                            "Algo deu errado!",
                            "error"
                        );
                    }
                });
            });
        }
});

function adicionarAoCarrinho(item){
    var ids = _.map(cart, 'id');

    if (!_.includes(ids, item.id)) {
        cart.push(item);
    } else {
        var index = _.findIndex(cart, { id : item.id});
        cart[index].quantity += item.quantity
    }

    console.log('adicionarAoCarrinho', item)
}

$("body").on("click", "#limparCarrinho", function() {

    if(cart.length > 0){
        Swal.fire({
                title: "Cancelar?",
                text: "Deseja realmente Cancelar?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#1c0065",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sim, Cancelar!",
                preConfirm: function () {
                    return new Promise(function (resolve) {
                        cart = new Array();
                        $("#totalItens").html("0");
                        $("#TableNo").text("");
                        $("#TableNoCart").text("");
                        $(".valorTotal").html("R$0,00");
                        $("#CartHTML").html("");
                        $("#p_subtotal").html("R$0,00");
                        $(".totalPagar").html("R$0,00");
                        $("#pedidoID").val("");
                        $('#idsearchphone').val('');
                        $('#idsearchphone').trigger('change');
                        $('#tipoDeVenda').val(vendaTipo.ENTREGAR);
                        $('#tipoDeVenda').trigger('change');
                        Swal.fire({
                            title: "Sucesso",
                            text: "Sucesso",
                            icon: "success",
                        });
                    });
                },
                allowOutsideClick: false,
            });
        }
});

// $("body").on("keyup", "#item-quantity", function(e) {

//     if(e.keyCode == 13){
//        $('#getProduto').focus();
//        $('#getProduto').val('');
//     }
// });

var calcDiscount = function(id, index) {
    var quantity = $.tratarValor($('#item-quantity-'+id).val());
    var discount = $.tratarValor($('#item-discount-'+id).val());
    var discountTotal = 0;
    if(quantity > 0){
        var price = $.tratarValor($("#item-price-"+id).val());
        if(discountType === "%"){
            discountTotal = quantity * ((discount * price) / 100);
        }else{
            discountTotal = quantity * discount;
        }
    }

    return discountTotal
}

$("body").on("blur change", ".IncOrDecToCart", function(e) {
    //debugger;

    var item = {
        id: parseInt($(this).attr("data-id"))
    };
    var index = _.findIndex(cart, item);
    if ($.toMoneyVendaSimples($(this).val()) <= 0) {
        deleteItemFromCart(item);
    } else {
        cart[index].discountType = discountType;
        cart[index].discountValue = calcDiscount($(this).attr("data-id"),index);
        cart[index].quantity = $.toMoneyVendaSimples($(this).val());
    }

    show_cart();
});

$("body").on("keyup", ".IncOrDecToCart", function(e) {
    //debugger;
    if(e.keyCode == 13){
       $(this).blur();
       $(this).trigger('blur');
    }
});

$("body").on("blur change", ".priceToCart", function(e) {
    //debugger;

    var item = {
        id: parseInt($(this).attr("data-id"))
    };
    var index = _.findIndex(cart, item);
    cart[index].discountType = discountType;
    cart[index].discountValue = calcDiscount($(this).attr("data-id"),index);
    cart[index].price = $.toMoneyVendaSimples($(this).val());
    show_cart()
});

$("body").on("keyup", ".priceToCart", function(e) {

    if(e.keyCode == 13){
       $(this).blur();
       $(this).trigger('blur');
    }
});

$("body").on("blur change", ".discountToCart", function(e) {
    //debugger;

    var item = {
        id: parseInt($(this).attr("data-id"))
    };
    var index = _.findIndex(cart, item);

    cart[index].discountType = discountType;
    cart[index].discountValue = calcDiscount($(this).attr("data-id"),index);
    cart[index].discount = $.tratarValor($(this).val());

    show_cart();
});

$("body").on("keyup", ".discountToCart", function(e) {
    //debugger;
    if(e.keyCode == 13){
       $(this).blur();
       $(this).trigger('blur');
    }
});


$("body").on("click", ".DeleteItem", function() {
    var item = {
        id: parseInt($(this).attr("data-id"))
    };

    deleteItemFromCart(item);

});

function deleteItemFromCart(item) {
    var index = _.findIndex(cart, item);
    cart.splice(index, 1);
    show_cart();
}

function gravarPedido(status, e){
    if(status == vendaStatus.CONCLUIDA){
        var valorpago = $("#valortotalpago").val().replace('.','').replace(',', '.');
        var valorAPagar = $("#valorAPagar").val().replace('.','').replace(',', '.');
        if(valorpago <= 0){
            $("#valortotalpago").focus();
            swal.fire('', 'Digite o valor pago', 'error');
            return;
        }
        if((valorpago - valorAPagar) < 0){
            $("#valortotalpago").focus();
            swal.fire('', 'O valor pago é menor que o valor Total', 'error');
            return;
        }
    }

    if (cart.length < 1) {
        $("#checkout-modal").modal("hide");
        swal.fire("", "Pedido sem itens", "error");
        return false;
    }

    var vendasituacao = status;

    var form_data = {
        id: $("#pedidoID").val(),
        idempresa: $("#idempresa").val(),
        orcamento: $("#orcamento").val(),
        idclientevendedor: $("#idclientevendedor").val(),
        faturar: $("#faturar").val(),
        pdv: 1,
        observacao: $("#observacao").val(),
        idcliente: $("#idcliente").isNullOrEmpty() ? 1 : $("#idcliente").val(),
        id_tipo_pagto: $("#id_forma_pagto").val(),
        idvendatipo: $("#tipoDeVenda").val(),
        valorsubtotal: $("#p_subtotal").html().replace("R$", "").replace('.','').replace(',', '.'),
        valortotalpago: $("#valortotalpago").val().replace('.','').replace(',', '.'),
        valortotal: $(".valorTotal").html().replace("R$", "").replace('.','').replace(',', '.'),
        valortroco: $("#valortroco").val().replace('.','').replace(',', '.'),
        descontovalor : $("#valorDesconto").val().replace('.','').replace(',', '.'),
        descontoporcento : $("#valorDescCento").val().replace('.','').replace(',', '.'),
        vendaitens: _.map(cart, function(cart) {
            return {
                idproduto: cart.product_id,
                idcart: cart.id,
                quantidade: cart.quantity,
                discount: cart.discountValue,
                valorunitario: cart.price,
                name: cart.name,
                valortotal: (parseInt(cart.quantity) * cart.price),
            }
        })
    };

    //console.log("form_data" ,form_data);
    //return;

    var total_amount = Number(localStorage.getItem("total_amount"));
    _.map(cart, function(cart) {
        localStorage.setItem("total_amount", total_amount + (cart.quantity * cart.price));
    });

    $(e).html('<i class="fa fa-spinner fa-spin" style="font-size:18px"></i> Processando...');
    $(e).prop("disabled", true);

    var url = '';

    if($("#pedidoID").isNullOrEmpty()){
        url = '/pdv/inserir';
    }else{
        var id = $("#pedidoID").val();
        url = '/pdv/alterar/' + id;
    }
    console.log(form_data)
    Pace.restart();
    Pace.track(function () {
    $.ajax({
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        data: form_data,
        success: function(data) {
            $(".emEspera").html(data.emespera);
            $("#checkout-modal").modal("hide");
            cart = [];
            $("#TableNo").text("");
            $("#total_pago").val("");
            $("#valortroco").val("");
            $("#observacao").val("");
            $("#total_amount_modal").html("R$0,00");
            $("#finalizarPedido").html('Finalizar');
            $("#finalizarPedido").prop("disabled", false);
            $("#id").val("");

            var title = 'Pedido Finalizado';

            if(status == vendaStatus.ABERTA){
                title = 'Pedido em espera'
            }

            toastr.success(title);
            $('#idsearchphone').val('');
            $('#idsearchphone').trigger('change');
            if(status == vendaStatus.CONCLUIDA){
                $("#pedidoID").val(data.msg);
                $('#impressaoModal').modal('show');
            }

            $("#p_subtotal").html("R$0,00");
            $("#p_discount").html("R$0,00");
            $("#idcliente").val("");

            show_cart();

            if(status == vendaStatus.CONCLUIDA)
                $(e).html('Finalizar');
            else
                $(e).html('Pedido em espera');

            $(e).prop("disabled", false);
        },
        error: function(xhr, type, exception) {
            console.log(xhr);
            if(xhr.status == 401 || xhr.status == 419){
                 Swal.fire({
                     title: "Erro",
                     text: "Sua sessão expirou, é preciso fazer o login novamente.",
                     type: "error",
                     showCancelButton: false,
                     allowOutsideClick: false,
                 }).then(function (result) {
                     $.limparBloqueioSairDaTela();
                     location.reload();
                 });
            }else{
                toastr.error(xhr.responseJSON.message);
                if(status == vendaStatus.CONCLUIDA)
                    $(e).html('Finalizar');
                else
                    $(e).html('Pedido em espera');
                $(e).prop("disabled", false);
            }
        }
    });
    });
}


$("body").on("click", "#imprimirCozinha", function() {
    $('body').find('iframe[id=iframe_impressao]').attr('src', '/pdv/cozinha/' + $("#pedidoID").val());
});

$("body").on("click", "#imprimirCupom", function() {
    $('body').find('iframe[id=iframe_impressao]').attr('src', '/pdv/cupom/' + $("#pedidoID").val() );
});

$("body").on("click", "#printPedidosBtn", function() {
    var id = $(this).attr('data-id')
    if($.isNotNullAndNotEmpty(id)){
        Pace.restart()
        Pace.track(function(){
            $('body').find('iframe[id=iframe_impressao]').attr('src', '/pdv/cupom/' + id)
        })
    }else{
        Swal.fire(
            "Oops...",
            "Selecione um pedido..",
            "error"
        );
    }
});

$("body").on("click", "#finalizarPedido", function() {
    //socket.emit("guiche history");
    gravarPedido(vendaStatus.CONCLUIDA, this);
});

function show_cart() {
    if (cart.length > 0) {
        var qty = 0;
        var total = 0;
        var discount = 0;
        var cart_html = "";
        var obj = cart;
        $.each(obj, function(key, value) {
            console.log('show_cart', value)
            cart_html += '<tr>';
            cart_html += '<td><h5 style="margin:0px;">' + value.name + '</h5></td>';
            cart_html += '<td width="15%"><input type="text" value="' + $.toMoneySimples(value.quantity) + '" id="item-quantity-'+value.id+'" class="form-control form-control-sm money IncOrDecToCart" data-id=' + value.id + '></td>';
            cart_html += '<td width="15%"><input type="text" value="' + $.toMoneySimples(value.price) + '" id="item-price-'+value.id+'" class="form-control form-control-sm money priceToCart" data-id=' + value.id + '></td>';
            cart_html += '<td width="15%"><div class="input-group input-group-sm">';
            cart_html += '<input type="text" value="' + $.toMoneySimples(value.discount) + '" id="item-discount-'+value.id+'" class="form-control form-control-sm money discountToCart" data-id=' + value.id + '>';
            cart_html += '<span class="input-group-append"><button type="button" data-id=' + value.id + ' class="btn btn-primary btn-sm btn-change-discount">'+value.discountType+'</button>';
            cart_html += '</span></div></td>';
            cart_html += '<td width="15%" class="text-center"><h5 style="margin:0px;">' + $.toMoney((value.price * value.quantity) - value.discountValue) + '</h5> </td>';
            cart_html += '<td width="10%" class="text-center"><a href="javascript:void(0)"';
            cart_html += 'class="btn btn-sm btn-danger DeleteItem" data-id=' + value.id + '><i class="fa fa-trash"></i></a></td>';
            cart_html += '</tr>';

            qty = Number(value.quantity);
            discount += value.discountValue;
            total = Number(total) + Number(value.price * qty);
        });

        var taxa = 0;

        $("#p_subtotal").html($.toMoney(total));
        $("#p_discount").html($.toMoney(discount));
        console.log($.toMoney(discount))
        $("#valorDesconto").val($.toMoneyVendaSimples(discount, false));

        var total_amount = Number(total) - discount;
        $("#total_amount").val(total_amount);
        $("#total_amount_modal").html($.toMoney(total));
        $("#taxa").val(taxa);
        $("#valorAPagar").val($.toMoneyVendaSimples(total_amount, false))

        $(".valorTotal").html($.toMoney(total_amount));
        $("#CartHTML").html("");
        $("#CartHTML").html(cart_html);
        count_items = 0;
        cart.forEach(function(conta){
            count_items = parseInt(count_items) + parseInt(conta.quantity);
        });
        $("#totalItens").html(count_items);
        $(".countcart").html(count_items);
    } else {
        count_items = 0;
        $("#totalItens").html(count_items);
        $(".countcart").html(count_items);
        $(".valorTotal").html("R$0,00");
        $("#p_subtotal").html("R$0,00");
        $("#total_amount_modal").html("R$0,00");
        $("#CartHTML").html("");
    }
}

$('#pesquisar-produto-modal').on('hidden.bs.modal', function() {

    setTimeout(() => {
        $('#item-quantity').focus();
    }, 500);
});

$('#pesquisar-produto-modal').on('shown.bs.modal', function() {

    $("#find-product").select2('focus');
    $("#find-product").select2('open');
});

$('#pesquisar-cliente-modal').on('shown.bs.modal', function() {

    $("#find-client").select2('focus');
    $("#find-client").select2('open');
});

shortcut.add("F1", function (e) {
    e.preventDefault();
    $('#pesquisar-produto-modal').modal('show');
});

shortcut.add("F2", function (e) {
    e.preventDefault();
    $('#item-quantity').focus();
    $('#item-quantity').select();

});

shortcut.add("F3", function (e) {
    e.preventDefault();
    $('#item-discount').focus();
    $('#item-discount').select();

});
shortcut.add("F4", function (e) {
    e.preventDefault();
    $('#item-price').focus();
    $('#item-price').select();
});

shortcut.add("F5", function (e) {
    e.preventDefault();
});

shortcut.add("F6", function (e) {
    e.preventDefault();
    $('#pesquisar-cliente-modal').modal('show');
});

shortcut.add("F9", function (e) {
    e.preventDefault();
    $("#checkout").trigger('click');
});

shortcut.add("F7", function (e) {
    e.preventDefault();
    $("#limparCarrinho").trigger('click');
});

shortcut.add("ESC", function (e) {
    e.preventDefault();
    $("#pesquisar-produto-modal").modal('hide');
});
</script>
<style>
    .user-block .description {
        color: #b9b9b9 !important;
    }

    .cart-item {
        max-height: 160px;
        overflow-y: scroll;
    }

    .scale-anm {
        transform: scale(1);
    }

    .tile {
        -web-kit-transform: scale(0);
        transform: scale(0);
        -webkit-transition: all 350ms ease;
        transition: all 350ms ease;
    }

    .product_list {

        min-height: 200px !important;
        margin-top: 0px;
    }

    .product_list h2 {

        padding: 2px 8px;
        margin-bottom: 8px !important;
    }

    .sidebar-mini.sidebar-collapse .content-wrapper,
    .sidebar-mini.sidebar-collapse .main-footer,
    .sidebar-mini.sidebar-collapse .main-header {
        margin-left: 0px !important;
    }

    .content-header,
    .main-sidebar,
    .navbar-nav-pdv {
        display: none !important;
    }

    /* Chrome, Safari, Edge, Opera */
    .IncOrDecToCart::-webkit-outer-spin-button,
    .IncOrDecToCart::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    .IncOrDecToCart[type=number] {
        -moz-appearance: textfield;
    }
</style>
@endpush
