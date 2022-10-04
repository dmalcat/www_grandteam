<div class="content_bg">

    <div class="content">
        <h1 class="content_title">{'Mapa stránek'|translate}</h1>
        <div class="content_drobisky">
            {*include file="boxes/drobisky.tpl"*}
        </div>
        <div class="content_text2">
            <div class="mapa_stranek_kategorie">{'Hlavní menu'|translate}</div>
            <ul class="mapa_stranek_ul">
            	{foreach from=dbContentCategory::getAll(1, null, 3) item=dbContentCategory name=menu}
            		<li>
                        <a href="{$dbContentCategory->getUrl()}" class="{if $dbContentCategory->target}ext{/if}" target="{$dbContentCategory->target}">{$dbContentCategory->name|translate}</a>
                        {if $dbContentCategory->getSubCategories()|@count}
                            <ul>
                              {foreach from=$dbContentCategory->getSubCategories() item=dbContentCategorySub}
                                  <li>
                                      <a href="{$dbContentCategorySub->getUrl()}" class="{if $dbContentCategorySub->target}ext{/if}" target="{$dbContentCategorySub->target}">{$dbContentCategorySub->name|translate}</a>
                                      {if $dbContentCategorySub->getSubCategories()|@count}
                                          <ul>
                                            {foreach from=$dbContentCategorySub->getSubCategories() item=dbContentCategorySubSub}
                                                <li>
                                                    <a href="{$dbContentCategorySubSub->getUrl()}" class="{if $dbContentCategorySubSub->target}ext{/if}" target="{$dbContentCategorySubSub->target}">{$dbContentCategorySubSub->name|translate}</a>
                                                    {if $dbContentCategorySubSub->getSubCategories()|@count}
                                						<ul>
                                						{foreach from=$dbContentCategorySubSub->getSubCategories() item=dbContentCategorySubSubSub}
                                                            <li>
                                                                <a href="{$dbContentCategorySubSubSub->getUrl()}" class="{if $dbContentCategorySubSubSub->target}ext{/if}" target="{$dbContentCategorySubSubSub->target}">{$dbContentCategorySubSubSub->name|translate}</a>
                                                            </li>
                                						{/foreach}
                                						</ul>
                                					{/if}
                                                </li>
                                            {/foreach}
                                          </ul>
                              		  {/if}
                              	</li>
                              {/foreach}
                            </ul>
                      {/if}
                    </li>
            	{/foreach}
            </ul>
            <div class="mapa_stranek_kategorie">{'Úřední deska'|translate}</div>
            <ul class="mapa_stranek_ul">
            	{foreach from=dbContentCategory::getAll(1, null, 6) item=dbContentCategory name=menu}
            		<li>
                        <a href="{$dbContentCategory->getUrl()}" class="{if $dbContentCategory->target}ext{/if}" target="{$dbContentCategory->target}">{$dbContentCategory->name|translate}</a>
                        {if $dbContentCategory->getSubCategories()|@count}
                            <ul>
                              {foreach from=$dbContentCategory->getSubCategories() item=dbContentCategorySub}
                                  <li>
                                      <a href="{$dbContentCategorySub->getUrl()}" class="{if $dbContentCategorySub->target}ext{/if}" target="{$dbContentCategorySub->target}">{$dbContentCategorySub->name|translate}</a>
                                      {if $dbContentCategorySub->getSubCategories()|@count}
                                          <ul>
                                            {foreach from=$dbContentCategorySub->getSubCategories() item=dbContentCategorySubSub}
                                                <li>
                                                    <a href="{$dbContentCategorySubSub->getUrl()}" class="{if $dbContentCategorySubSub->target}ext{/if}" target="{$dbContentCategorySubSub->target}">{$dbContentCategorySubSub->name|translate}</a>
                                                    {if $dbContentCategorySubSub->getSubCategories()|@count}
                                						<ul>
                                						{foreach from=$dbContentCategorySubSub->getSubCategories() item=dbContentCategorySubSubSub}
                                                            <li>
                                                                <a href="{$dbContentCategorySubSubSub->getUrl()}" class="{if $dbContentCategorySubSubSub->target}ext{/if}" target="{$dbContentCategorySubSubSub->target}">{$dbContentCategorySubSubSub->name|translate}</a>
                                                            </li>
                                						{/foreach}
                                						</ul>
                                					{/if}
                                                </li>
                                            {/foreach}
                                          </ul>
                              		  {/if}
                              	</li>
                              {/foreach}
                            </ul>
                      {/if}
                    </li>
            	{/foreach}
            </ul>
            <div class="mapa_stranek_kategorie">{'Kalendář akcí'|translate}</div>
            <ul class="mapa_stranek_ul">
            	{foreach from=dbCalendar::getActual() item=dbContentCategory name=menu}
            		<li>
                        <a href="{$dbContentCategory->getUrl()}" class="{if $dbContentCategory->target}ext{/if}" target="{$dbContentCategory->target}">{$dbContentCategory->name|translate}</a>
                    </li>
            	{/foreach}
            </ul>
        </div>
    </div>

    {include file="boxes/nejnovejsi_z_kategorie.tpl"}

</div>

{include file="boxes/zajimavosti.tpl"}

