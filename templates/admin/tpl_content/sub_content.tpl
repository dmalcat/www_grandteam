{literal}
	<style>
		.Xcontent_category_image_input { display: none; }
		.Xcontent_category_video_input { display: none; }
	</style>
{/literal}
<div style="float: left; background-color:#5f6c94; border: solid 1px black; color: white;">
	<form action="" method="post" enctype="multipart/form-data" class="admin_table">
		<table width="100%" bordercolor="#FFFFFF" style="width: 690px;">
			<tr>
				<th>Název v menu</th>
				<th>Externí odkaz</th>
				<th>Pořadí</th>
				<th>Zobrazit</th>
				<th>Typ</th>
<!-- 				<th>stránkování - Menu na homepage</th> -->
			</tr>
			<tr>
				<th><input name="name" value="{$p_selected_content_category_name}"/></th>
				<th><input name="external_url" value="{$p_selected_content_category_external_url}"/></th>
				<th><input type="text" name="priority" value="{$p_selected_content_category_priority}" style="width:25px;"/></th>
                <th>
					{html_checkboxes name="content_category_visible" options=$s_yes_no selected=$p_selected_content_category_visible  title="zobrazit/skryt"}
				</th>
				<th>
					<select name="p_selected_content_category_menu">
						<option value="0" {if $p_selected_content_category_menu} == "0"} selected {/if}>článek</option>
						<option value="1" {if $p_selected_content_category_menu} == "1"} selected {/if}>položka menu</option>
					</select>
				</th>
				<th>
	<!-- 					<input type="text" name="sub_content_category_counter_limit" value="{$p_selected_content_category_sub_content_category_counter_limit}"/> -->
<!-- 						<input type="text" name="gps" value="{$p_selected_content_category_gps}"/> -->
				</th>
			</tr>
			<tr>
				<td colspan="1">
					Nadřazené menu<br/>
					<select name="parent_id">
						<option value="">---</option>
						{foreach from=$p_content_categories item=content_category}
							<option value="{$content_category->id_content_category}" {if $content_category->id_content_category == $p_selected_content_category_id_parent} selected="true" {/if}>{$content_category->name}</option>
						{/foreach}
					</select>
				</td>
				<td colspan="2">
					Menu na úvod. stránce<br/>
						{html_checkboxes name="homepage" options=$s_yes_no selected=$p_selected_content_category_homepage  title="zobrazit na homepage"}
				</td>
			</tr>
			<tr {if !$ENABLE_DATUM_ADMIN}style="display: none"{/if}>
<!-- 			<th colspan="4">  -->
<!-- 				<fieldset><legend>Popis položky menu</legend> -->
<!-- 					<textarea name="description" style="width:330px">{$p_selected_content_category_description}</textarea> -->
<!-- 				</fieldset> -->
<!-- 			</th> -->
<!-- 			<td colspan="5"> -->
				<td>datum:&nbsp;<br/><input type="text" name="datum" onclick='scwShow(this,event);' value="{$p_selected_content_category_datum|default:$smarty.now|date_format:"%Y-%m-%d"}" /></td>
				<td>zobrazit od:&nbsp;<br/><input type="text" name="visible_from" onclick='scwShow(this,event);' value="{$p_selected_content_category_visible_from}" /></td>
				<td>zobrazit do:&nbsp;<br/><input type="text" name="visible_to" onclick='scwShow(this,event);' value="{$p_selected_content_category_visible_to}" /></td>
