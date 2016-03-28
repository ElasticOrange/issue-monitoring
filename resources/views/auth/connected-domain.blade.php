<script type="text/template" id="connected-domain-template">
    <tr domain-id="<%= id %>">
        <th scope="row">
            <%= name %>
        </th>
        <td>
            <label>
            	<input name="rights[<%= id %>][can_see_issues]"
                        type="hidden"
                        value="0"
                />
                <input name="rights[<%= id %>][can_see_issues]"
                        type="checkbox"
                        value="1"
                        checked="checked"
                />Acces
            </label>
            <label style="margin-left: 20px;">
            	<input name="rights[<%= id %>][alert_for_issues]"
                        type="hidden"
                        value="0"
                />
                <input name="rights[<%= id %>][alert_for_issues]"
                        type="checkbox"
                        value="1"
                        checked="checked"
                />Alerte
            </label>
        </td>
        <td>
            <label>
            	<input name="rights[<%= id %>][can_see_reports]"
                        type="hidden"
                        value="0"
                />
                <input name="rights[<%= id %>][can_see_reports]"
                        type="checkbox"
                        value="1"
                        checked="checked"
                />Acces
            </label>
            <label style="margin-left: 20px;">
            	<input name="rights[<%= id %>][alert_for_reports]"
                        type="hidden"
                        value="0"
                />
                <input name="rights[<%= id %>][alert_for_reports]"
                        type="checkbox"
                        value="1" 
                        checked="checked"
                />Alerte
            </label>
        </td>
        <td>
            <label>
            	<input name="rights[<%= id %>][can_see_news]"
                        type="hidden"
                        value="0"
                />
                <input name="rights[<%= id %>][can_see_news]"
                        type="checkbox"
                        value="1"
                        checked="checked"
                />Acces
            </label>
            <label style="margin-left: 20px;">
            	<input name="rights[<%= id %>][alert_for_news]"
                        type="hidden"
                        value="0"
                />
                <input name="rights[<%= id %>][alert_for_news]"
                        type="checkbox"
                        value="1"
                        checked="checked"
                />Alerte
            </label>
        </td>
        <td>
            <label>
            	<input name="rights[<%= id %>][can_see_stakeholders]"
                        type="hidden"
                        value="0"
                />
                <input name="rights[<%= id %>][can_see_stakeholders]"
                        type="checkbox"
                        value="1"
                        checked="checked"
                />Acces
            </label>
        </td>
        <td>
            <a class="btn btn-danger" connected-domain-delete="<%= id %>">
                <span class="glyphicon glyphicon-trash"></span>
            </a>
        </td>
        <input type="hidden" name="domains_connected[]" value="<%= id %>" />
    </tr>
</script>