<table align="left" width="100%" style="border: solid 1px black;">
	{foreach from=$p_cart.ITEMS item=item name=for_cart_items}
		{if $smarty.foreach.for_cart_items.index eq 0}
			<tr style="background-color: lightgray;">
				{foreach from=$item->PROPS key=prop_name item=prop_value}
					{if $prop_name != "kod_cd" AND $prop_name != "doba_dodani"}<th>{$prop_name|translate}</th>{/if}
				{/foreach}
				<!--<th>Cena po slevě/ks</th>-->
				<th>Cena/ks</th>
				<th>Počet</th>
				<th>Cena celkem</th>
			</tr>
		{/if}
		<tr>
			{foreach from=$item->PROPS key=prop_name item=property}
				{if $prop_name != "kod_cd" AND $prop_name != "doba_dodani"}<td>{$property->value}</td>{/if}
			{/foreach}
			<td align="right">{$item->price_vat|price}</td>
			<!--<td align="right">{$item->price_raw_vat|price}</td>-->
			<td align="right">{$item->count} ks</td>
			<td align="right">{$item->SUM_VAT|price}</td>

		</tr>
	{/foreach}
</table>
<div style="clear: both"></div><br/><br/>
<table align="right">
	<tr>
		<th align="right">Cena zboží celkem:</th>
		<th align="right">{$p_cart.ITEMS_SUM_VAT|price}</th>
	</tr>
	{*
	<tr>
		<th align="right">Doprava:</th>
		<th align="right">{$p_cart.TRANSPORT_SUM|price} {$p_cart.PRICE_UNIT}</th>
	</tr>
	<tr>
		<th align="right">Celkem:</th>
		<th align="right">{$p_cart.SUM|price} {$p_cart.PRICE_UNIT}</th>
	</tr>
	<tr>
		<th align="right">Celkem vč. DPH:</th>
		<th align="right">{$p_cart.SUM_VAT|price} {$p_cart.PRICE_UNIT}</th>
	</tr>			
	*}
	
</table><br/><br/>
<div class="clear"></div><br/><br/>