$(document).ready(function () {
    $(function () {

        "use strict";

        $('.select2').select2();
        ns.comboBoxSelectTags("empresa_id", "/empresa/obter-empresas", "emp_id");
        ns.comboBoxSelectTags("usuario", "/empresa/obter-users", "user_id");

        $('body').on('click', '#btnPesquisar', function () {
            var totaliza = {};
            totaliza.totaliza = false;
            $('#gridtemplate').DataTable().clear().destroy();
            ns.gridDataTable(colunas, colunasconfig, false, false, "usuario", totaliza, 'filtro-pesquisa');
        });

        var colunas = [
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
            {
                data: 'user_name',
                name: 'user_name',
                autoWidth: true
            },
            {
                data: 'user_logon',
                name: 'user_logon',
                autoWidth: true
            },
            {
                data: 'user_cpf',
                name: 'user_cpf'
            },
            {
                data: 'user_email',
                name: 'user_email'
            },
            {
                data: 'empresa',
                name: 'empresa'
            },
            {
                data: 'role',
                name: 'role'
            },
            {
                data: 'status',
                name: 'status'
            }

        ];

        var colunasconfig = [
            { width: 20, targets: 0 },
            { width: "auto", targets: 1 },
            { width: "auto", targets: 2 },
            { width: "auto", targets: 3 }
        ];

    });
});
