<div class="block support-grid rounded">
	<div class="block-header block-header-default">
		<h3 class="block-title d-none d-md-block">{$widget_history_funds}</h3>
	</div>
	<div class="block-content">
		<div class="table-responsive">
			<table class="table table-striped table-vcenter">
				<thead>
				<tr>
					<th>{$widget_log_title_date}</th>
					<th>{$widget_log_title_status}</th>
					<th>{$widget_log_title_system}</th>
					<th>{$widget_log_t_amount}</th>
					<th>{$widget_log_t_amount_w}<br>{$widget_user_comission}: {$money_withdrawal.withdrawal_commision}%</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				{foreach $log_list as $item}
					<tr>
						<td>{$item.date_create}</td>
						<td>
							{$status[$item.status]}
							<br>
							<small>{$item.data_approve}</small>
						</td>
						<td>
							{$item.system}
							<br>
							<small>{if $item.wallet != null}{$item.wallet}{/if}</small>
						</td>
						<td>
							{$item.took}
						</td>
						<td>
							{$.php.percentage($item.took,$money_withdrawal.withdrawal_commision)}
						</td>
						<td>
							<a class="btn btn-alt-primary" href="/panel/withdrawal/{$item.id}">Info</a>
						</td>
					</tr>
				{/foreach}
				</tbody>
			</table>
		</div>
	</div>
</div>