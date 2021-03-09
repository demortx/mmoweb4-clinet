<table class="table table-sm table-vcenter table-hover">
    <thead>
    <tr>
        <th style="width: 50px;">ID</th>
        <th>Name</th>
        <th>Level</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    {foreach $top_list as $key => $row  index=$index}
        <tr>
            <th scope="row">{$index+1}</th>
            <td>{$row.rb_name}</td>
            <td>{$row.level}</td>
            <td>
                {if $row.rb_online == true}
                    <span class="text-success">Alive</span>
                {elseif $row.rb_online == false}
                    <span class="text-danger">Dead</span>
                {else}
                    <span class="text-danger">{$row.rb_online}</span>
                {/if}
            </td>
        </tr>
    {/foreach}
    </tbody>
</table>