<div class="col-md-4">
    <h3 class="h1 font-w300 text-success">{$title_awaiting_user}
        <button type="button" id="reload-ticket-list" class="btn btn-sm btn-rounded btn-outline-primary submit-btn" {$.php.btn_ajax("Modules\Plugins\Support\Support", "get_all_ticket", [0])}>
            <i class="fa fa-refresh"></i>
        </button>
    </h3>
    <ul class="nav-users push ml-0">
        {if count($tickets['awaiting_user'])}
            {foreach $tickets['awaiting_user'] as $ticket}
                <li>
                    <a href="javascript:void(0)" class="submit-btn" {$.php.btn_ajax("Modules\Plugins\Support\Support", "open_ticket", ['tid' => $ticket['tid']])}>
                        <span class="badge badge-pill badge-success">{$ticket['count_msg']}</span> {$ticket['theme']|truncate:45:"..."}
                        <div class="font-w400 font-size-xs text-muted">{$ticket['text']|truncate:45:"..."}</div>
                    </a>
                </li>
            {/foreach}
        {else}
        <script>
            document.addEventListener("DOMContentLoaded", function (event) {
                setTimeout("$('#reload-ticket-list').trigger('click')", 500);
            });
        </script>
            <li class="text-center">
                <div class="font-w400 font-size-xs text-muted">{$title_msg_empty}</div>
            </li>
        {/if}
    </ul>
</div>
<div class="col-md-4">
    <h3 class="h1 font-w300 text-warning">{$title_awaiting_admin}</h3>
    <ul class="nav-users mt-10 push">
        {if count($tickets['awaiting_admin'])}
            {foreach $tickets['awaiting_admin'] as $ticket}
                <li>
                    <a href="javascript:void(0)" class="submit-btn" {$.php.btn_ajax("Modules\Plugins\Support\Support", "open_ticket", ['tid' => $ticket['tid']])}>
                        <span class="badge badge-pill badge-warning">{$ticket['count_msg']}</span> {$ticket['theme']|truncate:45:"..."}
                        <div class="font-w400 font-size-xs text-muted">{$ticket['text']|truncate:45:"..."}</div>
                    </a>
                </li>
            {/foreach}
        {else}
            <li class="text-center">
                <div class="font-w400 font-size-xs text-muted">{$title_msg_empty}</div>
            </li>
        {/if}
    </ul>
</div>
<div class="col-md-4">
    <h3 class="h1 font-w300 text-muted">{$title_closed}</h3>
    <ul class="nav-users mt-10 push">
        {if count($tickets['closed'])}
            {foreach $tickets['closed'] as $ticket}
                <li>
                    <a href="javascript:void(0)" class="submit-btn" {$.php.btn_ajax("Modules\Plugins\Support\Support", "open_ticket", ['tid' => $ticket['tid']])}>
                        <span class="badge badge-pill badge-secondary">{$ticket['count_msg']}</span> {$ticket['theme']|truncate:45:"..."}
                        <div class="font-w400 font-size-xs text-muted">{$ticket['text']|truncate:45:"..."}</div>
                    </a>
                </li>
            {/foreach}
        {else}
            <li class="text-center">
                <div class="font-w400 font-size-xs text-muted">{$title_msg_empty}</div>
            </li>
        {/if}
    </ul>
</div>