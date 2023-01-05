<table class="table table-sm table-vcenter table-hover">
    <thead>
    <tr>
        <th style="width: 50px;">ID</th>
        <th>Name</th>
        <th>Class</th>
        <th>LvL<sup style="color: red;">ML</sup></th>
        <th>Location</th>

    </tr>
    </thead>
    <tbody>
    {foreach $top_list as $key => $row  index=$index}
        <tr>
            <th scope="row">{$index+1}</th>
            <td>{$row.Name}</td>
            <td>{$row.Class}</td>
            <td>{$row.cLevel}<sup style="color: red;">{$row.mLevel}</sup></td>
            <td>{$row.MapNumber}</td>
        </tr>
    {/foreach}
    </tbody>
</table>

