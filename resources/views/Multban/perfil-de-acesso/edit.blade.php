@extends('layouts.app-master')
@section('page.title', 'Permissões')
@push('script-head')
<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<section class="content">
@if($routeAction)
<form class="form-horizontal" id="formPrincipal" role="form" method="POST"
        action="{{ route('perfil-de-acesso.update', $role->id) }}">
        @method('PATCH')
@else

<form class="form-horizontal" id="formPrincipal" role="form" method="POST"
        action="{{ route('perfil-de-acesso.store') }}">
@method('POST')
@endif
@csrf
@include('Multban.template.updatetemplate')

    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Permissões</h3>
                        </div>
                        <div class="card-body">
                    <div class="lead mb-3">
                        Marque abaixo as permissões que vão compor esta Permissão.
                    </div>
            <div class="card card-primary">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="name" class="form-label">Nome da Permissão</label>
                            <input value="{{ $role->name }}"
                                type="text"
                                class="form-control  form-control-sm"
                                name="name"
                                id="name"
                                placeholder="Nome da Permissão" required>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h3 class="m-0">Permissões</h3>
                            </div>
                            <div class="col-sm-6">
                                <div class="float-right">
                                    <button type="button" class="btn btn-info btn- m-1" id="checkAll">
                                        <i class="far fa-check-circle"></i> Marcar todos</button>
                                    <button type="button" class="btn btn-info btn- m-1" id="uncheckAll">
                                    <i class="fas fa-minus-circle"></i> Desmarcar todos</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-bottom mb-4"></div>

                    <div class="row">
                    @php $i = 0; @endphp
                    @foreach($permissionsa as $key => $permission)
                    <div class="col-md-3">
                    <ul class="list-unstyled">
                        <li>
                        <input type="checkbox"
                                    value="{{$permission->name}}"
                                    data-parent="{{$permission->parent_id}}"
                                    id="{{$permission->name}}"
                                    name="permission[{{ $permission->name }}]"
                                    value="{{ $permission->name }}"
                                    class='permission'
                                    {{ in_array($permission->name, $rolePermissions)
                                        ? 'checked'
                                        : '' }}>
                        <label for="{{$permission->name}}">{{$permission->description}}</label>

                        @if($permission->childs)
                            <ul>
                                @foreach($permission->childs as $submenu)

                                        @if (!Str::contains($submenu->name, array(".index", ".store", ".update")))
                                        <li>
                                            <input type="checkbox"
                                                data-parent="{{$submenu->parent_id}}"
                                                id="{{$submenu->name}}"
                                                name="permission[{{ $submenu->name }}]"
                                                value="{{ $submenu->name }}"
                                                class='permission'
                                                {{in_array($submenu->name, $rolePermissions) ? 'checked' : ''}}>
                                            <label for="{{$submenu->name}}">{{str_replace(['create', 'edit', 'copy', 'show', 'destroy'], ['criar', 'editar', 'copiar', 'ver', 'deletar'], $submenu->name)}}</label>
                                        </li>
                                        @endif

                                @endforeach
                            </ul>
                        @endif
                        </li>
                    </ul>
                    </div>

                @php $i++; @endphp
                @if(($i % 4) == 0)
                </div><div class="border-bottom mb-4"></div><div class="row"> <!-- row -->
                @endif
                @endforeach
                </div> <!-- row -->
            </div>
        </div>

        </div>
        </form>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">
<script src="{{asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{asset('assets/plugins/jquery-validation/localization/messages_pt_BR.min.js') }}"></script>
<script src="{{asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<link rel="stylesheet" href="{{asset('assets/dist/css/app.css') }}" />
<script src="{{asset('assets/dist/js/app.js') }}"></script>
<script src="{{asset('assets/dist/js/pages/perfil-de-acesso/perfil-de-acesso.js') }}"></script>


<script type="text/javascript">
    $(document).ready(function() {

            $("body").on("keyup change", "input[type='text']", function(e) {
                 $(this).removeClass('is-invalid');
            });

            $('[name="all_permission"]').on('click', function() {

                if($(this).is(':checked')) {
                    $.each($('.permission'), function() {
                        $(this).prop('checked',true);
                    });
                } else {
                    $.each($('.permission'), function() {
                        $(this).prop('checked',false);
                    });
                }

            });

        });

    $('input[type="checkbox"]').change(function(e) {

  var checked = $(this).prop("checked"),
      container = $(this).parent(),
      siblings = container.siblings();

  container.find('input[type="checkbox"]').prop({
    indeterminate: false,
    checked: checked
  });

  function checkSiblings(el) {

    var parent = el.parent().parent(),
        all = true;

    el.siblings().each(function() {
      let returnValue = all = ($(this).children('input[type="checkbox"]').prop("checked") === checked);
      return returnValue;
    });

    if (all && checked) {

      parent.children('input[type="checkbox"]').prop({
        indeterminate: false,
        checked: checked
      });

      checkSiblings(parent);

    } else if (all && !checked) {

      parent.children('input[type="checkbox"]').prop("checked", checked);
      parent.children('input[type="checkbox"]').prop("indeterminate", (parent.find('input[type="checkbox"]:checked').length > 0));
      checkSiblings(parent);

    } else {

      el.parents("li").children('input[type="checkbox"]').prop({
        indeterminate: true,
        checked: true
      });

    }

  }

  checkSiblings(container);
});
    </script>
@endpush
