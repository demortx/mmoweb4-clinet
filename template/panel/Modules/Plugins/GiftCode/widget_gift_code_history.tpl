<div class="block rounded">
    <div class="block-header block-header-default">
        <h3 class="block-title">{$th_title}</h3>
    </div>
    <div class="block-content">
        <table class="table table-striped table-vcenter">
            <thead>
            <tr>
                <th class="text-center" style="width: 100px;">#</th>
                <th>{$th_code}</th>
                <th style="width: 15%;">{$th_sum}</th>
                <th class="d-none d-md-table-cell" style="width: 30%;">{$th_date_create}</th>
            </tr>
            </thead>
            <tbody>
            {if count($.site.session->session.user_data.gift_code.history) > 0}
                {foreach $.site.session->session.user_data.gift_code.history as $code}
                    <tr class="{if $code.status == 1}table-success{/if}">
                        <td class="text-center">
                            {$code.id}
                        </td>
                        <td class="font-w600">{$code.cod}</td>
                        <td >{$code.sum}</td>
                        <td class="d-none d-sm-table-cell">{$code.date_create}</td>
                    </tr>

                {/foreach}
            {else}
            <tr>
                <td class="text-center" colspan="4">
                    {$th_gift_empty}
                </td>
            </tr>
            {/if}
            </tbody>
        </table>
    </div>
</div>
