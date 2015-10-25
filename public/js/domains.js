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
            event.preventDefault();
            $('#myModal').modal('show');

            $('[data-ajax=true]').remove();
            ajaxGetDomainName();
        });

        $(document).on('click', 'button[data-modal=true]', function(ev) {
            ev.preventDefault();
            setDomainFormForCreate();
        });
    });

    function ajaxGetDomainName() {
        var domain = getSelectedDomain();
        $.ajax({
            async: false,
            type: "GET",
            url: "/backend/domain/" + domain.id + "/edit",
            success: function (data) {
                $('.modal-content').html(data);
            }
        });
    }
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

    window.onDomainUpdate = function(domain) {
        var currentDomain = getSelectedDomain();
        tree.jqxTree('updateItem', currentDomain.element, {label: domain['name'], id: parseInt(domain['id'])});
        tree.jqxTree('selectItem',  getTreeItemById(tree, domain.id));
        tree.jqxTree('expandItem', currentDomain);

        $('#myModal').modal('hide');
    };
})();
