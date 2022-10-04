<div class="content">
    <h1 class="content_title">{$dbC->title_1}</h1>

    <div class="content_drobisky">
        {include file="boxes/drobisky.tpl"}
    </div>

    <div class="content_datum">
    </div>



    <div class="content_text2">
		K tomuto článku nemáte přístup. Pokud máte k dispozici přihlašovací údaje, zadejte je prosím do formuláře.<br/><br/>
		<form action="" method="post" id="prihlaseni">
			<label class="login_form_label">Jméno</label>
			<div class="login_form_input">
				<input type="text" name="login_user" class="validate[required]" id="login_user"/>
			</div>
			<label class="login_form_label">Heslo</label>
			<div class="login_form_input">
				<input type="password" name="login_pass" class="validate[required]" id="login_pass"/>
			</div>
			<input type="submit" name="submit" value="Odeslat" class="login_form_submit"/>
		</form>		
	</div>

	<!--	Tady budou v pasu vsechny galerie co jsou s pozici middle-->

    <div class="content_galerie">
	{if $galleriesBotom|@count > 1}
		{foreach from=$galleriesBotom item=dbGallery}
				<div class="galerie_box">
					<a href="javascript: void(0)" onclick="showGallery({$dbGallery->id})" title="{$dbGallery->name}" class="gal_image"><img src="{$dbGallery->gallery_image}" alt="{$dbGallery->name}" border="0" /></a>
					<h2 class="gal_name"><a href="/" title="{$dbGallery->name}">{$dbGallery->name}</a></h2>
					<div class="gal_popis">Fotografií v galerii: {$dbGallery->itemsCount}</div>
				</div>
		{/foreach}
	{/if}

	<div id="galerieDetail">
		{if $galleriesBotom|@count == 1}
			{include file="content/fotogalerie/galerieDetail.tpl" dbGallery=$galleriesBotom.0}
		{/if}
	</div>
    </div>


    <div class="content_galerie">
        {foreach from=$dbCC->getMappedGalleries(dbGallery::TYPE_FILES) item=dbGallery}
            {include file="content/fotogalerie/content_download_do_stranky.tpl" gal=$dbGallery}
        {/foreach}
    </div>


    {include file="content/content_video.tpl"}


</div>

