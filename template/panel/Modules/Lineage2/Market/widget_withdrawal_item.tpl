<div class="block support-grid rounded">
    <div class="block-header block-header-default">
        <h3 class="block-title d-none d-md-block">{$widget_history_withdrawal_item} #{$log_list.id}</h3>
    </div>
    <div class="block-content">
        <div class="table-responsive">
            <table class="table table-striped table-vcenter">
                <tbody>
                <tr>
                    <td>{$widget_log_title_date}</td>
                    <td>{$log_list.date_create}</td>
                </tr>
                <tr>
                    <td>{$widget_log_title_status}</td>
                    <td>
                        {$status[$log_list.status]}
                        {if $log_list.status == 1 && $log_list.system != 'ma'}
                            <br>
                            <small>{$log_list.data_approve}</small>
                        {elseif $log_list.system == 'ma' && $log_list.status == 1}
                            <br>
                            <small>{$log_list.date_create}</small>
                        {/if}
                    </td>
                </tr>
                <tr>
                    <td>{$widget_log_title_system}</td>
                    <td>
                        {if $log_list.system != null}
                            {$log_list.system}
                            <br>
                            <small>{if $log_list.wallet != null}{$log_list.wallet}{/if}</small>
                        {else}МА{/if}
                    </td>
                </tr>
                <tr>
                    <td>{$widget_log_title_amount}</td>
                    <td>
                        {if $log_list.system != null}{$log_list.took}{else}{$log_list.transfer}{/if}
                    </td>
                </tr>
                {if $.php.strlen($log_list.comment)}
                    <tr>
                        <td>{$widget_log_title_comment}</td>
                        <td>
                            {$log_list.comment}
                        </td>
                    </tr>
                {/if}
                </tbody>
            </table>
        </div>
    </div>
</div>