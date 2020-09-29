<h2 class="content-heading">Последнии товары</h2>

<div class="block rounded">
    <ul class="nav nav-tabs nav-tabs-alt" data-toggle="tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" href="#armor">Броня</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#weapon">Оружие</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#jewelry">Бижутерия</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#consumables">Расходники</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#coin">Адена</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#character">Персонажи</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#etc">Другое</a>
        </li>
    </ul>

    <div class="block-content tab-content p-0">
        <div class="tab-pane active" id="armor" role="tabpanel">
            <div class="table-responsive">
                <table class="table table-hover table-vcenter">
                    <tbody>
                        <tr>
                            {$.php.set_item(4037,false,false,'<td width="32"><img data-item="57" src="%icon%" width="32px" data-toggle="popover" data-placement="left" data-content="%description%" data-original-title="%name% %add_name%"></td><th>%name% %add_name%</th>')}
                            <td class="text-center">
                                <p class="text-muted mb-0">Заточка</p>
                                <p class="font-w600 mb-0">+5</p>
                            </td>
                            <td class="text-center" data-toggle="popover" title="Аугментация" data-placement="right" data-html="true" data-content="Wild Magic 10 lvl" data-original-title="Аугментация">
                                <p class="text-muted mb-0">Аугментация</p>
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="aug_1" checked="" disabled>
                                    <label class="custom-control-label" for="aug_1" ></label>
                                </div>
                            </td>
                            <td class="text-center" data-toggle="popover" title="Атрибут" data-placement="left" data-html="true" data-content="Wild Magic 10 lvl" data-original-title="Атрибут">
                                <p class="text-muted mb-0">Атрибут</p>
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="att_1" disabled>
                                    <label class="custom-control-label" for="att_1"></label>
                                </div>
                            </td>
                            <td class="text-center">
                                <p class="text-muted mb-0">РаР</p>
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="rar_1" checked="" disabled>
                                    <label class="custom-control-label" for="rar_1"></label>
                                </div>
                            </td>
                            <td class="text-center">
                                <p class="text-muted mb-0">Цена</p>
                                <p class="font-w600 mb-0">250</p>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-primary">
                                        Купить
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane" id="weapon" role="tabpanel">
            <h4 class="font-w400">Profile Content</h4>
            <p>...</p>
        </div>
        <div class="tab-pane" id="jewelry" role="tabpanel">
            <h4 class="font-w400">Profile Content</h4>
            <p>...</p>
        </div>
        <div class="tab-pane" id="consumables" role="tabpanel">
            <h4 class="font-w400">Profile Content</h4>
            <p>...</p>
        </div>
        <div class="tab-pane" id="coin" role="tabpanel">
            <h4 class="font-w400">Profile Content</h4>
            <p>...</p>
        </div>
        <div class="tab-pane" id="character" role="tabpanel">


            <div class="table-responsive">
                <table class="table table-hover table-vcenter">
                    <tbody>
                    <tr>
                        <td width="32">
                            <img data-item="57" src="{$.site.dir_panel}/assets/media/market/character/RankingWnd_FaceIcon_Darkelf_magician_M.png" width="32px">
                        </td>
                        <th>Demort</th>

                        <td class="text-center">
                            <p class="text-muted mb-0">Уровень</p>
                            <p class="font-w600 mb-0">76</p>
                        </td>
                        <td class="text-center">
                            <p class="text-muted mb-0">Класс</p>
                            <p class="font-w600 mb-0">Spellsinger</p>
                        </td>
                        <td class="text-center">
                            <p class="text-muted mb-0">Нублес</p>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="nub_1" checked="" disabled>
                                <label class="custom-control-label" for="nub_1" ></label>
                            </div>
                        </td>
                        <td class="text-center">
                            <p class="text-muted mb-0">Геройство</p>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="hero_1" disabled>
                                <label class="custom-control-label" for="hero_1"></label>
                            </div>
                        </td>
                        <td class="text-center"  data-toggle="popover" title="Сабкласс" data-placement="left" data-html="true" data-content="Necromancer LvL:45<br>Spectral Dancer LvL:65<br>Warsmith LvL:75" data-original-title="Атрибут">
                            <p class="text-muted mb-0">Сабкласс</p>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="sub_1" checked="" disabled>
                                <label class="custom-control-label" for="sub_1"></label>
                            </div>
                        </td>
                        <td class="text-center">
                            <p class="text-muted mb-0">Цена</p>
                            <p class="font-w600 mb-0">250</p>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-primary">
                                    Купить
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>


        </div>
        <div class="tab-pane" id="etc" role="tabpanel">
            <h4 class="font-w400">Profile Content</h4>
            <p>...</p>
        </div>
    </div>
</div>