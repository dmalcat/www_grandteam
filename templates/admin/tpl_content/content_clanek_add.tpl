<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="Author" content="3nicom.cz" />
	<meta name="Robots" content="follow" />
	<link href="/templates/admin/css/page_style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div style="margin-left:auto;margin-right:auto;height: auto;width:640px;">
<div style="float: left; width:640px;background-color:#DEDEDE; border: solid 1px black;margin:10px 0px;">
	<form action="" method="post" enctype="multipart/form-data">
   		<div style="clear: both; height: 1px; font-size: 1px; overflow: hidden;">&nbsp;</div>
			<table width="100%">
				<tr align="left">
					<td style="font-size:11px;color:#000;">Titulek &nbsp;<input name="title_1" value="{$content->title_1}" style="width: 250px;" />
                    </td>
					<td>
					    <select name="content_category_styly">
					        <option value="">Vyberte styl:</option>
					        {foreach from=$kategorieStyly item=kategorie}
					           {if $zvolenaKategorie == $kategorie->cat_id}
					               <option selected="selected" value="{$kategorie->cat_id}">{$kategorie->name}</option>
					           {else}
					               <option value="{$kategorie->cat_id}">{$kategorie->name}</option>
					           {/if}
					        {/foreach}
					    </select>
				    </td>
				   <td>
					    <select name="content_category_autor">
					        <option value="">Vyberte autora:</option>
					        {foreach from=$autori item=autor}
					           {if $zvolenyAutor == $autor->id_user}
					               <option selected="selected" value="{$autor->id_user}">{$autor->PROPERTIES.34->VALUES}</option>
					           {else}
					               <option value="{$autor->id_user}">{$autor->PROPERTIES.34->VALUES}</option>
					           {/if}
					        {/foreach}
					    </select>
				    </td>
				</tr>
    			<tr>
					<td colspan="3">Anotační text<br />{fckeditor BasePath="/fckeditor/" InstanceName="text_1$fck_instance_suffix" Value=$content->text_1|default:'' Width="630" Height="130px" ToolbarSet="Basic" CheckBrowser="true" DisplayErrors="true"}</td>
				</tr>
				<tr>
					<td colspan="3">Dlouhý text<br />{fckeditor BasePath="/fckeditor/" InstanceName="text_2$fck_instance_suffix" Value=$content->text_2|default:'' Width="630" Height="200px" ToolbarSet="Default" CheckBrowser="true" DisplayErrors="true"}</td>
				</tr>
				</table>
				<table width="100%" bordercolor="#FFFFFF">
    			
				<tr>
					<td colspan="1" valign="top">obrázek 1:<br/>
						<input type="file" name="content_category_image[]" /><br/>
						{if $p_selected_content_category_image_1}
							<input type="checkbox" name="content_category_image_delete[1]" />smazat obrázek<br/>
							<a href="{$p_selected_content_category_images_path}{$p_selected_content_category_image_1}" rel="shadowbox[content_image]"><img height="25" src="{$p_selected_content_category_images_path}T-{$p_selected_content_category_image_1}"/></a>
						{/if}
					</td>
					<td colspan="1" valign="top">obrázek 2:<br/>
						<input type="file" name="content_category_image[]" /><br/>
						{if $p_selected_content_category_image_2}
							<input type="checkbox" name="content_category_image_delete[2]" />smazat obrázek<br/>
							<a href="{$p_selected_content_category_images_path}{$p_selected_content_category_image_2}" rel="shadowbox[content_image]"><img height="25" src="{$p_selected_content_category_images_path}{$p_selected_content_category_image_2}"/></a>
						{/if}
					</td>
					<td colspan="1" valign="top">obrázek 3:<br/>
						<input type="file" name="content_category_image[]" /><br/>
						{if $p_selected_content_category_image_3}
							<input type="checkbox" name="content_category_image_delete[3]" />smazat obrázek<br/>
							<a href="{$p_selected_content_category_images_path}{$p_selected_content_category_image_3}" rel="shadowbox[content_image]"><img height="25" src="{$p_selected_content_category_images_path}{$p_selected_content_category_image_3}"/></a>
						{/if}
					</td>
				</tr>
				<tr>
					<td colspan="1" valign="top">obrázek 4:<br/>
						<input type="file" name="content_category_image[]" /><br/>
						{if $p_selected_content_category_image_4}
							<input type="checkbox" name="content_category_image_delete[4]" />smazat obrázek<br/>
							<a href="{$p_selected_content_category_images_path}{$p_selected_content_category_image_4}" rel="shadowbox[content_image]"><img height="25" src="{$p_selected_content_category_images_path}{$p_selected_content_category_image_4}"/></a>
						{/if}
					</td>
					<td colspan="1" valign="top">obrázek 5:<br/>
						<input type="file" name="content_category_image[]" /><br/>
						{if $p_selected_content_category_image_5}
							<input type="checkbox" name="content_category_image_delete[5]" />smazat obrázek<br/>
							<a href="{$p_selected_content_category_images_path}{$p_selected_content_category_image_5}" rel="shadowbox[content_image]"><img height="25" src="{$p_selected_content_category_images_path}{$p_selected_content_category_image_5}"/></a>
						{/if}
					</td>
					<td colspan="1" valign="top">obrázek 6:<br/>
						<input type="file" name="content_category_image[]" /><br/>
						{if $p_selected_content_category_image_6}
							<input type="checkbox" name="content_category_image_delete[6]" />smazat obrázek<br/>
							<a href="{$p_selected_content_category_images_path}{$p_selected_content_category_image_6}" rel="shadowbox[content_image]"><img height="25" src="{$p_selected_content_category_images_path}{$p_selected_content_category_image_6}"/></a>
						{/if}
					</td>
				</tr>
				<tr>
					<td colspan="1" valign="top">obrázek 7:<br/>
						<input type="file" name="content_category_image[]" /><br/>
						{if $p_selected_content_category_image_7}
							<input type="checkbox" name="content_category_image_delete[7]" />smazat obrázek<br/>
							<a href="{$p_selected_content_category_images_path}{$p_selected_content_category_image_7}" rel="shadowbox[content_image]"><img height="25" src="{$p_selected_content_category_images_path}{$p_selected_content_category_image_7}"/></a>
						{/if}
					</td>
					<td colspan="1" valign="top">obrázek 8:<br/>
						<input type="file" name="content_category_image[]" /><br/>
						{if $p_selected_content_category_image_8}
							<input type="checkbox" name="content_category_image_delete[8]" />smazat obrázek<br/>
							<a href="{$p_selected_content_category_images_path}{$p_selected_content_category_image_8}" rel="shadowbox[content_image]"><img height="25" src="{$p_selected_content_category_images_path}{$p_selected_content_category_image_8}"/></a>
						{/if}
					</td>
					<td colspan="1" valign="top">obrázek 9:<br/>
						<input type="file" name="content_category_image[]" /><br/>
						{if $p_selected_content_category_image_9}
							<input type="checkbox" name="content_category_image_delete[9]" />smazat obrázek<br/>
							<a href="{$p_selected_content_category_images_path}{$p_selected_content_category_image_9}" rel="shadowbox[content_image]"><img height="25" src="{$p_selected_content_category_images_path}{$p_selected_content_category_image_9}"/></a>
						{/if}
					</td>
				</tr>
				<tr>
					<td colspan="3"><hr/></td>
				</tr>
				<tr>
					<td colspan="1" valign="top">video 1:<br/>
						<input type="file" name="content_category_video[]" /><br/>
						{if $p_selected_content_category_video_1}
							<input type="checkbox" name="content_category_video_delete[1]" />smazat video<br/>
							<a href="/videos_content_category/{$selected_content_category_id}/preview/{$p_selected_content_category_video_1}" rel="shadowbox[content_video]"><img height="25" src="{$p_selected_content_category_video_thumbnail_path_1}{$p_selected_content_category_video_thumbnail_1}"/></a>
						{/if}
					</td>
				</tr>
				<tr>
					<td colspan="3"><hr/></td>
				</tr>
				<tr>
						<td colspan="3">
							<input type="hidden" name="id_content" value="{$content->id_content}"/>
							<input type="hidden" name="selected_content_category_id" value="{$selected_content_category_id}"/><!--	tak si tak rikam ze by to tu pro vlozeni nemelo byt ... -->
						</td>
				</tr>
				<tr>
					{if $content_edit}
						<td colspan="2" align="left">
							<input type="submit" name="content_do_edit" value="upravit" class="btn_edit"/>
						</td>
						</form>
						<td colspan="2" align="left">
							<form action="/admin/content_category_content/" method="post">
								<input type="hidden" name="selected_content_category_id" value="{$selected_content_category_id}"/><!--	tak si tak rikam ze by to tu pro vlozeni nemelo byt ... -->
								<input type="submit" name="content_do_delete" value="smazat" class="btn_delete" onclick="return confirm('Opravdu smazat {$content->title} ?')"/>
							</form>
						</td>
					{else}
						<td colspan="3" align="left">
							<input type="submit" name="content_do_add" value="vložit" class="login_submit"/>
						</td>
						</form>
					{/if}
				</tr>
			</table>

<div style="clear: both;">&nbsp;</div>
</div>
</div>
</body>
</html>
