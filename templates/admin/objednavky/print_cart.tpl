<table align="left" width="100%" style="border: solid 1px black;">
	{foreach from=$p_cart.ITEMS item=item name=for_cart_items}
		
		{if $smarty.foreach.for_cart_items.index eq 0}
			<tr style="background-color: lightgray;">
				{foreach from=$item->PROPS key=prop_name item=prop_value}
					<th>{$prop_name|translate}</th>
				{/foreach}
				<th>Cena před slevou / ks</th>
				<th>Cena / ks</th>
				<th>Počet</th>
				<th>Cena celkem</th>
			</tr>
		{/if}
		<tr>
			{foreach from=$item->PROPS key=prop_name item=prop}
				{assign var=opt_prop_name value=$prop->prop_name}
				{assign var=opt_prop_value value=$prop->value}
				{if $prop_name == "doba_dodani" AND $item->store > 0}{assign var=opt_prop_value value="1"}{/if}
				<td>{$opt_prop_value}</td>
			{/foreach}


			<td>{$item->price_raw_vat|price}</td>
			<td>{$item->price_vat|price}</td>
			<td>{$item->count} ks</td>
			<td>{$item->SUM_VAT|price}</td>

		</tr>
	{/foreach}
</table>
<div style="clear: both"></div><br/><br/>
<table align="right">
	<tr>
		<th align="right">Cena zboží celkem:</th>
		<th align="right">{$p_cart.ITEMS_SUM_VAT|price}</th>
	</tr>
	<tr>
		<th align="right">Doprava:</th>
		<th align="right">{$p_cart.TRANSPORT_SUM|price}</th>
	</tr>
	{*
	<tr>
		<th align="right">Celkem:</th>
		<th align="right">{$p_cart.SUM|price}</th>
	</tr>
	*}
	<tr>
		<th align="right">Celkem vč. DPH:</th>
		<th align="right">{$p_cart.SUM_VAT|price}</th>
	</tr>			
	
</table><br/><br/>
<div class="clear"></div><br/><br/>