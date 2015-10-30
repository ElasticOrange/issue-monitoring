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

        $(document).on('click', '#editDomain', function (event) {
            $('#myModal').modal('show');
            ajaxGetDomainNameForEdit();
        });

        $(document).on('click', '#addDomain', function(ev) {
            ev.preventDefault();
            setDomainFormForCreate();
        });

        $(document).on('click', '#deleteDomain', function(ev) {
            setIdForDeleteAction();
        });
    });

    function setIdForDeleteAction() {
        var domain = getSelectedDomain();
        $.ajax({
            async: false,
            type: "GET",
            url: "/backend/domain/" + domain.id + "/delete",
            success: function (data) {
                tree.jqxTree('removeItem', domain.element);
            }
        });
    }

    function ajaxGetDomainNameForEdit() {
        var domain = getSelectedDomain();
        $.ajax({
            async: false,
            type: "GET",
            url: "/backend/domain/" + domain.id + "/edit",
            success: function (data) {
                $('.modal-content').html(data);
                $('input[name=parent_id]').attr("value", parseInt(domain.parentId));
            }
        });
    }

    function getSelectedDomain() {
        var element = tree.jqxTree('getSelectedItem');
        return element;
    }

    function setDomainFormForCreate() {
        var domain = getSelectedDomain();
        $.ajax({
            async: false,
            type: "GET",
            url: "/backend/domain/create",
            success: function (data) {
                $('.modal-content').html(data);
                $('input[name=parent_id]').attr("value", parseInt(domain.id));
            }
        });
    }

    window.getTreeItemById = function (tree, id) {
        var items = tree.jqxTree('getItems');

        var item = _.find(items, {id: id.toString()});

        return item;
    };

    window.onDomainCreated = function(domain) {
        var currentDomain = getSelectedDomain();
        tree.jqxTree('addTo', {
            label: domain['name'],
            id: parseInt(domain['id'])
        }, currentDomain);
        tree.jqxTree('selectItem',  getTreeItemById(tree, domain.id));
        tree.jqxTree('expandItem', currentDomain);

        $('#myModal').modal('hide');
    };

    window.onDomainUpdated = function(domain) {
        var currentDomain = getSelectedDomain();
        tree.jqxTree('updateItem', currentDomain.element, {label: domain['name'], id: parseInt(domain['id'])});
        tree.jqxTree('selectItem',  getTreeItemById(tree, domain.id));
        tree.jqxTree('expandItem', currentDomain);

        $('#myModal').modal('hide');
    };
})();
