{if $item}
    <div class="item_seznam_a" onclick="window.location.href = '{$item->getUrl()}'">
        <div class="item_seznam" data-image-src="{$item->getImage(1, "detail", TRUE)->src}">
            <div class="bottom">
                <h2 style="background-color: {$item->getColor()}">{$item->name}</h2>
                <div class="green">
                    {if $categoryName}
                        <div class="category">
                            <span class="content_category cc_{$categoryId}">{$categoryName}</span>
                        </div>
                    {elseif $item->getCategory()}
                        <div class="category">
                            <span class="content_category cc_{$item->getCategory()}">{$item->getCategory(TRUE)}</span>
                        </div>
                    {/if}
                    <div class="description">
                        {*                        {$item->getContent()->text_2}*}
                    </div>
                </div>
            </div>
        </div>
    </div>
{/if}