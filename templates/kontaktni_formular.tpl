<div class="kontaktni_formular">
    <div class="row mt30">
        <form class="form-horizontal" action="" method="post"  id="form_kontaktni_formular">
            <fieldset>
                <div class="col-md-8 col-md-offset-2">
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="jmeno">Jméno <span class="text-red">*</span></label>
                        <div class="col-md-4">
                            <input id="jmeno" name="kontakt[jmeno]" type="text" placeholder="" class="form-control " required="">
                        </div>
                        <label class="col-md-2 control-label" for="telefon">Telefon  <span class="text-red">*</span></label>
                        <div class="col-md-4">
                            <input id="telefon" name="kontakt[telefon]" type="tel" placeholder="" class="form-control " value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="spolecnost">Společnost:</label>
                        <div class="col-md-4">
                            <input id="spolecnost" name="kontakt[spolecnost]" type="text" placeholder="" class="form-control " value="">
                        </div>
                        <label class="col-md-2 control-label" for="email">E-mail  <span class="text-red">*</span></label>
                        <div class="col-md-4">
                            <input id="email" name="kontakt[email]" type="email" placeholder="" class="form-control " required="" value="">
                        </div>
                    </div>
                    <div class="form-group mt30">
                        <label class="col-md-2 control-label" for="vzkaz">Zpráva  <span class="text-red">*</span></label>
                        <div class="col-md-10">
                            <textarea class="form-control" id="vzkaz" name="kontakt[vzkaz]" rows="2" style="height: 100px;" required="">{$smarty.post.kontakt.vzkaz}</textarea>
                            {*                            <div class="text-red text-right small">Položky označené * jsou povinné</div>*}
                        </div>
                    </div>
                    <div class="form-group mt30">
                        <div class="col-md-11 col-md-offset-1 text-center">
                            <div class="g-recaptcha img-inline" data-sitekey="6LeU1HMUAAAAALPpyvvGCgbBoZdV0WHx-qcWOQjY"></div>
                        </div>
                        <div class="col-md-11 col-md-offset-1 text-center mt20">
                            <input type="hidden" name="kontakt[clanek]" value="{$dbCC->name|default:'Úvodní stránka'}" />
                            <button type="submit" name="do_send_vzkaz" class="btn btn-default">Odeslat</button>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
