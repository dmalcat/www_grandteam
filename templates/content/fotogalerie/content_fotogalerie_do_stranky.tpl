<div class="galerie margin-top-5 mt30 ">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-gray">
                {$dbGallery->name}
            </h2>
            <div class="row">
                {*<div class="text-white padding-left-15 padding-right-15">
                {$dbGallery->annotation}
                </div>*}
                {foreach from=$dbGallery->getImages() item=image name=for_galerie}
                    <div class="col-md-2 col-sm-4 col-xs-6 mb20">
                        {*						<div class="row">*}
                        {*<div class="col-md-12 text-center shadow margin-bottom-5 text-black" style="height: 20px; overflow: hidden">
                        {$image->name|replace:'.JPG':''|truncate:40}
                        </div>*}
                        {*						</div>*}
                        <div class="text-center">
                            <div class="shadow">
                                {*									<a href="{$image->dImage}" rel="shadowbox[trip]" title="{$image->name}" class="galerie_detail_image" >*}
                                <a href="{$image->oImage}" title="{$image->description|nl2br}" class="galerie_detail_image swipebox image_wrap" >
                                    <img class="img-responsive shadow-white img-rounded image_image" src="{$image->dImage}" alt="{$image->name}" title="{$image->name}"/>
                                </a>
                            </div>
                        </div>
                        {*<div class="row">
                        <div class="col-md-12">
                        <div class="thumbnail mb0 background-gray-light">
                        <span class="">{$image->getName()}	</span>
                        </div>
                        </div>
                        </div>*}
                    </div>
                    {if $smarty.foreach.for_galerie.iteration % 6 ==0}<div class="clearfix visible-md visible-lg"></div>{/if}
                    {if $smarty.foreach.for_galerie.iteration % 3 ==0}<div class="clearfix visible-sm"></div>{/if}
                    {if $smarty.foreach.for_galerie.iteration % 2 ==0}<div class="clearfix visible-xs"></div>{/if}
                {/foreach}
            </div>
        </div>
    </div>
</div>

