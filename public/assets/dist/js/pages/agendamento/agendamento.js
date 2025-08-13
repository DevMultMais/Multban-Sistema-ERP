$(function () {


    ns.comboBoxSelect("cliente_id", "/cliente/get-cliente", "cidade_ibge");

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
