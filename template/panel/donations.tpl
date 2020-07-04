<div class="my-50 text-center">
    <h2 class="font-w700 text-black mb-10">Buy/Sell</h2>
    <h3 class="h5 text-muted mb-0">Bitcoin (BTC)</h3>
</div>
<div class="row">
    <div class="col-lg-6 offset-lg-3">



        <div class="block block-fx-shadow">

            <div class="block-content">
                <form action="be_forms_elements_bootstrap.html" method="post" onsubmit="return false;">

                    <div class="form-group">
                        <label for="select-server">Server</label>
                        <select class="form-control" id="select-server" name="sid"> <!-- select_server() -->
                            {foreach $.site.config.project.server_info as $platform => $server_list}

                                <optgroup label="{ucfirst($platform)}">
                                    {foreach $server_list as $sid => $server}
                                        <option value="{$sid}">{$server.name}</option>
                                    {/foreach}
                                </optgroup>
                            {/foreach}
                        </select>
                    </div>





                    <div class="form-group">
                        <label  for="example-select">Payment</label>
                        <select class="form-control" id="example-select" name="example-select">
                            <option value="0">Unitpay</option>
                            <option value="1">G2A</option>
                            <option value="2">Nextpay</option>
                            <option value="3">Free Kassa</option>
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="example-nf-email">Char name</label>
                        <input type="email" class="form-control" name="example-nf-email" placeholder="Enter Email..">
                    </div>
                    <div class="form-group">
                        <label for="example-nf-password">Count</label>
                        <input type="number" class="form-control"  name="example-nf-password" placeholder="Enter count col..">
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-sm-6 push"></div>
                        <div class="col-sm-6 text-sm-right push">
                            <button type="submit" class="btn btn-alt-success min-width-125">Donations</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>