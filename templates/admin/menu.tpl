<h1 class="clanek_title">{if !$dbCC}NOVÁ POLOŽKA MENU{else}EDITACE POLOŽKY MENU - {$dbC->title_1}{/if}</h1>
<form action="" method="post" id="nova_polozka_menu" enctype="multipart/form-data">

	<div class="clanek_levy_sloupec">
		<span class="label">Název *</span>
		<div class="nazev_hd"></div>
		<div class="nazev_bg">
			<input type="text" name="nazev" value="{$dbCC->name}" class="validate[required]" id="nazev"/>
		</div>
		<div class="nazev_ft"></div>

		<span class="label">Externí odkaz / emailová adresa</span>
		<div class="nazev_hd"></div>
		<div class="nazev_bg">
			<input type="text" name="external_url" value="{$dbCC->external_url}" class="" id="externi_url"/>
		</div>
		<div class="cb"></div>
		<div class="nazev_ft"></div>

	</div>

	<div class="clanek_pravy_sloupec">
		<table class="zarazeni_table" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td>ZAŘAZENÍ V MENU</td>
				<td style="padding-left:35px;">
					<select name="id_content_type">
						{foreach from=dbContentType::getAll() item=pContentType}
							<option value="{$pContentType->id}" {if $pContentType->id == $dbCC->id_content_type}selected="selected"{/if}{if !$dbCC && $pContentType->id == dbContentType::DEFAULT_ID_CONTENT_TYPE}selected="selected"{/if}>{$pContentType->name}</option>
						{/foreach}
					</select>
				</td>
			</tr>
			<tr>
				<td nowrap="nowrap">ZAŘAZENÍ V KATEGORII</td>
				<td style="padding-left:35px;">
					<select name="id_parent" id="id_content_category">
						<option value="">---</option>
						{foreach from=dbContentCategory::getAll(null, null, $dbCC->id_content_type) item=cat}
							<option value="{$cat->id}" {if $cat->id == $dbCC->id_parent|default:$smarty.get.parent} selected="true" {/if}>{$cat->name}</option>
							{foreach from=$cat->getSubCategories(null) item=sub_cat}
								<option value="{$sub_cat->id}" {if $sub_cat->id == $dbCC->id_parent|default:$smarty.get.parent} selected="true" {/if}>----{$sub_cat->name}</option>
								{foreach from=$sub_cat->getSubCategories(null) item=sub_sub_cat}
									<option value="{$sub_sub_cat->id}" {if $sub_sub_cat->id == $dbCC->id_parent|default:$smarty.get.parent} selected="true" {/if}>--------{$sub_sub_cat->name}</option>
									{foreach from=$sub_sub_cat->getSubCategories(null) item=sub_sub_sub_cat}
										<option value="{$sub_sub_sub_cat->id}" {if $sub_sub_sub_cat->id == $dbCC->id_parent|default:$smarty.get.parent} selected="true" {/if}>--------{$sub_sub_sub_cat->name}</option>
										{foreach from=$sub_sub_sub_cat->getSubCategories(null) item=sub_sub_sub_sub_cat}
											<option value="{$sub_sub_sub_sub_cat->id}" {if $sub_sub_sub_sub_cat->id == $dbCC->id_parent|default:$smarty.get.parent} selected="true" {/if}>------------{$sub_sub_sub_sub_cat->name}</option>
										{/foreach}
									{/foreach}

								{/foreach}
							{/foreach}
						{/foreach}
					</select>
				</td>
			</tr>
			{*<tr>
				<td>VIZITKA</td>
				<td style="padding-left:35px;">
					<select name="id_vizitka" id="id_content_category">
						<option value="">---</option>
						{foreach from=dbContentCategory::getAll(null, null, 4) item=cat}
							<option value="{$cat->id}" {if $cat->id == $dbCC->id_vizitka} selected="true" {/if}>{$cat->name}</option>
						{/foreach}
					</select>
				</td>
			</tr>*}
		</table>

		<table class="anotacni_obr_table" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<th style="text-align:left;padding-left:30px;">Anotační obrázek 1</th>
				<th><!--  Anotační obrázek 2 --></th>
				<th><!--  Anotační obrázek 3 --></th>
			</tr>
			<tr>
				<td>
					<div class="anotacni_obr">
						<a href="{dbContentCategory::IMAGES_PATH}{$dbCC->id}/{$dbCC->image_1}" rel="shadowbox[trip]">
							<div class="anotacni_obr_image" style="background-image:url({if $dbCC->image_1}{dbContentCategory::IMAGES_PATH}{$dbCC->id}/{$dbCC->image_1}{else}/images/admin/obr.png{/if});">
							</div>
						</a>
						<a href="javascript:void(0)" title="Přidat obrázek" class="anotacni_obr_pridat" id="upload_foto_1"></a>
						<a href="javascript:void(0)" title="Smazat obrázek" class="anotacni_obr_smazat" id="delete_foto_1"></a>
						<div id="div_upload_foto_1" class="ui-datepicker">
							<div class="ui-datepicker-header ui-widget-header ui-helper-clearfix ui-corner-all">
								<div class="ui-datepicker-title">Nahrát foto</div>
								<a class="ui-datepicker-next ui-corner-all" onclick="$('#div_upload_foto_1').hide();">
									<span class="ui-icon ui-icon-closethick"></span>
								</a>
							</div>
							<div style="width:250px;margin-top:10px;margin-left:5px;">
								<input type="file" name="content_category_image[]"/>
							</div>
						</div>
					</div>
				</td>
				<td>
					{*  <div class="anotacni_obr">
					<a href="{dbContentCategory::IMAGES_PATH}{$dbCC->id}/{$dbCC->image_2}" rel="shadowbox[trip]">
					<div class="anotacni_obr_image" style="background-image:url({if $dbCC->image_2}{dbContentCategory::IMAGES_PATH}{$dbCC->id}/{$dbCC->image_2}{else}/images/admin/obr.png{/if});">
					</div>
					</a>
					<a href="javascript:void(0)" title="Přidat obrázek" class="anotacni_obr_pridat" id="upload_foto_2"></a>
					<a href="javascript:void(0)" title="Smazat obrázek" class="anotacni_obr_smazat" id="delete_foto_2"></a>
					<div id="div_upload_foto_2" class="ui-datepicker">
					<div class="ui-datepicker-header ui-widget-header ui-helper-clearfix ui-corner-all">
					<div class="ui-datepicker-title">Nahrát foto</div>
					<a class="ui-datepicker-next ui-corner-all" onclick="$('#div_upload_foto_2').hide();">
					<span class="ui-icon ui-icon-closethick"></span>
					</a>
					</div>
					<div style="width:250px;margin-top:10px;margin-left:5px;">
					<input type="file" name="content_category_image[]"/>
					</div>
					</div>
					</div>*}
				</td>
				<td>
					{*<div class="anotacni_obr">
					<a href="{dbContentCategory::IMAGES_PATH}{$dbCC->id}/{$dbCC->image_3}" rel="shadowbox[trip]">
					<div class="anotacni_obr_image" style="background-image:url({if $dbCC->image_3}{dbContentCategory::IMAGES_PATH}{$dbCC->id}/{$dbCC->image_3}{else}/images/admin/obr.png{/if});">
					</div>
					</a>
					<a href="javascript:void(0)" title="Přidat obrázek" class="anotacni_obr_pridat" id="upload_foto_3"></a>
					<a href="javascript:void(0)" title="Smazat obrázek" class="anotacni_obr_smazat" id="delete_foto_3"></a>
					<div id="div_upload_foto_3" class="ui-datepicker">
					<div class="ui-datepicker-header ui-widget-header ui-helper-clearfix ui-corner-all">
					<div class="ui-datepicker-title">Nahrát foto</div>
					<a class="ui-datepicker-next ui-corner-all" onclick="$('#div_upload_foto_3').hide();">
					<span class="ui-icon ui-icon-closethick"></span>
					</a>
					</div>
					<div style="width:250px;margin-top:10px;margin-left:5px;">
					<input type="file" name="content_category_image[]"/>
					</div>
					</div>
					</div> *}
				</td>
			</tr>
		</table>

	</div>



	<div class="submit_box">
		{if $dbCC}
			<input type="hidden" name="id" value="{$dbCC->id}"/>
			<input type="hidden" name="visible" value="{$dbCC->visible}"/>
			<input type="hidden" name="menu" value="{$dbCC->menu}"/>
			<input type="hidden" name="priority" value="{$dbCC->priority}"/>
			<input type="submit" value="Uložit úpravy" name="do_clanek" class="ulozit_upravy_tlac" />
			<input type="submit" value="Smazat menu" class="smazat_tlac" />
		{else}
			<input type="hidden" name="menu" value="{dbContentCategory::TYPE_MENU}"/>
			<input type="submit" value="Vložit položku menu" name="do_clanek" class="ulozit_upravy_tlac pozice_uprostred" />
		{/if}

		<!--<input type="submit" value="Smazat položku menu" class="smazat_tlac" />-->
	</div>

</form>

<div class="dalsi_moznosti_title ui-accordion-header">
	<span class="ui-icon ui-icon-circle-plus"></span>
	DALŠÍ MOŽNOSTI
</div>
<div class="dalsi_moznosti_box" style="padding-bottom: 0px; margin-bottom: 20px;">
	{include file="admin/pripojene_fotogalerie.tpl"}
	{include file="admin/pripojene_videogalerie.tpl"}
	{include file="admin/pripojene_soubory.tpl"}
</div>
