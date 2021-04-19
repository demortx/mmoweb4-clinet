<table class="table table-sm table-vcenter table-hover">
    <thead>
    <tr>
        <th style="width: 50px;">Rank</th>
        <th>Name</th>
        <th>LvL</th>
        <th>Glory Points</th>
        <th>Race</th>
        <th>Class</th>
        <th>Gender</th>
    </tr>
    </thead>
    <tbody>
    {foreach $top_list as $key => $row  index=$index}
        <tr>
            <th scope="row">{$index+1}</th>
            <td>{$row.name}</td>
            <td>{$.php.exp_level($row.exp)}</td>
            <td>{$.php.number_format($row.gp)}</td>
            <td>{$.php.get_race_img($row.race)}</td>
            <td>{$.php.get_class_img($row.player_class)}</td>
            <td>{$.php.get_gender_img($row.gender)}</td>
        </tr>
    {/foreach}
    </tbody>
</table>