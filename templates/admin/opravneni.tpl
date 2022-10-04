<script type="text/javascript">
        jQuery(document).ready( function() {
            jQuery('#vyberRoli').change(function(){
                window.location = jQuery(this).val();
	        });
        });
</script>
<h1 class="clanek_title">OPRÁVNĚNÍ</h1>
<div class="uzivatele_opravneni">

    {if $roleId ne 'null'}
    	<script type="text/javascript">
    			var roleId = {$roleId};
        		jQuery(document).ready( function() {
        			jQuery('#contentTree_1').fileTree({
        				script: '/res/ajax.php?mode=aclContent',
        				postData: { contentType: 2 }
        			 }, function(attributes) {
        				 contentId = attributes.id;
        				 jQuery('#controlList_1').html('Načítám ...');
        				 jQuery.post('/res/ajax.php?mode=aclControllList', { roleId: roleId, contentId: contentId, resourceType: 'content' },
        				 function(data) {
        					 jQuery('#controlList_1').html(data);
        					 jQuery('#controlList_1 .resource').click(function(){
        						 resourceId = jQuery(this).attr('id').replace('resource_', '');
        						 checked = jQuery(this).attr('checked');
        						 jQuery.post('/res/ajax.php?mode=aclControllListSave', { roleId: roleId, contentId: contentId, resourceId: resourceId, checked: checked},
        						 function(data) {});
    					     });

    				     });

    			});

    			jQuery('#system_resources .resource, #content_resources  .resource').click(function(){
                    resourceId = jQuery(this).attr('id').replace('main_resource_', '');
                    checked = jQuery(this).attr('checked');
                    jQuery.post('/res/ajax.php?mode=aclSystemResourceSave', { roleId: roleId, resourceId: resourceId, checked: checked},
                    function(data) {});
                });

    		});
    	</script>

    		{if count($systemoveZdroje)}
    			<div class="uzivatel_opravneni_box">
                    <h2>Systémové zdroje</h2>
    				<table id="system_resources">
    					<tr>
    						<th>Název</th><th style="padding:0px;">Povoleno</th>
    					</tr>
    					{foreach from=$systemoveZdroje item=zdroj}
    						<tr>
    							<td>{$zdroj->resource}</td>
    							<td align="center" style="padding:0px;">
    								{if $zdroj->id|acl:null:$roleId}
    									<input type='checkbox' checked="checked" class='resource' id='main_resource_{$zdroj->id}' />
    								{else}
    									<input type='checkbox' class='resource' id='main_resource_{$zdroj->id}' />
    								{/if}
    							</td>
    						</tr>
    					{/foreach}
    				</table>
    			</div>
    		{/if}
    		{if count($contentZdroje)}
                <div class="uzivatel_opravneni_box_2">
                    <h2>Content zdroje</h2>
    				<table id="content_resources">
    					<tr>
    						<th>Název</th><th style="padding:0px;">Povoleno</th>
    					</tr>
    					{foreach from=$contentZdroje item=zdroj}
    						<tr>
    							<td>{$zdroj->resource}</td>
    							<td align="center" style="padding:0px;">
    								{if $zdroj->id|acl:null:$roleId}
    									<input type='checkbox' checked="checked" class='resource' id='main_resource_{$zdroj->id}' />
    								{else}
    									<input type='checkbox' class='resource' id='main_resource_{$zdroj->id}' />
    								{/if}
    							</td>
    						</tr>
    					{/foreach}
    				</table>
    			</div>
    		{/if}
        <div class="uzivatel_opravneni_tree_box">
            <h2>Omezení struktury</h2>
    		<div id="contentTree_1" style="float: left"></div>
    		<div id="controlList_1" style="float: right;position:absolute;right:0px;top:27px;"></div>
    		<div class="cb"></div>


		<br/><br/>
		<h2>Souhrn aplikovaných restrikcí</h2>
			<table style="font-size: 10px;">
				<tr><th>Obsah</th><th>zobrazit</th><th>editovat</th><th>smazat</th></tr>
				{foreach from=$dbUser->getAclCCEntries($roleId) key=idContentCategory item=entry}
					{if dbContentCategory::getById($idContentCategory)}
						<tr>
							<td>
									{foreach from=dbContentCategory::getById($idContentCategory)->getNavigation() item=cc name=restriction_for}
										<span class="text">{$cc->name}{if !$smarty.foreach.restriction_for.last} > {/if}</span>
									{/foreach}
							</td>
							<td>{if $entry.zobrazit}aplikováno{/if}</td>
							<td>{if $entry.editovat}aplikováno{/if}</td>
							<td>{if $entry.smazat}aplikováno{/if}</td>
						</tr>
					{/if}
				{/foreach}
			</table>

    	</div>
    {/if}




</div>






