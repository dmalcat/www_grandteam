<h1 class="clanek_title">KATEGORIE PRODUKTŮ</h1>
<div id="kategorie_produktu">
	<div class="kategorie_vypis">
	        <form action="" method="post">
			<input type="submit" name="category_type" value="kategorie" id="category" class="btn_kategorie {if $smarty.post.category_type=='značky'}sedy{/if}"/>
			<input type="submit" name="category_type" value="značky" id="manufacture" class="btn_znacky {if $smarty.post.category_type=='kategorie'}sedy{elseif $smarty.post.category_type=='značky'}{else}sedy{/if}"/>
		</form>
		<div class="cb"></div>
			{assign var=lnk_base value="/admin/kategorie_produktu/"}
			{include file="admin/eshop/seznam_kategorii.tpl"}
		</div>
		<div class="kategorie_edit">
			{if $dbCategory}
				<h2>Upravit kategorii</h2>
				<form action="" method="post" enctype="multipart/form-data">

		                <div style="float:left;width:530px;">
					<div class="kategorie_label">Název kategorie *</div>
					<div class="nazev_hd" style="margin-left: 20px;"></div>
					<div class="nazev_bg" style="margin-left: 20px;"><input type="text" name="name" value="{$dbCategory->name}"/></div>
					<div class="nazev_ft" style="margin-left: 20px;"></div>
				</div>
				<div class="kategorie_label" style="width:120px;">
					Zobrazit<br />
					{html_checkboxes name="category_visible" options=$s_yes_no selected=$dbCategory->visible  title="zobrazit/skrýt"}
				</div>
                {*
                <span class="label" style="margin-left: 20px;"><strong>Název kategorie SK*</strong></span>
                <div class="nazev_hd" style="margin-left: 20px;"></div>
                <div class="nazev_bg" style="margin-left: 20px;">
				<input type="text" name="name_sk" value="{$dbCategory->name_sk}"/>
                </div>
                <div class="nazev_ft" style="margin-left: 20px;"></div>
                <span class="label" style="margin-left: 20px;"><strong>Název kategorie DE*</strong></span>
                <div class="nazev_hd" style="margin-left: 20px;"></div>
                <div class="nazev_bg" style="margin-left: 20px;">
				<input type="text" name="name_de" value="{$dbCategory->name_de}"/>
                </div>
                <div class="nazev_ft" style="margin-left: 20px;"></div>
                *}
                <div class="cb"></div>
                <div class="kategorie_label" style="width:130px;">
                    Pořadí
                </div>
                <div class="kategorie_label" style="width:130px;">
                    Koef. slevy
                </div>
                <div class="kategorie_label" style="width:150px;">
                    Nadřazená kategorie
                </div>
                <div class="cb"></div>
                <div class="kategorie_prvek" style="width:140px;">
                    <input type="text" name="priority" value="{$dbCategory->priority}" class="kategorie_poradi" />
                </div>
                <div class="kategorie_prvek" style="width:140px;">
                    <input type="text" name="sleva" value="{$dbCategory->sleva}" class="kategorie_poradi"/>
                </div>
                <div class="kategorie_prvek">
					<select name="parent_id">
						<option value="">---</option>
						{foreach from=dbCategory::getAllRecursively() item=category}
							<option value="{$category->id}" {if $category->id == $dbCategory->id_parent} selected="true" {/if}>{$category->name}</option>
						{/foreach}
					</select>
                </div>
                <div class="kategorie_label">
                    Obrázek kategorie
                </div>
                <div class="cb"></div>

                <div class="anotacni_obr" style="margin-left:20px;">
					<a href="{$pContentCategory->content->IMAGES_PATH}{$pContentCategory->content->IMAGES.image_1}" rel="shadowbox[trip]">
						<div id="anotacniObrazek_1" class="anotacni_obr_image" style="background-image:url({if $dbCategory->image}/images_categories/{$dbCategory->image}{else}/images/admin/obr.png{/if});"></div>
					</a>
					<a href="javascript:void(0)" title="Přidat obrázek" class="anotacni_obr_pridat" id="upload_foto_1"></a>
					<a href="javascript:void(0)" title="Smazat obrázek" class="anotacni_obr_smazat" id="delete_foto_1" onclick="kategorieObrazekDelete({$dbCategory->id}, 1)"></a>
					<div id="div_upload_foto_1" class="ui-datepicker">
						<div class="ui-datepicker-header ui-widget-header ui-helper-clearfix ui-corner-all">
							<div class="ui-datepicker-title">Nahrát foto</div>
							<a class="ui-datepicker-next ui-corner-all" onclick="$('#div_upload_foto_1').hide();">
								<span class="ui-icon ui-icon-closethick"></span>
							</a>
						</div>
						<div style="width:250px;margin-top:10px;margin-left:5px;">
							<input type="file" name="f"/>
						</div>
					</div>
                </div>

                <div class="cb"></div>
                <div class="kategorie_label">
                    Popis kategorie
                </div>
                <div class="text_kategorie">
                    {fckeditor BasePath="/fckeditor/" InstanceName="description" Value=$dbCategory->description Width="664px" Height="296px" ToolbarSet="Default"}
                </div>
                <div class="kategorie_label">
                    Popis kategorie 2
                </div>
                <div class="text_kategorie">
                    {fckeditor BasePath="/fckeditor/" InstanceName="description2" Value=$dbCategory->description2|default:'' Width="664px" Height="296px" ToolbarSet="Default"}
                </div>
                <div class="kategorie_label">
                    Meta titulek
                </div>
                <input type="text" name="meta_title" value="{$dbCategory->meta_title}" class="kategorie_meta_input"/>
                <div class="kategorie_label">
                    Meta description
                </div>
                <input type="text" name="meta_description" value="{$dbCategory->meta_description}" class="kategorie_meta_input"/>
                <div class="kategorie_label">
                    Meta keywords
                </div>
                <input type="text" name="meta_keywords" value="{$dbCategory->meta_keywords}" class="kategorie_meta_input"/>


				<input type="hidden" name="id_category" value="{$dbCategory->id}"/>
				<input type="submit" name="category_main_do_edit" value="Upravit kategorie" class="ulozit_upravy_tlac" style="margin:50px 40px;"/>
				<input type="submit" name="category_main_do_delete" value="Smazat kategorii" class="smazat_tlac"  style="margin:50px 30px;" onclick="return confirm('Opravdu smazat kategorii {$dbCategory->name} ?')"/>
			</form>
		{/if}
        <div class="kategorie_nova">
            <h2>Nová kategorie</h2>
			<form action="" method="post" enctype="multipart/form-data">
                <div class="kategorie_label">
					Název kategorie *
                </div>
                <div class="nazev_hd" style="margin-left: 20px;"></div>
                <div class="nazev_bg" style="margin-left: 20px;">
                    <input type="text" name="name" class="validate[required]" id="nazev"/>
                </div>
                <div class="nazev_ft" style="margin-left: 20px;"></div>


                <div class="kategorie_label">
                    Nadřazená kategorie
                </div>
                <div class="cb"></div>
                {*
                <div class="kategorie_label" style="margin-left:0px;">
				Obrázek kategorie
                </div>*}
                <div class="kategorie_prvek">
					<select name="parent_id">
						<option value="">---</option>
						{foreach from=dbCategory::getAllRecursively() item=category}
							<option value="{$category->id}" {if $category->id == $dbCategory->id} selected="true" {/if}>{$category->name}</option>
						{/foreach}
					</select>
                </div> {*
                <div class="kategorie_prvek" style="margin-left:0px;">
				<input type="file" name="f" />
                </div> *}
				<input type="submit" name="category_main_do_insert" value="Přidat kategorii" class="ulozit_upravy_tlac" style="margin-top:30px;margin-left:200px;"/>

			</form>
        </div>
	</div>

</div>