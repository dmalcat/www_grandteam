<div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        {foreach from=dbGallery::getById(1)->getImages() item=item name=forSlider}
            <li data-target="#myCarousel" data-slide-to="0" {if $smarty.foreach.forSlider.first}class="active"{/if}>
            </li>
        {/foreach}
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        {foreach from=dbGallery::getById(1)->getImages() item=item name=forSlider}
            <div class="item {$smarty.foreach.forSlider.first|if:'active':''}">
                <img src="{$item->oImage}" alt="{$item->name}" class="img-full">
                <div class="carousel-caption">
                    {*                    <h3><a href="{$item->getUrl()}" {if $item->getTarget()}target="{$item->getTarget()}"{/if}class="text-white text-bold">{$item->name}</a></h3>*}
                    <small class="text-white">{$item->datum|date_format:'%d.%m.%Y'}</small>
                    {*                    <p>{$item->getContent()->text_1}</p>*}
                </div>
            </div>
        {/foreach}




    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span class="sr-only">Next</span>
    </a>
</div>