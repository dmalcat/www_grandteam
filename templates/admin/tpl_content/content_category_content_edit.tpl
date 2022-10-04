<div style="float: left; background-color:#5f6c94; border: solid 1px black;">
	<form action="" method="post" enctype="multipart/form-data">
	<table width="100%" bordercolor="#FFFFFF">
		<tr>
		<th><!--Zobrazit--></th><th><!--Homepage--></th><th>Položka</th><th>Externí odkaz</th><th>Pořadí</th><th>Nadřazená položka</th>
		</tr>
		<tr>
		<td><!--{html_checkboxes name="content_visible" options=$s_yes_no title="zobrazit/skryt"}--></td>
		<td><!--{html_checkboxes name="homepage" options=$s_yes_no title="zobrazit na homepage"}--></td>
		<th><input name="name" value="{$p_selected_content->name}"/></th>
		<th><input name="url" value="{$p_selected_content->getUrl()}"/></th>
		<th><input type="text" name="priority" value="{$p_selected_content->priority}"/></th>
		<td><select name="parent_id">
			<option value="">---</option>
					{foreach from=$p_content_categories item=content}
						<option value="{$content->id_content_category}" {if $content->id_content_category == $p_selected_content->id_parent} selected="true" {/if}>{$content->name}</option>
					{/foreach}
			</select></td>
		</tr>
		<tr>
		<th colspan="6">
			<fieldset><legend>Popis</legend>
				<textarea name="description" style="width:669px">{$p_selected_content->description}</textarea>
			</fieldset>
		</th>
		</tr>
		<tr>
		<td>
			<input type="hidden" name="id_content_category" value="{$selected_content_category_id}"/>
			<input type="submit" name="content_category_do_edit" value="upravit" class="btn_edit"/>
		</td>
		<td><input type="submit" name="content_category_do_delete" value="smazat" class="btn_delete" onclick="return confirm('Opravdu smazat kategorii {$p_content_categories.$selected_content_category_id->name} ?')"/></td>
		</tr>
	</table>
	</form>
</div>