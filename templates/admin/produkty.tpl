<h1 class="clanek_title">EDITACE PRODUKTŮ {if !$selected_category_id}- VYBERTE POŽADOVANOU KATEGORII{elseif !$smarty.post.id_item}- VYBERTE PRODUKT{/if}</h1>
<div id="produkty">

	<div class="kategorie_vypis">
        {assign var=enable_fck value=true}
        <form action="" method="post">
			<input type="submit" name="category_type" value="kategorie" id="category" class="btn_kategorie {if $smarty.post.category_type=='značky'}sedy{/if}"/>
			<input type="submit" name="category_type" value="značky" id="manufacture" class="btn_znacky {if $smarty.post.category_type=='kategorie'}sedy{elseif $smarty.post.category_type=='značky'}{else}sedy{/if}"/>
		</form>
		<div class="cb"></div>

            {assign var=id_item value=$p_item.INFO->id_item}
            {assign var=lnk_base value="/admin/produkty/"}
			{include file="admin/eshop/seznam_kategorii_produkty.tpl"}
	</div>
	<div class="produkt_edit">

        {if $p_raw_items}
            <div class="varianty_detail_box">
                <h3>VYBERTE PRODUKT</h3>
				<form action="" method="post">
					<table class="nastaveni_doprava_table" border="0" cellpadding="0" cellspacing="0" style="width:370px;margin-top:0px;margin-left:0px;">
						<tr>
		        				<td>{html_options  name="id_item" options=$p_raw_items selected=$id_item onchange="submit()"}</td>
		        				<td><input type="submit" name="zobrazit" value="Zobrazit" class="produkty_pridat"/></td>
		        			</tr>
					</table>
				</form>
             </div>
        		{*if $category_id}
            		<table>
            			<tr>
            				<th>Filtr - počet nalezených položek: <span id="productsCount">-</span></th>
            			</tr>
            			<tr>
            				<td>
            					<form action="" method="post">
            					    <select id="productSelect" name="id_item">
            					       <option value="">Zadejte filtr</option>
            					    </select>
            						<input type="submit" name="zobZobrazitrazit" value="Zobrazit"/>

            					</form>
            				</td>
            			</tr>
            			<tr>
            			    <td>
                	            <input type="text" id="suggestField" />
                                <input type="button" value="Filtr" onclick="suggest()" />
            			    </td>
            			</tr>
            		</table>
        		{/if*}

        {/if}



        {assign var=item value=$p_item.INFO}
    	{if $id_item}
    		<h2>UPRAVIT PRODUKT - {$p_item.INFO->basename}</h2>

                {*if !$smarty.post.id_sub_sub_item}
                    <div class="varianty_detail_box">
                    <h3>VLOŽIT VARIANTU TOHOTO PRODUKTU - {$p_item.INFO->basename}</h3>
    				<form action="" method="post">
                        <table class="nastaveni_doprava_table" border="0" cellpadding="0" cellspacing="0" style="width:370px;margin-top:0px;margin-left:0px;">
    						<tr>
    							<th>Zobr</th>
    							<th>Název</th>
    							<th></th>
    						</tr>
    						<tr>
    							<td>{html_checkboxes name="item_visible" options=$s_yes_no selected=1 title="zobrazit/skryt"}</td>
    							<td><input type="text" name="name" class="nastaveni_doprava_input_delsi"/></td>
    							<td>
    								<input type="hidden" name="id_parent" value="{$p_item.INFO->id_item}">
    								<input type="hidden" name="id_item" value="{$smarty.post.id_item}"/>
    								<input type="hidden" name="id_sub_item" value="{$smarty.post.id_sub_item}"/>
    								<input type="hidden" name="id_sub_sub_item" value="{$smarty.post.id_sub_sub_item}"/>
    								<input type="submit" name="item_insert" value="Vložit" class="produkty_pridat"/>
    							</td>
    						</tr>
    					</table>
    				</form>
                    </div>

    			{/if*}

			<form  name="product_edit" action="" method="post" enctype="multipart/form-data">
                <table class="produkt_table" border="0" cellpadding="0" cellspacing="0">
                    {foreach from=$p_item.STEPS item=step}
    				{assign var=id_step value=$step.ID_STEP}
    				{if $SHOW_STEP_TITLES}
    					<tr align="left">
    						<th colspan="2">{$step.NAME} (záložka)</th>
    					</tr>
    				{/if}
    				{foreach from=$step.CATEGORIES item=category}
    					{assign var=id_category value=$category.ID_CATEGORY}
    					{if $SHOW_CATEGORY_TITLES}
    						<tr align="left">
    							<th colspan="2">&nbsp; => {$category.NAME} (kategorie vlastností)</th>
    						</tr>
    					{/if}
    					{foreach from=$category.PROPERTIES item=property}
    						{assign var=prop_name value=$property.PROP_NAME}
    						{assign var=prop_value value=$property.PROP_VALUE}
    						{if $p_item.INFO->id_parent} <!--  resime varianty  -->
    							{assign var=parent_prop_value value=$property.PROP_VALUE}
    							{assign var=prop_value value=$p_item_child.STEPS.$id_step.CATEGORIES.$id_category.PROPERTIES.$prop_name.PROP_VALUE}
    							{if !$prop_value and $prop_name or true}
    								{*
    								<tr class="deep_blue" valign="middle">
    									<th>převzato {$prop_name|translate} {if $property.PROP_UNIT}({$property.PROP_UNIT}){/if}</th>
    										<td valign="middle">{$prop_value}
    												{if $property.PROP_TYPE == "STRING"}{$parent_prop_value}{/if}
    												{if $property.PROP_TYPE == "TEXTAREA"}{$parent_prop_value|nl2br}{/if}
    												{if $property.PROP_TYPE == "S_CHECKBOX"}{html_checkboxes disabled=true name="name[$prop_name]" options=$property.PROP_ENUMERATION|@array_compact selected=$parent_prop_value|@enum_values}{/if}
    												{if $property.PROP_TYPE == "E_SELECT"}{html_options disabled=true name="name[$prop_name]" options=$property.PROP_ENUMERATION|@array_compact selected=$parent_prop_value|@enum_values}{/if}
    												{if $property.PROP_TYPE == "E_RADIO"}{html_radios disabled=true name="name[$prop_name]" options=$property.PROP_ENUMERATION|@array_compact selected=$parent_prop_value|@enum_values}{/if}
    												{if $property.PROP_TYPE == "FILE"}{/if}
    												{if $property.PROP_TYPE == "IMAGE"}
    													<a href="{$parent_prop_value.url}" target="_blank" class="image_property" rel="lightbox[roadtrip]" title="{$parent_prop_value.url}">
    														<img src="{$parent_prop_value.thumbnail_url}" alt="image" height="50"/>
    													</a>
    												{/if}
    										</td>
    								</tr>
    								*}
    								{if $p_item.INFO->FIRST_MAIN_CATEGORY|in_array:$property.PROPERTY_CATEGORY_MAPPING.VARIANT}
    									<tr valign="middle">
    										<th>{$prop_name|translate} {if $property.PROP_UNIT}({$property.PROP_UNIT}){/if}</th>
    										<td valign="middle">
    												{if $property.PROP_TYPE == "STRING"}<input type="text" name="name[{$prop_name}]" value="{$prop_value}" class="produkt_input_delsi"/>{/if}
    												{if $property.PROP_TYPE == "TEXTAREA"}
    													{if $enable_fck}
                                                            <div class="text_produkty">
                                                                {fckeditor BasePath="/fckeditor/" InstanceName="name[$prop_name]" Value=$prop_value Width="450px" Height="150px" ToolbarSet="Basic"}
                                                            </div>
    													{else}
    													    <div class="text_produkty">
    														  <textarea name="name[{$prop_name}]">{$prop_value}</textarea>
    														</div>
    													{/if}
    												{/if}
    												{if $property.PROP_TYPE == "S_CHECKBOX"}
    													<input type="hidden" name="name[{$prop_name}]" value="">
    													{html_checkboxes name="name[$prop_name]" options=$property.PROP_ENUMERATION|@array_compact selected=$prop_value|@enum_values separator='<br />'}
    												{/if}
    												{if $property.PROP_TYPE == "E_SELECT"}{html_options name="name[$prop_name]" options=$property.PROP_ENUMERATION|@array_compact selected=$prop_value|@enum_values}{/if}
    												{if $property.PROP_TYPE == "E_RADIO"}{html_radios name="name[$prop_name]" options=$property.PROP_ENUMERATION|@array_compact|translate selected=$prop_value|@enum_values}{/if}
    												{if $property.PROP_TYPE == "FILE"}
    													<input type="file" name="name[{$prop_name}]" value="{$prop_value}"/>
    													{if $prop_value}
    														<a href="{$prop_value}" target="_blank" class="file_property">{$prop_value}</a>
    														<input type="checkbox" name="name[{$prop_name}]" value="_delete_file_">smazat
    													{/if}
    												{/if}
    												{if $property.PROP_TYPE == "IMAGE"}
    													<input type="file" name="name[{$prop_name}]" value="{$prop_value.thumbnail_url}"/>
    													{if $prop_value}
    														<a href="{$prop_value.url}" target="_blank" class="image_property" rel="lightbox[roadtrip]" title="{$prop_value.url}"><img src="{$prop_value.thumbnail_url}" alt="image" height="50"/></a>
    														<input type="checkbox" name="name[{$prop_name}]" value="_delete_file_">smazat
    													{/if}
    												{/if}
    										</td>
    									</tr>
    								{/if}
    							{/if}
    						{else}
    							<tr valign="middle">
    								<th>{$prop_name|translate} {if $property.PROP_UNIT}({$property.PROP_UNIT}){/if}</th>
    								<td valign="middle">
    										{if $property.PROP_TYPE == "STRING"}<input type="text" name="name[{$prop_name}]" value="{$prop_value}" class="produkt_input_delsi"/>{/if}
    										{if $property.PROP_TYPE == "TEXTAREA"}
    										    {if $enable_fck}
                                                    <div class="text_produkty">
                                                        {fckeditor BasePath="/fckeditor/" InstanceName="name[$prop_name]" Value=$prop_value Width="450px" Height="150px" ToolbarSet="Basic"}
                                                    </div>
                                                {else}
                                                    <div class="text_produkty">
                                                        <textarea name="name[{$prop_name}]">{$prop_value}</textarea>
    												</div>
    										    {/if}
    										{/if}
    										{if $property.PROP_TYPE == "S_CHECKBOX"}
    											<input type="hidden" name="name[{$prop_name}]" value="">
    											{html_checkboxes name="name[$prop_name]" options=$property.PROP_ENUMERATION|@array_compact selected=$prop_value|@enum_values separator='<br />'}
    										{/if}
    										{if $property.PROP_TYPE == "E_SELECT"}{html_options name="name[$prop_name]" options=$property.PROP_ENUMERATION|@array_compact selected=$prop_value|@enum_values}{/if}
    										{if $property.PROP_TYPE == "E_RADIO"}{html_radios name="name[$prop_name]" options=$property.PROP_ENUMERATION|@array_compact|translate selected=$prop_value|@enum_values}{/if}
    										{if $property.PROP_TYPE == "FILE"}
    											<input type="file" name="name[{$prop_name}]" value="{$prop_value}"/>
    											{if $prop_value}
    												<a href="{$prop_value}" target="_blank" class="file_property">{$prop_value}</a>
    												<input type="checkbox" name="name[{$prop_name}]" value="_delete_file_">smazat
    											{/if}
    										{/if}
    										{if $property.PROP_TYPE == "IMAGE"}
    											<input type="file" name="name[{$prop_name}]" value="{$prop_value.thumbnail_url}"/>
    											{if $prop_value}
    												<a href="{$prop_value.url}" target="_blank" class="image_property" rel="lightbox[roadtrip]" title="{$prop_value.url}"><img src="{$prop_value.thumbnail_url}" alt="image" height="50"/></a>
    												<input type="checkbox" name="name[{$prop_name}]" value="_delete_file_">smazat
    											{/if}
    										{/if}
    								</td>
    							</tr>
    						{/if}
    					{/foreach}
    				{/foreach}
    			{/foreach}
    			</table>
				{if !$p_item.INFO->id_parent}
                    <div class="produkt_detail_kategorie">
                        <div class="produkt_detail_box">
                        	<h3>ZAŘAZENO V KATEGORIÍCH</h3>
                            {include file="admin/eshop/jstree.tpl" tree=$category_tree varname="id_category"}
                            {include file="admin/eshop/jstree.tpl" tree=$znacka_tree varname="id_category_manufacturers"}
                        </div>
                        <div class="produkt_detail_box">
                        	<h3>DOPORUČUJEME KOUPIT S KATEGORIÍ</h3>
                            {include file="admin/eshop/jstree.tpl" tree=$related_category_tree varname="id_related"}
                            {include file="admin/eshop/jstree.tpl" tree=$related_znacka_tree varname="id_related_manufacturers"}
                        </div>
                    </div>
                    <div class="produkt_detail_box" style="padding-top:20px;width:688px;border-top: 1px solid #9C9C9C;">
                        	<h3>DOPORUČUJEME KOUPIT S PRODUKTY</h3>
                            <div class="cb"></div>
                            <select name="id_related_item">
								{foreach from=$p_items_to_related item=r_item}
									<option value="{$r_item->id_item}">{$r_item->nazev}</option>
								{/foreach}
							</select>
							<input type="hidden" name="id_item_to_set_relates" value="{$id_item}"/>
							<input type="submit" name="do_add_related_item" value="Přidat" class="produkty_pridat"/>
                            <div class="cb"></div>
                            <select name="id_related_item_delete">
								{foreach from=$p_item.INFO->RELATED_ITEMS item=rel_item}
									<option value="{$p_items_to_related.$rel_item->id_item}">{$p_items_to_related.$rel_item->kod} {$p_items_to_related.$rel_item->nazev}</option>
								{/foreach}
							</select>
							<input type="hidden" name="id_item_to_set_relates_delete" value="{$id_item}"/>
							<input type="submit" name="do_del_related_item" class="produkty_odebrat" onclick="return confirm('Opravdu odebrat ?')" value="Odebrat"/>
							<div class="cb"></div>
                        {if $p_item.INFO->RELATED_ITEMS}
                            <h3>PŘIPOJENÉ PRODUKTY</h3>
                            <div class="cb"></div>
                            <ul class="pripojene_produkty">
                                {foreach from=$p_item.INFO->RELATED_ITEMS item=rel_item}
    								<li>{$p_items_to_related.$rel_item->kod} - {$p_items_to_related.$rel_item->nazev}<br/></li>
    							{/foreach}
    						</ul>
                        {/if}
                    </div>
				{/if}
				<h2>SYSTÉM</h2>
				<table class="nastaveni_doprava_table" border="0" cellpadding="0" cellspacing="0" style="width:688px;margin-left:0px;">
                    <tr>
    					<th>Zobr.</th>
                        <th>Název systém</th>
                        <th>Cena vč DPH</th>
                        <!-- <th>DPH</th> -->
                        <th>Skladem</th>
                        <th>Priorita</th>
                        {if !$p_item.INFO->id_parent}
    						<th>Výrobce</th>
    				    {/if}
    				</tr>
    				<tr>

                        <td>{html_checkboxes name="item_visible" options=$s_yes_no selected=$p_item.INFO->visible title="zobrazit/skryt"}</td>
                        <td><input type="text" name="basename" value="{$p_item.INFO->basename}" class="produkt_input_delsi"/></td>
                        <td><input type="text" name="price_vat" value="{$p_item.INFO->price_vat|round}" class="nastaveni_doprava_input_kratky"/></td>
                        <!-- <td>{html_radios name="id_dph" options=$s_dph selected=$p_item.INFO->id_dph}</td> -->
                        <td><input type="text" name="store" value="{$p_item.INFO->store}" class="nastaveni_doprava_input_kratky"/></td>
                        <td><input type="text" name="priority" value="{$p_item.INFO->priority}" class="nastaveni_doprava_input_kratky"/></td>
                        {if !$p_item.INFO->id_parent}
    						<td>{html_options name="manufacturer" options=$s_manufacturers selected=$p_item.INFO->id_manufacturer}</td>
    				    {/if}
    				</tr>
                </table>
				<div class="cb"></div>
                <div class="submit_produkt_box">
                    	<input type="hidden" name="prop_name" value="{$property.PROP_NAME}"/>
						<input type="hidden" name="id_item_to_edit" value="{$id_item}"/>
						<input type="hidden" name="id_item" value="{$smarty.post.id_item}"/>
						<input type="hidden" name="id_sub_item" value="{$smarty.post.id_sub_item}"/>
						<input type="hidden" name="id_sub_sub_item" value="{$smarty.post.id_sub_sub_item}"/>
						<input type="hidden" name="is_variant" value="{if $p_item.INFO->id_parent}true{/if}">
                        <!--<input type="hidden" name="item_edit" value="true" /> -->
						<input type="submit" name="item_property_edit" value="Upravit produkt" class="ulozit_upravy_tlac" style="margin-right:0px;margin-left:50px;"/>
                        </form>
                        <form sction="" method="post">
							<input type="hidden" name="id_item_to_edit" value="{$id_item}"/>
							<input type="submit" name="item_delete" value="Smazat produkt" class="smazat_tlac" onclick="return confirm('Opravdu smazat ?')" style="margin-right:0px;margin-left:50px;"/>
						</form>
               </div>
		{/if}




    </div>
