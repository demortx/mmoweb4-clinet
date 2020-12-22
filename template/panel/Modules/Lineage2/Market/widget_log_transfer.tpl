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
						<th>{$widget_log_title_amount}</th>
					</tr>
				</thead>
				<tbody>
					{foreach $log_list as $item}
					<tr>
						<td>{$item.date_create}</td>
						<td>
							{$status[$item.status]}
							{if $item.status == 1 && $item.system != null}
							<br>
							<small>{$item.data_approve}</small>
							{/if}
							{if $item.system == null && $item.status == 1}
							<br>
							<small>{$item.date_create}</small>
							{/if}
						</td>
						<td>
							{if $item.system != null}
							{$item.system}
							<br>
							<small>{if $item.wallet != null}{$item.wallet}{/if}</small>
							{else}МА{/if}
						</td>
						<td>
							{if $item.system != null}{$item.took}{else}{$item.transfer}{/if}
						</td>
					</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
	</div>
</div>