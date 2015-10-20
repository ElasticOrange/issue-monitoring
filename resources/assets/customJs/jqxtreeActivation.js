$(document).ready(function () {
    var tree = $('#jqxTree');
    var source = null;
    $.ajax({
        async: false,
        url: "/getTree",
        success: function (data, status, xhr) {
            source = (data);
        }
    });

    var dataAdapter = new $.jqx.dataAdapter(source);
    dataAdapter.dataBind();
    var records = dataAdapter.getRecordsHierarchy('id', 'parent_id', 'items', [{ name: 'name', map: 'label' }]);
    console.log(records);
    tree.jqxTree({ source: records,  height: 300, width: 200 });
});