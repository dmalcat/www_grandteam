<div class="video_box none" style="bottom:0px;left:0px;margin-top:60px;">
	<h2>PŘIPOJENÉ VIDEA</h2>
	<div class="galerie_box">
		<div class="galerie_box_video">
			Video 1
			<input type="file"  name="content_category_video[]"/>
			<div class="cb"></div>
			<div class="anotacni_obr_videa">
				<div class="anotacni_obr_videa_image" style="background-image:url({$text|default:'/images/admin/obr.png'});">
					{if $dbCC && $dbCC->getVideo(1)}
						<a href="{$dbCC->getVideo(1)->detail->image}" rel="shadowbox[trip1]" id="contentCategoryVideo_1">
							<img src="{$dbCC->getVideo(1)->preview->image}" border="0" alt=" "/>
						</a>
					{/if}
				</div>
			</div>
			{if $dbCC && $dbCC->getVideo(1)}
				<input type="submit" name="" value="Smazat video" class="galerie_video_delete" onclick="return deleteContentCategoryVideo({$dbCC->id}, 1)" id="contentCategoryVideoDelete_1"/>
			{/if}
		</div>
		<div class="galerie_box_video">
			Video 2
			<input type="file"  name="content_category_video[]"/>
			<div class="cb"></div>
			<div class="anotacni_obr_videa">
				<div class="anotacni_obr_videa_image" style="background-image:url({$text|default:'/images/admin/obr.png'});">
					{if $dbCC && $dbCC->getVideo(2)}
						<a href="{$dbCC->getVideo(2)->detail->image}" rel="shadowbox[trip1]" id="contentCategoryVideo_2">
							<img src="{$dbCC->getVideo(2)->preview->image}" border="0" alt=" "/>
						</a>
					{/if}
				</div>
			</div>
			{if $dbCC && $dbCC->getVideo(2)}
				<input type="submit" name="" value="Smazat video" class="galerie_video_delete" onclick="return deleteContentCategoryVideo({$dbCC->id}, 2)" id="contentCategoryVideoDelete_2" />
			{/if}
		</div>
		<div class="galerie_box_video">
			Video 3
			<input type="file"  name="content_category_video[]"/>
			<div class="cb"></div>
			<div class="anotacni_obr_videa">
				<div class="anotacni_obr_videa_image" style="background-image:url({$text|default:'/images/admin/obr.png'});">
					{if $dbCC && $dbCC->getVideo(3)}
						<a href="{$dbCC->getVideo(3)->detail->image}" rel="shadowbox[trip1]" id="contentCategoryVideo_3">
							<img src="{$dbCC->getVideo(3)->preview->image}" border="0" alt=" "/>
						</a>
					{/if}
				</div>
			</div>
			{if $dbCC && $dbCC->getVideo(3)}
				<input type="submit" name="" value="Smazat video" class="galerie_video_delete" onclick="return deleteContentCategoryVideo({$dbCC->id}, 3)" id="contentCategoryVideoDelete_3"/>
			{/if}
		</div>
	</div>
	<div class="galerie_box_submit">
		<input type="hidden" name="id" value="{$dbCC->id}"/>
		<input type="hidden" name="doVideo" value="Uložit videa" class="ulozit_upravy_tlac pozice_uprostred" />
	</div>
</div>