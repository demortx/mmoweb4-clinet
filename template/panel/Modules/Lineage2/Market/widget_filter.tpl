<div class="block rounded">
    <div class="block-content ">
        <form>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-5 row">
                        <label class="col-12" for="name">{$widget_sell_name}</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control " id="name" name="name" value="{if $.get.name?}{$.get.name}{/if}" placeholder="Name..">
                        </div>
                    </div>
                    <div class="form-group mb-5 row">
                        <label class="col-12" for="price_from">{$widget_sell_price}</label>
                        <div class="col-lg-12">
                            <div class="input-daterange input-group">
                                <input type="text" class="form-control " id="price_from" name="price_from" value="{if $.get.price_from?}{$.get.price_from?}{/if}" placeholder="From" autocomplete="off">
                                <div class="input-group-prepend input-group-append">
                                    <span class="input-group-text  font-w600">to</span>
                                </div>
                                <input type="text" class="form-control " id="price_to" name="price_to" value="{if $.get.price_to?}{$.get.price_to?}{/if}" placeholder="To" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-5 row">
                        <label class="col-12" for="grade">{$grade}</label>
                        <div class="col-lg-12">
                            <select class="form-control" id="grade" name="grade">
                                <option value="">{$ajax_filter_no_select}</option>
                                {foreach $grade_list as $gr}
                                    <option value="{$gr['grade']}" {if $.get.grade? AND $.get.grade == $gr['grade']}selected{/if}>{$gr['grade']|upper}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-5 row">
                        <label class="col-12" for="enc_from">{$ajax_buy_shop_enchant}</label>
                        <div class="col-lg-12">
                            <div class="input-daterange input-group">
                                <input type="text" class="form-control " id="enc_from" name="enc_from" value="{if $.get.enc_from?}{$.get.enc_from?}{/if}" placeholder="From: +1" autocomplete="off">
                                <div class="input-group-prepend input-group-append">
                                    <span class="input-group-text  font-w600">to</span>
                                </div>
                                <input type="text" class="form-control " id="enc_to" name="enc_to" value="{if $.get.enc_to?}{$.get.enc_to?}{/if}" placeholder="To: +20" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-5 row">
                        <label class="col-12" for="rarity">{$rare}</label>
                        <div class="col-lg-12">
                            <select class="form-control" id="rarity" name="rarity">
                                <option value="">{$ajax_filter_no_select}</option>
                                <option value="rare" {if $.get.rarity? AND $.get.rarity == 'rare'}selected{/if}>Rare</option>
                                <option value="special" {if $.get.rarity? AND $.get.rarity == 'special'}selected{/if}>Special</option>
                                <option value="amazing" {if $.get.rarity? AND $.get.rarity == 'amazing'}selected{/if}>Amazing</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-5 row">
                        <label class="col-12" for="attributes">{$attribute}</label>
                        <div class="col-lg-12">
                            <select class="form-control" id="attributes" name="attributes">
                                <option value="">{$ajax_filter_no_select}</option>
                                {foreach $att as $id => $att_info}
                                    <option value="{$id}" {if $.get.attributes? AND $.get.attributes == $id}selected{/if}>{$att_info}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group mb-5 row">
                <div class="col-12 text-right">
                    <button type="submit" class="btn btn-sm btn-alt-primary">
                        {$ajax_filter_search}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>