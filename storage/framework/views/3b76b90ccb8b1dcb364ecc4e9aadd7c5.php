
<?php $__env->startSection('page.title', 'Home'); ?>
<?php $__env->startPush('script-head'); ?>
<link href="<?php echo e(url('/assets/plugins/morris/morris.css')); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?php echo e(asset('assets/plugins/datatables-checkboxes/css/dataTables.checkboxes.min.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(asset('assets/plugins/datatables-select/css/select.bootstrap4.min.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(asset('assets/plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.min.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')); ?>" />

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?php echo e(empty($vendas) ? 0 : $vendas); ?></h3>
                        <b>
                            <p>VENDAS</p>
                        </b>
                    </div>
                    <div class="icon">
                        <i class="fas fa-money-bill"></i>
                    </div>
                    <div class="small-box-footer">
                        Total de Vendas
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">

                        <h3><?php echo e(empty($produtosVendidos) ? 0 : $produtosVendidos); ?></h3>
                        <b>
                            <p><span>ITENS VENDIDOS</span></p>
                        </b>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <div class="small-box-footer">
                        Total Vendido
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?php echo e($quantidadeCliente == 0 ? 0 : $quantidadeCliente); ?></h3>

                        <b>
                            <p>CLIENTES</p>
                        </b>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="<?php echo e(url('/cliente')); ?>" class="small-box-footer">

                        <i class="fa fa-arrow-circle-right"></i> Ver página
                    </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3><?php echo e($quantidadeProduto == 0 ? 0 : $quantidadeProduto); ?></h3>
                        <b>
                            <p>PRODUTOS</p>
                        </b>
                    </div>
                    <div class="icon">
                        <i class="fa fa-archive"></i>
                    </div>
                    <a href="<?php echo e(url('/produto')); ?>" class="small-box-footer">
                        <i class="fa fa-arrow-circle-right"></i> Ver página
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header ui-sortable-handle">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Vendas mês a mês
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div id="flotchartMes"></div>
                    </div><!-- /.card-body -->
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header ui-sortable-handle">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Movimento de Caixa
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                            <!--button type="button" class="btn btn-tool" data-card-widget="remove"><i
                            class="fas fa-times"></i></button-->
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body p-0">
                        <div id="flotchartMov"></div>
                    </div><!-- /.card-body -->
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header ui-sortable-handle">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Novos clientes
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                            <!--button type="button" class="btn btn-tool" data-card-widget="remove"><i
                            class="fas fa-times"></i></button-->
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body p-0">
                        <div id="flotchartCadasCli"></div>
                    </div><!-- /.card-body -->
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Produtos mais vendidos este mês</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                            <!--button type="button" class="btn btn-tool" data-card-widget="remove"><i
                            class="fas fa-times"></i></button-->
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-2">
                        <table id="maisvendidos-table" class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10px">ID</th>
                                    <th>Produto</th>
                                    <th>Preço</th>
                                    <th>Qtde.</th>
                                    <th width="80">Total</th>
                                    <th>Porcent.</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-outline card-primary">
                    <div class="card-header with-border">
                        <h3 class="card-title">Movimentacao caixa</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body chart-responsive"><br>
                        <div class="chart" id="sales-chart" style="height: 300px; position: relative;"></div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</section>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>

<script src="<?php echo e(asset('assets/plugins/select2/js/select2.full.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugins/highcharts/highcharts.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugins/highcharts/modules/exporting.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugins/highcharts/modules/export-data.js')); ?>"></script>

<script src="<?php echo e(asset('assets/plugins/morris/morris.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugins/raphael/raphael.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugins/chart-js/Chart.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugins/datatables/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugins/datatables-select/js/dataTables.select.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugins/datatables-fixedheader/js/dataTables.fixedHeader.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugins/datatables-checkboxes/js/dataTables.checkboxes.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')); ?>"></script>

