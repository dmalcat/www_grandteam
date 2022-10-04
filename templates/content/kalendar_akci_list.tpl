<div class="content_bg">

    <div class="content">
        <h1 class="content_title">{$dbCT->name}</h1>

        <div class="content_drobisky">
            {*include file="boxes/drobisky.tpl"*}
        </div>

        <div class="content_text_aktuality">
                {*foreach from=$dbCCs->sort('datum','desc') item=clanek*}
					{foreach from=dbContentCategory::getAllRecursively(1, null, dbContentType::getBySeoName('kalendar_akci')->id, null, null, null, null,  null, 0)->sort('visible_to','desc')->limit(0,9) item=clanek}
							<h4>
							<br/>Od: {$clanek->visible_from|date_format:'%d.%m.%Y'} Do: {$clanek->visible_to|date_format:'%d.%m.%Y'}<br/>
							<!--{if dbContentCategory::getById($deska->id_parent)->name}<span style="font-size: 80%; color: #9A1935">{dbContentCategory::getById($deska->id_parent)->name}: </span>{/if}
							{$deska->name} </h4>
							<a href="{$deska->file1->original}" title="{$deska->name}" class="aktuality_tlac">{$deska->file1->fileInfo->name} ({$deska->file1->size|file_size})</a><img width="15" src="{dbGallery::GALLERY_PATH}icons/{$deska->file1->fileInfo->icon_url}"/> -->
									<a href="{$clanek->getUrl()}" class="aktuality_menu_title" target="{$clanek->target}">{$clanek->name}</a><br/>
							<br/>
                {/foreach}
        </div>


    </div>

    {include file="boxes/nejnovejsi_z_kategorie.tpl"}

</div>

{include file="boxes/zajimavosti.tpl"}

