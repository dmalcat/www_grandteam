<div style="float: left; background-color:#5f6c94; border: solid 1px black;">
<form action="" method="post" enctype="multipart/form-data">
	<table width="100%"  border="0" bordercolor="#FFFFFF">
	<tr>
		<th><!--Zobrazit--></th><th><!--Homepage--></th><th>Název položky menu</th><th>Externí odkaz menu</th><th>Řazení</th><th>Nadřazená položka menu</th>
	</tr>
	<tr class="new">
		<th><!--{html_checkboxes name="content_visible" options=$s_yes_no title="zobrazit/skryt"}--></th>
		<th><!--{html_checkboxes name="homepage" options=$s_yes_no title="zobrazit na homepage"}--></th>
		<th><input name="name"/></th>
		<th><input name="url" value="{$p_content_categories.$selected_content_category_id->getUrl()}"/></th>
		<th><input type="text" name="priority"/></th>
		<td><select name="parent_id">
			<option value="">---</option>
				{foreach from=$p_content_categories item=content}
					<option value="{$content->id_content_category}" {if $content->id_content_category == $selected_content_category_id} selected="true" {/if}>{$content->name}</option>
				{/foreach}
		</select></td>
	</tr>
	<tr>
		<th colspan="6">
			<fieldset><legend>Popis menu</legend>
				<textarea name="description" style="width:669px"></textarea>
			</fieldset>
		</th>
	</tr>
	<tr>
		<td><input type="submit" name="content_category_do_insert" value="přidat" class="btn_edit"/></td>
	</tr>
	</table>
</form>
</div>