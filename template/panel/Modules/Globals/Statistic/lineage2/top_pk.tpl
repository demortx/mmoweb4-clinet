<table class="table table-sm table-vcenter table-hover">
    <thead>
    <tr>
        <th style="width: 50px;">ID</th>
        <th>Name</th>
        <th>Class</th>
        <th>Clan</th>
        <th>LvL</th>
        <th>PvP / PK</th>
        <th>Time</th>
        <th>Online</th>
    </tr>
    </thead>
    <tbody>
    {foreach $top_list as $key => $row  index=$index}
        <tr>
            <th scope="row">{$index+1}</th>
            {*{$row.ally_crest_id}*}{*{$row.crest_id}*}
            <td>{$row.char_name}</td>
            <td>{$row.class}</td>
            <td title="Ally: {$row.ally}">{$.php.get_crest($row.ally_crest_id, $r_sid)}{$.php.get_crest($row.crest_id, $r_sid)} {$row.clan}</td>
            <td>{$row.lvl}</td>
            <td>{$row.pvp} / {$row.pk}</td>
            <td>{$row.use_time}</td>
            <td>{if $row.char_online == 1}<i class="si si-globe text-success"></i>{else}<i class="si si-globe  text-gray"></i>{/if}</td>
        </tr>
    {/foreach}
    </tbody>
</table>