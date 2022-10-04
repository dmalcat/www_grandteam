{foreach from=dbContentCategory::getAll(1, null, 3) item=dbContentCategory name=menu}
	{if $dbContentCategory->selected || ($dbCT->id == 6 && $dbContentCategory->seoname == "mesto_a_samosprava") || ($dbContentCategory->id == 4839 && $par_1 == "kalendar")}
		<h2 style="margin-bottom:0px;padding-bottom:10px;">{$dbContentCategory->name|translate}</h2>
		<div class="content_sloupec_box" style="border-bottom: 1px solid #000;">
			<ul id="treeview" class="treeview-famfamfam treeview">
				{if $dbContentCategory->getSubCategories(true, null, $now, $now)|@count}
						{foreach from=$dbContentCategory->getSubCategories(true, null, $now, $now) item=dbContentCategorySub}
								<li>
									<a href="{$dbContentCategorySub->getUrl()}" class="{if $dbContentCategorySub->target}ext {/if}"  target="{$dbContentCategorySub->target}">{$dbContentCategorySub->name|translate}</a>
									{if $dbContentCategorySub->getSubCategories(true, null, $now, $now)|@count}
										<ul>
											{foreach from=$dbContentCategorySub->getSubCategories(true, null, $now, $now) item=dbContentCategorySubSub}
												<li>
													<a href="{$dbContentCategorySubSub->getUrl()}" class="{if $dbContentCategorySubSub->target}ext {/if}" target="{$dbContentCategorySubSub->target}">{$dbContentCategorySubSub->name|translate}</a>
													{if $dbContentCategorySubSub->getSubCategories(true, null, $now, $now)|@count}
														<ul>
														{foreach from=$dbContentCategorySubSub->getSubCategories(true, null, $now, $now) item=dbContentCategorySubSubSub}
															<li><a href="{$dbContentCategorySubSubSub->getUrl()}" class="{if $dbContentCategorySubSubSub->target}ext {/if}" target="{$dbContentCategorySubSubSub->target}">{$dbContentCategorySubSubSub->name|translate}</a></li>
														{/foreach}
														</ul>
													{/if}
												</li>
											{/foreach}
										</ul>
									{/if}
								</li>
						{/foreach}
				{/if}
			</ul>
		</div>
	{/if}
{/foreach}
