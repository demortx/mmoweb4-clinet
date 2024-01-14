<div class="block">
    <div class="block-content">
        <table class="table table-borderless table-striped">
            <thead>
            <tr>
                <th>Id</th>
                <th>item id</th>
                <th>Name</th>
                <th>Add name</th>
                <th>Desc</th>
            </tr>
            </thead>
            <tbody>
            {foreach $no_icon as $item}
                <tr>
                    <td style="font-size: 10px;">
                        {$item.id}
                    </td>
                    <td class="font-size-sm">
                        {$item.item_id}
                    </td>
                    <td style="font-size: 10px;">
                        {$item.name}
                    </td>
                    <td style="font-size: 10px;">
                        {$item.add_name}
                    </td>
                    <td style="font-size: 10px;">
                        {$item.description}
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
</div>