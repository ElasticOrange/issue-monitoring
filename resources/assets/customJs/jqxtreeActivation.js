$(document).ready(function () {
    var tree = $('#domainTree');
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
    var records = dataAdapter.getRecordsHierarchy('id', 'parent_id', 'items', [{name: 'name', map: 'label'}]);
    tree.jqxTree({source: records, height: 300, width: 200});

    $("#domainTree .jqx-tree-item").dblclick(function (event) {
        var currentTreeItem = tree.jqxTree('getSelectedItem');
        var currentTreeItemId = currentTreeItem.id;
        var currentTreeItemParentId = currentTreeItem.parentId;
        editDomain(currentTreeItemId);
        changeParentIdForSelectedItemBeforeEdit(currentTreeItemParentId);
    });

    $(document).on('submit', '', function(ev) {
        changeLabelForSelectedTreeItem();
    });
});

function changeLabelForSelectedTreeItem() {
    var tree =  $('#domainTree');
    var element = tree.jqxTree('getSelectedItem');
    var label = $('#content').val();
    tree.jqxTree('updateItem', element, {label: label});
}

function changeParentIdForSelectedItemBeforeEdit(parentId) {
    $('[data-parent=true]').val(parentId);
    console.log("edit parentid is: ", parentId);
}

function editDomain(id){
    $('[data-ajax=true]').attr("action", "/backend/domain/"+id);
    $('<input>').attr({type: 'hidden', name: '_method', value: 'PUT'}).appendTo('form');
    $('#myModal').modal('show');
    $('[data-adauga=true]').hide();
    $('[data-edit=true]').removeClass('hidden');
}
