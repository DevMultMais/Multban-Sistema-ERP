@extends('layouts.app-master')
@section('page.title', 'Auditoria')
@push('script-head')
<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}">
@endpush

@section('content')
<!-- Main content -->
<section class="content">
    @if($routeAction)
    <form class="form-horizontal" id="formPrincipal" role="form" method="POST" action="{{ route('usuario.update', $usuario->id) }}">
        @method('PATCH')
        @else

        <form class="form-horizontal" id="formPrincipal" role="form" method="POST" action="{{ route('usuario.store') }}">
            @method('POST')
            @endif


            @csrf
            @include('Multban.template.updatetemplate')

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Auditoria</h3>
                </div>
                <div class="card-body">
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="id">ID:</label>
                                    <div class="input-group">
                                        <input type="number" disabled name="id" value="{{$usuario->id ?? ''}}" placeholder="0" disabled class="form-control">
                                    </div>
                                </div>

                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="name">Nome:</label>
                                    <input class="form-control" placeholder="Digite o nome du usuário" autofocus="autofocus" maxlength="60" name="name" type="text" id="name" value="{{$usuario->name}}">
                                </div>


                                <div class="form-group col-md-4">
                                    <label for="username">Username:</label>
                                    <input class="form-control" placeholder="Digite o nome du usuário" autofocus="autofocus" maxlength="60" name="username" type="text" id="username" value="{{$usuario->username}}">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="email">E-mail:</label>
                                    <input class="form-control" placeholder="Digite o nome Fantasia" autofocus="autofocus" name="email" type="email" id="email" value="{{$usuario->email}}">
                                </div>
                            </div>

                            <div class="form-row">

                                <div class="form-group col-md-4">
                                    <label for="password">Senha:</label>
                                    <div class="input-group mb-3">
                                        <input type="password" autofocus="autofocus" class="form-control" id="password" name="password" required placeholder="Digite a senha">
                                        <span class="input-group-append">
                                            <button type="button" id="showPassword" class="btn btn-default"><i class="fa fa-eye-slash"></i></button>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="confirm-password">Confirmar senha:</label>
                                    <div class="input-group mb-3">
                                        <input type="password" autofocus="autofocus" class="form-control" id="confirm-password" name="confirm-password" required placeholder="Confirme a senha">
                                        <span class="input-group-append">
                                            <button type="button" id="showConfirmPassword" class="btn btn-default"><i class="fa fa-eye-slash"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="roles">Permissão:</label>
                                    <select class="form-control select2" id="roles" name="roles" multiple data-placeholder="Selecione" style="width: 100%;">
                                        @foreach($roles as $role)
                                        <option id="{{$role}}" @foreach($userRole as $u) @if($role==$u) selected="selected" @endif @endforeach value="{{$role}}">
                                            {{$role}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <div class="card card-widget card-outline card-primary">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-4">
                                    <img id="image-product" class="img-circle elevation-2 m-3" src="{{empty($usuario->image) ? url('/assets/dist/img/') . '/' . 'no-product-image.png' : url('/storage/images/usuario') . '/' . $usuario->image}}" alt="{{$usuario->image}}" style="
                                border-radius: 50%;
                                position: relative;
                                height: 117px;
                                width: 117px;
                                overflow: hidden;
                                float: left;
                                margin-right: 10px;
                            ">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" accept=".jpeg,.png,.jpg,.gif,.webp" name="image" id="customFile">
                                        <label class="custom-file-label" for="customFile" data-browse="{{empty($usuario->image) ? 'Adicionar Imagem' : 'Alterar Imagem'}}">{{!empty($usuario->image) ? $usuario->image : 'Nenhuma imagem selecionada'}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </form>

</section>
<!-- /.content -->

@endsection

@push('scripts')

<script type="text/javascript">
    function readURLProduct(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#image-product').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#customFile").change(function() {
        readURLProduct(this);
    });
    $(document).ready(function(e) {
        $("body").on("keyup change", "input[type='text'],input[type='password'],input[type='email']", function(e) {
            $(this).removeClass('is-invalid');
        });
        $('body').on('click', '#showPassword', function(e) {
            $(this).find("i").toggleClass("fa-eye fa-eye-slash");
            $('#showConfirmPassword').find("i").toggleClass("fa-eye fa-eye-slash");
            var type = $('#password')
            if (type.attr('type') == 'password') {
                type.attr('type', 'text')
                $('#confirm-password').attr('type', 'text')
            } else {
                type.attr('type', 'password')
                $('#confirm-password').attr('type', 'password')
            }
        });

        $('body').on('click', '#showConfirmPassword', function(e) {
            $(this).find("i").toggleClass("fa-eye fa-eye-slash");
            $('#showPassword').find("i").toggleClass("fa-eye fa-eye-slash");
            var type = $('#confirm-password')
            if (type.attr('type') == 'password') {
                type.attr('type', 'text')
                $('#password').attr('type', 'text')
            } else {
                type.attr('type', 'password')
                $('#password').attr('type', 'password')
            }
        });
        // $(".alert-dismissible")
        //         .fadeTo(10000, 500)
        //         .slideUp(500, function() {
        //             $(".alert-dismissible").alert("close");
        //         });

        ns.iniciarlizarMascaras();
        bsCustomFileInput.init();
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "progressBar": true,
            "preventDuplicates": false,
            "positionClass": "toast-top-right",
            "onclick": null,
            "showDuration": "400",
            "hideDuration": "5500",
            "timeOut": "5500",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        $('#message').css('display', 'none');

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
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatables-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{asset('assets/dist/js/app.js') }}"></script>
@endpush
