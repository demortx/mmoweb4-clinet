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
                        <br>
                        <small>{$log_list.data_approve}</small>
                    </td>
                </tr>
                <tr>
                    <td>{$widget_log_title_system}</td>
                    <td>
                        {$log_list.system}
                        <br>
                        <small>{if $log_list.wallet != null}{$log_list.wallet}{/if}</small>
                    </td>
                </tr>
                <tr>
                    <td>{$widget_log_t_amount}</td>
                    <td>
                        {$log_list.took}
                    </td>
                </tr>
                <tr>
                    <td>{$widget_log_t_amount_w}</td>
                    <td>
                        {$.php.percentage($log_list.took,$money_withdrawal.withdrawal_commision)} ({$widget_user_comission}: {$money_withdrawal.withdrawal_commision}%)
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