<script src="<?php echo e(asset('assets/plugins/jszip/jszip.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugins/pdfmake/pdfmake.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugins/pdfmake/vfs_fonts.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugins/datatables-buttons/js/buttons.print.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/dist/js/app.js')); ?>"></script>
<script type="text/javascript">
    $(document).ready(function () {
           var table = $('#maisvendidos-table').DataTable({
                processing: true,
                //serverSide: true,
                responsive: true,
                paging: true,
                lengthChange: true,
                searching: false,
                ordering: true,
                info: true,
                autoWidth: false,
                rowId: "id",
                language: {
                    select: {
                        rows: {
                            _: "%d itens selecionados",
                            0: "",
                            1: "1 item selecionado",
                        },
                    },
                    sEmptyTable: "Nenhum registro encontrado",
                    sInfo:
                        "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    sInfoEmpty: "Mostrando 0 até 0 de 0 registros",
                    sInfoFiltered: "(Filtrados de _MAX_ registros)",
                    sInfoPostFix: "",
                    sInfoThousands: ".",
                    sLengthMenu: "_MENU_ resultados por página",
                    sLoadingRecords: "Carregando...",
                    sProcessing: "Processando...",
                    sZeroRecords: "Nenhum registro encontrado",
                    sSearch: "Pesquisar",
                    oPaginate: {
                        sNext: "Próximo",
                        sPrevious: "Anterior",
                        sFirst: "Primeiro",
                        sLast: "Último",
                    },
                    oAria: {
                        sSortAscending:
                            ": Ordenar colunas de forma ascendente",
                        sSortDescending:
                            ": Ordenar colunas de forma descendente",
                    },
                },
                "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // converting to interger to find total
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // computing column Total of the complete result
            var qtdTotal = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    //console.log(a, b)
                    return intVal(a) + intVal(b);
                }, 0 );

	        var valorTotal = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    //console.log(a, b)
                    return intVal(a) + intVal(b);
                }, 0 );


            // Update footer by showing the total with the reference of the column index
	    $( api.column( 0 ).footer() ).html('Total: ');
            $( api.column( 3 ).footer() ).html($.fn.dataTable.render.number( '.', ',', 2, '' ).display(qtdTotal));
            $( api.column( 4 ).footer() ).html($.toMoney(valorTotal));
        },
        ajax: '<?php echo route('home.maisvendidos'); ?>',
        columns: [
            { data: 'idproduto', name: 'idproduto' },
            { data: 'descricao', name: 'descricao' },
            { data: 'preco', name: 'preco', render: $.fn.dataTable.render.number( '.', ',', 2, 'R$ ' ) },
            { data: 'quantidade', name: 'quantidade', render: $.fn.dataTable.render.number( '.', ',', 2, '' )},
            { data: 'valortotal', name: 'valortotal', render: $.fn.dataTable.render.number( '.', ',', 2, 'R$ ' ) },
            { data: 'porcentagem', name: 'porcentagem' },
        ],
        fixedColumns: true,
                        select: "single",
                        order: [[3, "desc"]],
    });
    table.buttons().container()
        .appendTo( '#maisvendidos-table .col-md-6:eq(0)' );
});


var cadascli = []
var cadasclires = <?php echo $cadascli; ?>

$.each(cadasclires, function(key, value){
    cadascli.push(value)
})
console.log(cadascli)

var receita = ('<?php echo e($dashboardMovimentacao["receita"]); ?>').replace(',', '.')
var despesa = ('<?php echo e($dashboardMovimentacao["despesa"]); ?>').replace(',', '.')
var total = ('<?php echo e($dashboardMovimentacao["total"]); ?>').replace(',', '.')
var monthsReceita = []
var monthsDespesa = []
var monthsTotal = []

<?php $__currentLoopData = $dashboardMovimentacao["monthsReceita"]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
monthsReceita.push(<?php echo e($item); ?>);
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__currentLoopData = $dashboardMovimentacao["monthsDespesa"]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
monthsDespesa.push(<?php echo e($item); ?>);
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__currentLoopData = $dashboardMovimentacao["monthsTotal"]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
monthsTotal.push(<?php echo e($item); ?>);
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

var donut = new Morris.Donut({
    element: 'sales-chart',
    resize: true,
    colors: ["#28a745", "#dc3545", "#17a2b8"],
    data: [{
            label: "Receita",
            value: receita
        },
        {
            label: "Despesa",
            value: despesa
        },
        {
            label: "Total",
            value: total
        }
    ],
    formatter: function(x) {
        var amount = parseFloat(x);
        return amount.toLocaleString('pr-BR', { style: 'currency', currency: 'BRL' });//parseFloat(x).format()
    },
    hideHover: 'auto'
});

