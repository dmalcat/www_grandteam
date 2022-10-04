<div class="content_bg">

    <div class="content">
        <h1 class="content_title">{'Aktuality'|translate}</h1>
        <div class="content_text_aktuality">
            <ul class="content_menu">
                {foreach from=dbContentCategory::getAktuality()  item=aktuality_menu}
                    <li>
                        {if $aktuality_menu->datum}
                            <div class="aktuality_menu_datum">
                                {$aktuality_menu->datum|date_format:"%d.%m.%Y"}
                            </div>
                        {/if}
                        <a href="{$aktuality_menu->getUrl()}" class="aktuality_menu_title" target="{$aktuality_menu->getTarget()}">{$aktuality_menu->name}</a>
                        {if $aktuality_menu->getContent()->text_1 and $aktuality_menu->getContent()->text_1!="&nbsp;" or $aktuality_menu->image_1}
                            <div class="aktuality_menu_text">
                                {if $aktuality_menu->image_1}
                                    <img src="{dbContentCategory::IMAGES_PATH}{$aktuality_menu->id}/{$aktuality_menu->image_1}" alt="{$aktuality_menu->getContent()->title_1}" align="left" border="0" />
                                {/if}
                                {$aktuality_menu->getContent()->text_1}
                            </div>
                        {/if}
                    </li>
                {/foreach}
            </ul>
        </div>
    </div>

    {include file="boxes/nejnovejsi_z_kategorie.tpl"}

</div>

{include file="boxes/zajimavosti.tpl"}