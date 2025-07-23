@extends('layouts.app-master')
@section('page.title', 'Usuário')
@push('script-head')
<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}">
@endpush

@section('content')
<!-- Main content -->
<section class="content">
    @if($routeAction)
    <form class="form-horizontal" id="formPrincipal" role="form" method="POST"
        action="{{ route('usuario.update', $usuario->user_id) }}">
        @method('PATCH')
        @else

        <form autocomplete="off" class="form-horizontal" id="formPrincipal" role="form" method="POST"
            action="{{ route('usuario.store') }}">
            @method('POST')
            @endif
            @csrf
            @include('Multban.template.updatetemplate')

            <div class="card card-outline card-tabs">
                <div class="card-header p-0 pt-1 border-bottom-0">

                    <!--ABAS/TABS-->
                    <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">

                        <li class="nav-item">
                            <a class="nav-link active" id="tabs-dados-tab" data-toggle="pill" href="#tabs-dados"
                                role="tab" aria-controls="tabs-dados" aria-selected="true">Dados Gerais</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="tabs-senha-tab" data-toggle="pill" href="#tabs-senha" role="tab"
                                aria-controls="tabs-senha" aria-selected="false">Senhas</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="tabs-adicionais-tab" data-toggle="pill" href="#tabs-adicionais"
                                role="tab" aria-controls="tabs-adicionais" aria-selected="false">Dados Adicionais</a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-two-tabContent">

                        <!--ABA DADOS GERAIS-->
                        <div class="tab-pane fade active show" id="tabs-dados" role="tabpanel"
                            aria-labelledby="tabs-dados-tab">
                            <div class="card card-primary">
                                <div class="card-body">

                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="Empresa">Empresa:*</label>
                                            <select id="emp_id" name="emp_id"
                                                class="form-control select2 select2-hidden-accessible"
                                                data-placeholder="Pesquise a Empresa" style="width: 100%;"
                                                aria-hidden="true">
                                                @if($usuario->empresa)
                                                <option value="{{$usuario->empresa->emp_id}}">
                                                    {{$usuario->empresa->emp_id}} - {{$usuario->empresa->emp_nfant}}
                                                </option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-3" id="serachClient">
                                            <label for="user_id">Código do Usuário:</label>
                                            <div class="input-group">
                                                <!--O código tem que ser registrado automaticamnete após a criação do usuário-->
                                                <input autocomplete="off" class="form-control"
                                                    id="user_id" name="user_id" value="{{$usuario->user_id}}"
                                                    placeholder="Código do Usuário" readonly="">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="user_logon">Usuário de Logon:*</label>
                                            <input autocomplete="off" type="text" class="form-control" id="user_logon"
                                                name="user_logon" value="{{$usuario->user_logon}}"
                                                placeholder="Digite o Usuário">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="user_sts">Status do Usuário:*</label>
                                            <select id="user_sts" name="user_sts" class="form-control select2"
                                                data-placeholder="Selecione" style="width: 100%;" required
                                                aria-hidden="true">
                                                <option></option>
                                                @foreach($status as $key => $sts)
                                                <option value="{{$sts->user_sts}}" {{$sts->user_sts ==
                                                    $usuario->user_sts ? 'selected' : ''}}>{{$sts->user_sts_desc}}
                                                </option>

                                                @endforeach
                                            </select>
                                        </div>

                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="user_name">Nome Completo:*</label>
                                            <input autocomplete="off" class="form-control" placeholder="Digite o nome"
                                                name="user_name" type="text" id="user_name"
                                                value="{{$usuario->user_name}}">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="user_cpf">CPF do Usuário:*</label>
                                            <input autocomplete="off" type="text"
                                                class="form-control cpf" id="user_cpf" name="user_cpf"
                                                value="{{$usuario->user_cpf}}" placeholder="CPF" maxlength="14">

                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="user_crm">CRM do Usuário:</label>
                                            <input autocomplete="off" type="text"
                                                class="form-control" id="user_crm" name="user_crm"
                                                value="{{$usuario->user_crm}}" placeholder="CRM" maxlength="14">

                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="user_email">E-mail:*</label>
                                            <input autocomplete="off" type="email" class="form-control" id="user_email"
                                                name="user_email" value="{{$usuario->user_email}}"
                                                placeholder="Digite o E-mail">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="user_func">Cargo:*</label>
                                            <select id="user_func" name="user_func" class="form-control select2"
                                                data-placeholder="Selecione" style="width: 100%;" required
                                                aria-hidden="true">
                                                <option></option>
                                                @foreach($tbDmUserFunc as $key => $func)
                                                <option value="{{$func->user_func}}" {{$func->user_func ==
                                                    $usuario->user_func ? 'selected' : '' }}>{{$func->user_func_desc}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="user_cel">Número de Celular:*</label>
                                            <input autocomplete="off" type="text" class="form-control cell_with_ddd"
                                                id="user_cel" name="user_cel" value="{{$usuario->user_cel}}"
                                                placeholder="Digite o Celular">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="user_tfixo">Telefone Fixo:</label>
                                            <input autocomplete="off" type="text" class="form-control phone_with_ddd"
                                                id="user_tfixo" name="user_tfixo" value="{{$usuario->user_tfixo}}"
                                                placeholder="Digite o Telefone Fixo">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="user_role">Perfil de Acesso:*</label>
                                            <select class="form-control select2" name="user_role" id="user_role"
                                                data-placeholder="Selecione" style="width: 100%;">
                                                <option></option>
                                                @foreach($roles as $role)
                                                <option id="{{$role}}" @foreach($userRole as $u) @if($role==$u)
                                                    selected="selected" @endif @endforeach value="{{$role}}">
                                                    {{$role}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="user_screen">Tela Inicial:*</label>
                                            <select class="form-control select2" name="user_screen" id="user_screen"
                                                data-placeholder="Selecione" style="width: 100%;">
                                                <option></option>
                                                @foreach($telas as $key => $tela)
                                                <option value="{{$tela->name}}" {{$tela->name == $usuario->user_screen ?
                                                    'selected' : ''}}>{{$tela->description}}</option>

                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="langu">Idioma:</label>
                                            <select class="form-control select2" name="langu" id="langu"
                                                data-placeholder="Selecione" style="width: 100%;">
                                                <option></option>
                                                @foreach($langu as $key => $lang)
                                                <option value="{{$lang->langu}}" {{$lang->langu == $usuario->langu ?
                                                    'selected' : '' }}>{{$lang->langu_desc}}</option>

                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--ABA DE SENHA-->
                        <div class="tab-pane fade" id="tabs-senha" role="tabpanel" aria-labelledby="tabs-senha-tab">
                            <div class="card card-primary">
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="user_pass">Senha do Usuário:</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control custom-input" id="user_pass"
                                                    name="user_pass" required placeholder="Digite sua senha">
                                                <span class="input-group-append">
                                                    <button type="button" class="btn btn-default eye"><i
                                                            class="fa fa-eye-slash"></i></button>
                                                </span>
                                            </div>
                                            <span id="user_passError" class="text-danger text-sm"></span>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="confirm_password">Repetir Senha:</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control custom-input"
                                                    id="confirm_password" name="confirm_password" required
                                                    placeholder="Repita sua senha">
                                                <span class="input-group-append">
                                                    <button type="button" class="btn btn-default eye"><i
                                                            class="fa fa-eye-slash"></i></button>
                                                </span>
                                            </div>
                                            <span id="confirm_passwordError" class="text-danger text-sm"></span>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <button type="button" class="btn btn-primary" id="btnEnviarSenha">Enviar
                                                Solicitação de Cadastro por Email</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ABA DADOS ADICIONAIS -->
                        <div class="tab-pane fade" id="tabs-adicionais" role="tabpanel"
                            aria-labelledby="tabs-adicionais-tab">
                            <div class="card card-primary">
                                <div class="card-body">

                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="user_resp">Supervisor do Usuário:</label>
                                            <select class="form-control select2" name="user_resp" id="user_resp"
                                                data-placeholder="Selecione" style="width: 100%;">
                                                <option></option>
                                                @foreach($users as $key => $user)
                                                    <option value="{{$user->user_id}}" {{$user->user_id == $usuario->user_resp ? 'selected' : ''}}>{{$user->user_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-2 text-center">
                                            <label>Usuário Comissionado:</label>

                                            <div class="form-group">
                                                <div class="custom-control custom-radio d-inline">
                                                    <input class="custom-control-input" type="radio"
                                                        {{$usuario->user_comis == 'x' ? 'checked' : ''}}
                                                    value="sim"
                                                    id="user_comis" name="user_comis">
                                                    <label for="user_comis" class="custom-control-label">SIM</label>
                                                </div>
                                                <div class="custom-control custom-radio d-inline">
                                                    <input class="custom-control-input" type="radio"
                                                        {{$usuario->user_comis == '' ? 'checked' : ''}} value="nao"
                                                    id="user_comis_n" name="user_comis">
                                                    <label for="user_comis_n" class="custom-control-label">NÃO</label>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="user_pcomis">Percentual de Comissão:</label>
                                            <input type="text" value="{{$usuario->user_pcomis}}" class="form-control porcentagem" id="user_pcomis" name="user_pcomis"
                                                placeholder="%" min="0" max="100">
                                        </div>
                                    </div>

                                    <div class="form-row">

                                        <div class="form-group col-md-3">
                                            <label for='user_cdgbc'>Cdg Banco Principal:</label>
                                            <select class="form-control select2" data-allow-clear="true"
                                                name="user_cdgbc" id="user_cdgbc" data-placeholder="Selecione"
                                                style="width: 100%;">
                                                <option></option>

                                                @foreach($tbDmBncCode as $key => $bnc)
                                                <option {{ ($bnc->cdgbc == $usuario->user_cdgbc) ? 'selected' :
                                                    '' }}
                                                    value="{{$bnc->cdgbc}}">
                                                    {{$bnc->cdgbc}} - {{$bnc->cdgbc_desc}}
                                                </option>
                                                @endforeach
                                            </select>
                                            <span id="user_cdgbcError" class="text-danger text-sm"></span>
                                        </div>

                                        <div class="col-md-7" id="banco-principal" style="display: none;">
                                            <div class="row">
                                                <div class="form-group col-md-3">
                                                    <label for='user_agbc'>Agência:</label>
                                                    <input type="text" maxlength="20" id='user_agbc' name='user_agbc'
                                                        value="{{ $usuario->user_agbc ?? '' }}" class='form-control'
                                                        placeholder='Agência'>
                                                    <span id="user_agbcError" class="text-danger text-sm"></span>
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label for='user_ccbc'>Conta Corrente:</label>
                                                    <input type="text" id='user_ccbc' name='user_ccbc'
                                                        value="{{$usuario->user_ccbc ?? '' }}" class='form-control'
                                                        placeholder='Conta Corrente'>
                                                    <span id="user_ccbcError" class="text-danger text-sm"></span>
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label for='user_pix'>Chave PIX:</label>
                                                    <input type="text" id='user_pix' name='user_pix'
                                                        value="{{$usuario->user_pix ?? '' }}" class='form-control'
                                                        placeholder='Chave PIX'>
                                                    <span id="user_pixError" class="text-danger text-sm"></span>
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label for='user_seller'>Seller:</label>
                                                    <input type="text" id='user_seller' name='user_seller'
                                                        value="{{$usuario->user_seller ?? '' }}" class='form-control'
                                                        placeholder='Seller'>
                                                    <span id="user_sellerError" class="text-danger text-sm"></span>
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
    </form>
</section>
<!-- /.content -->

@endsection

@push('scripts')

<script type="text/javascript">
    $(document).ready(function(e) {

         @if ($usuario->user_pcomis > 0)
            $("#banco-principal").show();
        @endif

        @if ($usuario->user_cdgbc)
            $("#banco-principal").show();
        @endif

        // Verifica o status do usuário e ajusta o texto do botão de ativação/inativação
        if ("{{$usuario->user_sts}}" == "EX" || "{{$usuario->user_sts}}" == "IN") {
            $("#btnInativar").text("Ativar");
            $("#btnInativar").prepend('<i class="fa fa-check"></i> ');
            $("#btnExcluir").prop('disabled', true);


        } else {
            $("#btnInativar").text("Inativar");
            $("#btnInativar").prepend('<i class="fa fa-ban"></i> ');
        }
    });
</script>
<script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-validation/localization/messages_pt_BR.min.js') }}"></script>
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
<script src="{{ asset('assets/dist/js/pages/usuario/usuario.js') }}"></script>
@endpush
