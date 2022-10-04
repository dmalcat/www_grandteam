<?php /* Smarty version Smarty-3.0.7, created on 2019-01-09 08:04:28
         compiled from "/data/www/grandteam.cz/public_html/templates/admin/seznam_clanku.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5812907515c359cfc067c15-84143640%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fa5f88cbe5e8a59a9ce131ce07f80e13c485a829' => 
    array (
      0 => '/data/www/grandteam.cz/public_html/templates/admin/seznam_clanku.tpl',
      1 => 1538867450,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5812907515c359cfc067c15-84143640',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="accordion" data-content_type="<?php echo $_smarty_tpl->getVariable('idContentType')->value;?>
">
	<?php if ($_smarty_tpl->getVariable('filterContentCategory')->value=='filterZajimavosti'){?>
		<?php $_smarty_tpl->tpl_vars['from'] = new Smarty_variable(dbContentCategory::getZajimavosti(), null, null);?>
	<?php }elseif($_smarty_tpl->getVariable('filterContentCategory')->value=='filterAktuality'){?>
		<?php $_smarty_tpl->tpl_vars['from'] = new Smarty_variable(dbContentCategory::getAktuality(), null, null);?>
	<?php }else{ ?>
		<?php $_smarty_tpl->tpl_vars['from'] = new Smarty_variable(dbContentCategory::getAll(null)->sort('priority'), null, null);?>
	<?php }?>
	<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('from')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
	<?php if ($_smarty_tpl->getVariable('dbUser')->value->isAllowed('editovat',$_smarty_tpl->getVariable('item')->value->id)){?>
		<div id="accordion_item_<?php echo $_smarty_tpl->getVariable('item')->value->id;?>
" class="ac_item <?php if (dbContentCategory::getSubcategoriesCount(null,$_smarty_tpl->getVariable('item')->value->id)>0){?>parent<?php }?>">
			<?php $_template = new Smarty_Internal_Template("admin/_accordion_item.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
		</div>
	<?php }?>
    <?php }} ?>
</div>

<script type="text/javascript">
$(document).ready(function(){

	$(document).on("click", "h3.bg", function(e){
		e.preventDefault();
		//	console.log((e.target || e.eventSrc).nodeName);
			//	magie k zastaveni propagace u nechtenych elementu
		if( ( ( (e.target || e.eventSrc).nodeName) != "H3") && ( ( (e.target || e.eventSrc).nodeName) != "SPAN") )return 0;
		//	console.log(e);
		$clicked = $(this);
		$clicked.toggleClass("expanded");
		var level = 0;
		$rodic = $clicked;
			//	jak jsme hluboko?
		while(!$rodic.parent().hasClass("ac_item")){
			$rodic = $rodic.parent();
			level++;
		}

		if($clicked.parent().hasClass("parent") && !$clicked.find(".ikona > span").hasClass("ui-icon-triangle-1-e")){
				//	expanded = rozvinuty
			if($clicked.hasClass("expanded")){
				$clicked.parent().children(".appended").slideDown("fast");
				$clicked.find(".ikona span").removeClass("ui-icon ui-icon-circle-plus");
				$clicked.find(".ikona span").addClass("ui-icon ui-icon-circle-minus");
			}else{
				$clicked.parent().children(".appended").slideUp("fast");
				$clicked.find(".ikona span").removeClass("ui-icon ui-icon-circle-minus");
				$clicked.find(".ikona span").addClass("ui-icon ui-icon-circle-plus");
			}
		}


		var id = $clicked.attr("data-id");
		var content_type = $("#accordion").attr("data-content_type");
		$.ajax({
			url: "/res/ajax.php?mode=fetchSub",
			type: "POST",
			dataType: "json",
			data: { id_item: id, level: level, content_type: content_type },
			success: function(data){
				//	console.log(data);
				if(!$clicked.next().hasClass("appended")){
					$.each(data.obsah, function(key, value){
						$clicked.after(value);
					});
				}
			},
			error: function(data){
				//	console.log(data);
			}
		});

	});

	$(document).on("change", ".contentCategoryType", function(e){
		e.preventDefault();
		$vybrano = $(this);
			//	slozitejsi kvuli dynamickemu DOMu
		$vybrana_option = $vybrano.find("option:selected");
		$nevybrane_option = $vybrano.find("option").not($vybrana_option);
		$nevybrane_option.attr("selected", false);
		$vybrana_option.attr("selected", true);
		$vybrano.prev("span").html($vybrana_option.html());
		//	console.log($vybrana_option);
		loading('show');
		$option = $(this);
		$.ajax({
			url: "/res/ajax.php?mode=setContentCategoryType",
			type: "GET",
			dataType: "json",
			data: { idContentCategory: $option.attr('rel'), type: $option.val() },
			success: function(data){
				successBox('Typ položky byl upraven.');
				//	console.log($option);
				loading('hide');
				//	window.location.reload();
			}
		});
		return 0;
	});

	<?php if ($_smarty_tpl->getVariable('dbCC')->value){?>
		<?php $_smarty_tpl->tpl_vars["counter"] = new Smarty_variable(300, null, null);?>
		<?php  $_smarty_tpl->tpl_vars['dbContentCategory'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('dbCC')->value->getNavigation(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['dbContentCategory']->key => $_smarty_tpl->tpl_vars['dbContentCategory']->value){
?>
			<?php if ($_smarty_tpl->getVariable('dbContentCategory')->value->id_parent){?>
				setTimeout( "rozbalClanky(<?php echo $_smarty_tpl->getVariable('dbContentCategory')->value->id_parent;?>
)", <?php echo $_smarty_tpl->getVariable('counter')->value;?>
 );
			<?php }?>
			<?php $_smarty_tpl->tpl_vars['counter'] = new Smarty_variable($_smarty_tpl->getVariable('counter')->value+300, null, null);?>
		<?php }} ?>
	<?php }?>
});

function rozbalClanky(id){
	$('h3.bg[data-id="'+id+'"]').click();
}
</script>
