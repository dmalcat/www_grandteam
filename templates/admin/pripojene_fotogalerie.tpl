<div class="fotogalerie_box">
    <h2>PŘIPOJENÉ FOTOGALERIE {if $dbCC}({$dbCC->getMappedGalleries(dbGallery::TYPE_FOTO)|@count}){/if}</h2>
    {if $dbCC}
        {foreach from=$dbCC->getMappedGalleries(dbGallery::TYPE_FOTO) item=pGallery name=fotogalerie}
            <form action="" method="post" id="doMapGalleryFoto">
                <div class="galerie_box">
                    <div class="galerie_cislo">{$smarty.foreach.fotogalerie.iteration}</div>
                    <div class="galerie_text" style="margin-left: 0px; width: 250px;">{$pGallery->title|truncate:45}</div>
                    <div class="galerie_text" style="margin-left: 0px; width: 250px;">
                        porřadi:&nbsp; <input type="text" name="priority" rel="{$pGallery->id_content_map_gallery}" value="{$pGallery->priority}" style="width: 50px;" class="gallery_priority"/>
                    </div>
                    {*	<div class="galerie_text">UMÍSTĚNÍ</div>
                    <div class="galerie_select">
                    <select name="galleryPosition" rel="{$pGallery->id}" class="galleryPositionChanger">
                    <option value="{dbGallery::POSITION_TOP}" {if $pGallery->position == dbGallery::POSITION_TOP} selected="selected"{/if}>nahoru</option>
                    <option value="{dbGallery::POSITION_MIDDLE}" {if $pGallery->position == dbGallery::POSITION_MIDDLE} selected="selected"{/if}>střed</option>
                    <option value="{dbGallery::POSITION_BOTTOM}" {if $pGallery->position == dbGallery::POSITION_BOTTOM} selected="selected"{/if}>dolů</option>
                    </select>
                    </div> *}
                    <input type="hidden" name="idGallery" value="{$pGallery->id}"/>
                    <input type="hidden" name="galleryPriority" value="{dbGallery::DEFAULT_PRIORITY}"/>
                    <input type="submit" title="Odebrat galerii od článku" name="doUnMapGallery" class="pridat_spojeni" value="ODEBRAT PŘIPOJENÍ" onclick="return confirm('Opravdu odebrat propojeni s touto galerií ?')">
                </div>
            </form>
        {/foreach}
    {/if}
    <div class="galerie_box">
        <form action="" method="post">
            <div class="galerie_cislo"></div>
            <div class="galerie_select">
                <select name="idGallery">
                    <option value=""> -- vyberte -- </option>
                    {foreach from=dbGallery::getAll(dbGallery::TYPE_FOTO) item=pGallery}
                        <option name="idGallery" value="{$pGallery->id_gallery}">{$pGallery->title|truncate:40}</option>
                        {*foreach from=$pGallery->getSubGalleries() item=pGallerySub}
                        <option name="idGallery" value="{$pGallerySub->id_gallery}">&nbsp;&nbsp;-&nbsp;{$pGallerySub->title|truncate:40}</option>
                        {/foreach*}
                    {/foreach}
                </select>
            </div>
            {*	<div class="galerie_text">UMÍSTĚNÍ</div>
            <div class="galerie_select">
            <select name="galleryPosition">
            <option value="{dbGallery::POSITION_TOP}">nahoru</option>
            <option value="{dbGallery::POSITION_MIDDLE}">střed</option>
            <option value="{dbGallery::POSITION_BOTTOM}">dolů</option>
            </select>
            </div>   *}
            <input type="hidden" name="galleryPriority" value="{dbGallery::DEFAULT_PRIORITY}"/>
            <input type="submit" title="Přidat galerii k článku" name="doMapGallery" class="pridat_spojeni" value="PŘIPOJIT K ČLÁNKU">
        </form>
    </div>
</div>