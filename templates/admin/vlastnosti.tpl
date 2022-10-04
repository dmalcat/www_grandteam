<h1 class="clanek_title">EDITACE DOSTUPNÝCH VLASTNOSTÍ PRO PRODUKTY</h1>
{foreach from=$p_categories key=step_id item=p_step_categories}
    <h2 class="vlastnosti_nazev_h2">ZÁLOŽKA {$p_steps.$step_id.NAME}</h2>
    {foreach from=$p_step_categories.categories item=category}
        <h3 class="vlastnosti_nazev_h3">=>KATEGORIE {$category.NAME}</h3>
        <table class="vlastnosti_table" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:0px;">
            <tr>
                <th style="width:28px;">Zobr.</th>
                <th style="width:45px;text-align:center;">Poř.</th>
                <th style="width:150px;">Název</th>
                <th style="width:116px;">Typ</th>
                <th style="width:43px;">Jedn.</th>
                <!--  <th>Prohl.</th> -->
                <!--  <th>Překl.</th> -->
                <!--  <th>Dědit</th> -->
                <!--  <th>Kontrola</th> -->
                <th style="width:75px;">Zobrazit</th>
                <!--  <th>Řazení</th> -->
                <!--  <th>Kategorie</th> -->

                <th>Vlastnost pro</th>
                <th>Variantní vlastnost pro</th>
                <th>Dodatková vlastnost pro</th>
                <th style="width:78px;">Vkládat do objedn.</th>
                <th style="width:43px;">Upravit</th>
                <th style="width:47px;">Smazat</th>
            </tr>
        </table>
        {foreach from=$category.properties key=property_name item=property}
            <form action="" method="post">
                <table class="vlastnosti_table" border="0" cellpadding="0" cellspacing="0" style="margin-top:0px;">
                    <tr><th colspan="12"><hr/></th></tr>
                    <tr>
                        <td style="width:28px;">{html_checkboxes name="prop_visible" options=$s_prop_visible selected=$property.PROP_VISIBLE}</td>
                        <td style="width:45px;"><input type="text" size="3" name="prop_weight" value="{$property.PROP_WEIGHT}" class="vlastnosti_poradi"/></td>
                        <td style="width:150px;"><input type="text" name="prop_name" value="{$property.PROP_NAME}" class="vlastnosti_nazev"/></td>
                        <td style="width:116px;" class="vlastnosti_select">{html_options name="prop_type" options=$s_prop_type selected=$property.PROP_TYPE disabled="true"}</td>
                        <td style="width:43px;"><input type="text" size="3" name="prop_unit" value="{$property.PROP_UNIT}" class="vlastnosti_poradi"/></td>
                        <!--  <td>{html_checkboxes name="prop_search" options=$s_prop_search selected=$property.PROP_SEARCH}</td> -->
                        <!--  <td>{html_checkboxes name="prop_lang_depending" options=$s_prop_lang_depending selected=$property.PROP_LANG_DEPENDING}</td> -->
                        <!--  <td>{html_checkboxes name="prop_inherit" options=$s_prop_inherit selected=$property.PROP_INHERIT}</td> -->
                        <!--  <td><input type="text" name="prop_validation_regex" value="{$property.PROP_VALIDATION_REGEX}"/></td> -->
                        <td style="width:75px;">{html_checkboxes name="prop_show" options=$s_prop_item_show selected=$property.PROP_SHOW}</td>
                        <!--  <td>{html_options name="prop_sort" options=$s_prop_sort selected=$property.PROP_SORT_TYPE}</td> -->
                        <!--  <td class="vlastnosti_select">
                                <select name="move_to_category">
                        {foreach from=$p_step_categories.categories item=category_tmp}
                                <option value="{$category_tmp.ID_CATEGORY}" {if $category_tmp.ID_CATEGORY == $category.ID_CATEGORY}selected="true" {/if}>{$category_tmp.NAME}</option>
                        {/foreach}
                </select>
        </td> -->
                        <td class="vlastnosti_kategorie">
                            <select name="move_to_category">
                                {foreach from=$p_step_categories.categories item=category_tmp}
                                    <option value="{$category_tmp.ID_CATEGORY}" {if $category_tmp.ID_CATEGORY == $category.ID_CATEGORY}selected="true" {/if}>{$category_tmp.NAME}</option>
                                {/foreach}
                            </select>
                            {foreach from=$p_property_categories item=prop_category}
                                <input type="checkbox"  name="property_map_category_general[]" value="{$prop_category->id_category}" {if $prop_category->id_category|in_array:$property.PROPERTY_CATEGORY_MAPPING.GENERAL}checked="true" {/if} />{$prop_category->name}<br/>
                            {/foreach}
                        </td>
                        <td class="vlastnosti_kategorie">
                            {foreach from=$p_property_categories item=prop_category}
                                <input type="checkbox"  name="property_map_category_variant[]" value="{$prop_category->id_category}"  {if $prop_category->id_category|in_array:$property.PROPERTY_CATEGORY_MAPPING.VARIANT}checked="true" {/if} />{$prop_category->name}<br/>
                            {/foreach}
                        </td>
                        <td class="vlastnosti_kategorie">
                            {foreach from=$p_property_categories item=prop_category}
                                <input type="checkbox"  name="property_map_category_additional[]" value="{$prop_category->id_category}" {if $prop_category->id_category|in_array:$property.PROPERTY_CATEGORY_MAPPING.ADDITIONAL}checked="true" {/if} />{$prop_category->name}<br/>
                            {/foreach}
                        </td>
                        <td style="width:78px;text-align:center;">{html_checkboxes name="prop_copy_to_cart" options=$s_yes_no selected=$property.PROP_COPY_TO_CART}</td>
                        <td style="text-align:center;width:43px;">
                            <input type="hidden" name="id_property" value="{$property.PROP_ID}" class="btn_edit"/>
                            <input type="submit" {if $property.PROP_REQUIRED}disabled="disabled"{/if} name="property_do_edit" value=" " class="nastaveni_doprava_edit"/>
                        </td>
                        <td style="text-align:center;width:47px;"><input type="submit" {if $property.PROP_REQUIRED}disabled="disabled"{/if} name="property_do_delete" value=" " class="nastaveni_doprava_smazat" onclick="return confirm('Opravdu smazat vlastnost {$property.PROP_NAME} ?\n Dojde ke smazání všech souvisejících hodnot !')"/></td>
                    </tr>
                </table>
            </form>
            {if $property.PROP_ENUMERATED}
                {foreach from=$property.PROP_ENUMERATION item=enum}
                    <form action="" method="post">
                        <table class="vlastnosti_table" border="0" cellpadding="0" cellspacing="0" style="margin:0px;margin-left:20px;">
                            <tr>
                                <td style="width:28px;"></td>
                                <td style="width:45px;"></td>
                                <td colspan="10">
                                    <input type="text" size="7" name="value" value="{$enum.value}" class="nastaveni_doprava_input_kratky"/>
                                    <input type="hidden" name="id_property" value="{$property.PROP_ID}" />
                                    <input type="hidden" name="id_enumeration" value="{$enum.id_enumeration}"/>
                                    <input type="submit" name="property_enum_do_edit" value=" " class="vlastnost_edit"/>
                                    <input type="submit" name="property_enum_do_delete" value=" " class="vlastnost_delete" onclick="return confirm('Opravdu smazat - {$enum.value} ?')"/>
                                </td>
                            </tr>
                        </table>
                    </form>
                {/foreach}
                <form action="" method="post">
                    <table class="vlastnosti_table" border="0" cellpadding="0" cellspacing="0" style="margin:0px;margin-left:20px;">
                        <tr>
                            <td style="width:28px;"></td>
                            <td style="width:45px;"></td>
                            <td colspan="10">
                                <input type="text" size="7" name="value" class="nastaveni_doprava_input_kratky"/>
                                <input type="hidden" name="id_property" value="{$property.PROP_ID}"/>
                                <input type="submit" name="property_enum_do_insert" value=" " class="vlastnost_edit"/>
                            </td>

                        </tr>
                    </table>
                </form>
            {/if}
        {/foreach}
        <form action="" method="post">
            <table class="vlastnosti_table" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <th style="width:28px;">Zobr.</th>
                    <th style="width:45px;"></th>
                    <th style="width:150px;">Název</th>
                    <th style="width:116px;">Typ</th>
                    <th style="width:43px;">Jedn.</th>
                    <th style="width:75px;">Zobrazit</th>
                    <th>Kategorie</th>
                    <th></th>
                </tr>
                <tr><th colspan="12"><hr/></th></tr>
                <tr>
                    <td>{html_checkboxes name="prop_visible" options=$s_prop_visible selected=$property.PROP_VISIBLE}</td>
                    <td style="width:45px;"></td>
                    <td><input type="text" name="prop_name" value="{$smarty.get.prop_name}" class="vlastnosti_nazev"/></td>
                    <td class="vlastnosti_select">{html_options name="prop_type" options=$s_prop_type selected=$smarty.get.prop_type|default:'STRING'}</td>
                    <td><input type="text" size="3" name="prop_unit" value="{$smarty.get.prop_unit}" class="vlastnosti_poradi"/></td>
                        {*<td>{html_checkboxes name="prop_search" options=$s_prop_search selected=$smarty.get.prop_search}</td>
                        <td>{html_checkboxes name="prop_lang_depending" options=$s_prop_lang_depending selected=$smarty.get.prop_lang_depending}</td>
                        <td>{html_checkboxes name="prop_inherit" options=$s_prop_inherit selected=$property.PROP_INHERIT}</td>
                        <td><input type="text" name="prop_validation_regex" value="{$smarty.get.prop_validation_regex}"/></td>*}
                    <td>{html_checkboxes name="prop_show" options=$s_prop_item_show selected=$smarty.get.prop_show}</td>
                    {*<td>{html_options name="prop_sort" options=$s_prop_sort}</td> *}
                    <td colspan="4" class="vlastnosti_select">
                        <select name="move_to_category">
                            {foreach from=$p_step_categories.categories item=category_tmp}
                                <option value="{$category_tmp.ID_CATEGORY}" {if $category_tmp.ID_CATEGORY == $category.ID_CATEGORY}selected="true" {/if}>{$category_tmp.NAME}</option>
                            {/foreach}
                        </select>
                    </td>
                    <td colspan="2">
                        <input type="hidden" name="id_step" value="{$step_id}"/>
                        <input type="hidden" name="id_category" value="{$category.ID_CATEGORY}"/>
                        <input type="submit" name="property_do_insert" value="Vložit" class="objednavka_filtr"/>
                    </td>
                </tr>
            </table>
        </form>
    {/foreach}
{/foreach}

