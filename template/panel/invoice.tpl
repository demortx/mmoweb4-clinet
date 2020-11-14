<!-- Page Content -->
<div class="hero bg-pattern" >
    <div class="hero-inner">
        <div class="content content-full">

            {if $response_error}
            <div class="py-30 text-center">
                <i class="si si-chemistry text-primary display-3"></i>
                <h2 class="h3 font-w400 mt-30 mb-10">{$response_error_msg}</h2>
                <a class="btn btn-hero btn-noborder btn-rounded btn-alt-primary" href="{$.php.set_url('panel')}">
                     <i class="fa fa-arrow-left mr-10"></i> Go Back to Dashboard
                 </a>
            </div>
            {else}
            <!-- Invoice -->
            <div class="block">

                <div class="block-header block-header-default">
                    <h3 class="block-title">#{$response_data.payment_id}</h3>
                    <div class="block-options">
                        <!-- Print Page functionality is initialized in Helpers.print() -->
                        <button type="button" class="btn-block-option" onclick="Codebase.helpers('print-page');">
                            <i class="si si-printer"></i> Print Invoice
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <!-- Invoice Info -->
                    <div class="row my-20">
                        <!-- Company Info -->
                        <div class="col-6">
                            <p class="h3">{$.site.config.project.name}</p>
                            <address>
                                Order: {$response_data.order_id}<br>
                                Payment: {$response_data.payment_system}<br>
                                Date create: {$response_data.date_create}<br>
                                Date complete: {$response_data.date_complete}<br>
                                Status: {if $response_data.status == 1}complete{else}refund{/if}

                            </address>
                        </div>
                        <!-- END Company Info -->

                        <!-- Client Info -->
                        <div class="col-6 text-right">
                            <p class="h3">{if $response_data.ma_email?}{$response_data.ma_email}{else}{$response_data.ma_phone}{/if}</p>
                            <address>
                                {if $.php.is_string($response_data.email)}Payer email: {$response_data.email}<br>{/if}
                                {if $.php.is_string($response_data.char_name)}Delivered to character: {$response_data.char_name}<br>{/if}
                                Currency: {$response_data.currency}<br>
                                Last IP: {$response_data.last_ip}<br>
                                ISO: {$response_data.iso}
                            </address>
                        </div>
                        <!-- END Client Info -->
                    </div>
                    <!-- END Invoice Info -->

                    <!-- Table -->
                    <div class="table-responsive push">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 60px;"></th>
                                <th>Product</th>
                                <th class="text-center" style="width: 90px;">Qnt</th>
                                <th class="text-right" style="width: 120px;">Unit</th>
                                <th class="text-right" style="width: 120px;">Amount</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                                <td class="text-center">1</td>
                                <td>
                                    <p class="font-w600 mb-5">{$.site.config.payment_system.long_name_valute}</p>
                                    <div class="text-muted">In-game currency</div>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-pill badge-primary">{$response_data.coin}</span>
                                </td>

                                <td class="text-right">{$.php.round($response_data.sum / $response_data.coin, 2)} {$response_data.currency}</td>
                                <td class="text-right">{$.php.round($response_data.sum, 2)} {$response_data.currency}</td>
                            </tr>




                            <tr class="table-warning">
                                <td colspan="4" class="font-w700 text-uppercase text-right">Total Due + VAT</td>
                                <td class="font-w700 text-right">{$.php.round($response_data.sum, 2)} {$response_data.currency}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- END Table -->

                    <!-- Footer -->
                    <p class="text-muted text-center">Thank you very much for doing business with us. We look forward to working with you again!</p>
                    <!-- END Footer -->
                </div>
            </div>
            <!-- END Invoice -->

            {/if}
        </div>
    </div>
</div>
<!-- END Page Content -->