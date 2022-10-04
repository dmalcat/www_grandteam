{foreach from=$tree key=key item=item}
<div {if $rec == 1}style="padding-left: 18px;"{else} name="root_elem" class="produkt_tree"{/if} >
	{if is_array($item.CHILDS)}
		<a href="javascript: void(0);" style="text-decoration: none;">
			<div onclick="element_change(document.getElementById('id_{$varname}_{$item.ID}'));" id="id_{$varname}_{$item.ID}" style="width: 10px; background:url(/images/admin/i.png) no-repeat;background-position:left bottom; position: relative; float: left;">
				&nbsp;
			</div>
		</a>
		{if $rec == 1}
			<input type="checkbox" name="{$varname}[]" onchange="" value="{$item.ID}" {if $item.CHECKED == "1"}checked="checked"{/if} /> {$item.NAME}
		{else}
			<input type="hidden" name="" onchange="" value="-1" enabled="false" readonly="true" style="display: none;" /> &nbsp; {$item.NAME}
		{/if}

	{else}
		{if $rec == 1}
            <div>
    			<div style="width: 10px;position: relative; float: left; ">&nbsp;</div>
                <input type="checkbox" id="id_{$varname}_{$item.ID}" name="{$varname}[]" onchange="" value="{$item.ID}" {if $item.CHECKED == "1"}checked="checked"{/if} /> {$item.NAME}
            </div>
        {else}
            <div>
    			<div style="width: 16px;position: relative; float: left; ">&nbsp;</div>
                <input type="hidden" name="" onchange="" value="-1" enabled="false" readonly="true" style="display: none;" /> {$item.NAME}
            </div>
		{/if}
	{/if}

	{if is_array($item.CHILDS)}
		<div style="display: none;">
			{include file="admin/eshop/jstree.tpl" tree=$tree.$key.CHILDS varname=$varname rec=1}
		</div>
	{/if}

	{if $item.CHECKED == "1"}
		<script type="text/javascript">
  <!--
			open_tree(document.getElementById('id_{$varname}_{$item.ID}'));
  -->
		</script>
	{/if}
</div>
{/foreach}
