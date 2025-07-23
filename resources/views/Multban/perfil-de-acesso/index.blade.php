@extends('layouts.app-master')
@section('page.title', 'Permissões')
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
        <div class="card-header">
            <div class="row" style="margin-bottom: 5px">
                <div class="col-md-6">
                    <label>Empresa:</label>
                    <select class="form-control select2" id="idempresa" disabled="disabled" data-placeholder="Selecione"
                        style="width: 100%;">
                        <option id="{{$empresa->emp_id}}" value="{{$empresa->emp_id}}">
                            {{str_pad($empresa->emp_id, "5", "0", STR_PAD_LEFT).' - '. $empresa->emp_fant}}</option>

                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label id="pesquisaData"> </label>
                    <select class="form-control select2" id="idFiltro" style="width: 100%;">
                        @foreach ($filtros as $key => $filtro )
                        <option value="{{$key}}">{{$filtro}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 pesquisaData" style="display:none">
                    <label>Data inicial</label>
                    <input type="date" value="{{$dataInicial == '' ? date('Y-m-d') : $dataInicial}}"
                        class="form-control" id="dataInicial" />
                </div>
                <div class="col-md-2 pesquisaData" style="display:none">
                    <label>Data final</label>
                    <input type="date" value="{{$dataFinal == '' ? date('Y-m-d') : $dataFinal}}" class="form-control"
                        id="dataFinal" />
                </div>
                <div class="col-md-3">
                    <label id="pesquisaData">&nbsp;</label>
                    <div class="input-group mb-3">
                        <input type="text" id="inputPesquisa" class="form-control">
                        <span class="input-group-append">
                            <button type="button" id="btnPesquisar" class="btn btn-default"><i
                                    class="fa fa-search"></i></button>
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="card card-outline card-primary">
        @can('perfil-de-acesso.create')
        <div class="card-header">
            <a href="/perfil-de-acesso/inserir" class="btn btn-primary"><i class="fa fa-plus"></i> Criar novo</a>
        </div>
        @endcan
        <div class="card-body">

            <div class="table-responsive">
                <table id="gridtemplate" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome da permissão</th>
                            <th>Usuários com a permissão</th>
                            <th>Ação</th>
                        </tr>
                    </thead>

                </table>
            </div>

        </div>

</section>

@endsection
@push('scripts')
<!-- Select2 -->
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatables-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{asset('assets/dist/js/app.js') }}"></script>

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

$("#inputPesquisa").val({{Session::get('idModeloInserido')}})
setTimeout(function(){
    $("#btnPesquisar").trigger("click");
    $("#inputPesquisa").val("");
}, 500);
toastr.success("{{ $message }}", "Sucesso");
@endif

@if($message=Session::get('error'))
toastr.error("{{ $message }}", "Erro");
@endif
@if (count($errors)> 0)
@foreach ($errors->all() as $error)
toastr.error("{{ $error }}", "Erro");
@endforeach
@endif



$('#btnPesquisar').click(function(){
    var totaliza = {};
    totaliza.qtd = 0;
    totaliza.vlr = 3;
    totaliza.totaliza = false;
    $('#gridtemplate').DataTable().clear().destroy();
    ns.gridDataTable(colunas, colunasconfig, true, "single", "perfil-de-acesso", totaliza);
});
//Initialize Select2 Elements
$('.select2').select2();

var colunas = [
    {
        data: 'id',
        name: 'id'
    },
    {
        data:'name',
        name:'name',
        autoWidth: true
    },
    {
        data:'userRoles',
        name:'userRoles',
        autoWidth: true
    },
    {
        data: 'action',
        name: 'action',
        orderable: false,
        searchable: false
    }];

var colunasconfig = [
    { width: 20, targets: 0 },
    { width: "auto", targets: 1 },
    { width: "auto", targets: 2 },
    { width: "auto", targets: 3 }
];

var selecao = true;

// $(document).on('dblclick', 'tbody tr', function () {
//     var id = $('#gridtemplate').DataTable().row( this ).id();
//     window.location = '/perfil-de-acesso/'+parseInt(id)+ '/alterar';
// });

$(document).on('click', '#delete_grid_id', function(e){
    var id = $(this).data('id');
    ns.swalDelete(id, 'perfil-de-acesso');
    e.preventDefault();
});
});

</script>
@endpush

{{--
@extends('layouts.app-master')

@section('content')


@if(session()->get('error'))
    <div class="col-sm-12">
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-exclamation-triangle"></i> Alerta!</h5>
            {{ session()->get('error') }}
    </div>
    </div>
    @endif
    <h1 class="mb-3">Laravel 8 User Roles and Permissions Step by Step Tutorial - codeanddeploy.com</h1>

    <div class="bg-light p-4 rounded">
        <h1>Roles</h1>
        <div class="lead">
            Manage your roles here.
            <a href="{{ route('perfil-de-acesso.create') }}" class="btn btn-info btn-sm float-right">Add role</a>
        </div>

        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>

        <table class="table table-bordered">
          <tr>
             <th width="1%">No</th>
             <th>Name</th>
             <th width="3%" colspan="3">Action</th>
          </tr>
            @foreach ($roles as $key => $role)
            <tr>
                <td>{{ $role->id }}</td>
                <td>{{ $role->name }}</td>
                <td>
                    <a class="btn btn-info btn-sm" href="{{ route('perfil-de-acesso.show', $role->id) }}">Show</a>
                </td>
                <td>
                    <a class="btn btn-info btn-sm" href="{{ route('perfil-de-acesso.edit', $role->id) }}">Edit</a>
                </td>
                <td>
                    {!! Form::open(['method' => 'DELETE','route' => ['perfil-de-acesso.destroy', $role->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
            @endforeach
        </table>

        <div class="d-flex">
            {!! $roles->links() !!}
        </div>

    </div>
@endsection
--}}
