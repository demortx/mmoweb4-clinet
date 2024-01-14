<table class="table table-sm table-vcenter table-hover">
    <thead>
    <tr>
        <th style="width: 50px;">ID</th>
        <th>Name</th>
        <th>Class</th>
        <th>LvL</th>
        <th>PK Win / PK Total</th>
        <th>Rank</th>
    </tr>
    </thead>
    <tbody>
    {foreach $top_list as $key => $row  index=$index}
        <tr>
            <th scope="row">{$index+1}</th>
            <td>{$row.char_name}</td>
            <td>{$row.class}</td>
            <td>{$row.lvl}</td>
            <td>{$row.pkw} / {$row.pkt}</td>
            <td>{$row.rank}</td>
        </tr>
    {/foreach}
    </tbody>
</table>