<div class="soubory_box">
		<h2>PŘIPOJENÉ SOUBORY {if $dbCC}({$dbCC->getMappedGalleries(dbGallery::TYPE_FILES)|@count}){/if}</h2>
		{if $dbCC}
			{foreach from=$dbCC->getMappedGalleries(dbGallery::TYPE_FILES) item=pGallery name=fotogalerie}
				 <form action="" method="post">
					<div class="galerie_box">
						<div class="galerie_cislo">{$smarty.foreach.fotogalerie.iteration}</div>
						<div class="galerie_text" style="margin-left: 0px; width: 250px;">{$pGallery->title|truncate:25}</div>
						{*<div class="galerie_text">UMÍSTĚNÍ</div>
						<div class="galerie_select">
							<select name="galleryPosition" rel="{$pGallery->id}" class="galleryPositionChanger">
								<option value="{dbGallery::POSITION_TOP}" {if $pGallery->position == dbGallery::POSITION_TOP} selected="selected"{/if}>nahoru</option>
								<option value="{dbGallery::POSITION_MIDDLE}" {if $pGallery->position == dbGallery::POSITION_MIDDLE} selected="selected"{/if}>střed</option>
								<option value="{dbGallery::POSITION_BOTTOM}" {if $pGallery->position == dbGallery::POSITION_BOTTOM} selected="selected"{/if}>dolů</option>
							</select>
						</div> *}
						<input type="hidden" name="idGallery" value="{$pGallery->id}"/>
						<input type="hidden" name="galleryPriority" value="{dbGallery::DEFAULT_PRIORITY}"/>
						<input type="submit" title="Odebrat soubory od článku" name="doUnMapGallery" class="pridat_spojeni" value="ODEBRAT PŘIPOJENÍ" onclick="return confirm('Opravdu odebrat propojeni s těmito soubory ?')">
					</div>
				 </form>
			{/foreach}
		{/if}
		<div class="galerie_box">
		 	<form action="" method="post" id="doMapGalleryFoto">
				<div class="galerie_cislo"></div>
				<div class="galerie_select">
					<select name="idGallery">
						<option value=""> -- vyberte -- </option>
						{foreach from=dbGallery::getAll(dbGallery::TYPE_FILES) item=pGallery}
							<option name="idGallery" value="{$pGallery->id_gallery}">{$pGallery->title|truncate:40}</option>
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
				<input type="submit" title="Přidat soubory k článku" name="doMapGallery" class="pridat_spojeni" value="PŘIPOJIT K ČLÁNKU">
			 </form>
		</div>
	</div>