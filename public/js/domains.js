(function(){
    var tree;
    var domainForm;

    $(document).ready(function () {
        tree = $('#domainTree');
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
            changeParentIdForSelectedItemBeforeEdit(currentTreeItemParentId);
            editDomain(currentTreeItemId);
        });

        $(document).on('click', 'button[data-modal=true]', function(ev) {
            ev.preventDefault();
            setDomainFormForCreate();
        });
    });


    function getDomainForm() {
        if ( ! domainForm) {
            domainForm = $('#domain-form');
        }

        return domainForm;
    }

    function resetForm(form) {
        var token = form.find('input[name=_token]').val();
        form.find(':input').val('');
        form.find('input[name=_token]').val(token);
    }

    function getSelectedDomain() {
        var element = tree.jqxTree('getSelectedItem');
        return element;
    }

    function setDomainFormForCreate() {
        var form = getDomainForm();

        resetForm(form);

        form.attr('action', '/backend/domain');
        form.attr('success-function', 'onDomainCreated')

        var domain = getSelectedDomain();
        if (domain.id) {
            form.find('input[name=parent_id]').val(domain.id);
        }
    }

    window.getTreeItemById = function (tree, id) {
        var items = tree.jqxTree('getItems');

        var item = _.find(items, {id: id.toString()});

        return item;
    }

    window.onDomainCreated = function(domain) {
        var currentDomain = getSelectedDomain();
        tree.jqxTree('addTo', {
            label: domain['name'],
            id: parseInt(domain['id'])
        }, currentDomain);
        tree.jqxTree('selectItem',  getTreeItemById(tree, domain.id));
        tree.jqxTree('expandItem', currentDomain);

        $('#myModal').modal('hide');
    }


/*

    function changeLabelForSelectedTreeItem() {
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


    function addDomainToTree(domain) {

    }

    function addValueToHiddenElement(element) {
        var item = $('#domainTree').jqxTree('getSelectedItem');
        var itemId = $(item).attr('id');

        $('[data-adauga=true]').show();
        $('[data-edit=true]').addClass('hidden');
        $('[data-ajax=true]').attr("action", "/backend/domain");
        $('input[value=PUT]').remove();

        $(element).attr("value", itemId);
        console.log("id from adauga: ", itemId);
    }

*/

})();
