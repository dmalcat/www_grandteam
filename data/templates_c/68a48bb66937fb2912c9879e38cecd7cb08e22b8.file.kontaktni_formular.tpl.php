<?php /* Smarty version Smarty-3.0.7, created on 2019-01-09 06:27:33
         compiled from "/data/www/grandteam.cz/public_html/templates/kontaktni_formular.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17840420385c35864523af49-14717694%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '68a48bb66937fb2912c9879e38cecd7cb08e22b8' => 
    array (
      0 => '/data/www/grandteam.cz/public_html/templates/kontaktni_formular.tpl',
      1 => 1540921075,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17840420385c35864523af49-14717694',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
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
                            <textarea class="form-control" id="vzkaz" name="kontakt[vzkaz]" rows="2" style="height: 100px;" required=""><?php echo $_POST['kontakt']['vzkaz'];?>
</textarea>
                        </div>
                    </div>
                    <div class="form-group mt30">
                        <div class="col-md-11 col-md-offset-1 text-center">
                            <div class="g-recaptcha img-inline" data-sitekey="6LeU1HMUAAAAALPpyvvGCgbBoZdV0WHx-qcWOQjY"></div>
                        </div>
                        <div class="col-md-11 col-md-offset-1 text-center mt20">
                            <input type="hidden" name="kontakt[clanek]" value="<?php echo (($tmp = @$_smarty_tpl->getVariable('dbCC')->value->name)===null||$tmp==='' ? 'Úvodní stránka' : $tmp);?>
" />
                            <button type="submit" name="do_send_vzkaz" class="btn btn-default">Odeslat</button>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
