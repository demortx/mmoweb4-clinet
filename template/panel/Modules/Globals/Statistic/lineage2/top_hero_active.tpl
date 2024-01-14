<table class="table table-sm table-vcenter table-hover">
    <thead>
    <tr>
        <th style="width: 50px;">ID</th>
        <th>Name</th>
        <th>Class</th>
        <th>Clan</th>
    </tr>
    </thead>
    <tbody>
    {foreach $top_list as $key => $row  index=$index}
        <tr>
            <th scope="row">{$index+1}</th>
            <td>{$row.char_name}</td>
            <td>{$row.class}</td>
            <td title="Ally: {$row.ally}">{$.php.get_crest($row.ally_crest_id, $r_sid)}{$.php.get_crest($row.crest_id, $r_sid)} {$row.clan}</td>
        </tr>
    {/foreach}
    </tbody>
</table>