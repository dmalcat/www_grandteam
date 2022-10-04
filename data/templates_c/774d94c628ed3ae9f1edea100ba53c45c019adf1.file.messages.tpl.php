<?php /* Smarty version Smarty-3.0.7, created on 2019-01-09 06:27:33
         compiled from "/data/www/grandteam.cz/public_html/templates/messages.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14913456255c35864543ddb8-03237765%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '774d94c628ed3ae9f1edea100ba53c45c019adf1' => 
    array (
      0 => '/data/www/grandteam.cz/public_html/templates/messages.tpl',
      1 => 1540920887,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14913456255c35864543ddb8-03237765',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_translate')) include '/data/www/grandteam.cz/public_html/res/classes/smarty/plugins/modifier.translate.php';
?><script type="text/javascript">
	<?php if ($_smarty_tpl->getVariable('error_message')->value){?>
	$(document).ready(function () {
			bootbox.alert("<?php echo $_smarty_tpl->getVariable('error_message')->value;?>
", function () {}
			);
		});
	<?php }?>
	<?php if ($_smarty_tpl->getVariable('success_message')->value){?>
		$(document).ready(function () {
				bootbox.alert("<?php echo $_smarty_tpl->getVariable('success_message')->value;?>
", function () {}
				);
			});
	<?php }?>
	<?php  $_smarty_tpl->tpl_vars['modal'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('modals')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['modal']->key => $_smarty_tpl->tpl_vars['modal']->value){
?>
			$(document).ready(function () {
				$('#<?php echo $_smarty_tpl->tpl_vars['modal']->value;?>
').modal('show');
			});
	<?php }} ?>
</script>


<div id="loginModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title"><?php echo smarty_modifier_translate('Přihlášení');?>
</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-5" >
						<p>
							<a href="/registrace" class="btn btn-primary btn-sm btn-block"><?php echo smarty_modifier_translate('Registrace');?>
</a><br />
							<a href="/registrace/ztracene_heslo" class="btn btn-sm btn-info btn-block"><?php echo smarty_modifier_translate('Zapomenuté heslo');?>
</a>
						</p>
					</div>

					<div class="col-md-7" style="border-left:1px solid #ccc; ">
						<form class="form-horizontal form-valid-no-scroll" method="post" action="">
							<fieldset>
								<input id="login" name="login_user" type="text" placeholder="přihlašovací jméno" class="form-control input-md validate[required, custom[email]]">
								<div style='height: 16px;'></div>
								<input id="heslo" name="login_pass" type="password" placeholder="heslo" class="form-control input-md validate[required]">
								<div style='height: 16px;'></div>
								<button id="singlebutton" name="singlebutton" class="btn btn-primary btn-sm pull-right">Přihlásit</button>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div id="addToCart" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addToCartLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title"><?php echo smarty_modifier_translate('Košík');?>
.</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12" >
						<p>
							Zboží bylo přídáno do košíku. <br />
						</p>
						<a href="#" data-dismiss="modal" data-target="#" class="btn btn-primary pull-left">zpět na zboží</a>
						<a href="/objednavka" class="btn btn-success pull-right">zobrazit košík</a>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>