</div>





{if $p_item_childs.1}
	<div style="float: left; padding: 5px; margin-right: 10px; border: solid 1px white; overflow: hidden;">
		<table>
			<tr>
				<th>Varianty produktu</th>
			</tr>
			{foreach from=$p_item_childs.1 item=item}
				<form action="" method="post">
				<tr class="deep_blue" style="border: solid 1px white;">
					<td class="btn_item" {if $item->id_item == $id_item} id="chosen"{/if}>
						<input type="hidden" name="id_item" value="{$smarty.post.id_item}"/>
						<input type="hidden" name="id_sub_item" value="{$item->id_item}"/>
						<input type="submit" name="item_detail_edit" value="{if $item->id_parent}=>{/if}{$item->basename}" class="btn_item"/>
					</td>
				</tr>
				</form>
			{/foreach}
		</table>
	</div>
{/if}
{if $p_item_childs.2}
	<div style="float: left; padding: 5px; margin-right: 10px; border: solid 1px white; overflow: hidden;">
		<table>
			<tr>
				<th>Varianty variant</th>
			</tr>
			{foreach from=$p_item_childs.2 item=item}
				<form action="" method="post">
				<tr class="deep_blue" style="border: solid 1px white;">
					<td class="btn_item" {if $item->id_item == $id_item} id="chosen"{/if}>
						<input type="hidden" name="id_item" value="{$smarty.post.id_item}"/>
						<input type="hidden" name="id_sub_item" value="{$smarty.post.id_sub_item}"/>
						<input type="hidden" name="id_sub_sub_item" value="{$item->id_item}"/>
						<input type="submit" name="item_detail_edit" value="{if $item->id_parent}=>{/if}{$item->basename}" class="btn_item"/>
					</td>
				</tr>
				</form>
			{/foreach}
		</table>
	</div>
{/if}