$(function () {


    var mensalValue = [];
    $.each(<?php echo $vendasPorMes; ?>, function(key, value){
        mensalValue.push(value)
    })

    $('#flotchartMes').highcharts({
    chart: {
        type: 'column'
    },
    title: {
        text: "Vendas últimos 12 meses"
    },
    subtitle: {
        text: "Últimos 12 meses"
    },
    credits: {
        enabled: false
    },
    xAxis: {
        categories: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez',]
    },
    yAxis: {
        labels: {
            formatter: function() {
                return 'R$'+ Highcharts.numberFormat(this.value, 2, ',', '.');
            }
        },
        min: 0,
        title: {
            text: 'Vendas'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [
    {
            color: '#007bff',
            name: 'Este Ano',
            data: mensalValue,
            dataLabels: {
                enabled: true,
                formatter: function() {
                    return 'R$'+ Highcharts.numberFormat(this.y, 2, ',', '.');
                }
            }
    }
    ]
    });

    $('#flotchartMov').highcharts({
    chart: {
        type: 'line'
    },
    title: {
        text: "Receitas e Despesas"
    },
    subtitle: {
        text: "Receitas - Despesas = Total"
    },
    credits: {
        enabled: false
    },
    xAxis: {
        categories: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez',],
        title: {
            text: null
        }
    },
    yAxis: {
        labels: {
            formatter: function() {
                return 'R$'+ Highcharts.numberFormat(this.value, 2, ',', '.');
            }
        },
        min: 0,
        title: {
            text: 'Vendas'
        }
    },tooltip: {
        valueDecimals: 2,
        valuePrefix: 'R$',
        formatter: function () {
            return this.points.reduce(function (s, point) {
                return s + '<br/> <span style="font-weight: bold;color: '+point.series.color+'">' + point.series.name + '</span>: ' + '<b>R$ ' + Highcharts.numberFormat(point.y, 2, ',', '.') + '</b>';
            }, '<b>' + this.x + '</b>');
        },
        shared: true
    },
    plotOptions: {

    },
    series: [
        {
            color: '#28a745',
            name: 'Receita',
            data: monthsReceita,
            dataLabels: {
                enabled: true,
                formatter: function() {
                    return 'R$'+ Highcharts.numberFormat(this.y, 2, ',', '.');
                }
            }
        },
        {
            color: '#dc3545',
            name: 'Despesas',
            data: monthsDespesa,
            dataLabels: {
                enabled: true,
                formatter: function() {
                    return 'R$'+ Highcharts.numberFormat(this.y, 2, ',', '.');
                }
            }
        },
        {
            color: '#17a2b8',
            name: 'Total',
            data: monthsTotal,
            dataLabels: {
                enabled: true,
                formatter: function() {
                    return 'R$'+ Highcharts.numberFormat(this.y, 2, '.', ',');
                }
            }
        }
        ]
    });

    $('#flotchartCadasCli').highcharts({
    chart: {
        type: 'line'
    },
    title: {
        text: "Clientes"
    },
    subtitle: {
        text: "Clientes cadastrados"
    },
    credits: {
        enabled: false
    },
    xAxis: {
        categories: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez',],
        title: {
            text: null
        }
    },
    yAxis: {
        labels: {
            formatter: function() {
                return 'R$'+ Highcharts.numberFormat(this.value, 2, ',', '.');
            }
        },
        min: 0,
        title: {
            text: 'Vendas'
        }
    },tooltip: {
        valueDecimals: 2,
        valuePrefix: 'R$',
        formatter: function () {
            return this.points.reduce(function (s, point) {
                return s + '<br/> <span style="font-weight: bold;color: '+point.series.color+'">' + point.series.name + '</span>: ' + '<b>' + point.y + ' cadastros</b>';
            }, '<b>' + this.x + '</b>');
        },
        shared: true
    },
    plotOptions: {

    },
    series: [
        {
            color: '#28a745',
            name: 'Clientes',
            data: cadascli,
            dataLabels: {
                enabled: true,
                formatter: function() {
                    return this.y;
                }
            }
        }
        ]
    });


});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app-master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Marcio Bomfim\Desktop\novo\system\multban\resources\views/home.blade.php ENDPATH**/ ?>