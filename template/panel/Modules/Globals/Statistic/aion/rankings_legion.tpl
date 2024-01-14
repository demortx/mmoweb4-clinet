<table class="table table-sm table-vcenter table-hover">
    <thead>
    <tr>
        <th style="width: 50px;">Rank</th>
        <th width="24px" class="p-0"></th>
        <th>Legion</th>
        <th>Member</th>
        <th>LvL</th>
        <th>Points</th>
    </tr>
    </thead>
    <tbody>
    {foreach $top_list as $key => $row  index=$index}
        <tr>
            <th scope="row">{$index+1}</th>
            <th  class="p-0">{$.php.get_crest($row.crest_id, $r_sid, '', '<img class="%class%" width="24" src="%src%">')}</th>
            <td>{$row.name}</td>
            <td>{$row.member_count}</td>
            <td>{$row.level}</td>
            <td>{$.php.number_format($row.contribution_points)}</td>
        </tr>
    {/foreach}
    </tbody>
</table>
