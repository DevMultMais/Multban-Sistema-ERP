$(function () {

    $("#btnInativar").text("Cancelar agendamento");
    $("#btnInativar").prepend('<i class="fa fa-ban"></i> ');
    $("#btnExcluir").hide();

    $('#cliente_id').on('select2:select', function (event) {
        var selectedItem = event.params.data;
        console.log('data: ', selectedItem);
        if (selectedItem) {
            $("#cliente_doc").val(selectedItem.cliente_doc);
            $("#cliente_rg").val(selectedItem.cliente_rg);
            $("#cliente_nome").val(selectedItem.cliente_nome);
            $("#cliente_email").val(selectedItem.cliente_email);
            $("#cliente_cel").val(selectedItem.cliente_cel);
            $("#cliente_telfixo").val(selectedItem.cliente_telfixo);
            $("#cliente_dt_nasc").val(selectedItem.cliente_dt_nasc);

            $("#cliente_doc").trigger('change');
            $("#cliente_rg").trigger('change');
            $("#cliente_nome").trigger('change');
            $("#cliente_email").trigger('change');
            $("#cliente_cel").trigger('change');
            $("#cliente_telfixo").trigger('change');
            $("#cliente_dt_nasc").trigger('change');

        }
    });

    $('body').on('click', '#btnInativar', function (e) {
        console.log($(this).text())
        var status = $(this).text().trim();

        e.preventDefault();
        Pace.restart();
        Pace.track(function () {
            if (status === 'Reagendar') {
                $('#status').val('AG');

                $("#btnInativar").text("Cancelar agendamento");
                $("#btnInativar").prepend('<i class="fa fa-check"></i> ');
            } else if (status === 'Cancelar agendamento') {
                $('#status').val('CN');
                $("#btnInativar").text("Reagendar");
                $("#btnInativar").prepend('<i class="fa fa-ban"></i> ');

            }

            $('#status').trigger('change');
            $('#btnSalvar').trigger('click');

        });
    });


    ns.comboBoxSelectTags("cliente_id", "/agendamento/get-cliente", "cidade_ibge");

    var inserir = document.URL.split("/")[4] == "inserir";
    console.log('inserir: ', inserir);
    if (inserir) {
        $("input[type='text']").each(function () {
            $(this).val('');
        });
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

})
