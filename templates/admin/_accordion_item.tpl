<div style="clear: both;"></div>
<h3 class="bg" data-id="{$item->id}">
    <div class="ikona"><span class="{if dbContentCategory::getById($item->id)->getSubcategories()|@count}ui-icon ui-icon-circle-plus{else}ui-icon ui-icon-triangle-1-e{/if}"></span></div>
    <div class="nazev">
        <a href="/admin/{if $item->menu == dbContentCategory::TYPE_MENU}menu{else}clanek{/if}/{$item->id}" title="{$item->name}" class="nazev_a">{$item->name|truncate:'24'}</a>
    </div>
    <div class="poradi">
        <a href="#" title="Posunout článek dolů" class="sipka_dolu" data-id="{$item->id}" data-parent="{$item->id_parent|default:0}"></a>
        <a href="#" title="Posunout článek nahoru" class="sipka_nahoru" data-id="{$item->id}" data-parent="{$item->id_parent|default:0}"></a>
    </div>
    <div class="typ"> 
        <div id="uniform-undefined" class="selector focus">
            <span style="-moz-user-select: none;">{if $item->menu == 1}položka menu{else}článek{/if}</span>
            <select name="contentCategoryType" class="contentCategoryType" style="width: 80px;" rel="{$item->id}">
                <option value="0" {if $item->menu == 0}selected="selected"{/if}>článek</option>
                <option value="1" {if $item->menu == 1}selected="selected"{/if}>položka menu</option>
            </select>
        </div>
    </div>
    <div class="zobrazit">
        <div id="uniform-undefined" class="checker">
            <span class="{if $item->visible}checked{/if}">
                <input type="checkbox" name="visible" {if $item->visible}checked="checked"{/if} onclick="setContentVisibility(this, {$item->id})" />
            </span>
        </div>
    </div>
    <div class="zobrazit_hp">
        <div id="uniform-undefined" class="checker">
            <span class="{if $item->homepage}checked{/if}">
                <input type="checkbox" name="homepage" {if $item->homepage}checked="checked"{/if} onclick="setContentCategoryHP(this, {$item->id})"  />
            </span>
        </div>
    </div>
    <div class="aktuality">
        <div id="uniform-undefined" class="checker">
            <span class="{if $item->aktuality}checked{/if}">
                <input type="checkbox" name="aktuality" {if $item->aktuality}checked="checked"{/if}  onclick="setContentCategoryAktuality(this, {$item->id})"  />
            </span>
        </div>
    </div>
    <div class="upravit">
        {if $item->menu != 1}
            <div id="uniform-undefined" class="checker">
                <span class="{if $item->zajimavosti}checked{/if}">
                    <input type="checkbox" name="zajimavosti" {if $item->zajimavosti}checked="checked"{/if}  onclick="setContentCategoryZajimavosti(this, {$item->id})"  />
                </span>
            </div>
        {/if}
    </div>
    <div class="pridat_clanek"><a href="/admin/clanek//?parent={$item->id}" title="Přidat článek"></a></div>
    <div class="smazat"><a href="javascript: void(0)" class="contentCategoryDelete" rel="{$item->id}" title="Smazat článek" alt="{$item->name}"></a></div>
    <div class="datum">{$item->datum|default:$smarty.now|date_format:"%d.%m.%Y"}</div>
    <div class="cb"></div>
</h3>

