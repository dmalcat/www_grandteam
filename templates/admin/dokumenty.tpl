<h1 class="clanek_title">{if $dbGallery}EDITACE DOKUMENTŮ - {$dbGallery->name}{else}NOVÉ DOKUMENTY{/if}</h1>
<form method="post" id="nove_dokumenty" enctype="multipart/form-data">

    <div class="clanek_levy_sloupec">
        <span class="label"><strong>Název *</strong></span>
        <div class="nazev_hd"></div>
        <div class="nazev_bg">
            <input type="text" name="name" value="{$dbGallery->name}" class="validate[required]" id="nazev"/>
        </div>
        <div class="nazev_ft"></div>

        <span class="label">Popis galerie</span>
        <div class="text_1_hd"></div>
        <div class="text_1_bg">
            {fckeditor BasePath="/fckeditor/" InstanceName="description" Value=$dbGallery->description|default:'' Width="505" Height="110px"  ToolbarSet="Basic"}
        </div>
        <div class="text_1_ft"></div>

        {*<span class="label sipka">Prostý text</span>
        <div class="text_2_hd"></div>
        <div class="text_2_bg">
            <textarea name="descriptionPlain">{$dbGallery->description}</textarea>
        </div>
        <div class="cb"></div>
        <div class="text_2_ft"></div> *}
    </div>

    <div class="clanek_pravy_sloupec">
        <table class="datum_table" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:10px;">
			<tr>
				<th>Datum</th>
				<th>Datum uveřejnění</th>
				<th>Datum stažení</th>
			</tr>
			<tr>
				<td style="padding-bottom:10px;">
					<div class="datum_bg">
						<input type="text" id="datepicker1" name="datum" value="{$dbGallery->datum|default:$smarty.now|date_format:'%d.%m.%Y'}"/>
					</div>
				</td>
				<td style="padding-bottom:10px;">
					<div class="datum_bg">
						<input type="text" id="datepicker2" name="visible_from" value="{$dbGallery->visible_from|date_format:'%d.%m.%Y'}"/>
					</div>
				</td>
				<td style="padding-bottom:10px;">
					<div class="datum_bg">
						<input type="text" id="datepicker3" name="visible_to" value="{$dbGallery->visible_to|date_format:'%d.%m.%Y'}"/>
					</div>
				</td>
			</tr>
        </table>

        <table class="anotacni_obr_table" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<th style="text-align:left;padding-left:25px;">Anotační obrázek</th>
			</tr>
			<tr>
				<td>
					<div class="anotacni_obr">
						<a href="{$dbGallery->galleryImage}" rel="shadowbox[trip]">
							<div class="anotacni_obr_image" style="background-image:url({$text|default:'/images/admin/obr.png'});">
								{if $dbGallery->galleryImage}
                                    <img src="{$dbGallery->galleryImage}" style="max-width: 115px; max-height: 103px;"/>
                                {/if}
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
								<input type="file" name="image"/>
							</div>
						</div>
					</div>
				</td>
			</tr>
        </table>
    </div>


    <div class="submit_box">
		<input type="hidden" name="id_gallery_type" value="{dbGallery::TYPE_FILES}"/>
		<input type="hidden" name="id_gallery_template" value="{dbGallery::TYPE_FILES}"/>
		{if $dbGallery}
			<input type="submit" value="Upravit fotogalerii" name="doGalleryEdit" class="ulozit_upravy_tlac" />
			<input type="submit" value="Smazat fotogalerii"  name="doGalleryDelete" class="smazat_tlac" onclick="return confirm('Opravdu smazat fotogalerii ?')"/>
		{else}
			<input type="submit" value="Uložit a zavřít" name="doGalleryAdd" class="ulozit_upravy_tlac" />
			<input type="submit" value="Uložit a přidat obsah"  name="doGalleryAddEdit" class="ulozit_upravy_tlac" />
		{/if}
		  <!--  <input type="submit" value="Smazat dokumenty" class="smazat_tlac pozice_pro_tri_tlacitka" /> -->
    </div>

</form>