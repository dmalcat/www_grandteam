<?php /* Smarty version Smarty-3.0.7, created on 2019-01-09 08:04:27
         compiled from "/data/www/grandteam.cz/public_html/templates/admin/fulltext_a_popisky_lista.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20469129355c359cfbda1482-32722747%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9d708b3601f24123310b7ee89cdc537a2756b885' => 
    array (
      0 => '/data/www/grandteam.cz/public_html/templates/admin/fulltext_a_popisky_lista.tpl',
      1 => 1538867450,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20469129355c359cfbda1482-32722747',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_select')) include '/data/www/grandteam.cz/public_html/res/classes/smarty/plugins/modifier.select.php';
if (!is_callable('smarty_function_html_options')) include '/data/www/grandteam.cz/public_html/res/classes/smarty/plugins/function.html_options.php';
if (!is_callable('smarty_function_html_options2')) include '/data/www/grandteam.cz/public_html/res/classes/smarty/plugins/function.html_options2.php';
if (!is_callable('smarty_function_html_checkboxes')) include '/data/www/grandteam.cz/public_html/res/classes/smarty/plugins/function.html_checkboxes.php';
?><div class="menu_clanky_popis">
	<!--TO DO opravit-->
	<?php if ($_smarty_tpl->getVariable('menuSelected')->value=="obsah"){?>
		<?php if ($_smarty_tpl->getVariable('par_2')->value=='seznam_clanku'&&!$_smarty_tpl->getVariable('par_3')->value){?>
			<div class="contentTypeSelect">
				<?php if (!$_smarty_tpl->getVariable('filterZajimavosti')->value||!$_smarty_tpl->getVariable('filterAktuality')->value){?>
					<form action="" method="post">
						Vyberte typ obsahu:
						<?php echo smarty_function_html_options(array('options'=>smarty_modifier_select(dbContentType::getAll(),'id','name'),'name'=>'idContentType','selected'=>$_smarty_tpl->getVariable('idContentType')->value,'onchange'=>"submit()"),$_smarty_tpl);?>

					</form>
				<?php }?>
			</div>
			<div class="contentTypeSelect">
				<form action="" method="post">
					Zobrazit:
					<select onchange="submit()" name="filterContentCategory">
						<option value="" <?php if (!$_smarty_tpl->getVariable('filterContentCategory')->value){?>selected="selected"<?php }?>>vše</option>
						<option value="filterAktuality" <?php if ($_smarty_tpl->getVariable('filterContentCategory')->value=='filterAktuality'){?>selected="selected"<?php }?>>aktuality</option>
						<option value="filterZajimavosti" <?php if ($_smarty_tpl->getVariable('filterContentCategory')->value=='filterZajimavosti'){?>selected="selected"<?php }?>>zajímavosti</option>
					</select>
				</form>
			</div>
		<?php }?>
		<div class="vyhledavani">
			<form method="post">
				<?php if ($_smarty_tpl->getVariable('par_2')->value=="seznam_fotogalerii"||$_smarty_tpl->getVariable('par_2')->value=="fotogalerie"||$_smarty_tpl->getVariable('par_2')->value=="seznam_dokumentu"||$_smarty_tpl->getVariable('par_2')->value=="dokumenty"||$_smarty_tpl->getVariable('par_2')->value=="editace_fotogalerie"){?>
					<input type="text" id="hledatFulltextGallery" value="" class="vyhledavani_input" />
				<?php }else{ ?>
					<input type="text" id="hledatFulltext" value="" class="vyhledavani_input" />
				<?php }?>
				<input type="button" value=" " id="vyhledatProdukty" class="vyhledavani_submit" />
			</form>
		</div>
		<div class="vyhledavani_popis">Vyhledávání:</div>
		<div class="cb"></div>
		<?php if ($_smarty_tpl->getVariable('par_2')->value=="seznam_clanku"){?>
				<div class="popis1">+/-</div>
				<div class="popis2">Název</div>
				<div class="popis3">Pořadí</div>
				<div class="popis4">Typ</div>
				<div class="popis5">Zobrazit</div>
				<div class="popis6">Zobrazit na HP</div>
				<div class="popis11">Aktuality</div>
				<div class="popis7">Newsletter</div>
				<div class="popis10">Přidat článek</div>
				<div class="popis8">Smazat</div>
				<div class="popis9">Datum</div>
		<?php }elseif($_smarty_tpl->getVariable('par_2')->value=="seznam_dokumentu"||$_smarty_tpl->getVariable('par_2')->value=="seznam_fotogalerii"){?>
			<div class="seznam_popis1">Název</div>
			<div class="seznam_popis2">Zobrazit</div>
			<div class="seznam_popis3">Editace obsahu</div>
			<div class="seznam_popis4">Upravit</div>
			<div class="seznam_popis5">Smazat</div>
			<div class="seznam_popis6">Datum</div>
		<?php }?>
	<?php }?>
	<?php if ($_smarty_tpl->getVariable('menuSelected')->value=="uzivatele"){?>
		<?php if ($_smarty_tpl->getVariable('par_2')->value=="prodejny"){?>
		<?php }?>
		<?php if ($_smarty_tpl->getVariable('par_2')->value=='uzivatele'){?>
			<form action="/admin/uzivatele/" method="post">
				<div class="vyhledavani">
					<input type="text" name="find_what" value="<?php echo $_POST['find_what'];?>
" class="vyhledavani_input"  id="hledatFulltextUser"/>
					<input type="hidden" name="user_search" value="true"/>
					<input type="submit" name="user_do_search" value=" " class="vyhledavani_submit"/>
				</div>
				<div class="vyhledavani_popis">hledat:</div>
				<div class="vyhledavani_uzivatele">
					<?php echo smarty_function_html_options(array('name'=>"find_where",'options'=>$_smarty_tpl->getVariable('s_user_list_properties')->value,'selected'=>$_POST['find_where']),$_smarty_tpl);?>

				</div>
				<div class="vyhledavani_popis">hledání podle:</div>
				<div class="vyhledavani_uzivatele">
					<?php echo smarty_function_html_options2(array('options'=>smarty_modifier_select(dbRole::getAll(),'id','name'),'name'=>'idRole','selected'=>$_POST['idRole'],'onchange'=>"submit()",'emptyLabel'=>"---vyberte---"),$_smarty_tpl);?>

				</div>
				<div class="vyhledavani_popis">Vybrat podle role:</div>
				<div class="cb"></div>
			</form>
		<?php }?>
		<?php if ($_smarty_tpl->getVariable('par_2')->value=='opravneni'){?>
			<div class="vyhledavani_uzivatele">
				<select id="vyberRoli">
					<option value="/admin/opravneni/">Vyberte roli</option>
					<?php  $_smarty_tpl->tpl_vars['role'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('vsechnyRole')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['role']->key => $_smarty_tpl->tpl_vars['role']->value){
?>
						<option	<?php if ($_smarty_tpl->getVariable('role')->value->id==$_smarty_tpl->getVariable('roleId')->value){?> selected="selected" <?php }?> value="/admin/opravneni/<?php echo $_smarty_tpl->getVariable('role')->value->id;?>
"><?php echo $_smarty_tpl->getVariable('role')->value->name;?>
</option>
					<?php }} ?>
				</select>
			</div>
			<div class="vyhledavani_popis">Vyberte roli uživatele:</div>
			<div class="cb"></div>
		<?php }?>
	<?php }?>
	<?php if ($_smarty_tpl->getVariable('menuSelected')->value=="kalendar"){?>
		<?php if ($_smarty_tpl->getVariable('par_2')->value=="kalendar_seznam"){?>
			<div class="seznam_kal_popis1">Název</div>
			<div class="seznam_kal_popis2">Typ akce</div>
			<div class="seznam_kal_popis2">Místo</div>
			<div class="seznam_kal_popis3">Zobrazit</div>
			<div class="seznam_kal_popis4">Datum od</div>
			<div class="seznam_kal_popis4">Datum do</div>
			<div class="seznam_kal_popis5">Upravit</div>
			<div class="seznam_kal_popis6">Smazat</div>
		<?php }?>
	<?php }?>
	<?php if ($_smarty_tpl->getVariable('menuSelected')->value=="newsletter"){?>
		<?php if ($_smarty_tpl->getVariable('par_2')->value=="seznam_newsletter"){?>
			<div class="seznam_newsletter_popis1">Název</div>
			<div class="seznam_newsletter_popis2">Upravit</div>
			<div class="seznam_newsletter_popis3">Smazat</div>
			<div class="seznam_newsletter_popis4">Datum </div>
		<?php }?>
	<?php }?>
	<?php if ($_smarty_tpl->getVariable('menuSelected')->value=="eshop"){?>
		<?php if ($_smarty_tpl->getVariable('par_2')->value=="produkty"){?>
			<form action="" method="post" style="float: left;">
				<table border="0" cellpadding="0" cellspacing="0" class="vlozit_produkt_table">
					<tr>
						<th>Zobr</th>
						<th>Název</th>
						<th></th>
					</tr>
					<tr>
						<td><?php echo smarty_function_html_checkboxes(array('name'=>"item_visible",'options'=>$_smarty_tpl->getVariable('s_yes_no')->value,'title'=>"zobrazit/skryt"),$_smarty_tpl);?>
</td>
						<td><input type="text" name="name" class="produkt_input_delsi"/></td>
						<td>
							<input type="submit" name="item_insert" value="Vložit" class="sklad_filtr"/>
						</td>
					</tr>
				</table>
				<div class="vyhledavani_popis" style="margin-top:5px;">Vložit produkt: &nbsp;&nbsp;&nbsp;</div>
				<div class="cb"></div>
			</form>
			<div style="float: right">
				Vyhledavání: <input type="text" id="hledatFulltextAdmin" value="" class="produkt_input_delsi"/><input type="button" value="Hledat" id="vyhledatProdukty" class="sklad_filtr">
			</div>
		<?php }?>
		<?php if ($_smarty_tpl->getVariable('par_2')->value=="sklad"){?>
			<form action="" method="post">
				<div class="vyhledavani_popis"><input type="submit" value="zobrazit" class="sklad_filtr" /></div>
				<div class="vyhledavani_uzivatele">
					<?php echo smarty_function_html_options(array('name'=>"id_category",'options'=>smarty_modifier_select(dbCategory::getAll(dbCategory::TYPE_CATEGORY),'id','name'),'selected'=>$_POST['id_category'],'onchange'=>"submit()"),$_smarty_tpl);?>


				</div>

				<div class="vyhledavani_popis">Vyberte kategorii nebo produkt:</div>
				<div class="cb"></div>
			</form>
		<?php }?>
	<?php }?>
</div>
<div class="cb"></div>

<div id="errorBox">
	<div id="errorBox_text"></div>
	<a href="javascript:void(0);" title="Zavřít" onclick="$('#errorBox').fadeOut(400);" class="tlacitko_zavrit"></a>
</div>
<div id="successBox">
	<div id="successBox_text"></div>
	<a href="javascript:void(0);" title="Zavřít" onclick="$('#successBox').fadeOut(400);" class="tlacitko_zavrit"></a>
</div>