{literal}
<script type="text/javascript">


var $idKategorie = {/literal} {$category_id} {literal};

jQuery(document).ready(function(){
    jQuery('#suggestField').keypress(function($event){
        if($event.which == 13){
            suggest();
        }
    });
});

function suggest()
{
     jQuery.ajax({
            type: "POST",
            url: '/init.php?force_ajax=true&mode=suggestProducts',
            dataType: 'json',
            data: {text: jQuery('#suggestField').val(), idCategory: $idKategorie},
            success: function($return){
                jQuery('#productSelect').html($return.html);
                jQuery('#productsCount').html($return.celkem);
            }
        });
}



function ajax_add_related_item(id_item, id_related_item) {
	$('#loading').show();
	$.getJSON("/res/init.php?force_ajax=true&mode=add_related_item&id_item=" + id_image + "&id_related_item=" + id_related_item,
        function(data){
// 			$('a#full_image').fadeOut("slow");
			alert(data);
			$('a#full_image').css({'background-image' : 'url(' + data.image_path + data.preview_image + ')'});
			$('#image_description').html(data.description);
			$('#image_name').html(data.name);
			$('a#full_image').attr("href",data.image_path + data.detail_image );
			$('a#full_image').attr("title",data.name);
			$('a#full_image').css({'height' : data.preview_height + 'px'});
			Shadowbox.setup();
// 			$('a#full_image').fadeIn("slow");
			$('#loading').hide();
			//$('.c_detail').corner();
			return false;
        });


}




