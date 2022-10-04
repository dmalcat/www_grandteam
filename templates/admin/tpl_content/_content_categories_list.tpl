<div style="margin-left: 15px;  width:250px;" id="content_category_tree"  class="filetree">
	<ul style="  width:220px;">
		{foreach from=$p_content_menu.$p_selected_content_type_seoname->CATEGORIES item=item}
			<li {if $item->id_content_category == $par_3}class="on"{/if} >
				<span class="{if $item->num_child}folder{else}file{/if}">
					{if $item->Xmenu}<span onclick="$('#parent_id_select').val('{$item->name}');">{$item->name}</span>{else}<a href="{$lnk_base}{$item->id_content_category}/">{$item->name}</a>{/if}
				</span>
				{if $item->CATEGORIES|@count}
					<ul>
						{foreach from=$item->CATEGORIES item=sub_item}
							<li {if $sub_item->SELECTED}style="font-weight: bold; background-color: yellow;"{/if}>
								<span class="{if $sub_item->num_child}folder{else}file{/if}">
									{if $sub_item->Xmenu}<span onclick="$('#parent_id_select').val('{$sub_item->name}');">{$sub_item->name}</span>{else}<a href="{$lnk_base}{$sub_item->id_content_category}/" >{$sub_item->name}</a>{/if}
								</span>
								{if $sub_item->CATEGORIES|@count}
									<ul>
										{foreach from=$sub_item->CATEGORIES item=sub_sub_item}
											<li {if $sub_sub_item->SELECTED}class="cat_on"{/if}>
                                                <span class="{if $sub_sub_item->num_child}folder{else}file{/if}">
                                                    <a href="{$lnk_base}{$sub_sub_item->id_content_category}/" style="color: #451801;" {if $sub_sub_item->id_content_category == $par_3}class="on"{/if}>{$sub_sub_item->name}</a>
                                                </span>
                                                {if $sub_sub_item->CATEGORIES|@count}
                									<ul>
                										{foreach from=$sub_sub_item->CATEGORIES item=sub_sub_sub_item}
                											<li {if $sub_sub_sub_item->SELECTED}class="cat_on"{/if}>
                                                                <span class="{if $sub_sub_sub_item->num_child}folder{else}file{/if}">
                                                                    <a href="{$lnk_base}{$sub_sub_sub_item->id_content_category}/" style="color: #451801;" {if $sub_sub_sub_item->id_content_category == $par_3}class="on"{/if}>{$sub_sub_sub_item->name}</a>
                                                                </span>
                                                            </li>
                										{/foreach}
                									</ul>
                								{/if}
                                            </li>
										{/foreach}
									</ul>
								{/if}
							</li>
						{/foreach}
					</ul>
				{/if}
			</li>
		{/foreach}
	</ul>
</div>
