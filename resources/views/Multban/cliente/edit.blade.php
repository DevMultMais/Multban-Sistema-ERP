@extends('layouts.app-master')
@section('page.title', 'Cliente')
@push('script-head')

<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-select/css/select.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />
<link href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<!-- Main content -->
<section class="content">
    @if($routeAction)

    <form class="form-horizontal" id="formPrincipal" role="form" method="POST"
        action="{{ route('cliente.update', $cliente->cliente_id) }}">
        @method('PATCH')
        @else

        <form class="form-horizontal" id="formPrincipal" role="form" method="POST"
            action="{{ route('cliente.store') }}">
            @method('POST')
            @endif
            @include('Multban.template.updatetemplate')

                <input type="hidden" id="cliente_id" name="cliente_id" value="{{$cliente->cliente_id}}" />
             <input type="hidden" id="is_edit" value="1" />
            <div class="card card-primary card-outline card-outline-tabs">
                <!-- MENU ABAS/TABS -->
                <div class="card-header p-0 pt-1 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">

                        <li class="nav-item">
                            <a class="nav-link active" id="tabs-dados-tab" data-toggle="pill" href="#tabs-dados"
                                role="tab" aria-controls="tabs-dados" aria-selected="true">Dados Gerais</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="tabs-endereco-tab" data-toggle="pill" href="#tabs-endereco"
                                role="tab" aria-controls="tabs-endereco" aria-selected="false">Endereço</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="tabs-compras-tab" data-toggle="pill" href="#tabs-compras" role="tab"
                                aria-controls="tabs-compras" aria-selected="false">Compras Realizadas</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="tabs-score-tab" data-toggle="pill" href="#tabs-score" role="tab"
                                aria-controls="tabs-score" aria-selected="false">SCORE</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="tabs-cartoes-tab" data-toggle="pill" href="#tabs-cartoes" role="tab"
                                aria-controls="tabs-cartoes" aria-selected="false">Cartões</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="tabs-prontuario-tab" data-toggle="pill" href="#tabs-prontuario"
                                role="tab" aria-controls="tabs-prontuario" aria-selected="false">Prontuário</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="tabs-receituario-tab" data-toggle="pill" href="#tabs-receituario"
                                role="tab" aria-controls="tabs-receituario" aria-selected="false">Receituário</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="tabs-atendimento-tab" data-toggle="pill" href="#tabs-atendimento"
                                role="tab" aria-controls="tabs-atendimento" aria-selected="false">Atendimento</a>
                        </li>

                    </ul>
                </div>

                <!-- CONTEÚDO ABAS/TABS -->
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-two-tabContent">

                        <!--ABA DADOS GERAIS-->
                        <div class="tab-pane fade active show" id="tabs-dados" role="tabpanel"
                            aria-labelledby="tabs-dados-tab">

                            <div class="card card-primary">

                                <div class="card-body">

                                    <div class="form-row">

                                        <div class="form-group col-md-2">
                                            <label for="cliente_tipo">Tipo de cliente:*</label>
                                            <select class="form-control select2" id="cliente_tipo" name="cliente_tipo"
                                                data-placeholder="Selecione o tipo" style="width: 100%;">
                                                <option></option>
                                                @foreach($tipos as $key => $tipo)
                                                <option value="{{$tipo->cliente_tipo}}" {{$cliente->cliente_tipo ==
                                                    $tipo->cliente_tipo ? 'selected': ''}}>{{$tipo->cliente_tipo_desc}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="cliente_sts">Status:*</label>
                                            <select class="form-control select2" id="cliente_sts" name="cliente_sts"
                                                data-placeholder="Selecione o Status" style="width: 100%;">
                                                <option></option>
                                                @if ($canChangeStatus)
                                                    @foreach($status as $key => $sta)
                                                        <option value="{{$sta->cliente_sts}}" {{$cliente->cliente_sts ==
                                                            $sta->cliente_sts ? 'selected': ''}}>{{$sta->cliente_sts_desc}}
                                                        </option>
                                                    @endforeach
                                                @else
                                                <option value="NA" selected>Em análise</option>
                                                @endif
                                            </select>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="cliente_doc" id="labelcliente_doc">CPF/CNPJ:*</label>
                                            <div class="input-group input-group-sm">
                                                <input type="text" id="cliente_doc" name="cliente_doc"
                                                    class="form-control  form-control-sm" placeholder="Digite o CPF ou CNPJ"
                                                    value="{{$cliente->cliente_doc}}">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="cliente_pasprt">Número do Passaporte:</label>
                                            <div class="input-group input-group-sm">
                                                <input type="text" maxlength="15" id="cliente_pasprt" name="cliente_pasprt"
                                                    class="form-control  form-control-sm" placeholder="Digite o Número do Passaporte"
                                                    value="{{$cliente->cliente_pasprt}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">

                                        <div class="form-group col-md-4">
                                            <label for="cliente_nome">Nome:*</label>
                                            <input autocomplete="off" maxlength="255" class="form-control  form-control-sm" placeholder="Digite o nome"
                                                name="cliente_nome" type="text" id="cliente_nome"
                                                value="{{$cliente->cliente_nome}}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="cliente_nm_alt">Nome Alternativo:</label>
                                            <input autocomplete="off" maxlength="255" class="form-control  form-control-sm"
                                                placeholder="Digite o nome alternativo" name="cliente_nm_alt"
                                                type="text" id="cliente_nm_alt" value="{{$cliente->cliente_nm_alt}}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="cliente_nm_card">Nome Impresso no Cartão:</label>
                                            <input autocomplete="off" class="form-control  form-control-sm"
                                                placeholder="Digite o nome impresso no cartão" name="cliente_nm_card"
                                                type="text" id="cliente_nm_card" value="{{$cliente->cliente_nm_card}}">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="cliente_email">E-mail:*</label>
                                            <div class="input-group input-group-sm">
                                                <input autocomplete="off" type="email" class="form-control  form-control-sm"
                                                    id="cliente_email" name="cliente_email"
                                                    value="{{$cliente->cliente_email}}" placeholder="Digite o E-mail">
                                            </div>
                                        </div>

                                        <div class="form-group align-self-end">
                                            <button type="button" class="btn btn-primary btn-sm" id="btnReenviarSolicitacao">
                                                Reenviar Solicitação de Autorização
                                            </button>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-2">
                                            <label for="cliente_cel">Celular:*</label>
                                            <input autocomplete="off" type="text" class="form-control cell_with_ddd form-control-sm"
                                                id="cliente_cel" name="cliente_cel" value="{{$cliente->cliente_cel}}"
                                                placeholder="Digite o Celular">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="cliente_telfixo">Telefone Fixo:</label>
                                            <input autocomplete="off" type="text" class="form-control phone_with_ddd form-control-sm"
                                                id="cliente_telfixo" name="cliente_telfixo"
                                                value="{{$cliente->cliente_telfixo}}" placeholder="Digite o Telefone">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="cliente_rendam">Renda Mensal Aprox.:*</label>
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">R$</span>
                                                </div>
                                                <input autocomplete="off" class="form-control money form-control-sm"
                                                    placeholder="Digite a renda mensal aproximada" name="cliente_rendam"
                                                    type="text" id="cliente_rendam" value="{{$cliente->cliente_rendam}}"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="cliente_dt_fech">Dia para Fech.:*</label>
                                            <input class="form-control  form-control-sm"
                                                placeholder="Digite o melhor dia para fechamento" name="cliente_dt_fech"
                                                type="number" id="cliente_dt_fech" value="{{$cliente->cliente_dt_fech}}"
                                                required>
                                        </div>

                                    </div>

                                </div>
                                <!-- /.card-body -->
                            </div>

                            <!--Campo para os Dados Saneados-->
                            <div class="card card-primary">

                                <div class="card-body">

                                    <div class="card-header ui-sortable-handle header-dadosSaneados py-1">
                                        <h3 class="card-title">
                                            <i class="fas fa-chart-pie mr-1"></i>
                                            Dados Saneados
                                        </h3>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-2">
                                            <label for="cliente_cel_s">Telefone Celular Saneado:</label>
                                            <input type="text" class="form-control cell_with_ddd form-control-sm"
                                                value="{{$cliente->cliente_cel_s}}" id="cliente_cel_s"
                                                name="cliente_cel_s" disabled>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="cliente_rdam_s">Renda Mensal Saneada:</label>
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">R$</span>
                                                </div>
                                                <input type="text" class="form-control money form-control-sm"
                                                    value="{{$cliente->cliente_rdam_s}}" id="cliente_rdam_s"
                                                    name="cliente_rdam_s" disabled>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="cliente_email_s">E-mail Saneado:</label>
                                            <input type="text" class="form-control  form-control-sm"
                                                value="{{$cliente->cliente_email_s}}" id="cliente_email_s"
                                                name="cliente_email_s" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--ABA ENDEREÇO-->
                        <div class="tab-pane fade" id="tabs-endereco" role="tabpanel"
                            aria-labelledby="tabs-endereco-tab">

                            <div class="card card-primary">

                                <div class="card-body">

                                    <div class="form-row">

                                        <div class="form-group col-md-2">
                                            <label for="cliente_cep">CEP:*</label>
                                            <a href="#" data-toggle="modal" data-target="#cep-info-modal">
                                                <i class="far fa-question-circle"></i>
                                            </a>

                                            <div class="input-group input-group-sm">
                                                <input autocomplete="off" type="text" autofocus="autofocus"
                                                    class="form-control cep form-control-sm" id="cliente_cep" name="cliente_cep"
                                                    value="{{$cliente->cliente_cep}}" placeholder="CEP">
                                                <span class="input-group-append">
                                                    <button type="button" id="btnPesquisarCep"
                                                        class="btn btn-default"><i class="fa fa-search"></i></button>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="cliente_end">Endereço (Logradouro):*</label>
                                            <input autocomplete="off" class="form-control  form-control-sm" placeholder="Endereço"
                                                value="{{$cliente->cliente_end}}" name="cliente_end" type="text"
                                                id="cliente_end">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="cliente_endnum">Número:*</label>
                                            <input autocomplete="off" class="form-control  form-control-sm" placeholder="Número"
                                                value="{{$cliente->cliente_endnum}}" name="cliente_endnum" type="text"
                                                id="cliente_endnum">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="cliente_endcmp">Complemento:</label>
                                            <input autocomplete="off" class="form-control  form-control-sm" placeholder="Complemento"
                                                value="{{$cliente->cliente_endcmp}}" name="cliente_endcmp" type="text"
                                                id="cliente_endcmp">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="cliente_endbair">Bairro:*</label>
                                            <input autocomplete="off" class="form-control  form-control-sm" placeholder="Bairro"
                                                value="{{$cliente->cliente_endbair}}" name="cliente_endbair" type="text"
                                                id="cliente_endbair">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="cliente_endcid">Cidade:*</label>
                                            <select id="cliente_endcid" name="cliente_endcid"
                                                class="form-control select2 select2-hidden-accessible"
                                                data-placeholder="Pesquise a cidade" style="width: 100%;"
                                                aria-hidden="true">
                                                @if($cliente->cidade)
                                                <option value="{{$cliente->cidade->cidade}}">
                                                    {{$cliente->cidade->cidade_desc}}</option>

                                                @endif
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="cliente_endest">Estado:*</label>
                                            <select id="cliente_endest" name="cliente_endest"
                                                class="form-control select2 select2-hidden-accessible"
                                                data-placeholder="Pesquise o estado" style="width: 100%;"
                                                aria-hidden="true">
                                                @if($cliente->estado)
                                                <option value="{{$cliente->estado->estado}}">
                                                    {{$cliente->estado->estado}} - {{$cliente->estado->estado_desc}}
                                                </option>

                                                @endif
                                            </select>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="cliente_endpais">Pais:*</label>
                                            <select id="cliente_endpais" name="cliente_endpais"
                                                class="form-control select2 select2-hidden-accessible"
                                                data-placeholder="Pesquise o País" style="width: 100%;"
                                                aria-hidden="true">
                                                @if($cliente->pais)
                                                <option value="{{$cliente->pais->pais}}">{{$cliente->pais->pais}} -
                                                    {{$cliente->pais->pais_desc}}</option>
                                                @else
                                                <option value="BR">BR - BRASIL</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- card Endereço -->

                            <!--Campo para os Dados Saneados-->
                            <div class="card card-primary">

                                <div class="card-body">

                                    <div class="card-header ui-sortable-handle header-dadosSaneados py-1">
                                        <h3 class="card-title">
                                            <i class="fas fa-chart-pie mr-1"></i>
                                            Dados Saneados
                                        </h3>
                                    </div>


                                    <div class="form-row">
                                        <div class="form-group col-md-2">
                                            <label for="cliente_cep_s">CEP:*</label>
                                            <input type="text" class="form-control  form-control-sm" value="{{$cliente->cliente_cep_s}}"
                                                id="cliente_cep_s" name="cliente_cep_s" disabled>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="cliente_end_s">Endereço:</label>
                                            <input type="text" class="form-control  form-control-sm" value="{{$cliente->cliente_end_s}}"
                                                id="cliente_end_s" name="cliente_end_s" disabled>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="cliente_endnum_s">Número:</label>
                                            <input type="text" class="form-control  form-control-sm"
                                                value="{{$cliente->cliente_endnum_s}}" id="cliente_endnum_s"
                                                name="cliente_endnum_s" disabled>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="cliente_endcmp_s">Complemento:</label>
                                            <input type="text" class="form-control  form-control-sm"
                                                value="{{$cliente->cliente_endcmp_s}}" id="cliente_endcmp_s"
                                                name="cliente_endcmp_s" disabled>
                                        </div>
                                    </div>

                                    <div class="form-row">

                                        <div class="form-group col-md-3">
                                            <label for="cliente_endbair_s">Bairro:</label>
                                            <input type="text" class="form-control  form-control-sm"
                                                value="{{$cliente->cliente_endbair_s}}" id="cliente_endbair_s"
                                                name="cliente_endbair_s" disabled>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="cliente_endcid_s">Cidade:</label>
                                            <input type="text" class="form-control  form-control-sm"
                                                value="{{$cliente->cliente_endcid_s}}" id="cliente_endcid_s"
                                                name="cliente_endcid_s" disabled>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="cliente_endest_s">Estado:</label>
                                            <input type="text" class="form-control  form-control-sm"
                                                value="{{$cliente->cliente_endest_s}}" id="cliente_endest_s"
                                                name="cliente_endest_s" disabled>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="cliente_endpais_s">Pais:</label>
                                            <input type="text" class="form-control  form-control-sm"
                                                value="{{$cliente->cliente_endpais_s}}" id="cliente_endpais_s"
                                                name="cliente_endpais_s" disabled>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- ABA COMPRAS REALIZADAS -->
                        <div class="tab-pane fade" id="tabs-compras" role="tabpanel" aria-labelledby="tabs-compras-tab">
                            <div class="card card-primary">
                                <div class="card-body">

                                    <!-- FILTROS -->
                                    <div class="form-row">
                                        <div class="form-group col-md-2">
                                            <label for="dt_movimento">Data da Compra:</label>
                                            <input type="date" class="form-control  form-control-sm" id="dt_movimento"
                                                name="dt_movimento">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="dt_vencimento">Data de Vencimento:</label> <input type="date"
                                                class="form-control  form-control-sm" id="dt_vencimento" name="dt_vencimento">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-2">
                                            <label for="dt_vencimento">Data de Pagamento:</label>
                                            <input type="date" class="form-control  form-control-sm" id="dt_vencimento"
                                                name="dt_vencimento">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="titulo_sts">Status do Título</label>
                                            <select id="titulo_sts" name="titulo_sts" class="form-control select2"
                                                data-placeholder="Selecione um Status" style="width: 100%;">
                                                <option value="OP">As opções devem ser gerar a partir dos dados mestres
                                                    deste campoY</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <button type="button" id="btnPesquisar" class="btn btn-primary btn-sm" style=""><i
                                                    class="fa fa-search"></i> Pesquisar</button>
                                        </div>
                                    </div>

                                    <!-- TABELA -->
                                    <table class="table-responsive">
                                        <table id="gridtemplate" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th class="checkbox-comprasRealizadas"></th>
                                                    <th>Ações</th>
                                                    <th>ID da Transação</th>
                                                    <th>Data da Transação</th>
                                                    <th>Valor da Transação</th>
                                                    <th>Meio de Pagamento</th>
                                                    <th>Parcela</th>
                                                    <th>Status da Transação</th>
                                                </tr>
                                            </thead>

                                            <!------------------------------------------------------------------------->
                                            <!-- Exemplo de linha de compra. substituir por valores reais da pesquisa-->
                                            <tbody>
                                                <tr>
                                                    <td><input type="checkbox" name="compraSelecionada" value="1"></td>
                                                    <td class="d-flex" align="left">
                                                        <button class="btn btn-sm btn-primary mr-1"
                                                            title="Imprimir Comprovante"><i
                                                                class="fas fa-print"></i></button>
                                                        <button class="btn btn-sm btn-primary mr-1"
                                                            title="Manutenção de Título"><i
                                                                class="fas fa-wrench"></i></button>
                                                        <button class="btn btn-sm btn-primary mr-1" title="Pagar"><i
                                                                class="fas fa-usd-square"></i></button>
                                                        <button class="btn btn-sm btn-primary mr-1"
                                                            title="Baixa Manual"><i
                                                                class="fas fa-hands-usd"></i></button>
                                                        <button class="btn btn-sm btn-primary mr-1" title="Cancelar"><i
                                                                class="fas fa-ban"></i></button>
                                                    </td>
                                                    <td>1</td>
                                                    <td>01/01/2023</td>
                                                    <td>R$ 100,00</td>
                                                    <td>Dinheiro</td>
                                                    <td>1</td>
                                                    <td>Pago</td>
                                                </tr>

                                                <tr>
                                                    <td><input type="checkbox" name="compraSelecionada" value="1"></td>
                                                    <td class="d-flex" align="left">
                                                        <button class="btn btn-sm btn-primary mr-1"
                                                            title="Imprimir Comprovante"><i
                                                                class="fas fa-print"></i></button>
                                                        <button class="btn btn-sm btn-primary mr-1"
                                                            title="Manutenção de Título"><i
                                                                class="fas fa-wrench"></i></button>
                                                        <button class="btn btn-sm btn-primary mr-1" title="Pagar"><i
                                                                class="fas fa-usd-square"></i></button>
                                                        <button class="btn btn-sm btn-primary mr-1"
                                                            title="Baixa Manual"><i
                                                                class="fas fa-hands-usd"></i></button>
                                                        <button class="btn btn-sm btn-primary mr-1" title="Cancelar"><i
                                                                class="fas fa-ban"></i></button>
                                                    </td>
                                                    <td>2</td>
                                                    <td>15/01/2023</td>
                                                    <td>R$ 250,00</td>
                                                    <td>Boleto</td>
                                                    <td>1</td>
                                                    <td>Pendente</td>
                                                </tr>

                                                <tr>
                                                    <td><input type="checkbox" name="compraSelecionada" value="1"></td>
                                                    <td class="d-flex" align="left">
                                                        <button class="btn btn-sm btn-primary mr-1"
                                                            title="Imprimir Comprovante"><i
                                                                class="fas fa-print"></i></button>
                                                        <button class="btn btn-sm btn-primary mr-1"
                                                            title="Manutenção de Título"><i
                                                                class="fas fa-wrench"></i></button>
                                                        <button class="btn btn-sm btn-primary mr-1" title="Pagar"><i
                                                                class="fas fa-usd-square"></i></button>
                                                        <button class="btn btn-sm btn-primary mr-1"
                                                            title="Baixa Manual"><i
                                                                class="fas fa-hands-usd"></i></button>
                                                        <button class="btn btn-sm btn-primary mr-1" title="Cancelar"><i
                                                                class="fas fa-ban"></i></button>
                                                    </td>
                                                    <td>2</td>
                                                    <td>15/01/2023</td>
                                                    <td>R$ 550,00</td>
                                                    <td>Cartão</td>
                                                    <td>1</td>
                                                    <td>Inadimplente</td>
                                                </tr>
                                            </tbody>
                                            <!-- Exemplo de linha de compra. substituir por valores reais da pesquisa-->
                                            <!------------------------------------------------------------------------->

                                        </table>
                                    </table>
                                </div>
                            </div>

                            <div>
                                <button class="btn btn-primary btn-sm">Enviar Link de Pagto da Compra</button>
                                <button class="btn btn-primary btn-sm">Enviar Link de Pagto da Fatura</button>
                            </div>
                        </div>

                        <!-- ABA SCORE -->
                        <div class="tab-pane fade" id="tabs-score" role="tabpanel" aria-labelledby="tabs-score-tab">
                            <div class="card card-primary">
                                <div class="card-body">

                                    <!-- AÇÕES -->
                                    <div class="form-row">
                                        <div class="form-group col-md-2">
                                            <button type="button" class="btn btn-primary btn-sm"
                                                id="btnConsultarScore">Consultar SCORE</button>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <input class="font-weight-bold" style="font-size: 1.5rem; color: #a702d8;"
                                                id="cliente_socre" name="cliente_socre" placeholder="SCORE" value="">
                                        </div>
                                    </div>

                                    <!-- TABELA -->
                                    <table class="table-responsive">
                                        <table id="gridtemplate" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Número do Processo/Protesto</th>
                                                    <th>Tipo do Processo/Protesto</th>
                                                    <th>Descrição do Processo/Protesto</th>
                                                    <th>Status do Processo/Protesto</th>
                                                    <th>Data da Pesquisa</th>
                                                    <th>Data Início do Processo/Protesto</th>
                                                    <th>Data Fim do Processo/Protesto</th>
                                                    <th>Valor do Processo/Protesto</th>
                                                </tr>
                                            </thead>

                                            <!------------------------------------------------------------------------->
                                            <!-- Exemplo de linha de compra. substituir por valores reais da pesquisa-->
                                            <tbody>
                                                <tr>
                                                    <td>123456</td>
                                                    <td>Protesto</td>
                                                    <td>Descrição do Protesto</td>
                                                    <td>Ativo</td>
                                                    <td>01/01/2023</td>
                                                    <td>01/01/2020</td>
                                                    <td>01/01/2021</td>
                                                    <td>R$ 500,00</td>
                                                </tr>
                                                <tr>
                                                    <td>654321</td>
                                                    <td>Processo Judicial</td>
                                                    <td>Descrição do Processo</td>
                                                    <td>Encerrado</td>
                                                    <td>15/01/2023</td>
                                                    <td>01/01/2019</td>
                                                    <td>01/01/2020</td>
                                                    <td>R$ 1.000,00</td>
                                                </tr>
                                            </tbody>
                                            <!-- Exemplo de linha de compra. substituir por valores reais da pesquisa-->
                                            <!------------------------------------------------------------------------->

                                        </table>
                                    </table>
                                    AQUI PRECISAMOS FAZER COM QUE ESTES DADOS DIMINUAM A FONTE CONFORME O TAMANHO DA
                                    TELA</br>
                                    PARA CABER NA TELA INDEPENDENTE DO TAMANHO DO DISPOSITIVO
                                </div>
                            </div>
                        </div>

                        <!-- ABA CARTÕES -->
                        <div class="tab-pane fade" id="tabs-cartoes" role="tabpanel" aria-labelledby="tabs-cartoes-tab">
                            <div class="card card-primary">
                                <div class="card-body">

                                    <!-- AÇÕES -->
                                    <div class="form-row">
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-primary btn-sm" data-modal="modalCriarCartao" id="btnCriarCartao">Criar Novo
                                                Cartão</button>
                                        </div>

                                        <div class="col-md-8">
                                            <div class="form-group d-inline-block">
                                                <label for="cliente_socre" class="mr-2">SCORE do Cliente:</label>
                                                <input type="text" id="cliente_socre"
                                                    class="form-control form-control-sm" readonly
                                                    style="width: 150px; display: inline-block;">
                                            </div>

                                            <div class="form-group d-inline-block ml-2">
                                                <label for="cliente_lmt_sg" class="mr-2">Limite Sugerido:</label>
                                                <input type="text" id="cliente_lmt_sg"
                                                    class="form-control form-control-sm" placeholder="Limite Sugerido"
                                                    readonly style="width: 150px; display: inline-block;">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- TABELA -->
                                        <table id="gridtemplate-cards" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Ações</th>
                                                    <th>Empresa</th>
                                                    <th>Número do Cartão</th>
                                                    <th>CV</th>
                                                    <th>Status</th>
                                                    <th>Tipo do Cartão</th>
                                                    <th>Modalidade do Cartão</th>
                                                    <th>Categoria</th>
                                                    <th>Descrição do Cartão</th>
                                                    <th>Saldo do Cartão</th>
                                                    <th>Limite do Cartão</th>
                                                    <th>Saldo de Pontos</th>
                                                </tr>
                                            </thead>
                                        </table>


                                    AQUI PRECISAMOS FAZER COM QUE ESTES DADOS DIMINUAM A FONTE CONFORME O TAMANHO DA
                                    TELA</br>
                                    PARA CABER NA TELA INDEPENDENTE DO TAMANHO DO DISPOSITIVO

                                </div>
                            </div>
                        </div>

                        <!--ABA PROTUÁRIO-->
                        <div class="tab-pane fade" id="tabs-prontuario" role="tabpanel"
                            aria-labelledby="tabs-prontuario-tab">

                            <div class="row">
                                <!-- Seção Esquerda: Filtro e Lista -->
                                <div class="col-md-4 border-right">
                                    <form class="mb-4">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="data_de">De:</label>
                                                <input type="date" class="form-control  form-control-sm" id="data_de" name="data_de">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="data_ate">Até:</label>
                                                <input type="date" class="form-control  form-control-sm" id="data_ate" name="data_ate">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="protocolo">Protocolo:</label>
                                                <input type="text" class="form-control  form-control-sm" id="protocolo" name="protocolo"
                                                    placeholder="Digite o Protocolo">
                                            </div>
                                            <div class="form-group col-md-6 align-self-end">
                                                <button type="button" id="btnPesquisar" class="btn btn-primary btn-sm"
                                                    style=""><i class="fa fa-search"></i> Pesquisar</button>
                                            </div>
                                        </div>
                                    </form>
                                    <table class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>Protocolo</th>
                                                <th>Tipo</th>
                                                <th>Médico</th>
                                                <th>Anexo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="linha-protocolo" data-protocolo="548965">
                                                <td>548965</td>
                                                <td>Consulta</td>
                                                <td>Dr. Pedro</td>
                                                <td><i class="far fa-paperclip"></i></td>
                                            </tr>
                                            <tr class="linha-protocolo" data-protocolo="983647">
                                                <td>983647</td>
                                                <td>Retorno</td>
                                                <td>Dra. Ana</td>
                                                <td></td>
                                            </tr>
                                            <tr class="linha-protocolo" data-protocolo="964872">
                                                <td>964872</td>
                                                <td>Exame</td>
                                                <td>Dr. Fernando</td>
                                                <td><i class="far fa-paperclip"></i></td>
                                            </tr>
                                            <tr class="linha-protocolo" data-protocolo="369872">
                                                <td>369872</td>
                                                <td>Consulta</td>
                                                <td>Dra. Patrícia</td>
                                                <td></td>
                                            </tr>
                                            <tr class="linha-protocolo" data-protocolo="329618">
                                                <td>329618</td>
                                                <td>Emergência</td>
                                                <td>Dr. Flávio</td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Seção Central: Editor e Anexos -->
                                <div class="col-md-5">
                                    <form>
                                        <div class="form-group">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <label for="texto_prt" class="mb-0">Anotações:</label>
                                                <input type="text" id="protocolo_atual"
                                                    class="form-control form-control-sm font-weight-bold"
                                                    style="width: 180px; font-size: 1.3rem; font-weight: bold;"
                                                    readonly>
                                            </div>
                                            <textarea id="texto_prt" class="form-control summernote"
                                                rows="10"></textarea>
                                        </div>
                                        <button id="btnSalvarPrt" type="button" class="btn btn-primary btn-sm"><i
                                                class="icon fas fa-save"></i> Salvar</button>
                                        <button id="btnReceituario" type="button" class="btn btn-primary btn-sm"><i
                                                class="icon fas fa-files-medical"></i> Receituário</button>
                                    </form>
                                </div>

                                <!-- Seção Esquerda: Imagens -->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="anexos">Anexar Arquivos:</label>
                                        <input type="file" id="anexos" name="anexos[]" class="form-control-file"
                                            multiple>
                                    </div>
                                    <!-- Exemplo de exibição de fotos anexadas -->
                                    <div class="mt-4">
                                        <label>Fotos Anexadas:</label>
                                        <div>
                                            <img src="https://via.placeholder.com/80"
                                                class="img-thumbnail atendimento-foto"
                                                style="cursor:pointer;max-width:80px;"
                                                title="Clique duas vezes para ampliar">
                                            <img src="https://via.placeholder.com/80"
                                                class="img-thumbnail atendimento-foto"
                                                style="cursor:pointer;max-width:80px;"
                                                title="Clique duas vezes para ampliar">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            A TABELA A SER UTILIZADA É A TBDM_CLIENTES_PRT</br>
                            SOMENTE USUÁRIO DO TIPO MÉDICO TERÃO ACESSO A ESTA ABA</br>
                            TUDO O QUE FOR DIGITADO NO CAMPO TEXTO DEVERÁ SER GRAVADO EM UMA TABELA DO BANCO DE
                            DADOS</br>
                            AS IMAGENS CARREGADAS TAMBÉM PRECISAM SER GRAVADAS NO BANCO DE DADOS</br>
                            DO LADO ESQUERDO, TEMOS O HISTÓRICO DE TUDO O QUE FOI GRAVADO, SE CLICAR EM ALGUM HISTÓRICO,
                            DEVEMOS CARREGAR O TEXTO E AS IMAGENS</br>
                            OS FILTROS DE DATA DE/ATÉ DEVEM UTILIZAR O CAMPO DTHR_CR DA TABELA TBDM_CLIENTES_REC</br>
                            ATENTAR PARA A NAVEGAÇÃO, POIS AO CLICAR EM RECEITUÁRIO, DEVEMOS LEVAR O PROTOCOLO QUE
                            ESTIVER SELECIONADO
                        </div>

                        <!--ABA RECEITUÁRIO-->
                        <div class="tab-pane fade" id="tabs-receituario" role="tabpanel"
                            aria-labelledby="tabs-receituario-tab">

                            <div class="row">
                                <!-- Seção Esquerda: Lista de Receitas -->
                                <div class="col-md-4 border-right">
                                    <form class="mb-4">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="data_de">De:</label>
                                                <input type="date" class="form-control  form-control-sm" id="data_de" name="data_de">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="data_ate">Até:</label>
                                                <input type="date" class="form-control  form-control-sm" id="data_ate" name="data_ate">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="protocolo">Protocolo:</label>
                                                <input type="text" class="form-control  form-control-sm" id="protocolo" name="protocolo"
                                                    placeholder="Digite o Protocolo">
                                            </div>
                                            <div class="form-group col-md-6 align-self-end">
                                                <button type="button" id="btnPesquisar" class="btn btn-primary btn-sm"
                                                    style=""><i class="fa fa-search"></i> Pesquisar</button>
                                            </div>
                                        </div>
                                    </form>
                                    <table class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>Data</th>
                                                <th>Protocolo</th>
                                                <th>Médico</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="linha-protocolo-rec" data-protocolo="548965">
                                                <td>01/06/2024</td>
                                                <td>548965</td>
                                                <td>Dr. João Silva</td>
                                            </tr>
                                            <tr class="linha-protocolo-rec" data-protocolo="983647">
                                                <td>15/05/2024</td>
                                                <td>983647</td>
                                                <td>Dra. Maria Souza</td>
                                            </tr>
                                            <tr class="linha-protocolo-rec" data-protocolo="964872">
                                                <td>10/05/2024</td>
                                                <td>964872</td>
                                                <td>Dr. Carlos Lima</td>
                                            </tr>
                                            <tr class="linha-protocolo-rec" data-protocolo="369872">
                                                <td>25/04/2024</td>
                                                <td>369872</td>
                                                <td>Dra. Ana Paula</td>
                                            </tr>
                                            <tr class="linha-protocolo-rec" data-protocolo="329618">
                                                <td>10/04/2024</td>
                                                <td>329618</td>
                                                <td>Dr. Pedro Alves</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Seção Direita: Editor de Receita -->
                                <div class="col-md-8">
                                    <!-- Corpo da Receita -->
                                    <div class="form-group">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label for="texto_rec" class="mb-0">Receita:</label>
                                            <input type="text" id="protocolo_receita"
                                                class="form-control form-control-sm font-weight-bold"
                                                style="width: 180px; font-size: 1.3rem; font-weight: bold;" readonly>
                                        </div>

                                        <textarea id="texto_rec" class="form-control summernote" rows="8">
                                            <div style="display: flex; align-items: flex-start;">
                                                <img src="{{ asset('assets/dist/img/logo-amarela-min.png') }}" alt="Logo" style="height: 50px; margin-right: 15px;">
                                                <div>
                                                    <div style="font-size: 1.2em; font-weight: bold;">Nome da Clínica</div>
                                                    <div style="font-size: 1em;">Dr. Nome do Médico - CRM 000000</div>
                                                </div>
                                            </div>
                                            <hr>
                                            <p><br></p>
                                        </textarea>
                                    </div>
                                    <!-- Botões -->
                                    <button id="btnSalvarRec" type="button" class="btn btn-primary btn-sm"><i
                                            class="icon fas fa-save"></i> Salvar</button>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="printCorpoReceita();"><i
                                            class="far fa-print"></i> Imprimir</button>
                                </div>
                            </div>

                            A TABELA A SER UTILIZADA É A TBDM_CLIENTES_REC
                            SOMENTE USUÁRIO DO TIPO MÉDICO TERÃO ACESSO A ESTA ABA</br>
                            TUDO O QUE FOR DIGITADO NO CAMPO TEXTO DEVERÁ SER GRAVADO EM UMA TABELA DO BANCO DE
                            DADOS</br>
                            O CAMPO TEXTO DEVERÁ TER UM CABEÇALHO ONDE O LOGO DEVERÁ SER CARREGADO DO CADASTRO DA
                            EMPRESA</br>
                            OS DADOS DA CLÍNICA SERÃO CARREGADOS DA EMPRESA QUE O USUÁRIO ESTIVER LOGADO</br>
                            OS DADOS DO MÉDICO SERÃO CARREGADOS DO USUÁRIO QUE ESTIVER LOGADO</br>
                            OS FILTROS DE DATA DE/ATÉ DEVEM UTILIZAR O CAMPO DTHR_CR DA TABELA TBDM_CLIENTES_REC</br>
                            DO LADO ESQUERDO, TEMOS O HISTÓRICO DE TUDO O QUE FOI GRAVADO, SE CLICAR EM ALGUM HISTÓRICO,
                            DEVEMOS CARREGAR O TEXTO DA RECEITA
                        </div>

                        <!--ABA ATENDIMENTO-->
                        <div class="tab-pane fade" id="tabs-atendimento" role="tabpanel"
                            aria-labelledby="tabs-atendimento-tab">

                            EXEMPLO</br>
                            AQUI PRECISAMOS EMULAR A TELA DO WHATS APP PARA QUE O USUÁRIO POSSA ENTRAR EM CONTATO COM O
                            CLIENTE</br>

                            <div class="card"
                                style="max-width: 500px; margin: 0 auto; height: 600px; display: flex; flex-direction: column;">
                                <!-- Cabeçalho do chat -->
                                <div class="card-header bg-success text-white d-flex align-items-center">
                                    <img src="{{ asset('assets/dist/img/user-avatar.png') }}" alt="Avatar"
                                        class="rounded-circle mr-2" style="width: 40px; height: 40px;">
                                    <span>Atendimento WhatsApp</span>
                                </div>
                                <!-- Corpo do chat -->
                                <div id="chat-body" class="card-body"
                                    style="flex: 1 1 auto; overflow-y: auto; background: #e5ddd5;">
                                    <!-- Mensagens exemplo -->
                                    <div class="d-flex flex-column">
                                        <div class="align-self-start bg-white rounded p-2 mb-2" style="max-width: 70%;">
                                            <small class="text-muted">Cliente</small><br>
                                            Olá, gostaria de informações sobre meu atendimento.
                                        </div>
                                        <div class="align-self-end bg-success text-white rounded p-2 mb-2"
                                            style="max-width: 70%;">
                                            <small class="text-white">Atendente</small><br>
                                            Olá! Como posso ajudar?
                                        </div>
                                    </div>
                                </div>
                                <!-- Campo de digitação -->
                                <div class="card-footer bg-light">
                                    <form id="form-chat" class="d-flex">
                                        <input type="text" id="chat-input" class="form-control mr-2"
                                            placeholder="Digite sua mensagem..." autocomplete="off">
                                        <button type="button" class="btn btn-success"><i class="fab fa-whatsapp"></i>
                                            Enviar</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </form>
</section>




<div class="modal fade" id="pesquisa-cliente-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Informação</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Digite o CNPJ ou o nome do cliente.</p>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <select id="clicod" name="clicod" autofocus="autofocus"
                            class="form-control select2 select2-hidden-accessible"
                            data-placeholder="Digite o CNPJ ou o nome do cliente" style="width: 100%;"
                            aria-hidden="true">
                            <option></option>

                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success pull-right" id="btnSearchClient" data-dismiss="modal"><i
                        class="fa fa-check"></i> OK</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal cnpj-->

<div class="modal fade" id="cnpj-info-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Informação</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Digite o CNPJ e clique no botão <button type="button" class="btn btn-default" disabled><i
                            class="fa fa-search"></i></button>, para preencher as informações da empresa
                    automaticamente&hellip;</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal cnpj-->

<!-- Modal para Criar Novo Cartão -->

<div class="modal fade" id="modalCriarCartao" role="dialog" aria-labelledby="modalCriarCartaoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCriarCartaoLabel">Criar Novo Cartão
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="formCriarCartao">
                @method('POST')
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="emp_id">Empresa:</label>
                        <select id="emp_id" name="emp_id" class="form-control select2 select2-hidden-accessible"
                            data-placeholder="Pesquise a Empresa" style="width: 100%;" aria-hidden="true">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="card_tp">Tipo do Cartão:</label>
                        <select class="form-control select2" style="width: 100%;" data-placeholder="Selecione o Tipo" id="card_tp" name="card_tp">
                            <option></option>
                            @foreach($cardTipos as $key => $card)
                            <option value="{{$card->card_tp}}">{{$card->card_tp_desc}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="card_mod">Modalidade do Cartão:</label>
                        <select class="form-control select2" style="width: 100%;" data-placeholder="Selecione a Modalidade" id="card_mod" name="card_mod">
                            <option></option>
                            @foreach($cardMod as $key => $card)
                            <option value="{{$card->card_mod}}">{{$card->card_mod_desc}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="card_categ">Categoria:</label>
                        <select class="form-control select2" style="width: 100%;" data-placeholder="Selecione a Categoria" id="card_categ" name="card_categ">
                            <option></option>
                            @foreach($cardCateg as $key => $card)
                            <option value="{{$card->card_categ}}">{{$card->card_categ_desc}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="card_desc">Descrição do Cartão:</label>
                        <input type="text" class="form-control  form-control-sm" id="card_desc" name="card_desc"
                            placeholder="Descrição do Cartão">
                    </div>
                    <div class="form-group">
                        <label for="card_limite">Limite do Cartão:</label>
                        <input type="text" class="form-control money form-control-sm" id="card_limite" name="card_limite"
                            placeholder="Limite do Cartão">
                    </div>
                </div>

            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secundary-multban btn-sm" data-dismiss="modal">
                        <i class="fas fa-times"></i> Fechar</button>
                <button type="submit" class="btn btn-primary btn-sm" id="btnSalvarCartao"><i class="fas fa-save"></i> Salvar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cep-info-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Informação</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Digite o CEP e clique no botão <button type="button" class="btn btn-default" disabled><i
                            class="fa fa-search"></i></button>, para preencher o Endereço automaticamente&hellip;</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal cep-->


<!-- /.content -->
@endsection

@push('scripts')

<script type="text/javascript">
    $(document).ready(function () {


         // Verifica o status do usuário e ajusta o texto do botão de ativação/inativação
        if ("{{$cliente->cliente_sts}}" == "EX" ) {
            $("#btnInativar").text("Ativar");
            $("#btnInativar").prepend('<i class="fa fa-check"></i> ');
            $("#btnExcluir").prop('disabled', true);


        } else if ("{{$cliente->cliente_sts}}" == "AT") {
            $("#btnInativar").text("Inativar");
            $("#btnInativar").prepend('<i class="fa fa-ban"></i> ');
            $("#btnExcluir").prop('disabled', false);}
         else {
            $("#btnInativar").text("Inativar");
            $("#btnInativar").prepend('<i class="fa fa-ban"></i> ');
        }
        // Exibição de mensagens de alerta
        $(".alert-dismissible")
            .fadeTo(10000, 500)
            .slideUp(500, function() {
                $(".alert-dismissible").alert("close");
            });

        // Inicialização do Summernote - Editor de Texto
        $('.summernote').summernote({
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear', 'fontsize', 'fontname', 'color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video', 'table']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        // Botão Receituário
        $('#btnReceituario').on('click', function() {
            // Copia o valor do protocolo atual para o campo da aba Receituário
            $('#protocolo_receita').val($('#protocolo_atual').val());
            // Mostra a aba Receituário
            $('#tabs-receituario-tab').tab('show');
        });

        // Quando clicar em uma linha de protocolo, atualiza o campo do protocolo atual
        $('.linha-protocolo').on('click', function() {
            var protocolo = $(this).data('protocolo');
            $('#protocolo_atual').val(protocolo);
        });

        // Quando clicar em uma linha de protocolo, atualiza o campo do protocolo receita
        $('.linha-protocolo-rec').on('click', function() {
            var protocolo = $(this).data('protocolo');
            $('#protocolo_receita').val(protocolo);
        });

    });

    // Impressão do conteúdo do editor de receita
    function printCorpoReceita() {
        var conteudo = $('#corpo_receita').summernote('code');
        var janela = window.open('', '', 'height=600,width=800');
        janela.document.write('<html><head><title>Receita</title>');
        janela.document.write('<link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}">');
        janela.document.write('<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">');
        janela.document.write('</head><body>');
        janela.document.write(conteudo);
        janela.document.write('</body></html>');
        janela.document.close();
        janela.focus();

        // Aguarda o carregamento das imagens antes de imprimir
        janela.onload = function() {
            setTimeout(function() {
                janela.print();
                janela.close();
            }, 500); // 0.5 segundo de delay para garantir o carregamento
        };
    }

</script>

<script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-validation/localization/messages_pt_BR.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-validation/additional-methods.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/js/i18n/pt-BR.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/datatables-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<!-- InputMask -->
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
<link rel="stylesheet" href="{{asset('assets/dist/css/app.css') }}" />
<script src="{{asset('assets/dist/js/app.js') }}"></script>
<script src="{{asset('assets/dist/js/pages/cliente/cliente.js') }}"></script>

@endpush
