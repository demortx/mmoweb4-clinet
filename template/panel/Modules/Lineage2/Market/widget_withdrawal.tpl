<div class="block block-fx-shadow">
    <div class="block-content">
        <form action="be_pages_crypto_buy_sell.html" method="post" onsubmit="return false;">
            <div class="form-group row">
                <label class="col-12" for="withdrawal-type">Способ вывода</label>
                <div class="col-12">
                    <select class="form-control form-control-lg" id="withdrawal-type" name="withdrawal_type" size="2">
                        <option value="ma" selected>На счет мастер аккаунта</option>
                        <option value="purse">На электронный кошелек, банковскую карту итд</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-12" for="delivery_method">Способ доставки</label>
                <div class="col-12">
                    <select class="form-control form-control-lg" id="delivery_method" name="delivery_method">
                        <option value="qiwi">Qiwi</option>
                        <option value="webmoney">WebMoney</option>
                        <option value="paypal">PayPal</option>
                        <option value="money_yandex">Яндекс деньги</option>
                        <option value="card">Card Visa, MasterCard</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-12" for="withdrawal_wallet">Номер кошелька или карты</label>
                <div class="col-12">
                    <div class="input-group input-group-lg">
                        <input type="text" class="form-control" id="withdrawal_wallet" name="wallet">
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-12" for="withdrawal_sum">Сумма вывода</label>
                <div class="col-12">
                    <div class="input-group input-group-lg">
                        <input type="number" min="200" class="form-control" id="withdrawal_sum" name="withdrawal_sum" placeholder="200">
                        <div class="input-group-append">
                            <span class="input-group-text font-w600">Unit</span>
                        </div>
                    </div>
                </div>
            </div>
            <hr>

            <div class="form-group row">
                <div class="col-12 text-center">
                    <div class="font-size-sm text-muted">
                        <i class="fa fa-clock-o"></i> <em>Время обработки вывода от 2х до 7ми суток, на счет мастер аккаунта моментально!</em>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12">
                    <button type="submit" class="btn btn-hero btn-lg btn-block btn-alt-primary">Создать заявку</button>
                </div>
            </div>
        </form>
    </div>
</div>