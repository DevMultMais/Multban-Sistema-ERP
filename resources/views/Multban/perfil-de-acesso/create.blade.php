@extends('layouts.app-master')
@section('page.title', 'Permissões Administrativas')
@push('script-head')
<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>Add new role</h1>
        <div class="lead">
            Add new role and assign permissions.
        </div>

        <div class="container mt-4">

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('permissao.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input value="{{ old('name') }}"
                        type="text"
                        class="form-control  form-control-sm"
                        name="name"
                        placeholder="Name" required>
                </div>
                <label for="permissions" class="form-label">Permissões</label>

                <div class="float-right">
                    <button type="button" class="btn btn-primary btn-sm" id="checkAll">
                        <i class="far fa-check-circle"></i> Marcar todos</button>
                    <button type="button" class="btn btn-info btn-sm" id="uncheckAll">
                        <i class="fas fa-minus-circle"></i> Desmarcar todos</button>
                </div>
                <ul class="list-unstyled">
                    @foreach($permissions as $permission)
                    <li>
                                <input type="checkbox"
                                name="permission[{{ $permission->name }}]"
                                value="{{ $permission->name }}"
                                class='permission'
                                id="{{$permission->name}}">
                                <label for="{{$permission->name}}">{{$permission->name}}</label>

                                <ul>
                        @foreach($permission->childs as $submenu)

                        @if (!Str::contains($submenu->name, array(".index", ".store", ".update")))

                            <li>
                                <input type="checkbox"
                                name="permission[{{ $submenu->name }}]"
                                value="{{ $submenu->name }}"
                                class='permission'
                                id="{{$submenu->name}}">
                                <label for="{{$submenu->name}}">{{$submenu->name}}</label>
                            </li>

                        @endif

                        @endforeach</ul>
                    </li>
                    @endforeach
                </ul>
                <button type="submit" class="btn btn-primary btn-sm">Save user</button>
                <a href="{{ route('permissao.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>
@endsection

@push('scripts')
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">
<script src="{{asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{asset('assets/plugins/jquery-validation/localization/messages_pt_BR.min.js') }}"></script>
<script src="{{asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<link rel="stylesheet" href="{{asset('assets/dist/css/app.css') }}" />
<script src="{{asset('assets/dist/js/app.js') }}"></script>
<script src="{{asset('assets/dist/js/pages/funcoesadministrativas/funcoesadministrativas.js') }}"></script>


    <script type="text/javascript">
        $(document).ready(function() {
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
      checked: checked
    });

    checkSiblings(parent);

  } else if (all && !checked) {
    parent.children('input[type="checkbox"]').prop("checked", checked);
    checkSiblings(parent);

  } else {

    el.parents("li").children('input[type="checkbox"]').prop({
      checked: true
    });

  }

}

checkSiblings(container);
});
    </script>
@endpush
