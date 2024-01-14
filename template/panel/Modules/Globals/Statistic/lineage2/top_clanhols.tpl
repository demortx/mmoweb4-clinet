<table class="table table-sm table-vcenter table-hover">
    <thead>
    <tr>
        <th style="width: 50px;">ID</th>
        <th>Name</th>
        <th>Town</th>
        <th>Clan</th>
        <th>Leader</th>
    </tr>
    </thead>
    <tbody>
    {foreach $top_list as $key => $row  index=$index}
        {if empty($row.holl_id)}
            {continue}
        {/if}
        <tr>
            <th scope="row">{$index+1}</th>
            <th>{$row.holl_id}</th>
            <th>{$row.town}</th>
            <td title="Leader: {$row.char_name}">{$.php.get_crest($row.crest_id, $r_sid)} {$row.clan}</td>
            <td>{$row.char_name}</td>
        </tr>
    {/foreach}
    </tbody>
</table>
