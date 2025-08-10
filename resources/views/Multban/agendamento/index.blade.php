@extends('layouts.app-master')
@section('page.title', 'Agenda')
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

    @if (count($errors) > 0)
    @foreach ($errors->all() as $error)
    <div class="col-sm-12">
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Alerta!</h5>
            {{ $error }}
        </div>
    </div>

    @endforeach
    @endif


    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">

                <div class="sticky-top mb-3">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Agendamento</h4>
                        </div>
                        <div class="card-body">
                            <!-- the events -->
                            <div class="input-group mb-3">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                    Agendar
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#" id="btnAgendamento">Atendimento</a>
                                    <a class="dropdown-item" href="#">Urgência</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
        <div class="row">
            <!-- /.col -->
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-body p-0">
                        <!-- THE CALENDAR -->
                        <div id="calendar"></div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
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
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/fullcalendar-6.1.18/dist/index.global.min.js') }}"></script>
<script src="{{ asset('assets/plugins/fullcalendar-6.1.18/dist/locales/pt-br.global.min.js') }}"></script>

<script src="{{ asset('assets/dist/js/app.js') }}"></script>
<script src="{{ asset('assets/dist/js/pages/cliente/gridcliente.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('body').on('click', '#btnAgendamento', function (e) {
            e.preventDefault();
            $('#modalAgenda').modal('show');
        });

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
    });
</script>


<script>
    $(function () {

        var SITEURL = "{{ url('/') }}";



$.ajaxSetup({

    headers: {

    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

    }

});

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
    m    = date.getMonth(),
    y    = date.getFullYear()

    var Calendar = FullCalendar.Calendar;

    var calendarEl = document.getElementById('calendar');

    // initialize the external events
    // -----------------------------------------------------------------

    var calendar = new Calendar(calendarEl, {
        events: SITEURL + "/get-agendamento",
        locale: 'pt-br',
    initialView: 'dayGridMonth',
 timeZone: 'UTC',
    slotMinTime: "08:00:00",
    slotMaxTime: "20:00:00",
    selectable: true,
    selectMirror: false,
    dayMaxEvents: true, // allow "more" link when too many events
    navLinks: true, // can click day/week names to navigate views
    editable: false,
    droppable: false, // this allows things to be dropped onto the calendar !!!
    displayEventTime: true,
    displayEventEnd: true,
    firstDay: 1, // Monday as the first day of the week
    slotDuration: '00:15:00', // 30 minutes slots
    //slotLabelInterval: '00:15', // 1 hour intervals for time labels
    slotLabelFormat: { hour: '2-digit', minute: '2-digit', hour12: false }, // 24-hour format for time labels
  timeFormat: 'h(:mm)t',
    // eventContent: function(arg) {
    //     console.log('eventContent: ', arg);
    //     // Customize the content of the event
    //     // You can return a string or an object with html property
    //     // Here we are returning a div with the event description
    //     // and a dot for the event color
    //   return { html: '<div class="fc-daygrid-event-dot"></div><div class="fc-event-time">'+arg.event.startStr+'</div><div class="fc-event-title">TEste</div>' };
    // },
    eventDidMount: function(info) {
        console.log('eventDidMount: ', info.event);
        new bootstrap.Tooltip(info.el, {
            title: info.event.extendedProps.description, // Or whatever content you want
            placement: 'top', // Adjust placement as needed
            trigger: 'hover', // Show on hover
            container: 'body', // Attach to the body to prevent clipping
            delay: { "show": 500, "hide": 100 } // Optional delay for showing/hiding
        });
    },
    eventTimeFormat: { // like '14:30:00'
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit',
    meridiem: false
  }
    eventMouseEnter: function(info) {
        console.log('Event: ', info.event);

        // alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
        // alert('View: ' + info.view.type);

        // change the border color just for fun
        info.el.style.cursor = 'pointer';
     },
    eventClick: function(info) {
        console.log('eventClick: ', info.event);
        // Show a tooltip with the event description
        // alert('Event: ' + info.event.title);
        // alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
        // alert('View: ' + info.view.type);
        Pace.restart();
        Pace.track(function() {
            // You can use the event ID to fetch more details or perform actions
            console.log('Event ID: ', info.event.id);
            window.location.href = SITEURL + "/agendamento/" + info.event.id + "/alterar";
        });

        // change the border color just for fun
        info.el.style.borderColor = 'red';
  },
    headerToolbar: {
        left  : 'prev,next,today',
        center: 'title',
        right : 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
      },
    themeSystem: 'bootstrap',

    });

    calendar.render();
  })
</script>

@if ($message = Session::get('success'))
<script>
    toastr.success("{{ $message }}", "Sucesso");
            console.log('idModeloInserido', "{{ Session::get('idModeloInserido') }}");
            $("#inputPesquisa").val("{{ Session::get('idModeloInserido') }}");
            setTimeout(function(){
                $("#btnPesquisar").trigger("click");
                $("#inputPesquisa").val("");
            }, 200);
</script>
@endif

@if ($message = Session::get('error'))
<script>
    $("#inputPesquisa").val("{{ Session::get('idModeloInserido') }}");
        toastr.error("{{ $message }}", "Erro");
        setTimeout(function(){
            $("#btnPesquisar").trigger("click");
            $("#inputPesquisa").val("");
        }, 200);
</script>
@endif

@if (count($errors) > 0)
<script>
    var errors = {!! json_encode($errors->all()) !!};
            errors.forEach(function(error) {
                toastr.error(error, "Erro");
            });
</script>
@endif

@endpush