<!--			</td>-->
			</tr>
		</table>
		<div style="clear: both; height: 1px; font-size: 1px; overflow: hidden;">&nbsp;</div>
		{if !$p_content->content_category->id_master}
			{if !$p_selected_content_category_menu}
				<table width="680">
					<tr align="left">
						<th>Titulek</th>
						<th><!--umístit článek na úvodní stránku--></th>
						<th>Šablona</th>
					</tr>
					<tr>
						<td>
							<!--Titulek 1: --><input name="title_1" value="{$content->title_1}"/ style="width: 350px;"><br/>
						</td>
							<td >Text na HP {html_checkboxes name="content_homepage" options=$s_yes_no selected=$content->homepage  title="zobrazit na homepage"}</td>
							<td align="left">
								<select name="id_template">
								{foreach from=$p_templates item=template}
									<option value="{$template->id_template}" {if $content->id_template == $template->id_template} selected {/if}>{$template->name}</option>
								{/foreach}
								</select>
							</td>
					</tr>
					<tr>
						<td colspan="3">{fckeditor BasePath="/fckeditor/" InstanceName="text_1$fck_instance_suffix" Value=$content->text_1|default:'' Width="680" Height="250px" ToolbarSet="Default" CheckBrowser="true" DisplayErrors="true"}</td>
					</tr>
					<tr>
						<td colspan="3">{fckeditor BasePath="/fckeditor/" InstanceName="text_2$fck_instance_suffix" Value=$content->text_2|default:'' Width="680" Height="500px" ToolbarSet="Default" CheckBrowser="true" DisplayErrors="true"}</td>
					</tr>
					</table>
					<table width="100%" bordercolor="#FFFFFF">
					<tr>
						<td>Meta Title</td>
						<td colspan="2"  align="right"><input type="text" style="width:450px" name="meta_title" value="{$content->meta_title}"/></td>
					</tr>
					<tr>
						<td>Meta Description</td>
						<td colspan="2" align="right"><input type="text" style="width:450px" name="meta_description" value="{$content->meta_description}"/></td>
					</tr>
					<tr>
						<td>Meta Keywords</td>
						<td colspan="2" align="right"><input type="text" style="width:450px" name="meta_keywords" value="{$content->meta_keywords}"/></td>
					</tr>
					<tr>
						<td colspan="3"><hr/></td>
					</tr>
					<tr>
							<td colspan="1" valign="top">Anotační obrázek<br/>
							<input type="file" name="content_category_image[]" /><br/>
							{if $p_selected_content_category_image_1}
								<input type="checkbox" name="content_category_image_delete[1]" />smazat obrázek<br/>
								<a href="{$p_selected_content_category_images_path}{$p_selected_content_category_image_1}" rel="shadowbox[content_image]"><img height="25" src="{$p_selected_content_category_images_path}T-{$p_selected_content_category_image_1}"/></a>
							{/if}
<!--
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
-->
					</tr>
<!--					<tr>
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
-->
  					<tr>
						<td colspan="3"><hr/></td>
					</tr>
					<tr>
						{if $p_selected_content_category->seo_name == "homepage"}
							<td colspan="1" valign="top">před video<br/>
						{else}
							<td colspan="1" valign="top">video k článku<br/>
						{/if}
							<input type="file" name="content_category_video[]" class="content_category_video_input"  /><br/>
							<!--
         <input type="text" name="{$content_category_video_url}[1]" id="{$content_category_video_url}[1]" style="float:left;"/>
                            <a href="#" onclick="BrowseServer('{$content_category_video_url}[1]'); return false;">
                            <div class="btn_edit" style="width:30px; height:12px; text-align:center; float:left; margin-left:5px;">FTP</div></a><br/>
       -->
							{if $p_selected_content_category_video_1}</div>
								<div style="float:left; width:150px;margin:5px;">
								<a href="/videos_content_category/{$selected_content_category_id}/preview/{$p_selected_content_category_video_1}" rel="shadowbox[content_video]" style="float:left;" ><img height="25" src="{$p_selected_content_category_video_thumbnail_path_1}{$p_selected_content_category_video_thumbnail_1}"/></a><input type="checkbox" name="content_category_video_delete[1]" style="float:left; line-height:25px; margin:5px;"/>smazat video<br/></div>
							{/if}
						</td>
