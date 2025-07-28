$(document).ready(function () {
    $(function () {

        "use strict";

        $('.select2').select2();

        ns.comboBoxSelectTags("empresa_id", "/empresa/obter-empresas", "emp_id");
        ns.comboBoxSelectTags("cliente_id", "/cliente/get-client", "cliente_id");

        $('#btnPesquisar').click(function () {
            var totaliza = {};
            totaliza.totaliza = false;
            $('#gridtemplate').DataTable().clear().destroy();
            ns.gridDataTable(colunas, colunasConfiguracao, false, false, "cliente", totaliza, 'filtro-pesquisa');

        });

        var colunas = [
            {
                data: 'action',
                name: 'action'
            },
            {
                data: 'cliente_id',
                name: 'cliente_id'
            },
            {
                data: 'cliente_nome',
                name: 'cliente_nome',
                autoWidth: true
            },
            {
                data: 'cliente_doc',
                name: 'cliente_doc'
            },
            {
                data: 'cliente_tipo',
                name: 'cliente_tipo'
            },
            {
                data: 'cliente_email',
                name: 'cliente_email',
                searchable: false
            },
            {
                data: 'cliente_cel',
                name: 'cliente_cel',
                searchable: false
            },
            {
                data: 'cliente_sts',
                name: 'cliente_sts',
                searchable: false
            }
        ];

        var colunasConfiguracao = [
            { width: 20, targets: 0 },
            { width: "auto", targets: 1 },
            { width: "auto", targets: 2 },
            { width: "auto", targets: 3 }
        ];

        $(document).on('click', '#delete_grid_id', function (e) {
            var id = $(this).data('id');
            ns.swalDelete(id, 'cliente');
            e.preventDefault();
        });
    });
});
