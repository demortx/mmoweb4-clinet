<table class="table table-sm table-vcenter table-hover">
    <thead>
    <tr>
        <th style="width: 50px;">ID</th>
        <th>Ally</th>
        <th>Clan leader</th>
        <th>Total level</th>
        <th>Total rep</th>
        <th>Total member</th>
        <th>Total PvP</th>
    </tr>
    </thead>
    <tbody>
    {foreach $top_list as $key => $row  index=$index}
        <tr>
            <th scope="row">{$index+1}</th>
            <td title="Leader: {$row.char_name}">{$.php.get_crest($row.ally_crest_id, $r_sid)} {$row.ally}</td>
            <td title="Leader: {$row.char_name}">{$.php.get_crest($row.crest_id, $r_sid)} {$row.name}</td>
            <td>{$row.level}</td>
            <td>{$row.point}</td>
            <td>{$row.member_count}</td>
            <td>{$row.pvp_count}</td>
        </tr>
    {/foreach}
    </tbody>
</table>