<!--
  						<td colspan="1" valign="top">video 2:<br/>
							<input type="file" name="content_category_video[]" /><br/>
							{if $p_selected_content_category_video_2}
								<input type="checkbox" name="content_category_video_delete[2]" />smazat video<br/>
								<a href="{$p_selected_content_category_video_2}" rel="shadowbox[content_video]"><img height="25" src="{$p_selected_content_category_video_thumbnail_path_2}{$p_selected_content_category_video_thumbnail_2}"/></a>
							{/if}
						</td>
						<td colspan="1" valign="top">video 3:<br/>
							<input type="file" name="content_category_video[]" /><br/>
							{if $p_selected_content_category_video_3}
								<input type="checkbox" name="content_category_video_delete[3]" />smazat video<br/>
								<a href="{$p_selected_content_category_video_3}" rel="shadowbox[content_video]"><img height="25" src="{$p_selected_content_category_video_thumbnail_path_3}{$p_selected_content_category_video_thumbnail_3}"/></a>
							{/if}
						</td>
-->
					</tr>
<!--					<tr>
						<td colspan="3"><hr/></td>
					</tr>

					<tr>
							<td colspan="3">
	 							<input type="hidden" name="id_content_category" value="{$selected_content_category_id}"/> -->
								<input type="hidden" name="id_content" value="{$content->id_content}"/>
								<input type="hidden" name="selected_content_category_id" value="{$selected_content_category_id}"/><!--	tak si tak rikam ze by to tu pro vlozeni nemelo byt ... -->
							</td>
					</tr>
					<tr>
						{if $content_edit}
							<td colspan="2" align="left">
								<input type="submit" name="content_do_edit" value="upravit" class="btn_edit"/>
	<!-- 							<input type="submit" name="content_category_do_edit" value="upravit" class="btn_edit"/> -->
							</td>
							</form>
							<td colspan="2" align="left">
								<form action="/admin/content_category_content/" method="post">
									<input type="hidden" name="selected_content_category_id" value="{$selected_content_category_id}"/><!--	tak si tak rikam ze by to tu pro vlozeni nemelo byt ... -->
									<input type="submit" name="content_do_delete" value="smazat" class="btn_delete" onclick="return confirm('Opravdu smazat {$content->title} ?')"/>
								</form>
	<!-- 							<input type="submit" name="content_category_do_delete" value="smazat" class="btn_delete" onclick="return confirm('Opravdu smazat kategorii {$p_content_categories.$selected_content_category_id->name} ?')"/> -->
							</td>
						{else}
							<td colspan="3" align="left">
								<input type="submit" name="content_do_add" value="vložit" class="btn_edit"/>
							</td>
							</form>
						{/if}
					</tr>
				</table>
		{else}	<!--konec testu na typ menu-->
					<tr>
							<td colspan="3">
								<input type="hidden" name="id_content" value="{$content->id_content}"/>
								<input type="hidden" name="selected_content_category_id" value="{$selected_content_category_id}"/><!--	tak si tak rikam ze by to tu pro vlozeni nemelo byt ... -->
								<input type="submit" name="content_do_edit" value="upravit" class="btn_edit"/>
							</td>
					</tr>
				</form>

		{/if}
	{else}<!--	menu ma id_master - tj zobrazime lnk-->
		<!-- 			Tato položka meny je směřována na text z <a href="/admin/content/{$p_content->content_category_master->id_content_category}/">{$p_content->content_category_master->name}</a> -->
		</form>
		Tato položka meny je směřována na text z "{$p_content->content_category_master->name}" z meny "{$p_content->content_category_master->content_type->name}"
		<form action="/admin/content/{$p_content->content_category_master->id_content_category}/" method="post" style="display: inline;">
			<input type="hidden" name="content_type" value="{$p_content->content_category_master->content_type->id_content_type}"/>
			<input type="submit" name="do_change_content_type" value="přejít"/>
		</form>
	{/if}

<div style="clear: both;">&nbsp;</div>
</div>
