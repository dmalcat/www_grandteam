<div style="float: left; width:250px;">
	{if $ENABLE_LANGUAGES}
		<fieldset style="float: left; width:182px; padding:8px;">
			<legend>jazyk</legend>
			<form action="{$lnk_base}" method="post" style="float: left;">
			<select name="content_lang"  onchange="submit()" style="width:170px;">
				<option value="">vyberte</option>
					{foreach from=$p_content_langs item=p_content_lang}
						<option value="{$p_content_lang.id_content_lang}" {if $content_lang == $p_content_lang.id_content_lang} selected{/if}>{$p_content_lang.name}</option>
					{/foreach}
			</select>
			</form>
		</fieldset>
	{/if}
  <fieldset style="float: left; width:234px; margin-bottom:5px; padding:8px;">
    <legend>menu</legend>
    <form action="{$lnk_base}" method="post" style="float: left;">
      <select name="content_type"  onchange="submit()" style="width:230px;">
        <option value="">vyberte</option>
			{foreach from=$p_content_types item=p_content_type}
				<option value="{$p_content_type.id_content_type}" {if $content_type == $p_content_type.id_content_type} selected{/if}>{$p_content_type.name}</option>
			{/foreach}
      </select>
    </form>
  </fieldset>
  <div class="clear"></div>
  <div style="background-color:#FFF; border:solid 1px #333; padding-top:10px; padding-bottom:10px; margin-bottom:10px; float:left; ">
    <div class="menu_dir" style="width:250px;">
      <div class="menu_dir_nadpis"><a href="{$lnk_base}">položky menu</a></div>
      {assign var="lnk_base" value=$lnk_base}        
      {include file="admin/tpl_content/_content_categories_list.tpl"} 
     </div>
  </div>


	{if $ENABLE_GALLERIES}{include file="admin/sub_content_category_map_gallery.tpl"}{/if}
	{if $ENABLE_POLLS}{include file="admin/sub_content_category_map_poll.tpl"}{/if}
	{if $ENABLE_GALLERIES}{include file="admin/sub_content_category_map_gallery_list.tpl"}{/if}
	{if $ENABLE_POLLS}{include file="admin/sub_content_category_map_poll_list.tpl"}{/if}


</div>