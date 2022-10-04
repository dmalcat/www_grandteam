<div style="clear: both;">
<!--   <fieldset style="float: left; width:182px; padding:8px;"> -->
<!--     <legend>jazyk</legend> -->
<!--     <form action="{$lnk_base}" method="post" style="float: left;"> -->
<!--       <select name="forum_lang"  onchange="submit()" style="width:170px;"> -->
<!--         <option value="">vyberte</option> -->
<!-- 			{foreach from=$p_forum_langs item=p_forum_lang} -->
<!-- 				<option value="{$p_forum_lang.id_forum_lang}" {if $forum_lang == $p_forum_lang.id_forum_lang} selected{/if}>{$p_forum_lang.name}</option> -->
<!-- 			{/foreach} -->
<!--       </select> -->
<!--     </form> -->
<!--   </fieldset> -->
  <fieldset style="float: left; width:182px; margin-bottom:5px; padding:8px;">
    <legend>typ chatu</legend>
    <form action="{$lnk_base}" method="post" style="float: left;">
      <select name="forum_type"  onchange="submit()" style="width:170px;">
        <option value="">vyberte</option>
			{foreach from=$p_forum_types item=p_forum_type}
				<option value="{$p_forum_type.id_forum_type}" {if $forum_type == $p_forum_type.id_forum_type} selected{/if}>{$p_forum_type.name}</option>
			{/foreach}
      </select>
    </form>
  </fieldset>
<!--   <div class="clear"></div> -->
  <fieldset style="float: left; width:182px; margin-bottom:5px; padding:8px;">
    <legend>kategorie chatu</legend>
    <form action="{$lnk_base}" method="post" style="float: left;">
      <select name="forum_category"  onchange="submit()" style="width:100px;">
        <option value="">vše</option>
			{foreach from=$p_forum_categories item=p_forum_category}
				<option value="{$p_forum_category->id_forum_category}" {if $forum_category == $p_forum_category->id_forum_category} selected{/if}>{$p_forum_category->name}</option>
			{/foreach}
      </select>
    </form>
  </fieldset>

<!--   <div class="clear"></div> -->
  <fieldset style="float: left; width:132px; margin-bottom:5px; padding:8px;">
    <legend>autor</legend>
    <form action="{$lnk_base}" method="post" style="float: left;">
      <select name="forum_author"  onchange="submit()" style="width:100px;">
        <option value="">vše</option>
			{foreach from=$p_forum_authors item=p_forum_author}
				<option value="{$p_forum_author->id_author}" {if $forum_author == $p_forum_author->id_author} selected{/if}>{$p_forum_author->name}</option>
			{/foreach}
      </select>
    </form>
  </fieldset>
	{if $p_forum}
		<fieldset style="float: left; margin-bottom:5px; padding:8px;">
			<legend>pouze nezodpovězené</legend>
			<form action="" method="post" style="float: left;">
				<input type="hidden" name="only_without_replies"  value=""/>
				<input type="checkbox" name="only_without_replies"  onclick="submit()" style="" {if $only_without_replies} checked {/if} />
				<input type="submit" style="display: none;"/>
			</form>
		</fieldset>
		<fieldset style="float: left; width:152px; margin-bottom:5px; padding:8px;">
			<legend>hledání dle id otazky</legend>
			<form action="" method="post" style="float: left;">
				<input type="text" name="filter_id_question"  style="width:70px;" value="{$smarty.post.filter_id_forum_question}"/>
				<input type="submit" name="do_filter_id_question" style="color: black;" value="hledej"/>
			</form>
		</fieldset>

	{/if}


</div>
<div style="clear: both;"><br/></div>