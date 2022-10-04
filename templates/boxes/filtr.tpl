

<div class="cenova_mapa">
    <div class="row">
        <div class="col-md-12">
            <form action="/cars" method="get" class="form-horizontal" id="cenova_mapa_form">
                <div>
                    <div class="row">
                        <div class="col-md-3">
                            Značka <span class="small" id="znacka_count"></span> <br/>
                            <select name="znacka[]" id="znacka" class="form-control dynamic" multiple data-onload-select2="" Xplaceholder="vyberte značku">
                                {foreach $smarty.get.znacka item=item} <option value="{$item}" selected="">{$item}</option> {/foreach}
                            </select>
                        </div>
                        <div class="col-md-2">
                            Model <span class="small" id="model_count"></span> <br/>
                            <select name="model[]" id="model" class="form-control dynamic" multiple data-onload-select2="" Xplaceholder="vyberte model">
                                {foreach $smarty.get.model item=item} <option value="{$item}" selected="">{$item}</option> {/foreach}
                            </select>
                        </div>

                        <div class="col-md-3">
                            Rok <br/>
                            <div class="input-group" >
                                <span class="input-group-addon">od</span>
                                <input id="rok_from" type="text" class="dynamic form-control " name="rok_from" value="{$smarty.get.rok_from}" placeholder="1980">
                                <span class="input-group-addon">do</span>
                                <input id="rok_to" type="text" class="dynamic form-control " name="rok_to" value="{$smarty.get.rok_to}" placeholder="{$smarty.now|date_format:'Y'}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            Cena <br/>
                            <div class="input-group" >
                                <span class="input-group-addon">od</span>
                                <input id="price_from" type="text" class="dynamic form-control " name="price_from" value="{$smarty.get.rok_from}" placeholder="0">
                                <span class="input-group-addon">do</span>
                                <input id="price_to" type="text" class="dynamic form-control " name="price_to" value="{$smarty.get.rok_to}" placeholder="">
                            </div>
                        </div>


                    </div>


                    <div class="row">
                        <div class="col-md-12 text-right">
                            <br />
                            <a href="/" class="btn btn-warning">Zrušit filtr</a>
                            <input type="submit" name="doFilter" value="Vyhledat" class="btn btn-primary" id="doMapa" />
                        </div>
                    </div>


                </div>
            </form>
        </div>
    </div>
</div>
