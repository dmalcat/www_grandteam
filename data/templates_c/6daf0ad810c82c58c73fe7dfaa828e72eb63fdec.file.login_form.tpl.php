<?php /* Smarty version Smarty-3.0.7, created on 2018-10-07 01:50:24
         compiled from "/data/www/3nicom.cloud/subdomains/grandteam/templates/admin/login_form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4563071995bb94a4002ac34-48193569%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6daf0ad810c82c58c73fe7dfaa828e72eb63fdec' => 
    array (
      0 => '/data/www/3nicom.cloud/subdomains/grandteam/templates/admin/login_form.tpl',
      1 => 1538867450,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4563071995bb94a4002ac34-48193569',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="login_form">
	<h1>
		<a href="http://www.3nicom.cz/" title="3nicom"></a>
	</h1>
	<div class="cb"></div>
	<div class="login_form_nadpis">administrační rozhraní</div>
	<div class="cb"></div>

	<h2><?php echo ((mb_detect_encoding(Registry::getDomainName(), 'UTF-8, ISO-8859-1') === 'UTF-8') ? mb_strtoupper(Registry::getDomainName(),SMARTY_RESOURCE_CHAR_SET) : strtoupper(Registry::getDomainName()));?>
 ADMINISTRACE</h2>

	<?php if ($_smarty_tpl->getVariable('dbUser')->value->id){?>
		<div class="login_form_nadpis" style="font-size: 12px; text-align: center; margin-top: 0px;">
			Přihlášený uživatel <?php echo $_smarty_tpl->getVariable('dbUser')->value->login;?>
 <a href="/logout">odhlásit</a>
		</div>
	<?php }?>

	<form action="/admin/" method="post" id="prihlaseni">
		<label class="login_form_label">Jméno</label>
		<div class="login_form_input">
			<input type="text" name="login_user" class="validate[required]" id="login_user"/>
		</div>
		<label class="login_form_label">Heslo</label>
		<div class="login_form_input">
			<input type="password" name="login_pass" class="validate[required]" id="login_pass"/>
		</div>
		<input type="submit" name="submit" value="Přihlásit do administrace" class="login_form_submit"/>
	</form>
</div>
