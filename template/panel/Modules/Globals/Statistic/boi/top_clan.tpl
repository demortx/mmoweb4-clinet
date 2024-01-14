<table class="table table-sm table-vcenter table-hover">
    <thead>
    <tr>
        <th style="width: 50px;">ID</th>
        <th>Clan</th>
        <th>Leader</th>
        <th>LvL</th>
    </tr>
    </thead>
    <tbody>
    {foreach $top_list as $key => $row  index=$index}
        <tr>
            <th scope="row">{$index+1}</th>
            <td>{$row.clan}</td>
            <td>{$row.char_name}</td>
            <td>{$row.level}</td>
        </tr>
    {/foreach}
    </tbody>
</table>
