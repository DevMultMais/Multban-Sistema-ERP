$(function () {

    $("#treeList :checkbox").change(function () {
        $(this).siblings("ul").find(":checkbox").prop("checked", this.checked);
        if (this.checked) {
            $(this)
                .parentsUntil("#treeList", "ul")
                .siblings(":checkbox")
                .prop("checked", true);
        } else {
            $(this)
                .parentsUntil("#treeList", "ul")
                .each(function () {
                    var $this = $(this);
                    var childSelected = $this.find(":checkbox:checked").length;
                    if (!childSelected) {
                        $this.prev(":checkbox").prop("checked", false);
                    }
                });
        }
    });


    $("#checkAll").click(function () {

        $("input:checkbox").prop("checked", "checked");
        $(".select2 > option").prop("selected", "selected");
        $(".select2").trigger("change");

        if ($("input:checkbox").is(":checked")) {
            $("input:checkbox").prop("checked", true);
        }

    });


    $("#uncheckAll").click(function () {
        $("input:checkbox").prop("checked", "checked");
        $(".select2").val(null).trigger("change");
        if ($("input:checkbox").is(":checked")) {
            $("input:checkbox").prop("checked", false);
        }
    });
});
