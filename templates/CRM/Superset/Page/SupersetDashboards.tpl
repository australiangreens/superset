<h3>Superset Dashboards</h3>

<div id="superset_dashboard_list">
  <table>
    <thead>
      <tr>
        <th width="50">ID</th>
        <th>Title</th>
      </tr>
    </thead>

    <tbody>
      {foreach from=$dashboards item=dashboard}
        <tr>
          <td>
            {$dashboard.id}
          </td>

          <td>
            {if $dashboard.viewable}
              <a
                class="superset-dashboard-link"
                data-dashboard-embed-id="{$dashboard.embed_id}"
                data-dashboard-title="{$dashboard.title}"
                href=""
                >
                {$dashboard.title}
              </a>
            {else}
              {$dashboard.title}
            {/if}
          </td>
        </tr>
      {/foreach}
    </tbody>
  </table>
</div>

<div id="superset_dashboard_popup">
  <dialog>
    <div id="popup_header">
      <h1></h1>

      <button type="button" id="close_popup">
        <span class="ui-icon fa-times"></span>
      </button>
    </div>

    <div id="popup_content"></div>
  </dialog>
</div>
