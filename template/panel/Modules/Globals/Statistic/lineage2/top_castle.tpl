<table class="table table-sm table-vcenter table-hover">
    <thead>
    <tr>
        <th style="width: 50px;">ID</th>
        <th>Picture</th>
        <th>Name</th>
        <th>Info</th>
        <th>Date</th>
        <th>Siege</th>
    </tr>
    </thead>
    <tbody>
    {foreach $top_list as $key => $row  index=$index}
        <tr>
            <th scope="row">{$index+1}</th>
            <td>
                <img style="height: 60px;border-radius: 3px;" src='{$.site.dir_panel}/assets/media/castle/{$row.castle_id}.jpg' alt=''>
            </td>
            <td>{$row.castle}</td>
            <td >
                <p>
                    <strong>Tax:</strong>
                    &nbsp; {$row.tax_rate}%
                    <br>
                    <strong>Clan:</strong>
                    &nbsp; {if $row.clan?}{$.php.get_crest($row.crest_id, $r_sid)} {$row.clan}{else}-{/if}
                    <br>
                    <strong>Leader:</strong>
                    &nbsp; {if $row.char_name?}{$row.char_name}{else}-{/if}
                </p>
            </td>

            <td>{$row.siege|date_format:"%d-%m-%y %H:%M"}</td>

            <td class='hidden-xs' colspan='2'>
                <p>
                    <small>
                        <strong>Attackers:</strong>
                        {if $row['attackers']?}{foreach $row['attackers'] as $val}{$.php.get_crest($val.crest_id, $r_sid)} {$val['clan']} | {/foreach}{else}-{/if}
                    </small>
                    <br>
                    <small>
                        <strong>Defenders:</strong>
                        {if $row['defenders']?}{foreach $row['defenders'] as $val}{$.php.get_crest($val.crest_id, $r_sid)} {$val['clan']} | {/foreach}{else}-{/if}
                    </small>
                </p>
            </td>
        </tr>
    {/foreach}
    </tbody>
</table>