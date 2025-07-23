@extends('layouts.app-master')
@section('page.title', 'Usuário')
@push('script-head')
<!-- Select2 -->
<link rel="stylesheet" href="/assets/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-select/css/select.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />
@endpush
@section('content')
<!-- Main content -->
<section class="content">
    @if(session()->get('success'))
        <div class="col-sm-12">
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-check"></i> Sucesso!</h5>
                {{ session()->get('success') }}
            </div>
        </div>
    @endif

    @if(session()->get('warning'))
        <div class="col-sm-12">
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-check"></i> Alerta!</h5>
                {{ session()->get('warning') }}
            </div>
        </div>
    @endif


    <div class="card card-outline card-primary">

        <div class="card-body" id="filtro-pesquisa">

            <div class="form-row">

                <div class="form-group col-md-3">
                    <label for="empresa_id">Empresa:</label>
                    <select id="empresa_id" name="empresa_id" class="form-control select2 select2-hidden-accessible"
                        data-placeholder="Pesquise a Empresa" style="width: 100%;" aria-hidden="true">
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Nome do Usuário:</label>
                    <select id="usuario" name="usuario" class="form-control select2 select2-hidden-accessible"
                        data-placeholder="Digite o Usuário" style="width: 100%;" aria-hidden="true">
                    </select>
                </div>
            </div>

            <div class="form-row">

                <div class="form-group col-md-2">
                    <label>CPF do Usuário:</label>
                    <input type="text" id="cpf" name="cpf" class="form-control cpf" placeholder="000.000.000-00" maxlength="11">
                </div>

                <div class="form-group col-md-3 align-self-end">
                    <button type="button" id="btnPesquisar" class="btn btn-primary mt-2" style=""><i class="fa fa-search"></i> Pesquisar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-outline card-primary">
        @can('usuario.create')
            <div class="card-header">
                <a href="/usuario/inserir" class="btn btn-primary"><i class="fa fa-plus"></i> Criar novo</a>
            </div>
        @endcan
        <div class="card-body">
            <div class="table-responsive">
                <table id="gridtemplate" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>Ações</th>
                            <th>Nome</th>
                            <th>Usuario</th>
                            <th>CPF</th>
                            <th>Email</th>
                            <th>Empresa</th>
                            <th>Permissão</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                </table>
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
<script src="{{asset('assets/dist/js/app.js') }}"></script>
<script src="{{ asset('assets/dist/js/pages/usuario/gridusuario.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function(){


        $('#inputPesquisa').on('keyup', function(e){
            if(e.keyCode == 13 /*Enter*/){
                $("#btnPesquisar").trigger("click");
            }
        })

        $(".alert-dismissible")
        .fadeTo(10000, 500)
        .slideUp(500, function() {
            $(".alert-dismissible").alert("close");
        });

        @if ($message = Session::get('success'))
            toastr.success("{{ $message }}", "Sucesso");
            console.log('idModeloInserido', "{{Session::get('idModeloInserido')}}")
            $("#inputPesquisa").val("{{Session::get('idModeloInserido')}}")
            setTimeout(function(){
                $("#btnPesquisar").trigger("click");
                $("#inputPesquisa").val("");
            }, 200);
        @endif

        @if($message=Session::get('error'))
            toastr.error("{{ $message }}", "Erro");
        @endif
        @if (count($errors)> 0)
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}", "Erro");
        @endforeach
        @endif



var selecao = true;

$(document).on('click', '#delete_grid_id', function(e){
    var id = $(this).data('id');
    ns.swalDelete(id, 'usuario');
    e.preventDefault();
});
});

</script>
@endpush
