{assign var=content value=$pContentCategory->content}
<h1 class="clanek_title">{if !$dbCC}NOVÝ ČLÁNEK{else}EDITACE ČLÁNKU - {$content->title_1} : náhled <a href="{$dbCC->getUrl()}" target="_blank">zde</a> &nbsp;&nbsp;&nbsp;[odkaz: {$dbCC->getUrl()}]{/if}</h1>
<form method="post" id="novy_clanek" enctype="multipart/form-data">

    <div class="clanek_levy_sloupec">
        <span class="label"><strong>Název *</strong></span>
        <div class="nazev_hd"></div>
        <div class="nazev_bg">
            <input type="text" name="nazev" value="{$dbCC->name}" class="validate[required]" id="nazev" autofocus=""/>
        </div>
        <div class="nazev_ft"></div>
        <span class="label">Externí odkaz</span>
        <div class="nazev_hd"></div>
        <div class="nazev_bg">
            <input type="text" name="external_url" value="{$dbCC->external_url}" class="" id="externi_url" placeholder="odkaz na jinou stranku ..."/>
        </div>
        <div class="cb"></div>
        <div class="nazev_ft"></div>

        {if $idContentType == 7}
            <span class="label">Cena</span>
            <div class="nazev_hd"></div>
            <div class="nazev_bg">
                <input type="text" name="price" value="{$dbCC->price}" class="" id="cena" placeholder="Cena ..."/>
            </div>
            <div class="cb"></div>
            <div class="nazev_ft"></div>

            <span class="label">Lokalita</span>
            <div class="nazev_hd"></div>
            <div class="nazev_bg">
                <input type="text" name="locality" value="{$dbCC->locality}" class="" id="lokalita" placeholder="Lokalita ..."/>
            </div>
            <div class="cb"></div>
            <div class="nazev_ft"></div>
        {/if}

        {*<span class="label">Autor</span>
        <div class="nazev_hd"></div>
        <div class="nazev_bg">
        <input type="text" name="author" value="{$dbCC->author}" class="" id="externi_url"/>
        </div>
        <div class="cb"></div>
        <div class="nazev_ft"></div>*}

    </div>

    <div class="clanek_pravy_sloupec">
        <table class="zarazeni_table" border="0" cellpadding="0" cellspacing="0">
            {if !$dbCC->id_content_type || TRUE}
            {if $smarty.get.parent}{assign var=parentIdContentType value=dbContentCategory::getById($smarty.get.parent)->id_content_type}{/if}
            <tr>
                <td>ZAŘAZENÍ V MENU</td>
                <td style="padding-left:35px;">
                    <select name="id_content_type">
                        {foreach from=dbContentType::getAll() item=pContentType}
                            <option value="{$pContentType->id_content_type}" {if $pContentType->id_content_type == $idContentType|default:$parentIdContentType|default:Content_3n::DEFAULT_ID_CONTENT_TYPE}selected="selected"{/if}>{$pContentType->name}</option>
                        {/foreach}
                    </select>
                </td>
            </tr>
            <tr>
            {else}
            <tr><td></td><td></td></tr>
        {/if}
        <tr>
            <td nowrap="nowrap">ZAŘAZENÍ V KATEGORII</td>
            <td style="padding-left:35px;">
                <select name="id_parent" id="id_content_category">
                    <option value="">---</option>
                    {foreach from=dbContentCategory::getAll(null, null, $dbCC->id_content_type) item=cat}
                        <option value="{$cat->id}" {if $cat->id == $dbCC->id_parent|default:$smarty.get.parent} selected="true" {/if}>{$cat->name}</option>
                        {*{foreach from=$cat->getSubCategories(null) item=sub_cat}
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
                        {/foreach}*}
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

    <table class="datum_table" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <th>Datum</th>
            <th>Datum uveřejnění</th>
            <th>Datum stažení</th>
        </tr>
        <tr>
            <td>
                <div class="datum_bg">
                    <input type="text" id="datepicker1" name="datum" value="{$pContentCategory->content_category->datum|default:$smarty.now|date_format:'%d.%m.%Y'}"/>
                </div>
            </td>
            <td>
                <div class="datum_bg">
                    <input type="text" id="datepicker2" name="visible_from" value="{$pContentCategory->content_category->visible_from|date_format:'%d.%m.%Y'}"/>
                </div>
            </td>
            <td>
                <div class="datum_bg">
                    <input type="text" id="datepicker3" name="visible_to" value="{$pContentCategory->content_category->visible_to|date_format:'%d.%m.%Y'}"/>
                </div>
            </td>
        </tr>
    </table>



</div>



<span class="label popis_text_hlavni">Vlastní text</span>
<div class="text_3">
    {*fckeditor BasePath="/fckeditor/" InstanceName="text_2$fck_instance_suffix" Value=$content->text_2|default:'' Width="800" Height="290px" ToolbarSet="Default" CheckBrowser="true" DisplayErrors="true"*}
    <textarea name="text_2" id="" cols="30" rows="20" style="width: 800px; height: 390px;font-size:15px;line-height:20px;" class="ckeditor" height="390">{$content->text_2}</textarea>
</div>

<div class="submit_box" style="bottom:20px;left:0px;position:absolute;">
    {if $pContentCategory}
        <input type="hidden" name="id" value="{$dbCC->id}"/>
        <input type="hidden" name="id_content" value="{$dbCC->getContent()->id}"/>
        <input type="hidden" name="visible" value="{$dbCC->visible}"/>
        <input type="hidden" name="menu" value="{$dbCC->menu}"/>
        <input type="hidden" name="priority" value="{$dbCC->priority}"/>
        <input type="submit" value="Uložit úpravy" name="do_clanek" class="ulozit_upravy_tlac" />
        <input type="submit" value="Smazat článek" class="smazat_tlac contentCategoryDelete" rel="{$dbCC->id}" title="Smazat článek" alt="{$dbCC->name}"/>
    {else}
        <input type="hidden" name="menu" value="{dbContentCategory::TYPE_CLANEK}"/>
        <input type="submit" value="Vložit článek" name="do_clanek" class="ulozit_upravy_tlac pozice_uprostred" />
    {/if}

</div>

{if $dbCC || true}
    {include file='admin/clanek_dalsi_moznosti.tpl'}
{/if}


{if !$dbCC}
</form>
{/if}