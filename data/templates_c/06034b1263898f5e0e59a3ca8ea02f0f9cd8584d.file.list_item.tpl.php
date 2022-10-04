<?php /* Smarty version Smarty-3.0.7, created on 2018-10-06 22:53:35
         compiled from "/data/www/grandteam.3n/templates/boxes/list_item.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5023400175bb93cef67bb07-89534073%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '06034b1263898f5e0e59a3ca8ea02f0f9cd8584d' => 
    array (
      0 => '/data/www/grandteam.3n/templates/boxes/list_item.tpl',
      1 => 1538866413,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5023400175bb93cef67bb07-89534073',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_smarty_tpl->getVariable('item')->value){?>
    <div class="item_seznam_a" onclick="window.location.href = '<?php echo $_smarty_tpl->getVariable('item')->value->getUrl();?>
'">
        <div class="item_seznam" data-image-src="<?php echo $_smarty_tpl->getVariable('item')->value->getImage(1,"detail")->src;?>
">
            <div class="bottom">
                <h2 style="background-color: <?php echo $_smarty_tpl->getVariable('item')->value->getColor();?>
"><?php echo $_smarty_tpl->getVariable('item')->value->name;?>
</h2>
                <div class="green">
                    <?php if ($_smarty_tpl->getVariable('categoryName')->value){?>
                        <div class="category">
                            <span class="content_category cc_<?php echo $_smarty_tpl->getVariable('categoryId')->value;?>
"><?php echo $_smarty_tpl->getVariable('categoryName')->value;?>
</span>
                        </div>
                    <?php }elseif($_smarty_tpl->getVariable('item')->value->getCategory()){?>
                        <div class="category">
                            <span class="content_category cc_<?php echo $_smarty_tpl->getVariable('item')->value->getCategory();?>
"><?php echo $_smarty_tpl->getVariable('item')->value->getCategory(true);?>
</span>
                        </div>
                    <?php }?>
                    <div class="description">
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }?>