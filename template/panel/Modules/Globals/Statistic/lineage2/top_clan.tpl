<table class="table table-sm table-vcenter table-hover">
    <thead>
    <tr>
        <th style="width: 50px;">ID</th>
        <th>Name</th>
        <th>Ally</th>
        <th>Castle</th>
        <th>Clan holl</th>
        <th>Level</th>
        <th>Rep</th>
        <th>Member</th>
        <th>PvP</th>
    </tr>
    </thead>
    <tbody>
    {foreach $top_list as $key => $row  index=$index}
        <tr>
            <th scope="row">{$index+1}</th>
            <td title="Leader: {$row.char_name}">{$.php.get_crest($row.ally_crest_id, $r_sid)}{$.php.get_crest($row.crest_id, $r_sid)} {$row.name}</td>
            <td>{$row.ally}</td>
            <td>{$row.castle}</td>
            <td>{$row.holl}</td>
            <td>{$row.level}</td>
            <td>{$row.point}</td>
            <td>{$row.member_count}</td>
            <td>{$row.pvp_count}</td>
        </tr>
    {/foreach}
    </tbody>
</table>