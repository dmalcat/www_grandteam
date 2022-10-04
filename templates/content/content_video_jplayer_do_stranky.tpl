{if $video}
	<div style="clear: both">&nbsp;</div>
	<div id="jp_container_{$index}" class="jp-video " style="width: 100%; margin-left: auto; margin-right: auto;">
		<div class="jp-type-single">
			<div id="jquery_jplayer_{$index}" class="jp-jplayer" style="text-align: center;"></div>
			<div class="jp-gui">
				<div class="jp-video-play">
{*					<a href="javascript:;" class="jp-video-play-icon" tabindex="1">play</a>*}
				</div>
				<div class="jp-interface">
					<div class="jp-progress">
						<div class="jp-seek-bar" align="left">
							<div class="jp-play-bar"></div>
						</div>
					</div>
					<div class="jp-current-time"></div>
					<div class="jp-duration"></div>
					<div class="jp-controls-holder">
						<ul class="jp-controls">
							<li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
							<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
							<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
							<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
							<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
							<li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
						</ul>
						<div class="jp-volume-bar" align="left">
							<div class="jp-volume-bar-value"></div>
						</div>
						<ul class="jp-toggles">
							<li><a href="javascript:;" class="jp-full-screen" tabindex="1" title="full screen">full screen</a></li>
							<li><a href="javascript:;" class="jp-restore-screen" tabindex="1" title="restore screen">restore screen</a></li>
							<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
							<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
						</ul>
					</div>
					<div class="jp-details">
						<ul>
							<li><span class="jp-title"></span></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="jp-no-solution">
				<span>Update Required</span>
				To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
			</div>
		</div>
	</div>
<div style="clear: both">&nbsp;</div><br />
{/if}

<script type="text/javascript">
	//<![CDATA[
	$(document).ready(function() {
		$("#jquery_jplayer_{$index}").jPlayer({
			ready: function() {
				$(this).jPlayer("setMedia", {
					title: "{$name|default:$dbCC->name}",
{*					m4v: "http://www.jplayer.org/video/m4v/Big_Buck_Bunny_Trailer.m4v",*}
{*					m4v: "{$video->detail->video}",*}
					m4v: "{$video}",
{*					ogv: "http://www.jplayer.org/video/ogv/Big_Buck_Bunny_Trailer.ogv",*}
{*					poster: "http://www.jplayer.org/video/poster/Big_Buck_Bunny_Trailer_480x270.png"*}
					poster: "{$image}",
{*					poster: "{$dbGalleryImage->detail->image}"*}
				});
			},
			swfPath: "/plugins/jPlayer",
			supplied: "m4v",
			cssSelectorAncestor: "#jp_container_{$index}",
			globalVolume: true,
			smoothPlayBar: true,
			keyEnabled: true,
			size: {
				width: "100%",
				height: "{$height|if:{$height}:'200px'}"
			}
		});


	{*		$("#jplayer_inspector").jPlayerInspector({ jPlayer: $("#jquery_jplayer_1") });*}
	});
	//]]>
</script>