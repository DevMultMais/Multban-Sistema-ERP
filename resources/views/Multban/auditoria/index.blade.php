@extends('layouts.app-master')
@section('page.title', 'Auditoria')
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
                        <option id="{{$configuracao->id}}" value="{{$configuracao->id}}">
                            {{str_pad($configuracao->id, "5", "0", STR_PAD_LEFT).' - '. $configuracao->cfgnom}}</option>

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
        <div class="card-body">

            <div class="table-responsive">
                <table id="gridtemplate" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>Usuário</th>
                            <th>Data</th>
                            <th>Ação</th>
                            <th>Tabela/Rotina</th>
                            <th>Identificação</th>
                            <th>Antes</th>
                            <th>Depois</th>
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



$('#btnPesquisar').click(function(){
    var totaliza = {};
    totaliza.qtd = 0;
    totaliza.vlr = 3;
    totaliza.totaliza = false;
    $('#gridtemplate').DataTable().clear().destroy();
    ns.gridDataTable(colunas, colunasconfig, false, "single", "auditoria", totaliza);
});
//Initialize Select2 Elements
$('.select2').select2();

var colunas = [
    {
        data:'audusu',
        name:'audusu',
        autoWidth: true
    },
    {
        data:'auddat',
        name:'auddat',
        autoWidth: true
    },
    {
        data:'audtar',
        name:'audtar',
        autoWidth: true
    },
    {
        data:'audarq',
        name:'audarq',
        autoWidth: true
    },
    {
        data: 'audlan',
        name: 'audlan',
        orderable: false,
        searchable: false
    },
    {
        data: 'audant',
        name: 'audant',
        orderable: false,
        searchable: false
    },
    {
        data: 'auddep',
        name: 'auddep',
        orderable: false,
        searchable: false
    }


];

var colunasconfig = [
];

var selecao = true;

// $(document).on('dblclick', 'tbody tr', function () {
//     var id = $('#gridtemplate').DataTable().row( this ).id();
//     window.location = '/auditoria/'+parseInt(id)+ '/alterar';
// });

$(document).on('click', '#delete_grid_id', function(e){
    var id = $(this).data('id');
    ns.swalDelete(id, 'auditoria');
    e.preventDefault();
});
});

</script>
@endpush
