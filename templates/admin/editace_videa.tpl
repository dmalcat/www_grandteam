<h1 class="clanek_title">OBSAH VIDEOGALERIE / EDITACE VIDEOGALERIE -  [ odkaz: {$dbGallery->getUrl()} ]</h1>
<div class="galerie_levy_sloupec">
	<span class="label">Videa v galerii</span>
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
									<input id="imagePriority_{$dbGalleryImage->id}" type="text" name="priority" value="{$dbGalleryImage->priority}" style="width: 20px; margin-left: 10px;" class="imagePriority uniform"  rel="{$dbGalleryImage->id}"/>
{*									<a href="javascript:void(0)" title="Posunout fotku dolů" class="foto_sipka_dolu" onclick="return sortGalleryImage({$dbGalleryImage->id}, {$dbGallery->id}, 'down')"></a>*}
{*									<a href="javascript:void(0)" title="Posunout fotku nahoru" class="foto_sipka_nahoru" onclick="return sortGalleryImage({$dbGalleryImage->id}, {$dbGallery->id}, 'up')"></a>*}
								</div>
								<div class="foto_obr">
									<a href="{$dbGalleryImage->pImage}" rel="shadowbox[]">
										<img src="{$dbGalleryImage->pImage}" alt=" " border="0" />
									</a>
								</div>
								<div class="foto_text">
									<div class="foto_nazev"><input type="text" value="{$dbGalleryImage->name}" class="imageName uniform" rel="{$dbGalleryImage->id}" id="imageName_{$dbGalleryImage->id}"/></div>
									<div class="foto_popis"><textarea name="fotoDescription" class="imageDescription uniform" rel="{$dbGalleryImage->id}" id="imageDescription_{$dbGalleryImage->id}">{$dbGalleryImage->description}</textarea></div>
								</div>
								<div class="foto_data">
									<div class="foto_zobrazit"><input type="checkbox"  id="imageVisible_{$dbGalleryImage->id}" class="imageVisible" {if $dbGalleryImage->visible}checked="checked"{/if} rel="{$dbGalleryImage->id}" /></div>
									<!--  <div class="foto_upravit"><a href="/" title="Upravit fotku"></a></div> -->

									<div class="foto_smazat"><a href="javascript: void(0)" title="Smazat video" id="imageDelete_{$dbGalleryImage->id}" class="imageDelete"  rel="{$dbGalleryImage->id}"></a></div>


									<form action="" method="post" enctype="multipart/form-data" id="galleryImageForm_{$dbGalleryImage->id}">
										<div class="foto_vymena">
											<input type="file" name="video" class="galleryImageFileInput" rel="{$dbGalleryImage->id}"/>
											<input type="hidden" name="video[name]" value="{$dbGalleryImage->name}"/>
											<input type="hidden" name="idImage" value="{$dbGalleryImage->id}"/>
										</div>
										<div class="odkaz_bg">
											<input type="text" name="url" class="imageUrl" id="imageUrl_{$dbGalleryImage->id}" placeholder="odkaz videa ..."   rel="{$dbGalleryImage->id}" value="{$dbGalleryImage->url}"/>
										</div>
										<div class="autor_bg">
											<input type="text" name="author" class="imageAuthor" id="imageAuthor_{$dbGalleryImage->id}" placeholder="autor videa ..."   rel="{$dbGalleryImage->id}" value="{$dbGalleryImage->author}"/>
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
<!--										<input type="submit" value="Upravit fotografii" class="submit_upravit_foto" id="galleryImageSubmit_{$dbGalleryImage->id}"/>-->
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
	<!--<a href="javascript:void(0)" title="Vložit foto z počítače" class="upload_foto_tlac">Vložit foto z počítače</a>-->
	{*<a href="javascript:void(0)" title="Vložit foto z FTP" class="upload_foto_ftp_tlac">Vložit foto z FTP</a>*}
	<div id="text" style="display:none;margin-top:18px;">
		<input type="hidden" name="type" value="video"/>
		<input id="file_upload" type="file" name="file_upload" rel="{$dbGallery->id}"/>
	</div>


</div>

<script type="text/javascript" src="/js/admin/videa.js"></script>
