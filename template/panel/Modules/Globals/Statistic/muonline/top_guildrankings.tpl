<table class="table table-sm table-vcenter table-hover">
    <thead>
    <tr>
        <th style="width: 50px;">ID</th>
        <th>Name</th>
        <th>Master</th>
        <th>Total Res</th>
        <th>Mark</th>
    </tr>
    </thead>
    <tbody>
    {foreach $top_list as $key => $row  index=$index}
        <tr>
            <th scope="row">{$index+1}</th>
            <td>{$row.G_Name} </td>
            <td>{$row.G_Master} </td>
            <td>{$row.G_Score} </td>
            <td>{$.php.get_crest($row.G_Mark, $r_sid)}</td>
        </tr>
    {/foreach}
    </tbody>
</table>