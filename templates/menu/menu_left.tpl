<div class="row affix-row">
    <div class="col-md-12 affix-sidebar">
        <div class="sidebar-nav">
            <div class="navbar navbar-default" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <span class="visible-xs navbar-brand">Menu</span>
                </div>
                <div class="navbar-collapse collapse sidebar-navbar-collapse">
                    <ul class="nav navbar-nav" id="sidenav">
                        {foreach from=dbContentCategory::getAll(1, null, 2) item=item name=top_menu}
                            {if $item->getSubCategories()|@count}
                                <li>
                                    <a href="javascript: void(0)" data-toggle="collapse" data-target="#toggle_{$item->id}" data-parent="#sidenav" {if !$item->selected}class="xcollapsed"{/if}>
                                        {$item->name} <span class="caret pull-right"></span>
                                    </a>
                                    <div class="collapse {if $item->selected}in{/if}" id="toggle_{$item->id}" {if !$item->selected}style="height: 0px;"{/if}>
                                        <ul class="nav nav-list">
                                            {foreach from=$item->getSubCategories() item=subitem name=top_menu_sub}
                                                <li class="sub {if $subitem->selected}active{/if}" >
                                                    <a href="{$subitem->getUrl()}">{$subitem->name}</a>
                                                </li>
                                            {/foreach}
                                        </ul>
                                    </div>
                                </li>
                            {else}
                                <li {if $item->selected}class="active"{/if}>
                                    <a href="{$item->getUrl()}">{$item->name}</a>
                                </li>
                            {/if}
                        {/foreach}
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div>

    </div>
</div>