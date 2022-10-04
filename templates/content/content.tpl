{*<div class="parallax-window" data-parallax="scroll" data-image-src="{$dbCC->getImage(1)->src}"></div>*}
<div class="Xbackground-white text-black pt50 content_detail">
    <div class="container">
        <div class="row">
            <div class="pb50">
                {if $dbCC->getImage(1)->image}
                    <div class="detail_img">
                        <img src="{$dbCC->getImage(1)->src}" alt="{$dbCC->name}" class="img-responsive img-full" />
                    </div>
                {/if}
                <div class="Xtext-justify content_text pb50">
                    <h1 class="text-bold mb5 pb5">{$dbCC->name}</h1>
                    <div class="detail_text mt15">{$dbC->text_2}</div>

                    {if $dbCC->getSubcategories() && FALSE}
                        <div class="homepage mt30 mb30">
                            {foreach from=$dbCC->getSubcategories() item=item}
                                <div class="col-md-4 item">
                                    <a href="{$item->getUrl()}">
                                        <div class="wrap" style="background-image: url({$item->getImage(1, NULL, true)->src});">
                                            <h2>{$item->name}</h2>
                                            <div class="content">
                                                {$item->getContent()->text_1}
                                                <div class="clearfix"></div>
                                                <a href="{$item->getUrl()}" class="btn btn_transparent mt15">Vstoupit</a>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            {/foreach}
                            <div class="clearfix"></div>
                        </div>
                    {/if}

                    {if $dbCC->seoname == "kontakty"}
                        <div class="mt30">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2560.9703415771014!2d14.433347316126623!3d50.068117079424376!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x470b947d51a62647%3A0x63fdae91a7f8a58c!2sB%C4%9Blehradsk%C3%A1+858%2F23%2C+120+00+Praha+2-Vinohrady!5e0!3m2!1scs!2scz!4v1538869104860" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                        </div>
                    {/if}





                    {*<div class="row">
                    {foreach from=$dbCC->getImages() item=image name=for_galerie}
                    <div class="col-md-3 col-sm-6 col-xs-6 mb20">
                    <div class="text-center">
                    <div class="shadow">
                    <a href="{$image->src}" title="{$image->image}" class="galerie_detail_image swipebox image_wrap" >
                    <img class="img-responsive shadow-white img-rounded image_image" src="{$image->src}" alt="{$image->image}" title="{$image->image}"/>
                    </a>
                    </div>
                    </div>
                    </div>
                    {if $smarty.foreach.for_galerie.iteration % 3 ==0}<div class="clearfix visible-md visible-lg"></div>{/if}
                    {if $smarty.foreach.for_galerie.iteration % 3 ==0}<div class="clearfix visible-sm"></div>{/if}
                    {if $smarty.foreach.for_galerie.iteration % 2 ==0}<div class="clearfix visible-xs"></div>{/if}
                    {/foreach}
                    </div>*}

                    <div class="Xrow mt15 mb15">
                        <div>
                            {foreach from=$dbCC->getMappedGalleries(dbGallery::TYPE_FOTO) item=gal name=content_galery}
                                {include file="content/fotogalerie/content_fotogalerie_do_stranky.tpl" dbGallery=$gal slider=true}
                            {/foreach}

                            {foreach from=$dbCC->getMappedGalleries(dbGallery::TYPE_FILES) item=gal}
                                {include file="content/fotogalerie/content_download_do_stranky.tpl" dbGallery=$gal}
                            {/foreach}

                            {foreach from=$dbCC->getMappedGalleries(dbGallery::TYPE_VIDEO) item=gal}
                                {foreach from=$gal->getImages(true) item=dbGalleryImage name=for_galerie}
                                    {*$dbGalleryImage|print_p*}
                                    <div class="row text-center">
                                        <div class="col-md-6 col-md-offset-3">
                                            {*include file="content/content_video_jplayer_do_stranky.tpl" video=$dbGalleryImage->dVideo index="g{$smarty.foreach.for_galerie.iteration}" height="300px" image=$dbCC->getImage(1, "detail")->src name=$dbGalleryImage->name*}
                                            {include file="content/content_video_jplayer_do_stranky.tpl" video=$dbGalleryImage->dVideo index="g{$smarty.foreach.for_galerie.iteration}" height="300px" image=$dbGalleryImage->pImage name=$dbGalleryImage->name}
                                        </div>
                                    </div>
                                {/foreach}
                            {/foreach}
                        </div>
                    </div>
                </div>
                <div class="mt30">
                    <h3 class="text-center text-white fs18">MÁTE DOTAZ NEBO POPTÁVKU ? KONTAKTUJTE NÁS</h3>
                    {include file="kontaktni_formular.tpl"}
                </div>
            </div>
        </div>
    </div>
</div>
