<div class="dalsi_moznosti_title ui-accordion-header">
    <span class="ui-icon ui-icon-circle-plus"></span>
    DALŠÍ MOŽNOSTI
</div>
<div class="dalsi_moznosti_box">
    <div class="Xclanek_levy_sloupec">
        <span class="label">Anotační text</span>
        {*        <div class="text_1_hd"></div>*}
        <div class="text_3">

            {*            {fckeditor BasePath="/fckeditor/" InstanceName="text_1" Value=$content->text_1|default:'' Width="505" Height="200px" ToolbarSet="Basic" CheckBrowser="true" DisplayErrors="true"}*}
            {*			<textarea name="text_1" id="" cols="30" rows="20" style="width: 515px; height: 200px;font-size:15px;line-height:20px;" class="ckeditor" height="390">{$content->text_1}</textarea>*}
            <textarea name="text_1" id="" cols="30" rows="20" style="width: 800px; height: 390px;font-size:15px;line-height:20px;" class="ckeditor" height="390">{$content->text_1}</textarea>
        </div>
        {*        <div class="text_1_ft"></div>*}

        {*<span class="label sipka">Prostý text</span>
        <div class="text_2_hd"></div>
        <div class="text_2_bg">
        <textarea>{$dbC->text_1}</textarea>
        </div>
        <div class="cb"></div>
        <div class="text_2_ft"></div> *}
    </div>

    <div style="clear: both;"></div>

    <div class="clanek_pravy_sloupec">
        <table class="anotacni_obr_table" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <th>Obrázek 1</th>
                <th>Obrázek 2</th>
                <th>Obrázek 3</th>
                <th>Obrázek 4</th>
                <th style="text-align:left;padding-left:31px;">Soubor 1</th>
                <th style="text-align:left;padding-left:31px;">Soubor 2</th>
            </tr>
            <tr>
                <td>
                    <div class="anotacni_obr">
                        <a href="{$pContentCategory->content->IMAGES_PATH}{$pContentCategory->content->IMAGES.image_1}" rel="shadowbox[trip]">
                            <div id="anotacniObrazek_1" class="anotacni_obr_image" style="background-image:url({if $dbCC->image_1}{$pContentCategory->content->IMAGES_PATH}{$pContentCategory->content->IMAGES.image_1}{else}/images/admin/obr.png{/if});"></div>
                        </a>
                        <a href="javascript:void(0)" title="Přidat obrázek" class="anotacni_obr_pridat" id="upload_foto_1"></a>
                        <a href="javascript:void(0)" title="Smazat obrázek" class="anotacni_obr_smazat" id="delete_foto_1" onclick="anotacniObrazekDelete({$dbCC->id}, 1)"></a>
                        <div id="div_upload_foto_1" class="ui-datepicker" style="z-index: 1000;">
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
                    <div class="anotacni_obr">
                        <a href="{$pContentCategory->content->IMAGES_PATH}{$pContentCategory->content->IMAGES.image_2}" rel="shadowbox[trip]">
                            <div id="anotacniObrazek_2" class="anotacni_obr_image" style="background-image:url({if $dbCC->image_2}{$pContentCategory->content->IMAGES_PATH}{$pContentCategory->content->IMAGES.image_2}{else}/images/admin/obr.png{/if});"></div>
                        </a>
                        <a href="javascript:void(0)" title="Přidat obrázek" class="anotacni_obr_pridat" id="upload_foto_2"></a>
                        <a href="javascript:void(0)" title="Smazat obrázek" class="anotacni_obr_smazat" id="delete_foto_2" onclick="anotacniObrazekDelete({$dbCC->id}, 2)"></a>
                        <div id="div_upload_foto_2" class="ui-datepicker" style="z-index: 1000;">
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
                    </div>
                </td>
                <td>
                    <div class="anotacni_obr">
                        <a href="{$pContentCategory->content->IMAGES_PATH}{$pContentCategory->content->IMAGES.image_3}" rel="shadowbox[trip]">
                            <div id="anotacniObrazek_3" class="anotacni_obr_image" style="background-image:url({if $dbCC->image_3}{$pContentCategory->content->IMAGES_PATH}{$pContentCategory->content->IMAGES.image_3}{else}/images/admin/obr.png{/if});"></div>
                        </a>
                        <a href="javascript:void(0)" title="Přidat obrázek" class="anotacni_obr_pridat" id="upload_foto_3"></a>
                        <a href="javascript:void(0)" title="Smazat obrázek" class="anotacni_obr_smazat" id="delete_foto_3" onclick="anotacniObrazekDelete({$dbCC->id}, 3)"></a>
                        <div id="div_upload_foto_3" class="ui-datepicker" style="z-index: 1000;">
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
                    </div>
                </td>
                <td>
                    <div class="anotacni_obr">
                        <a href="{$pContentCategory->content->IMAGES_PATH}{$pContentCategory->content->IMAGES.image_4}" rel="shadowbox[trip]">
                            <div id="anotacniObrazek_4" class="anotacni_obr_image" style="background-image:url({if $dbCC->image_4}{$pContentCategory->content->IMAGES_PATH}{$pContentCategory->content->IMAGES.image_4}{else}/images/admin/obr.png{/if});"></div>
                        </a>
                        <a href="javascript:void(0)" title="Přidat obrázek" class="anotacni_obr_pridat" id="upload_foto_4"></a>
                        <a href="javascript:void(0)" title="Smazat obrázek" class="anotacni_obr_smazat" id="delete_foto_4" onclick="anotacniObrazekDelete({$dbCC->id}, 4)"></a>
                        <div id="div_upload_foto_4" class="ui-datepicker" style="z-index: 1000;">
                            <div class="ui-datepicker-header ui-widget-header ui-helper-clearfix ui-corner-all">
                                <div class="ui-datepicker-title">Nahrát foto</div>
                                <a class="ui-datepicker-next ui-corner-all" onclick="$('#div_upload_foto_4').hide();">
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
                    <div class="anotacni_obr">
                        <a href="{$dbCC->file1->original}">
                            <div id="anotacniSoubor_1"  class="anotacni_obr_image" style="background-image:url(/images/icons/{$dbCC->file1->fileInfo->big_icon_url});"></div>
                        </a>
                        <a href="javascript:void(0)" title="Přidat soubor" class="anotacni_obr_pridat" id="upload_foto_5"></a>
                        <a href="javascript:void(0)" title="Smazat soubor" class="anotacni_obr_smazat" id="delete_foto_5" onclick="anotacniSouborDelete({$dbCC->id}, 1)"></a>
                        <div id="div_upload_foto_5" class="ui-datepicker"  style="z-index: 1000;">
                            <div class="ui-datepicker-header ui-widget-header ui-helper-clearfix ui-corner-all">
                                <div class="ui-datepicker-title">Nahrát Soubor</div>
                                <a class="ui-datepicker-next ui-corner-all" onclick="$('#div_upload_foto_2').hide();">
                                    <span class="ui-icon ui-icon-closethick"></span>
                                </a>
                            </div>
                            <div style="width:250px;margin-top:10px;margin-left:5px;">
                                <input type="file" name="content_category_file[]"/>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="anotacni_obr">
                        <a href="{$dbCC->file2->original}">
                            <div id="anotacniSoubor_2"  class="anotacni_obr_image" style="background-image:url(/images/icons/{$dbCC->file2->fileInfo->big_icon_url});"></div>
                        </a>
                        <a href="javascript:void(0)" title="Přidat soubor" class="anotacni_obr_pridat" id="upload_foto_6"></a>
                        <a href="javascript:void(0)" title="Smazat soubor" class="anotacni_obr_smazat" id="delete_foto_6" onclick="anotacniSouborDelete({$dbCC->id}, 2)"></a>
                        <div id="div_upload_foto_6" class="ui-datepicker"  style="z-index: 1000;">
                            <div class="ui-datepicker-header ui-widget-header ui-helper-clearfix ui-corner-all">
                                <div class="ui-datepicker-title">Nahrát Soubor</div>
                                <a class="ui-datepicker-next ui-corner-all" onclick="$('#div_upload_foto_3').hide();">
                                    <span class="ui-icon ui-icon-closethick"></span>
                                </a>
                            </div>
                            <div style="width:250px;margin-top:10px;margin-left:5px;">
                                <input type="file" name="content_category_file[]"/>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {*<div class="fotogalerie_box">
    <h2>GPS SOUŘADNICE</h2>
    <div class="galerie_box">
    <div class="clanek_gps">GPS ( např. 49°11'10.015"N, 15°26'58.850"E)</div>
    <div class="gps_bg">
    <input type="text" name="gps" value="{$dbCC->gps_lat} {$dbCC->gps_lng}"/>
    </div>
    <!--			<div class="clanek_gps">GPS lat</div>
    <div class="gps_bg"><input type="text" name="gps_lat" value="{$dbCC->gps_lat}"/></div>
    <div class="clanek_gps">GPS lng</div>
    <div class="gps_bg"><input type="text" name="gps_lng" value="{$dbCC->gps_lng}"/></div>-->
    </div>
    </div>


    {if $dbUser->isAdmin()}
    <div class="fotogalerie_box">
    <h2>PROPOJIT S ODBOREM</h2>
    <div class="galerie_box">
    <div class="clanek_gps">Zvolte odbor</div>
    <select name="id_odbor">
    {foreach dbUser::getOdbory() item=enum}
    <option value="{$enum->id_enumeration}" {if $dbCC->idOdbor == $enum->id_enumeration}selected="selected"{/if}>{$enum->value}</option>
    {/foreach}
    </select>
    <!--			<div class="clanek_gps">GPS lat</div>
    <div class="gps_bg"><input type="text" name="gps_lat" value="{$dbCC->gps_lat}"/></div>
    <div class="clanek_gps">GPS lng</div>
    <div class="gps_bg"><input type="text" name="gps_lng" value="{$dbCC->gps_lng}"/></div>-->
    </div>
    </div>
    {else}
    <input type="hidden" name="id_odbor" value="{$dbCC->id_odbor}"/>
    {/if}   *}


    {*include file="admin/pripojene_videa.tpl"*}


</form>

{include file="admin/pripojene_fotogalerie.tpl"}
{*include file="admin/pripojene_videogalerie.tpl"*}
{include file="admin/pripojene_soubory.tpl"}
</div>