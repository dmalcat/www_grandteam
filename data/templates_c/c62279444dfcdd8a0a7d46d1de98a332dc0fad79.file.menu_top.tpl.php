<?php /* Smarty version Smarty-3.0.7, created on 2018-10-07 01:50:32
         compiled from "/data/www/3nicom.cloud/subdomains/grandteam/templates/admin/menu/menu_top.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5895983055bb94a48974c62-29755983%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c62279444dfcdd8a0a7d46d1de98a332dc0fad79' => 
    array (
      0 => '/data/www/3nicom.cloud/subdomains/grandteam/templates/admin/menu/menu_top.tpl',
      1 => 1538867450,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5895983055bb94a48974c62-29755983',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<ul id="top_menu_1">
	<?php if ($_smarty_tpl->getVariable('dbUser')->value->isAllowed("SPRAVA OBSAHU")){?><li class="obsah"><a href="/admin/seznam_clanku" <?php if ($_smarty_tpl->getVariable('menuSelected')->value=="obsah"){?>class="top_menu_1_selected"<?php }?>>Články</a></li><?php }?>
	<?php if ($_smarty_tpl->getVariable('dbEshop')->value->getEnabledCalendar()){?><li class="vnitrni_komunikace"><a href="/admin/kalendar_seznam" <?php if ($_smarty_tpl->getVariable('menuSelected')->value=="kalendar"){?>class="top_menu_1_selected"<?php }?>>Kalendář</a></li><?php }?>
 	<?php if ($_smarty_tpl->getVariable('dbEshop')->value->getEnabledEshop()){?><li class="eshop"><a href="/admin/produkty" <?php if ($_smarty_tpl->getVariable('menuSelected')->value=="eshop"){?>class="top_menu_1_selected"<?php }?>>Eshop</a></li><?php }?>
 	<?php if ($_smarty_tpl->getVariable('dbEshop')->value->getEnabledEshop()){?><li class="objednavky"><a href="/admin/objednavky" <?php if ($_smarty_tpl->getVariable('menuSelected')->value=="objednavky"){?>class="top_menu_1_selected"<?php }?>>Objednávky</a></li><?php }?>
	<li class="odhlasit"><a href="/admin/logout/">Odhlásit</a></li>
</ul>
<ul id="top_menu_2">
	<?php if ($_smarty_tpl->getVariable('menuSelected')->value=="obsah"){?>
		<li class="clanky"><a href="/admin/seznam_clanku" <?php if ($_smarty_tpl->getVariable('par_2')->value=="seznam_clanku"){?>class="top_menu_2_selected"<?php }?>>Seznam článku</a></li>
		<li class="novy_clanek"><a href="/admin/clanek" <?php if ($_smarty_tpl->getVariable('par_2')->value=="clanek"){?>class="top_menu_2_selected"<?php }?>>Vytvořit článek</a></li>
		<li class="novy_clanek"><a href="/admin/menu" <?php if ($_smarty_tpl->getVariable('par_2')->value=="menu"){?>class="top_menu_2_selected"<?php }?>>Vytvořit položku</a></li>
		<li class="galerie"><a href="/admin/seznam_fotogalerii" <?php if ($_smarty_tpl->getVariable('par_2')->value=="seznam_fotogalerii"){?>class="top_menu_2_selected"<?php }?>>Seznam fotogalerií</a></li>
		<li class="nova_galerie"><a href="/admin/fotogalerie" <?php if ($_smarty_tpl->getVariable('par_2')->value=="fotogalerie"){?>class="top_menu_2_selected"<?php }?>>Vytvořit fotogalerii</a></li>
		<li class="dokumenty"><a href="/admin/seznam_dokumentu" <?php if ($_smarty_tpl->getVariable('par_2')->value=="seznam_dokumentu"){?>class="top_menu_2_selected"<?php }?>>Seznam dokumentů</a></li>
		<li class="nove_dokumenty"><a href="/admin/dokumenty" <?php if ($_smarty_tpl->getVariable('par_2')->value=="dokumenty"){?>class="top_menu_2_selected"<?php }?>>Vytvořit dokumenty</a></li>
	<?php }elseif($_smarty_tpl->getVariable('menuSelected')->value=="uzivatele"){?>
		<li class="seznam_uzivatelu"><a href="/admin/uzivatele" <?php if ($_smarty_tpl->getVariable('par_2')->value=="uzivatele"){?>class="top_menu_2_selected"<?php }?>>Seznam uživatelů</a></li>
		<li class="novy_uzivatel"><a href="/admin/novy_uzivatel" <?php if ($_smarty_tpl->getVariable('par_2')->value=="novy_uzivatel"){?>class="top_menu_2_selected"<?php }?>>Nový uživatel</a></li>
		<li class="seznam_uzivatelu"><a href="/admin/uzivatele_log" <?php if ($_smarty_tpl->getVariable('par_2')->value=="uzivatele_log"){?>class="top_menu_2_selected"<?php }?>>Statistika příhlášení</a></li>
		        <li class="role"><a href="/admin/users_export" target="_blank">Export uživatelů</a></li>
		<?php if ($_smarty_tpl->getVariable('dbUser')->value->isAdmin()){?><li class="role"><a href="/admin/role" <?php if ($_smarty_tpl->getVariable('par_2')->value=="role"){?>class="top_menu_2_selected"<?php }?>>Uživatelské role</a></li><?php }?>
		<li class="seznam_uzivatelu"><a href="/admin/dotazy" <?php if ($_smarty_tpl->getVariable('par_2')->value=="dotazy"){?>class="top_menu_2_selected"<?php }?>>Uživatelské dotazy</a></li>
		<li class="seznam_uzivatelu"><a href="/admin/prodejny" <?php if ($_smarty_tpl->getVariable('par_2')->value=="prodejny"){?>class="top_menu_2_selected"<?php }?>>Seznam prodejen</a></li>
		<?php if ($_smarty_tpl->getVariable('dbEshop')->value->getEnabledEshop()){?><li class="role"><a href="/admin/role" <?php if ($_smarty_tpl->getVariable('par_2')->value=="role"){?>class="top_menu_2_selected"<?php }?>>Nastavení slev</a></li><?php }?>
    <?php }elseif($_smarty_tpl->getVariable('menuSelected')->value=="newsletter"){?>
		<li class="clanky"><a href="/admin/seznam_newsletter" <?php if ($_smarty_tpl->getVariable('par_2')->value=="seznam_newsletter"){?>class="top_menu_2_selected"<?php }?>>Seznam newsletterů</a></li>
		<li class="dokumenty"><a href="/admin/newsletter" <?php if ($_smarty_tpl->getVariable('par_2')->value=="newsletter"){?>class="top_menu_2_selected"<?php }?>>Nový newsletter</a></li>
    <?php }elseif($_smarty_tpl->getVariable('menuSelected')->value=="kalendar"){?>
		<li class="clanky"><a href="/admin/kalendar_seznam" <?php if ($_smarty_tpl->getVariable('par_2')->value=="kalendar_seznam"){?>class="top_menu_2_selected"<?php }?>>Seznam událostí</a></li>
		<li class="novy_clanek"><a href="/admin/kalendar" <?php if ($_smarty_tpl->getVariable('par_2')->value=="kalendar"){?>class="top_menu_2_selected"<?php }?>>Vytvořit událost</a></li>
	<?php }elseif($_smarty_tpl->getVariable('menuSelected')->value=="eshop"){?>
		<li class="clanky"><a href="/admin/kategorie_produktu" <?php if ($_smarty_tpl->getVariable('par_2')->value=="kategorie_produktu"){?>class="top_menu_2_selected"<?php }?>>Kategorie produktů</a></li>
		<li class="dokumenty"><a href="/admin/produkty" <?php if ($_smarty_tpl->getVariable('par_2')->value=="produkty"){?>class="top_menu_2_selected"<?php }?>>Produkty</a></li>
		<li class="sklad"><a href="/admin/sklad" <?php if ($_smarty_tpl->getVariable('par_2')->value=="sklad"){?>class="top_menu_2_selected"<?php }?>>Sklad</a></li>
		<li class="novy_clanek"><a href="/admin/kupony" <?php if ($_smarty_tpl->getVariable('par_2')->value=="kupony"){?>class="top_menu_2_selected"<?php }?>>Slevové kupóny</a></li>
	<?php }elseif($_smarty_tpl->getVariable('menuSelected')->value=="nastaveni"){?>
		<?php if ($_smarty_tpl->getVariable('dbEshop')->value->getEnabledEshop()){?><li class="clanky"><a href="/admin/meny" <?php if ($_smarty_tpl->getVariable('par_2')->value=="meny"){?>class="top_menu_2_selected"<?php }?>>Měny</a></li><?php }?>
		<?php if ($_smarty_tpl->getVariable('dbEshop')->value->getEnabledEshop()){?><li class="clanky"><a href="/admin/doprava" <?php if ($_smarty_tpl->getVariable('par_2')->value=="doprava"){?>class="top_menu_2_selected"<?php }?>>Dopravy</a></li><?php }?>
		<?php if ($_smarty_tpl->getVariable('dbEshop')->value->getEnabledEshop()){?><li class="clanky"><a href="/admin/platba" <?php if ($_smarty_tpl->getVariable('par_2')->value=="platba"){?>class="top_menu_2_selected"<?php }?>>Platby</a></li><?php }?>
		<?php if ($_smarty_tpl->getVariable('dbEshop')->value->getEnabledEshop()){?><li class="clanky"><a href="/admin/doprava_platba" <?php if ($_smarty_tpl->getVariable('par_2')->value=="doprava_platba"){?>class="top_menu_2_selected"<?php }?>>Doprava => Platba</a></li><?php }?>
		<?php if ($_smarty_tpl->getVariable('dbEshop')->value->getEnabledEshop()){?><li class="clanky"><a href="/admin/dodavatele" <?php if ($_smarty_tpl->getVariable('par_2')->value=="dodavatele"){?>class="top_menu_2_selected"<?php }?>>Dodavatelé</a></li><?php }?>
		<?php if ($_smarty_tpl->getVariable('dbEshop')->value->getEnabledEshop()){?><li class="clanky"><a href="/admin/ceniky" <?php if ($_smarty_tpl->getVariable('par_2')->value=="ceniky"){?>class="top_menu_2_selected"<?php }?>>Ceníky</a></li><?php }?>
		<li class="clanky"><a href="/admin/preklady" <?php if ($_smarty_tpl->getVariable('par_2')->value=="preklady"){?>class="top_menu_2_selected"<?php }?>>Překlady</a></li>
		<?php if ($_smarty_tpl->getVariable('dbEshop')->value->getEnabledEshop()){?><li class="clanky"><a href="/admin/vlastnosti" <?php if ($_smarty_tpl->getVariable('par_2')->value=="vlastnosti"){?>class="top_menu_2_selected"<?php }?>>Vlastnosti</a></li><?php }?>
	<?php }?>
</ul>