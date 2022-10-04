<div id="menu_top">
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                {*                <a class="navbar-brand" href="/"><img src="/images/logo.jpg" alt="{Registry::getDomain()}"/></a>*}
                <a class="navbar-brand" href="/"><img src="/images/logo.png" alt="{Registry::getDomain()}" class="logo"/></a>
            </div>
            <div id="navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
                <ul class="nav navbar-nav navbar-right">
                    {foreach from=dbContentCategory::getAll(1, null, 1)->sort("priority") item=item name=top_menu}
                        {*                        {if $item->getSubcategories()|@count && $item->seoname <> 'aktuality'}*}
                        {if $item->getSubcategories()|@count}
                            <li class="dropdown {if $item->selected}active{/if}">
                                <a href="#" class="dropdown-toggle text-uppercase" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{$item->name} <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    {foreach from=$item->getSubcategories() item=item2}
                                        <li>
                                            <a href="{$item2->getUrl()}">{$item2->name}</a>
                                        </li>
                                    {/foreach}
                                </ul>
                            </li>
                        {else}
                            <li>
                                <a href="{$item->getUrl()}" class="text-uppercase">{$item->name}</a>
                            </li>
                        {/if}
                    {/foreach}
                </ul>
            </div>
        </div>
    </nav>
</div>