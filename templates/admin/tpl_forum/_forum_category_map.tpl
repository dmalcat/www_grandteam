{*
<br/><span style="color:#FFF; font-size:12px; display:block; font-weight:bold;">kategorie</span></br>
<select name="forum_content_category"  style="width:240px;">
	<option value="">vše</option>
	{foreach from=$p_forum_categories item=p_forum_category}
		<option value="{$p_forum_category->id_forum_category}" {if $p_forum_content->id_category == $p_forum_category->id_forum_category} selected{/if}>{$p_forum_category->name}</option>
	{/foreach}
</select>
*}

<!-- <br/><span style="color:black; font-size:12px; display:block; font-weight:bold;">kategorie</span></br> -->
{foreach from=$p_forum_categories item=p_forum_category}
	<input class="no_border" name="forum_content_category[]" type="checkbox" value="{$p_forum_category->id_forum_category}" {if $p_forum_category->id_forum_category|in_array:$p_map->IN_CATEGORIES} checked{/if}/>{$p_forum_category->name}
{/foreach}