<div class="cb"></div>



{*
<h1>Editace dostupných vlastností pro produkty</h1>
<table width="100%" border="0">
{foreach from=$p_categories key=step_id item=p_step_categories}
<tr class="deep_blue">
<th colspan="15">Záložka {$p_steps.$step_id.NAME}</th>
</tr>
{foreach from=$p_step_categories.categories item=category}
<tr class="deep_yellow">
<td>&nbsp;=></td>
<th colspan="14">Kategorie {$category.NAME}</th>
</tr>
<tr>
<th></th>
<th></th>
<th>zobr.</th>
<th>název</th>
<th>typ</th>
<th>jednotka</th>
<th>prohl.</th>
<th>překl.</th>
<th>dědit</th>
<th>kontrola</th>
<th>zobrazit</th>
<th>řazení</th>
<th>kategorie</th>
</tr>
<tr>
<th></th>
<th></th>
<th>pořadí</th>
<th colspan="2">vlastnost pro:</th>
<th colspan="2">variantní vlastnost pro:</th>
<th colspan="3">dodatková vlastnost pro:</th>
<th>ukládat do objednávky:</th>
<th>upravit</th>
<th>smazat</th>
</tr>
{foreach from=$category.properties key=property_name item=property}
<tr><th colspan="15"><hr/></th></tr>
<form action="" method="post">
<tr>
<td>&nbsp;</td>
<td><td>{html_checkboxes name="prop_visible" options=$s_prop_visible selected=$property.PROP_VISIBLE}</td></td>
<td><input type="text" name="prop_name" value="{$property.PROP_NAME}" /></td>
<td>{html_options name="prop_type" options=$s_prop_type selected=$property.PROP_TYPE disabled="true"}</td>
<td><input type="text" size="3" name="prop_unit" value="{$property.PROP_UNIT}"/></td>
<td>{html_checkboxes name="prop_search" options=$s_prop_search selected=$property.PROP_SEARCH}</td>
<td>{html_checkboxes name="prop_lang_depending" options=$s_prop_lang_depending selected=$property.PROP_LANG_DEPENDING}</td>
<td>{html_checkboxes name="prop_inherit" options=$s_prop_inherit selected=$property.PROP_INHERIT}</td>
<td><input type="text" name="prop_validation_regex" value="{$property.PROP_VALIDATION_REGEX}"/></td>
<td>{html_checkboxes name="prop_show" options=$s_prop_item_show selected=$property.PROP_SHOW}</td>
<td>{html_options name="prop_sort" options=$s_prop_sort selected=$property.PROP_SORT_TYPE}</td>
<td>
<select name="move_to_category">
{foreach from=$p_step_categories.categories item=category_tmp}
<option value="{$category_tmp.ID_CATEGORY}" {if $category_tmp.ID_CATEGORY == $category.ID_CATEGORY}selected="true" {/if}>{$category_tmp.NAME}</option>
{/foreach}
</select>
</td>
</tr>
<tr>
<td></td>
<td></td>
<td><input type="text" size="3" name="prop_weight" value="{$property.PROP_WEIGHT}"/></td>
<td colspan="2">
{foreach from=$Xp_property_categories item=prop_category}
<input type="checkbox"  name="property_map_category_general[]" value="{$prop_category->id_category}" {if $prop_category->id_category|in_array:$property.PROPERTY_CATEGORY_MAPPING.GENERAL}checked="true" {/if} />{$prop_category->name}<br/>
{/foreach}
</td>
<td colspan="2">
{foreach from=$Xp_property_categories item=prop_category}
<input type="checkbox"  name="property_map_category_variant[]" value="{$prop_category->id_category}"  {if $prop_category->id_category|in_array:$property.PROPERTY_CATEGORY_MAPPING.VARIANT}checked="true" {/if} />{$prop_category->name}<br/>
{/foreach}
</td>
<td colspan="3">
{foreach from=$Xp_property_categories item=prop_category}
<input type="checkbox"  name="property_map_category_additional[]" value="{$prop_category->id_category}" {if $prop_category->id_category|in_array:$property.PROPERTY_CATEGORY_MAPPING.ADDITIONAL}checked="true" {/if} />{$prop_category->name}<br/>
{/foreach}
</td>
<td>{html_checkboxes name="prop_copy_to_cart" options=$s_yes_no selected=$property.PROP_COPY_TO_CART}</td>
<td>
<input type="hidden" name="id_property" value="{$property.PROP_ID}" class="btn_edit"/>
<input type="submit" {if $property.PROP_REQUIRED}disabled="disabled"{/if} name="property_do_edit" value="upravit" class="btn_edit"/>
</td>
<td><input type="submit" {if $property.PROP_REQUIRED}disabled="disabled"{/if} name="property_do_delete" value="smazat" class="btn_delete" onclick="return confirm('Opravdu smazat vlastnost {$property.PROP_NAME} ?\n Dojde ke smazání všech souvisejících hodnot !')"/></td>
    
</tr>
</form>
{if $property.PROP_ENUMERATED}
{foreach from=$property.PROP_ENUMERATION item=enum}
<form action="" method="post">
<tr>
<td></td>
<td></td>
<td></td>
<td><input type="text" size="7" name="value" value="{$enum.value}"/></td>
<td>
<input type="hidden" name="id_property" value="{$property.PROP_ID}" class="btn_edit"/>
<input type="hidden" name="id_enumeration" value="{$enum.id_enumeration}" class="btn_edit"/>
<input type="submit" name="property_enum_do_edit" value="upravit" class="btn_edit"/>
</td>
<td><input type="submit" name="property_enum_do_delete" value="smazat" class="btn_delete" onclick="return confirm('Opravdu smazat - {$enum.value} ?')"/></td>
</tr>
</form>
{/foreach}
<form action="" method="post">
<tr>
<td></td>
<td></td>
<td></td>
<td><input type="text" size="7" name="value" /></td>
<td>
<input type="hidden" name="id_property" value="{$property.PROP_ID}" class="btn_edit"/>
<input type="submit" name="property_enum_do_insert" value="přídat" class="btn_edit"/>
</td>
<td></td>
</tr>
</form>
{/if}
{/foreach}
<tr><th colspan="14"><hr/></th></tr>
<form action="" method="post">
<tr class="new">
<td>&nbsp;</td>
<td></td>
<td>{html_checkboxes name="prop_visible" options=$s_prop_visible selected=$property.PROP_VISIBLE}</td>
<td><input type="text" name="prop_name" value="{$smarty.get.prop_name}" /></td>
<td>{html_options name="prop_type" options=$s_prop_type selected=$smarty.get.prop_type|default:'STRING'}</td>
<td><input type="text" size="3" name="prop_unit" value="{$smarty.get.prop_unit}"/></td>
<td>{html_checkboxes name="prop_search" options=$s_prop_search selected=$smarty.get.prop_search}</td>
<td>{html_checkboxes name="prop_lang_depending" options=$s_prop_lang_depending selected=$smarty.get.prop_lang_depending}</td>
<td>{html_checkboxes name="prop_inherit" options=$s_prop_inherit selected=$property.PROP_INHERIT}</td>
<!--  <td><input type="text" name="prop_validation_regex" value="{$smarty.get.prop_validation_regex}"/></td> -->
<td>{html_checkboxes name="prop_show" options=$s_prop_item_show selected=$smarty.get.prop_show}</td>
<td>{html_options name="prop_sort" options=$s_prop_sort}</td>
<td>
<select name="move_to_category">
{foreach from=$p_step_categories.categories item=category_tmp}
<option value="{$category_tmp.ID_CATEGORY}" {if $category_tmp.ID_CATEGORY == $category.ID_CATEGORY}selected="true" {/if}>{$category_tmp.NAME}</option>
{/foreach}
</select>
</td>
<td>
<input type="hidden" name="id_step" value="{$step_id}" class="btn_edit"/>
<input type="hidden" name="id_category" value="{$category.ID_CATEGORY}" class="btn_edit"/>
<input type="submit" name="property_do_insert" value="vložit" class="btn_edit"/>
</td>
<td></td>
    
</tr>
</form>
<tr><th colspan="14"><hr/></th></tr>
{/foreach}
{/foreach}
</table>
</form>
<div class="clear"></div>

*}