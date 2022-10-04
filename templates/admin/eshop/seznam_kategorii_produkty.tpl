<div class="kategorie_menu">
	<div id="content_category_tree" class="treeview">
		<ul>
			{foreach from=dbCategory::getAll(Session::get("category_type")) item=item}
				<li{if $item->xSELECTED}class="on"{/if}><a href="{$lnk_base}{$item->id}/">{$item->name}</a>
					{if $item->getSubCategories()|@count}
						<ul>
							{foreach from=$item->getSubCategories() item=sub_item}
								<li {if $sub_item->SELECTED}class="sub_on"{/if}><a href="{$lnk_base}{$sub_item->id}/" >{$sub_item->name}</a>
									{if $sub_item->getSubcategories()|@count}
										<ul>
											{foreach from=$sub_item->getSubcategories() item=sub_sub_item}
												<li {if $sub_sub_item->SELECTED}class="sub_sub_on"{/if}><a href="{$lnk_base}{$sub_sub_item->id_category}/">{$sub_sub_item->name}</a>
													{if $sub_sub_item->getSubCategories()|@count}
														<ul>
															{foreach from=$sub_sub_item->getSubCategories() item=sub_sub_sub_item}
																<li {if $sub_sub_sub_item->SELECTED}class="sub_sub_sub_on"{/if}><a href="{$lnk_base}{$sub_sub_sub_item->id_category}/">{$sub_sub_sub_item->name}</a>
																	{if $sub_sub_sub_item->getSubCategories()|@count}
																		<ul>
																			{foreach from=$sub_sub_sub_item->getSubCategories() item=sub_sub_sub_sub_item}
																				<li {if $sub_sub_sub_sub_item->SELECTED}class="sub_sub_sub_sub_on"{/if}><a href="{$lnk_base}{$sub_sub_sub_sub_item->id_category}/">{$sub_sub_sub_sub_item->name}</a>
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
					{/if}
				</li>
			{/foreach}
		</ul>
		<li{if $item->xSELECTED}class="on"{/if}><a href="{$lnk_base}/">NEZAŘAZENO</a>
	</div>
</div>