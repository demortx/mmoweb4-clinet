{set $top_list = array_shift($top_list)}
<div class="row gutters-tiny">
    <div class="col-12 col-md-8 min-height-200">
        <canvas class="chart-race"></canvas>
    </div>
    <div class="col-12 col-md-4">
        <table class="table table-sm table-vcenter">
            <tbody>
            <tr>
                <td>Total PvP</td>
                <td>{$top_list.pvp}</td>
            </tr>
            <tr>
                <td>Total PK</td>
                <td>{$top_list.pk}</td>
            </tr>
            <tr>
                <td>Characters</td>
                <td>{$top_list.count_char}</td>
            </tr>
            <tr>
                <td>Clans</td>
                <td>{$top_list.count_clan}</td>
            </tr>
            <tr>
                <td>Alliance</td>
                <td>{$top_list.count_ally}</td>
            </tr>
            <tr>
                <td>Heroes</td>
                <td>{$top_list.count_heroes}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="col-12 col-md-8 min-height-200">
        <canvas class="chart-gender"></canvas>
    </div>
</div>
{$.site._SEO->addTegHTML('footer', 'chartjs', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/chartjs/Chart.bundle.min.js?ver=0.1'])}
<script>
    document.addEventListener("DOMContentLoaded", function (event) {
        var chart_race  = jQuery('.chart-race');
        var chart_gender  = jQuery('.chart-gender');

        var chart_race_data = {
            labels: [
                'Human',
                'Elf',
                'Dark elf',
                'Orc',
                'Dwarf'
            {if $top_list.kamael > 0}
                ,'Kamael'
            {/if}
            ],
            datasets: [{
                data: [
                    {$top_list.human},
                    {$top_list.elf},
                    {$top_list.dark_elf},
                    {$top_list.orc},
                    {$top_list.dwarf}
                {if $top_list.kamael > 0}
                    ,{$top_list.kamael}
                {/if}
                ],
                backgroundColor: [
                    'rgb(204,127,26)',
                    'rgb(25,197,255)',
                    'rgb(0,43,124)',
                    'rgb(0,127,27)',
                    'rgb(204,95,90)'
                {if $top_list.kamael > 0}
                    ,'rgb(109,108,105)'
                {/if}
                ],
                hoverBackgroundColor: [
                    'rgb(204,127,26,.5)',
                    'rgb(25,197,255,.5)',
                    'rgb(0,43,124,.5)',
                    'rgb(0,127,27,.5)',
                    'rgb(204,95,90,.5)'
                {if $top_list.kamael > 0}
                    ,'rgb(109,108,105,.5)'
                {/if}
                ]
            }]
        };
        var chart_gender_data = {
            labels: [
                'Man',
                'Woman'
            ],
            datasets: [{
                data: [
                    {$top_list.man},
                    {$top_list.woman}
                ],
                backgroundColor: [
                    'rgb(89,174,204)',
                    'rgb(255,110,165)'
                ],
                hoverBackgroundColor: [
                    'rgba(89,174,204,.5)',
                    'rgba(255,110,165,.5)'
                ]
            }]
        };
        if (chart_race.length) {
            new Chart(chart_race, { type: 'polarArea', data: chart_race_data });
        }
        if (chart_gender.length) {
            new Chart(chart_gender, { type: 'pie', data: chart_gender_data });
        }
    });
</script>