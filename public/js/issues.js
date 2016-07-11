(function(){
    $(document).ready(function() {

        var actionButtonsTemplate = _.template($("#action_buttons").html(),
            {
                interpolate: /__([\s\S]+?)__/g
            }
        );
        $('#issues-table').DataTable({
            "language":{
                "sInfo": "Arata de la _START_ la _END_ din _TOTAL_ intrari",
                "sInfoEmpty": "Arata de la 0 la 0 din 0 intrari",
                "sLengthMenu": "Arata _MENU_ intrari",
                "sSearch": "Cauta",
                "paginate":{
                    "next": "Inainte",
                    "previous": "Inapoi",
                    "first": "Primul",
                    "last": "Ultimul"
                },
                "sEmptyTable": "Nu exista nicio inregistrare"
            },
            "columns": [
                {
                    data: "id",
                    title: "id"
                },
                {
                    data: "type",
                    title: "Tip"
                },
                {
                    data: "connected_domains",
                    title: "Domenii",
                    orderable: false,
                    render: function (data, type, rowData, meta) {
                        var domains = _.pluck(data, "name");
                        return domains.join();
                    }
                },
                {
                    data: "name",
                    title: "Nume",
                    orderable: false
                },
                {
                    data: "phase",
                    title: "Faza"
                },
                {
                    data: "id",
                    title: "Actiuni",
                    render: function (data, type, rowData, meta) {
                        return actionButtonsTemplate({id: data});
                    },
                    orderable: false
                }
            ],
            responsive: true,
            stateSave: true,
            serverSide: true,
            ajax: {
            "url": window.location.href + '/query',
            }
        });

        $("input[data-action=publish-issue]").click(function () {
            var request = $.ajax({
                url: $(this).attr('update-url'),
                data: {
                    published: $(this).prop('checked'),
                },
                method: 'get'
            });
            request.done(function (data) {
            });
        });

        function updateEndDate(groupId) {
            var startDatePicker = $('[data-type=startdate][data-groupid=' + groupId + ']');
            if (! startDatePicker.data('DateTimePicker')) {
                return;
            }
            var startDate = startDatePicker.data('DateTimePicker').date();

            var daysDuration = $('[data-type=duration][data-groupid=' + groupId + ']').val();
            if (! (daysDuration >= 0)) {
                return;
            }
            var endDate = startDate;

            endDate.add(daysDuration, 'days');

            var endDatePicker = $('[data-type=enddate][data-groupid=' + groupId + ']');
            if (! endDatePicker.data('DateTimePicker')) {
                return;
            }

            endDatePicker.data('DateTimePicker').date(endDate);
        }

        function updateDuration(groupId) {
            var startDatePicker = $('[data-type=startdate][data-groupid=' + groupId + ']');
            if (! startDatePicker.data('DateTimePicker')) {
                return;
            }
            var startDate = startDatePicker.data('DateTimePicker').date();

            var endDatePicker = $('[data-type=enddate][data-groupid=' + groupId + ']');
            if (! endDatePicker.data('DateTimePicker')) {
                return;
            }
            var endDate = endDatePicker.data('DateTimePicker').date();

            if (endDatePicker.data('DateTimePicker').date() <
                startDatePicker.data('DateTimePicker').date()) {

                endDatePicker.data('DateTimePicker').date(startDate);
                return;
            }

            var daysDuration = $('[data-type=duration][data-groupid=' + groupId + ']');
            var d = moment.duration(endDate - startDate);
            var days = Math.floor(d.asDays());

            if (! (days >= 0)) {
                return;
            }
            daysDuration.val(days);
        }

        // $(document).on('dp.change', '[data-type=startdate]',function() {
        //     var groupId = $(this).attr('data-groupid');
        //     updateEndDate(groupId);
        // });
        //
        // $(document).on('dp.change', '[data-type=enddate]',function() {
        //     var groupId = $(this).attr('data-groupid');
        //     updateDuration(groupId);
        // });
        //
        // $(document).on('change', '[data-groupid]',function() {
        //    var groupId = $(this).attr('data-groupid');
        //     updateEndDate(groupId);
        // });

        CKEDITOR.replace('editor1', {
            toolbar: [
                {name: 'basicstyles', items: ['Bold', 'Italic']},
                {name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent']},
                {name: 'links', items: ['Link', 'Unlink']},
                {name: 'styles', items: ['Styles', 'Format']},
                {name: 'document', items: ['Source']},
                {name: 'about', items: ['About']}
            ]
        });

        CKEDITOR.replace('editor2', {
            toolbar: [
                {name: 'basicstyles', items: ['Bold', 'Italic']},
                {name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent']},
                {name: 'links', items: ['Link', 'Unlink']},
                {name: 'styles', items: ['Styles', 'Format']},
                {name: 'document', items: ['Source']},
                {name: 'about', items: ['About']}
            ]
        });

        CKEDITOR.replace('editor3', {
            toolbar: [
                {name: 'basicstyles', items: ['Bold', 'Italic']},
                {name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent']},
                {name: 'links', items: ['Link', 'Unlink']},
                {name: 'styles', items: ['Styles', 'Format']},
                {name: 'document', items: ['Source']},
                {name: 'about', items: ['About']}
            ]
        });

        CKEDITOR.replace('editor4', {
            toolbar: [
                {name: 'basicstyles', items: ['Bold', 'Italic']},
                {name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent']},
                {name: 'links', items: ['Link', 'Unlink']},
                {name: 'styles', items: ['Styles', 'Format']},
                {name: 'document', items: ['Source']},
                {name: 'about', items: ['About']}
            ]
        });

        CKEDITOR.replace('editor5', {
            toolbar: [
                {name: 'basicstyles', items: ['Bold', 'Italic']},
                {name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent']},
                {name: 'links', items: ['Link', 'Unlink']},
                {name: 'styles', items: ['Styles', 'Format']},
                {name: 'document', items: ['Source']},
                {name: 'about', items: ['About']}
            ]
        });

        CKEDITOR.replace('editor6', {
            toolbar: [
                {name: 'basicstyles', items: ['Bold', 'Italic']},
                {name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent']},
                {name: 'links', items: ['Link', 'Unlink']},
                {name: 'styles', items: ['Styles', 'Format']},
                {name: 'document', items: ['Source']},
                {name: 'about', items: ['About']}
            ]
        });

        var domainAutocomplete = $('#domain-autocomplete');
        var domainList = new Bloodhound({
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: domainAutocomplete.attr('source-url'),
                wildcard: '{name}',
                transform: function (response) {
                    return _.filter(response, function (item) {
                        return $('[domain-id=' + item.id + ']').length === 0;
                    });
                }
            }
        });

        domainAutocomplete.typeahead(
            null,
            {
                name: 'domain',
                display: 'name',
                source: domainList
            }
        );

        typeaheadAutocomplete(domainAutocomplete);

        domainAutocomplete.bind(
            'typeahead:select',
            function (event, suggestion) {
                $(this).typeahead('val', '');

                var template = _.template($('#connected-domain-template').html());
                var compiled_template = template(suggestion);

                $('#connected-domains-container').append(compiled_template);
            }
        );

        $('#connected-domains-container').on('click', '[connected-domain-delete]', function () {
            var connected_stakeholder_id = $(this).attr('connected-domain-delete');
            $('[domain-id=' + connected_stakeholder_id + ']').remove();
        });

        var stakeholderAutocomplete = $('#stakeholder-autocomplete');
        var stakeholdersList = new Bloodhound({
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: stakeholderAutocomplete.attr('source-url'),
                wildcard: '{name}',
                transform: function (response) {
                    return _.filter(response, function (item) {
                        return $('[stakeholder-id=' + item.id + ']').length === 0;
                    });
                }
            }
        });

        stakeholderAutocomplete.typeahead(
            null,
            {
                name: 'stakeholder',
                display: 'name',
                source: stakeholdersList
            }
        );

        typeaheadAutocomplete(stakeholderAutocomplete);

        stakeholderAutocomplete.bind(
            'typeahead:select',
            function (event, suggestion) {
                $(this).typeahead('val', '');

                var template = _.template($('#connected-stakeholder-template').html());
                var compiled_template = template(suggestion);

                $('#connected-stakeholders-container').append(compiled_template);
            }
        );

        $('#connected-stakeholders-container').on('click', '[connected-stakeholder-delete]', function () {
            var connected_stakeholder_id = $(this).attr('connected-stakeholder-delete');
            $('[stakeholder-id=' + connected_stakeholder_id + ']').remove();
        });


        var newsAutocomplete = $('#news-autocomplete');
        var newsList = new Bloodhound({
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: newsAutocomplete.attr('source-url'),
                wildcard: '{name}',
                transform: function (response) {
                    return _.filter(response, function (item) {
                        return $('[news-id=' + item.id + ']').length === 0;
                    });
                }
            }
        });

        newsAutocomplete.typeahead(
            null,
            {
                name: 'news',
                display: 'name',
                source: newsList
            }
        );

        typeaheadAutocomplete(newsAutocomplete);

        newsAutocomplete.bind(
            'typeahead:select',
            function (event, suggestion) {
                $(this).typeahead('val', '');

                var template = _.template($('#connected-news-template').html());
                var compiled_template = template(suggestion);

                $('#connected-news-container').append(compiled_template);
            }
        );

        $('#connected-news-container').on('click', '[connected-news-delete]', function () {
            var connected_news_id = $(this).attr('connected-news-delete');
            $('[news-id=' + connected_news_id + ']').remove();
        });

        var issueAutocomplete = $('#issue-autocomplete');
        var roIssueName = $('[name-ro=true]').val();
        var enIssueName = $('[name-en=true]').val();

        var issuesList = new Bloodhound({
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: issueAutocomplete.attr('source-url'),
                wildcard: '{name}',
                transform: function (response) {
                    return _.filter(response, function (item) {
                        if (roIssueName == item.name || enIssueName == item.name) {
                            return withError('Issue is the same with filter result');
                        }
                        return $('[issue-id=' + item.id + ']').length === 0;
                    });
                }
            }
        });

        issueAutocomplete.typeahead(
            null,
            {
                name: 'issue',
                display: 'name',
                source: issuesList
            }
        );

        typeaheadAutocomplete(issueAutocomplete);

        issueAutocomplete.bind(
            'typeahead:select',
            function (event, suggestion) {
                $(this).typeahead('val', '');

                var template = _.template($('#connected-issue-template').html());
                var compiled_template = template(suggestion);

                $('#connected-issues-container').append(compiled_template);
            }
        );

        $('#connected-issues-container').on('click', '[connected-issue-delete]', function () {
            var connected_issue_id = $(this).attr('connected-issue-delete');
            $('[issue-id=' + connected_issue_id + ']').remove();
        });

        var initiatorAutocomplete = $('#initiator-autocomplete');
        var initiatorsList = new Bloodhound({
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: initiatorAutocomplete.attr('source-url'),
                wildcard: '{name}',
                transform: function (response) {
                    return _.filter(response, function (item) {
                        return $('[initiator-id=' + item.id + ']').length === 0;
                    });
                }
            }
        });

        initiatorAutocomplete.typeahead(
            null,
            {
                name: 'initiator',
                display: 'name',
                source: initiatorsList
            }
        );

        typeaheadAutocomplete(initiatorAutocomplete);

        initiatorAutocomplete.bind(
            'typeahead:select',
            function (event, suggestion) {
                $(this).typeahead('val', '');

                var template = _.template($('#connected-initiator-template').html());
                var compiled_template = template(suggestion);

                $('#connected-initiators-container').append(compiled_template);
            }
        );

        $('#connected-initiators-container').on('click', '[connected-initiator-delete]', function () {
            var connected_initiator_id = $(this).attr('connected-initiator-delete');
            $('[initiator-id=' + connected_initiator_id + ']').remove();
        });


        $('#locations-container').sortable({
            handle: ".location-handle"
        });
        $("div.step-sort").sortable({
            connectWith: ".connectedSteps",
            handle: ".step-handle",
            stop: function (event, ui) {

                var strParentId = ui.item.parents('.location').attr('id');
                var parentId = strParentId.match(/\d+/g);

                var object = $(ui.item).find(':input');
                for (var i = 0; i < object.length; i++) {
                    if ($(object[i]).attr('name')) {
                        $(object[i]).attr('name', ($(object[i]).attr('name').replace(/(\d+)/i, parentId)));
                    }
                }
            }
        }).disableSelection();


        var locationsList = new Bloodhound({
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: "/backend/issue/query-location/?name={name}",
                wildcard: '{name}',
                transform: function (response) {
                    return _.filter(response, function (item) {
                        return $('[location-id=' + item.id + ']').length === 0;
                    });
                }
            }
        });

        function initEventLocation(location) {
            var locationInput = $('[save-id-to=location-id-' + location + ']');

            locationInput.typeahead(
                null,
                {
                    name: 'location',
                    display: 'name',
                    source: locationsList
                }
            );

            typeaheadAutocomplete(locationInput);

            locationInput.bind(
                'typeahead:select',
                function (event, suggestion) {
                    $('#location-id-' + location).val(suggestion.id);
                });
        }

        function executeAddLocation(id, flowTemplateLocationName, flowTemplateLocationId, flowTemplateNrInregistrare) {
            var locationTemplate = _.template($('#location_template').html());
            if (flowTemplateLocationName == "Locatii" || flowTemplateLocationName == "Locatii") {
                flowTemplateLocationName = " ";
            };

            var populateLocationTemplate = locationTemplate({
                'id': id,
                'location_name': flowTemplateLocationName,
                'location_id': flowTemplateLocationId,
                'nr_inregistrare': flowTemplateNrInregistrare
            });

            $('#locations-container').append(populateLocationTemplate);

            initEventLocation('location-' + id);
            preventEnterToSubmit('[prevent-enter=true]');
        }

        $(document).on('click', '.add_location', function () {
            var id = _.uniqueId('new-');
            executeAddLocation(id);
        });

        $('#locations-container .location').each(function () {
            initEventLocation(this.id);
        });

        $(document).on('click', '.delete_location', function () {
            var selectedId = $(this).attr("delete-id");
            if (confirm("Doriti sa stergeti locatia ?")) {
                $('#' + selectedId).remove();
            }
        });

        $('.activate-editor').each(function(e){
            CKEDITOR.replace( this.id, {
                toolbar: [
                    {name: 'basicstyles', items: ['Bold', 'Italic']},
                    {name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent']},
                    {name: 'links', items: ['Link', 'Unlink']},
                    {name: 'styles', items: ['Styles', 'Format']},
                    {name: 'document', items: ['Source']},
                    {name: 'about', items: ['About']}
                ]
            });
        });

//FlowSteps
        function initFlowStepDate(flowStepId, edit) {
            var startDateWidgets = $('#startdate-widget-' + flowStepId).datetimepicker({
                locale: 'ro',
                format: 'L',
            });

            // if (edit == 0) {
            //     $('#startdate-result-' + flowStepId).val(moment().format("YYYY-MM-DD"));
            // }
            // else {
                $('#startdate-result-' + flowStepId).val(($('#startdate-widget-' + flowStepId).val()).split(".").reverse().join("-"));
            // }

            startDateWidgets.on('dp.change', function () {
                var d = $(this).data("DateTimePicker").date();
                var e = d.format("YYYY-MM-DD");
                $('#startdate-result-' + flowStepId).val(e);
            });

            var endDateWidgets = $('#enddate-widget-' + flowStepId).datetimepicker({
                locale: 'ro',
                format: 'L'
            });

            // if (edit == 0) {
            //     $('#enddate-result-' + flowStepId).val(moment().format("YYYY-MM-DD"));
            // }
            // else {
                $('#enddate-result-' + flowStepId).val(($('#enddate-widget-' + flowStepId).val()).split(".").reverse().join("-"));
            // }
            endDateWidgets.on('dp.change', function () {
                var d = $(this).data("DateTimePicker").date();
                var e = d.format("YYYY-MM-DD");
                $('#enddate-result-' + flowStepId).val(e);
            });
        }

        function initEventStep(stepId) {
            var stepsAutocompleteList = new Bloodhound({
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                datumTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: "/backend/issue/query-step-autocomplete/?name={name}",
                    wildcard: '{name}',
                    transform: function (response) {
                        return _.filter(response, function (item) {
                            return $('#autocomplete-' + item.id).length === 0;
                        });
                    }
                }
            });

            var stepInput = $('#autocomplete-' + stepId);

            stepInput.typeahead(
                null,
                {
                    name: 'stepAutocomplete',
                    display: 'name',
                    source: stepsAutocompleteList
                }
            );

            typeaheadAutocomplete(stepInput);

            stepInput.bind(
                'typeahead:select',
                function (event, suggestion) {
                    stepInput.val(suggestion.id);
                });

            $(document).on('keypress', '#autocomplete-' + stepId, function (e) {
                if (e.which == 13) {
                    e.preventDefault();

                    var request = $.ajax({
                        url: '/backend/stepautocomplete',
                        type: 'post',
                        data: {name: stepInput.typeahead('val')}
                    });
                    request.done(function (data) {
                        stepInput.val(data.name);
                    });

                }
            });
        }

        function executeAddFlowStep(stepId,
                                    locationId,
                                    flowTemplateFlowName,
                                    flowTemplateFlowDuration) {
            var stepTemplate = _.template($('#flowstep_template').html());

            var populateStepTemplate = stepTemplate({
                'id': stepId,
                'location_id': locationId,
                'flow_name': flowTemplateFlowName,
                'estimated_duration': flowTemplateFlowDuration
            });

            $('#flow-container-' + locationId).append(populateStepTemplate);

            initDocumentsTypeahead(stepId, locationId);

            var edit = 0;
            initFlowStepDate(stepId, edit);

            initEventStep(stepId);

            $("div.step-sort").sortable({
                connectWith: ".connectedSteps",
                handle: ".step-handle",
                stop: function (event, ui) {

                    var parentId = ui.item.parents('.location').attr('location-id');

                    var object = $(ui.item).find(':input');
                    for (var i = 0; i < object.length; i++) {
                        if ($(object[i]).attr('name')) {
                            var itemNameAttr = $(object[i]).attr('name');
                            var regexResult = /(^location\[)([a-z0-9-]+)(\].+)/.exec(itemNameAttr);
                            var newNameAttr = regexResult[1] + parentId + regexResult[3];

                            $(object[i]).attr('name', newNameAttr);
                        }
                    }
                }
            }).disableSelection();


            CKEDITOR.replace(locationId + stepId + '-ro', {
                toolbar: [
                    {name: 'basicstyles', items: ['Bold', 'Italic']},
                    {name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent']},
                    {name: 'links', items: ['Link', 'Unlink']},
                    {name: 'styles', items: ['Styles', 'Format']},
                    {name: 'document', items: ['Source']},
                    {name: 'about', items: ['About']}
                ]
            });
            CKEDITOR.replace(locationId + stepId + '-en', {
                toolbar: [
                    {name: 'basicstyles', items: ['Bold', 'Italic']},
                    {name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent']},
                    {name: 'links', items: ['Link', 'Unlink']},
                    {name: 'styles', items: ['Styles', 'Format']},
                    {name: 'document', items: ['Source']},
                    {name: 'about', items: ['About']}
                ]
            });

        }

        $(document).on('click', '.add_flowstep', function () {

            var stepId = _.uniqueId('new-');
            var locationId = $(this).attr('location-id');

            executeAddFlowStep(stepId, locationId);

        });

        $('.location-step').each(function () {
            var stepId = $(this).attr('step-id');
            var edit = 1;
            initFlowStepDate(stepId, edit);
            initEventStep(stepId);
        });

        $('.documente').each(function () {
            var stepId = $(this).attr('doc-step-id');
            var locationId = $(this).attr('doc-location-id');
            initDocumentsTypeahead(stepId, locationId);
        });

        $(document).on('click', '.delete_step', function () {
            var selected_id = $(this).attr("delete-id");
            if (confirm("Doriti sa stergeti pasul ?")) {
                $('#' + selected_id).remove();
            }
        });

//Documents
        function initDocumentsTypeahead(stepId, locationId) {
            var documentsList = new Bloodhound({
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                datumTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: $('#document-autocomplete-' + stepId).attr('source-url'),
                    wildcard: '{name}',
                    transform: function (response) {
                        return _.filter(response, function (item) {
                            return $('[document-id=' + item.id + ']').length === 0;
                        });
                    }
                }
            });

            $('#document-autocomplete-' + stepId).typeahead(
                null,
                {
                    name: 'document',
                    display: 'title',
                    source: documentsList
                }
            );

            $('#document-autocomplete-' + stepId).bind(
                'typeahead:select',
                function (event, suggestion) {
                    $(this).typeahead('val', '');

                    var documentsTemplate = _.template($('#connected-document-template').html());
                    var populateDocumentsTemplate = documentsTemplate(
                        {
                            'id': stepId,
                            'location_id': locationId,
                            'docId': suggestion.id,
                            'title': suggestion.title,
                            'file': suggestion.file,
                            'date': suggestion.data,
                            'fileName': suggestion.file_name
                        }
                    );
                    $('#autocomplete-document-' + stepId).append(populateDocumentsTemplate);
                }
            );
        }

        $(document).on('click', '.delete_document', function () {
            var selected_id = $(this).attr("connected-document-delete");
            if (confirm("Doriti sa stergeti documentul ?")) {
                $('#' + selected_id).remove();
            }
        });

        $(document).on('click', '[data-toggle=collapse]', function () {
            $(this).find('span.glyphicon-menu-down').toggleClass('rotate-bot');
        });

        $(document).on('click', '.add_template', function () {
            var flowTemplateId = $(this).parent().find('#add-template');


            var request = $.ajax({
                method: 'get',
                url: '/backend/flowtemplate/' + flowTemplateId.val() + '/get-full-template'
            });
            request.done(function (data) {

                if (!_.isArray(data)) {
                    return withError('data is not array');
                }

                _.forEach(data, function (locationStep) {
                    var id = _.uniqueId('new-');

                    executeAddLocation(
                        id,
                        locationStep.location.name,
                        locationStep.location_id,
                        locationStep.nr_inregistrare
                    );

                    _.forEach(locationStep.flowsteps, function (flowStep) {
                        var stepId = _.uniqueId('new-');

                        executeAddFlowStep(
                            stepId,
                            id,
                            flowStep.flow_name,
                            flowStep.estimated_duration
                        );

                    });

                });

            });

        });
    });
})();