function is_stupid() {
	var ie = false;
	if (navigator.appName=="Microsoft Internet Explorer") ie = true;

	return ie;
}

function element_open(element) {
	if (is_stupid()) {
		element.parentNode.parentNode.childNodes[3].style.display = 'block';
		element.parentNode.parentNode.childNodes[0].childNodes[0].style.backgroundPosition = '-9px bottom';
	} else {
        element.parentNode.parentNode.childNodes.item(5).style.display = 'block';
		element.parentNode.parentNode.childNodes.item(1).childNodes.item(1).style.backgroundPosition = '-9px bottom';
	}
}
function element_close(element) {
	if (is_stupid()) {
		element.parentNode.parentNode.childNodes[3].style.display = 'none';
		element.parentNode.childNodes[0].style.backgroundPosition = '0px bottom';
	} else {
        element.parentNode.parentNode.childNodes.item(5).style.display = 'none';
		element.parentNode.childNodes.item(1).style.backgroundPosition = '0px bottom';
	}
}

function open_tree(element) {
	if (is_stupid()) {
		if (element.parentNode.parentNode.parentNode.childNodes[0].parentNode.parentNode.childNodes[3] != null && element.parentNode.parentNode.parentNode.childNodes[0].parentNode.parentNode.childNodes[0].childNodes[0].style != null) {
			var working_element = element.parentNode.parentNode.parentNode.childNodes[0];
			if (working_element.id != null) {
				element_open(working_element);
				open_tree(working_element);
			}
		}
	} else {
		if (element.parentNode.parentNode.parentNode.childNodes.item(1).parentNode.parentNode.childNodes.item(5) != null && element.parentNode.parentNode.parentNode.childNodes.item(1).parentNode.parentNode.childNodes.item(1).childNodes.item(1) != null) {
			var working_element = element.parentNode.parentNode.parentNode.childNodes.item(1);
			if (working_element.id != null && working_element.name != "root_elem") {
				element_open(working_element);
				open_tree(working_element);
			}
		}
	}
}

function element_change(element) {
	if (is_stupid()) {
		if (element.parentNode.parentNode.childNodes[3].style.display == null || element.parentNode.parentNode.childNodes[3].style.display == 'block') {
			element_close(element);
		} else {
			element_open(element);
		}
	} else {
		if (element.parentNode.parentNode.childNodes.item(5).style.display == 'block') {
			element_close(element);
		} else {
			element_open(element);
		}
	}
}

	</script>
{/literal}

