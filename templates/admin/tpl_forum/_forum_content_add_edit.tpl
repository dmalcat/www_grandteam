{if $mode==edit}
    <table width="250" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="padding:5px;">
		<input type="hidden" name="id_forum_content" value="{$p_forum_content->id_forum_content}"/>
		<input type="hidden" name="id_parent" value="{$p_forum_content->id_parent}"/>
		<input type="hidden" name="id_author" value="{$p_forum_content->id_author}"/>
		<input type="hidden" name="author_name" value="{$p_forum_content->author_name}"/>
		<input type="hidden" name="author_email" value="{$p_forum_content->author_email}"/>
		<input type="hidden" name="visible" value="{$p_forum_content->visible}"/></td>
  </tr>
  <tr>
      <td style="padding:5px;">
			{section name=foo loop=$MAX_IMAGES_UPLOAD_COUNT}
				{assign var=index value=$smarty.section.foo.iteration}
				{assign var=image_index value=image_$index}
				{if $p_forum_content->$image_index}
					{capture assign='image'}/images_forum/{$p_forum_content->id_forum_content}/{$p_forum_content->$image_index}{/capture} 
					<a href="/images_forum/{$p_forum_content->id_forum_content}/{$p_forum_content->$image_index}" {if $image|file_is_image} rel="shadowbox[{$p_forum_content->id_forum_content}]" {else} target="_blank"{/if} title="{$p_forum_content->$image_index}" />
						<img src="/images/foto_ico.gif" border="0"/>
					</a>
				{/if}
			{/section}
			<br/>
			{section name=foo loop=$MAX_IMAGES_UPLOAD_COUNT}
				{assign var=index value=$smarty.section.foo.iteration}
				Obr.{$index}: <input type="file" name="file[{$index}]" /><br/>
			{/section}
</td>
  </tr>
  <tr>
 
    <td>&nbsp;</td>
  </tr>
  <tr>

  <td style="padding:5px;">	
		<input type="submit" name="do_forum_content_edit" value="upravit" class="btn_edit"/>
		<input type="submit" name="do_forum_content_delete" value="smazat" class="btn_delete" onclick="return confirm('Opravdu smazat ?')"/></td>
  </tr>

</table>
		
	<div style="">
		
	</div>
{/if}
{if $mode==insert}
				    <table width="250" border="0" cellspacing="0" cellpadding="0">
  <tr>
  
    <td style="padding:5px;">
		</td>
  </tr>
  <tr>
      <td style="padding:5px;">
			{section name=foo loop=$MAX_IMAGES_UPLOAD_COUNT}
				{assign var=index value=$smarty.section.foo.iteration}
				{assign var=image_index value=image_$index}
				{if $p_forum_content->$image_index}
					{capture assign='image'}/images_forum/{$p_forum_content->id_forum_content}/{$p_forum_content->$image_index}{/capture} 
					<a href="/images_forum/{$p_forum_content->id_forum_content}/{$p_forum_content->$image_index}" {if $image|file_is_image} rel="shadowbox[{$p_forum_content->id_forum_content}]" {else} target="_blank" {/if} title="{$p_forum_content->$image_index}" />
						<img src="/images/foto_ico.gif" border="0"/>
					</a>
				{/if}
			{/section}
			<br/>
			{section name=foo loop=$MAX_IMAGES_UPLOAD_COUNT}
				{assign var=index value=$smarty.section.foo.iteration}
				Obr.{$index}: <input type="file" name="file[{$index}]" /><br/>
			{/section}
		</td>
  </tr>
  <tr>
 
    <td>&nbsp;</td>
  </tr>
  <tr>

  <td style="padding:5px;">
		<input type="hidden" name="id_forum" value="{$p_forum->id_forum}"/>
		<input type="submit" name="do_forum_content_add" value="vložit" class="btn_edit"/>
	</td>
  </tr>

</table>
		
		
		


	<div style="">
		
	</div>
				
{/if}
{if $mode==reply}
				    <table width="250" border="0" cellspacing="0" cellpadding="0">
  <tr>
  
    <td style="padding:5px;">
	</td>
<!-- 					<input type="hidden" name="id_parent" value="{$p_forum_content->id_forum_content}"/> -->
<!-- 					<input type="submit" name="do_forum_content_add" value="reagovat" class="btn_edit"/> -->
		
  </tr>
  <tr>
      <td style="padding:5px;">
			{section name=foo loop=$MAX_IMAGES_UPLOAD_COUNT}
				{assign var=index value=$smarty.section.foo.iteration}
				{assign var=image_index value=image_$index}
<!-- 				{if $p_forum_content->$image_index}<a href="/images_forum/{$p_forum_content->id_forum_content}/P-{$p_forum_content->$image_index}" rel="shadowbox[{$p_forum_content->id_forum_content}]" title="{$p_forum_content->$image_index}" /><img src="/images/foto_ico.gif" border="0"/></a>{/if} -->
			{/section}
			<br/>
			{section name=foo loop=$MAX_IMAGES_UPLOAD_COUNT}
				{assign var=index value=$smarty.section.foo.iteration}
				Obr.{$index}: <input type="file" name="file[{$index}]" /><br/>
			{/section}
		</td>
  </tr>
  <tr>
 
    <td>&nbsp;</td>
  </tr>
  <tr>

	<td style="padding:5px;">
		<input type="hidden" name="id_parent" value="{$p_forum_content->id_forum_content}"/>
		<input type="hidden" name="reply_email" value="{$p_forum_content->author_email}"/>
		<input type="submit" name="do_forum_content_add" value="reagovat" class="btn_edit"/>
	</td>
  </tr>

</table>

{/if}