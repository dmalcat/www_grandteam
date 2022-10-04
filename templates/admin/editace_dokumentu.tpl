<h1 class="clanek_title">OBSAH DOKUMENTŮ / EDITACE DOKUMENTŮ -  [ odkaz: {$dbGallery->getUrl()} ] </h1>
<div class="galerie_levy_sloupec">
	<span class="label">Soubory v dokumentech</span>
	<div class="galerie_bg">
		<div class="galerie_bg_popis">
			<div class="galerie_bg_popis1">Pořadí</div>
			<div class="galerie_bg_popis2">Zobrazit</div>
			<!--  <div class="galerie_bg_popis3">Upravit</div> -->
			<div class="galerie_bg_popis4">Smazat</div>
		</div>
		<div id="mcs_container">
			<div class="customScrollBox">
				<div class="container">
					<div class="content">
						{foreach from=$dbGallery->getImages(false) item=dbGalleryImage name=fotogalerie}
							<div class="foto_box" style="background-color:{cycle values="#EBEBEB,#fff"}" id="galleryImage_{$dbGalleryImage->id}">
								<div class="foto_poradi">
									<a href="javascript:void(0)" title="Posunout soubor dolů" class="foto_sipka_dolu" onclick="return sortGalleryImage({$dbGalleryImage->id}, {$dbGallery->id}, 'down')"></a>
									<a href="javascript:void(0)" title="Posunout soubor nahoru" class="foto_sipka_nahoru" onclick="return sortGalleryImage({$dbGalleryImage->id}, {$dbGallery->id}, 'up')"></a>
								</div>
								<div class="foto_obr" style="background-image:url(/images/icons/{$dbGalleryImage->fileInfo->big_icon_url});">
									<a href="{$dbGalleryImage->file}" target="_blank">
									</a>
								</div>
								<div class="foto_text">
									<div class="foto_nazev"><input type="text" name="name" value="{$dbGalleryImage->name}" class="imageName uniform" rel="{$dbGalleryImage->id}" id="imageName_{$dbGalleryImage->id}"/></div>
									<div class="foto_popis"><textarea name="fotoDescription" class="imageDescription uniform" rel="{$dbGalleryImage->id}" id="imageDescription_{$dbGalleryImage->id}">{$dbGalleryImage->description}</textarea></div>
								</div>
								<div class="foto_data">
									<div class="foto_zobrazit"><input type="checkbox"  id="imageVisible_{$dbGalleryImage->id}" class="imageVisible" {if $dbGalleryImage->visible}checked="checked"{/if} rel="{$dbGalleryImage->id}" /></div>
									<!--  <div class="foto_upravit"><a href="/" title="Upravit fotku"></a></div> -->

									<div class="foto_smazat"><a href="javascript: void(0)" title="Smazat soubor" id="imageDelete_{$dbGalleryImage->id}" class="imageDelete"  rel="{$dbGalleryImage->id}"></a></div>


									<form action="" method="post" enctype="multipart/form-data" id="galleryImageForm_{$dbGalleryImage->id}">
                                        <div class="foto_vymena">
											<input type="file" name="file" class="galleryImageFileInput" rel="{$dbGalleryImage->id}"/>
											<input type="hidden" name="file[name]" value="{$dbGalleryImage->name}"/>
											<input type="hidden" name="idImage" value="{$dbGalleryImage->id}"/>
										</div>
										<div class="autor_bg">
											<input type="text" name=""/>
										</div>
										<!--
										  <div class="foto_spec_data">Speciální data:</div>
										<div class="typ_foto">
											<select>
												<option value="">Typ foto: reference</option>
												<option value="">Typ foto: mapa</option>
											</select>
										</div>
										<div class="gps_bg">
											<input type="text" name=""/>
										</div>
										-->
<!--										<input type="submit" value="Upravit soubor" class="submit_upravit_foto" id="galleryImageSubmit_{$dbGalleryImage->id}"/>-->
									</form>
								</div>
							</div>
						{/foreach}
					</div>
				</div>
				<div class="dragger_container">
					<div class="dragger"></div>
				</div>
			</div>
			<a href="#" class="scrollUpBtn"></a> <a href="#" class="scrollDownBtn"></a>
		</div>
	</div>
</div>


<div class="galerie_pravy_sloupec">
	<!--<a href="javascript:void(0)" title="Vložit soubor z počítače" class="upload_foto_tlac">Vložit soubor z počítače</a>-->
	{*<a href="javascript:void(0)" title="Vložit foto z FTP" class="upload_foto_ftp_tlac">Vložit foto z FTP</a>*}
	<div id="text" style="display:none;margin-top:18px;">
		<input type="hidden" name="type" value="file" />
		<input id="file_upload" type="file" name="file_upload" rel="{$dbGallery->id}"/>
	</div>


</div>

<script type="text/javascript" src="/js/admin/dokumenty.js"></script>
