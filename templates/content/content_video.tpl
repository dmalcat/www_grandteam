{if $dbCC->getVideo(1)->original}
	<video src="{$dbCC->getVideo(1)->original}" width="320" height="240"></video>
{*	<video width="320" height="240" poster="poster.jpg" controls="controls" preload="none">
		<!-- MP4 for Safari, IE9, iPhone, iPad, Android, and Windows Phone 7 -->
		<source type="video/mp4" src="myvideo.mp4" />
		<!-- WebM/VP8 for Firefox4, Opera, and Chrome -->
		<source type="video/webm" src="myvideo.webm" />
		<!-- Ogg/Vorbis for older Firefox and Opera versions -->
		<source type="video/ogg" src="myvideo.ogv" />
		<!-- Optional: Add subtitles for each language -->
		<track kind="subtitles" src="subtitles.srt" srclang="en" />
		<!-- Optional: Add chapters -->
		<track kind="chapters" src="chapters.srt" srclang="en" />
		<!-- Flash fallback for non-HTML5 browsers without JavaScript -->
		<object width="320" height="240" type="application/x-shockwave-flash" data="flashmediaelement.swf">
			<param name="movie" value="flashmediaelement.swf" />
			<param name="flashvars" value="controls=true&file=myvideo.mp4" />
			<!-- Image as a last resort -->
			<img src="myvideo.jpg" width="320" height="240" title="No video playback capabilities" />
		</object>
	</video>*}
{/if}
{if $p_content->content->VIDEOS.1.detail.video}
	<div class="content_video">
		<div id="flashContent" style="float:left; height:318px; width:520px;">
			<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="520" height="318" id="player" align="middle">
				<param name="movie" value="/player.swf" />
				<param name="quality" value="high" />
				<param name="bgcolor" value="#000000" />
				<param name="play" value="true" />
				<param name="loop" value="true" />
				<param name="wmode" value="transparent" />
				<param name="scale" value="showall" />
				<param name="menu" value="true" />
				<param name="devicefont" value="false" />
				<param name="salign" value="" />
				<param name="allowFullScreen" value = "true"/>
				<param name="allowScriptAccess" value="sameDomain" />
				<param name="FlashVars" value="reklamazacatek=false&bannercesta=/&bannerodkaz=/&videocesta={$p_content->content->VIDEOS.1.detail.path}{$p_content->content->VIDEOS.1.detail.video}&reklamakonec=false">
				<!--[if !IE]>-->
				<object type="application/x-shockwave-flash" data="/player.swf" width="520" height="318">
					<param name="movie" value="/player.swf" />
					<param name="quality" value="high" />
					<param name="bgcolor" value="#000000" />
					<param name="play" value="true" />
					<param name="loop" value="true" />
					<param name="wmode" value="transparent" />
					<param name="scale" value="showall" />
					<param name="menu" value="true" />
					<param name="devicefont" value="false" />
					<param name="salign" value="" />
					<param name="allowFullScreen" value = "true"/>
					<param name="allowScriptAccess" value="sameDomain" />
					<param name="FlashVars" value="reklamazacatek=false&bannercesta=/&bannerodkaz=/&videocesta={$p_content->content->VIDEOS.1.detail.path}{$p_content->content->VIDEOS.1.detail.video}&reklamakonec=false">

					<!--<![endif]-->
					<a href="http://www.adobe.com/go/getflash">
						<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="ZĂ­skat aplikaci Adobe Flash Player" />
					</a>
					<!--[if !IE]>-->
				</object>
				<!--<![endif]-->
			</object>
		</div>
	</div>
{/if}
{if $p_content->content->VIDEOS.2.detail.video}
	<div class="content_video">
		<div id="flashContent" style="float:left; height:318px; width:520px;">
			<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="520" height="318" id="player" align="middle">
				<param name="movie" value="/player.swf" />
				<param name="quality" value="high" />
				<param name="bgcolor" value="#000000" />
				<param name="play" value="true" />
				<param name="loop" value="true" />
				<param name="wmode" value="transparent" />
				<param name="scale" value="showall" />
				<param name="menu" value="true" />
				<param name="devicefont" value="false" />
				<param name="salign" value="" />
				<param name="allowFullScreen" value = "true"/>
				<param name="allowScriptAccess" value="sameDomain" />
				<param name="FlashVars" value="reklamazacatek=false&bannercesta=/&bannerodkaz=/&videocesta={$p_content->content->VIDEOS.2.detail.path}{$p_content->content->VIDEOS.2.detail.video}&reklamakonec=false">
				<!--[if !IE]>-->
				<object type="application/x-shockwave-flash" data="/player.swf" width="520" height="318">
					<param name="movie" value="/player.swf" />
					<param name="quality" value="high" />
					<param name="bgcolor" value="#000000" />
					<param name="play" value="true" />
					<param name="loop" value="true" />
					<param name="wmode" value="transparent" />
					<param name="scale" value="showall" />
					<param name="menu" value="true" />
					<param name="devicefont" value="false" />
					<param name="salign" value="" />
					<param name="allowFullScreen" value = "true"/>
					<param name="allowScriptAccess" value="sameDomain" />
					<param name="FlashVars" value="reklamazacatek=false&bannercesta=/&bannerodkaz=/&videocesta={$p_content->content->VIDEOS.2.detail.path}{$p_content->content->VIDEOS.2.detail.video}&reklamakonec=false">

					<!--<![endif]-->
					<a href="http://www.adobe.com/go/getflash">
						<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="ZĂ­skat aplikaci Adobe Flash Player" />
					</a>
					<!--[if !IE]>-->
				</object>
				<!--<![endif]-->
			</object>
		</div>
	</div>
{/if}
{if $p_content->content->VIDEOS.3.detail.video}
	<div class="content_video">
		<div id="flashContent" style="float:left; height:318px; width:520px;">
			<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="520" height="318" id="player" align="middle">
				<param name="movie" value="/player.swf" />
				<param name="quality" value="high" />
				<param name="bgcolor" value="#000000" />
				<param name="play" value="true" />
				<param name="loop" value="true" />
				<param name="wmode" value="transparent" />
				<param name="scale" value="showall" />
				<param name="menu" value="true" />
				<param name="devicefont" value="false" />
				<param name="salign" value="" />
				<param name="allowFullScreen" value = "true"/>
				<param name="allowScriptAccess" value="sameDomain" />
				<param name="FlashVars" value="reklamazacatek=false&bannercesta=/&bannerodkaz=/&videocesta={$p_content->content->VIDEOS.3.detail.path}{$p_content->content->VIDEOS.3.detail.video}&reklamakonec=false">
				<!--[if !IE]>-->
				<object type="application/x-shockwave-flash" data="/player.swf" width="520" height="318">
					<param name="movie" value="/player.swf" />
					<param name="quality" value="high" />
					<param name="bgcolor" value="#000000" />
					<param name="play" value="true" />
					<param name="loop" value="true" />
					<param name="wmode" value="transparent" />
					<param name="scale" value="showall" />
					<param name="menu" value="true" />
					<param name="devicefont" value="false" />
					<param name="salign" value="" />
					<param name="allowFullScreen" value = "true"/>
					<param name="allowScriptAccess" value="sameDomain" />
					<param name="FlashVars" value="reklamazacatek=false&bannercesta=/&bannerodkaz=/&videocesta={$p_content->content->VIDEOS.3.detail.path}{$p_content->content->VIDEOS.3.detail.video}&reklamakonec=false">

					<!--<![endif]-->
					<a href="http://www.adobe.com/go/getflash">
						<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="ZĂ­skat aplikaci Adobe Flash Player" />
					</a>
					<!--[if !IE]>-->
				</object>
				<!--<![endif]-->
			</object>
		</div>
	</div>
{/if}
