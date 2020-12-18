<div class="block rounded">
    <div class="block-content">
        <div class="row ">
            <div class="col-12 col-md-7 border-right">
                <h5>{$widget_total_stats_desc_title} <small>{$widget_total_stats_desc_title_sub}</small></h5>
                <p class="border-bottom">
                    {$widget_total_stats_desc}
                </p>

                <a href="{$.php.set_url('/panel/market/my-sell')}" class="btn btn-block btn-outline-primary  mb-10">{$widget_total_stats_my_sell}</a>

            </div>
            <div class="col-12 col-md-5">
                <h5>{$widget_total_stats_title}</h5>


                <table class="table table-borderless table-vcenter">
                    <tbody>
                    <tr>
                        <td class="table-success text-center p-5">
                            <i class="text-success"></i>
                        </td>
                        <td>
                            {$widget_total_stats_sales_today}
                        </td>
                        <td class="text-right">
                            <em class="font-size-sm text-muted">{$info.stat.sales_today}</em>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-danger text-center p-5">
                            <i class="text-success"></i>
                        </td>
                        <td>
                            {$widget_total_stats_sales_week}
                        </td>
                        <td class="text-right">
                            <em class="font-size-sm text-muted">{$info.stat.sales_week}</em>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-success text-center p-5">
                            <i class="text-success"></i>
                        </td>
                        <td>
                            {$widget_total_stats_new_today}
                        </td>
                        <td class="text-right">
                            <em class="font-size-sm text-muted">{$info.stat.news_today}</em>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-danger text-center p-5">
                            <i class="text-success"></i>
                        </td>
                        <td>
                            {$widget_total_stats_new_week}
                        </td>
                        <td class="text-right">
                            <em class="font-size-sm text-muted">{$info.stat.news_week}</em>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>