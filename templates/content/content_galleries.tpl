            {foreach from=$dbCC->getMappedGalleries(dbGallery::TYPE_FOTO) item=dbGallery}
                <div class="galerie_detail">
                	<h2 class="galerie_detail_name">{$dbGallery->name}</h2>
                	<table width="635" border="0" cellpadding="0" cellspacing="0">
                    		<tr>
                    			{foreach from=$dbGallery->getImages() item=image name=for_galerie}
                    				<td align="center" valign="top">
                    					<a href="{$image->dImage}" rel="lightbox[{$dbGallery->seo_name}]" title="{$image->name}" class="galerie_detail_image">
                    						<img src="{$image->tImage}" alt="{$image->name}" border="0" />
                    					</a>
                    					<div class="galerie_detail_image_name">{$image->name}</div>
                    				</td>
                    			{if $smarty.foreach.for_galerie.iteration % 4 ==0}</tr><tr>{/if}
                    		{/foreach}
                    	</tr>
                    </table>
                </div>
            {/foreach}

            {foreach from=$dbCC->getMappedGalleries(dbGallery::TYPE_FILES) item=gal}
                <div class="galerie_detail">
                    <h2 class="galerie_detail_name">{$gal->name}</h2>
                    <table width="635" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                        	<td>
                                <ul style="list-style-type:none;">
                					{foreach from=$gal->getImages(1) item=p_file}
                						<li>
                                            <a href="{$p_file->file}" target="_blank" class="galerie_detail_file">
                                                <strong>{$p_file->name}</strong>
                                            </a>
                						    <div class="galerie_detail_file_name">
                                                {if $p_file->description}
                                                    <a href="{$p_file->file}" target="_blank">
                                                        {$p_file->description}&nbsp;&nbsp;&nbsp;
                                                    </a>
                                                {/if}
                                                <a href="{$p_file->file}" target="_blank">
                                                    <img src="{dbGallery::GALLERY_PATH}{dbGallery::GALLERY_ICONS_PATH}{$p_file->fileInfo->big_icon_url}" width="35" height="42" border="0" align="center"  />
                                                    &nbsp;&nbsp;
                                                    {$p_file->original_size|file_size}
                                                </a>
                                            </div>
                						</li>
                					{/foreach}
                				</ul>
                            </td>
                        </tr>
                    </table>
                </div>
            {/foreach}