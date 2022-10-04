{foreach from=dbContentCategory::getAll(null, null, $dbCT->id) item=dbContentCategory name=menu}
		<h2>{$dbContentCategory->name|translate}</h2>
		<div class="content_sloupec_box">
			<ul id="treeview" class="treeview-famfamfam treeview">
				{if $dbContentCategory->getSubCategories()|@count}
						{foreach from=$dbContentCategory->getSubCategories() item=deska}
								<li>
									<span class="aktuality_datum">{$deska->visible_from|date_format:"%d.%m.%Y"} - {$deska->visible_to|date_format:"%d.%m.%Y"} | ({$deska->file1->fileInfo->name}&nbsp;{$deska->file1->size|file_size})</span>
									<h3 class="aktuality_title">
										<a href="{$deska->file1->original}" title="{$deska->name}" class="aktuality_tlacX" style="float: right; font-weight: normal;" >{$deska->name}</a>
									</h3>
								</li>
						{/foreach}
				{/if}
			</ul>
		</div>
{/foreach}
