<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs">
<head>
<title>Administrace</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Author" content="3nicom.cz" />
<meta name="Robots" content="follow" />
{literal}
<style>
	html, body {
		padding: 0px;
		margin: 0px;
		font-size: 10pt;
		font-family: tahoma;
	}
</style>
{/literal}
</head>
<body>
	<div id="all" style="background-color: white; color: black;">
		<table style="width: 100%; border: solid 2px black; font-size: 10pt;">
			<tr>
				<th colspan="2" align="right" style="border-bottom: solid 1px black;"><h2>Dodací list č.{$p_cart.VARSYMB} <input type="text" style="border: none; background-color: #eee;"/></h2></th>
			</tr>
				<td style="border: solid 1px black; padding: 5px; width: 50%">
					Dodavatel:<br/><br/>
					<div style="padding-left: 20px;">
						<strong>{$DODAVATEL_NAZEV}</strong><br/>
						{$DODAVATEL_ADRESA}<br/>
						{$DODAVATEL_PSC} {$DODAVATEL_MESTO}<br/>
					</div><br/>
					<div style="padding-bottom: 10px; border-bottom: solid 1px black;">
						Telefon: {$DODAVATEL_TELEFON}<br/> 
						Fax: {$DODAVATEL_FAX}<br/><br/>
						<strong>IČ: {$DODAVATEL_IC}</strong><br/>
						DIČ: {$DODAVATEL_DIC}<br/><br/>
						Banka: {$DODAVATEL_BANKA}<br/>
						Číslo účtu: {$DODAVATEL_CU}<br/>
					</div><br/>
					{if $dodaci_udaje_stejna}{assign var=DODACI_UDAJE_STEP value=$FAKTURACNI_UDAJE_STEP}{/if}
					Dodací údaje:<br/><br/>
					<div style="padding-left: 20px; padding-bottom: 10px;">
						{foreach from=$p_user.STEPS.$DODACI_UDAJE_STEP.CATEGORIES item=category}
							{foreach from=$category.PROPERTIES item=property}
									<strong>{$property.PROP_NAME}</strong>: {$property.PROP_VALUE}<br/>
							{/foreach}
						{/foreach}
					</div>
				</td>
				<td style="border: solid 1px black; padding: 5px;" valign="top">
					Fakturační údaje:<br/><br/>
					<div style="padding-left: 20px; border-bottom: solid 1px black; padding-bottom: 10px;">
						{foreach from=$p_user.STEPS.$FAKTURACNI_UDAJE_STEP.CATEGORIES item=category}
							{foreach from=$category.PROPERTIES item=property}
									<strong>{$property.PROP_NAME}</strong>: {$property.PROP_VALUE}<br/>
							{/foreach}
						{/foreach}
					</div><br/>
					Objednávka:<br/><br/>
					<div style="padding-left: 20px; padding-bottom: 10px;">
						Ze dne: {$p_cart.CLOSED|date_format:"%d.%m.%Y"}<br/>
						Přeprava: {$p_cart.TRANSPORT->name}<br/>
						Platba: {$p_cart.PAYMENT->name}<br/>
						Poznámka: {$p_cart.MESSAGE|nl2br} <br/>
					</div>					
				</td>
			<tr>
			</tr>
			<tr>
				<td colspan="2">
					<br/>
					{include file="admin/objednavky/print_cart_2.tpl"}
				</td>
			</tr>
		</table>
		{$p_cart->id_cart}			
	</div>
</body>
</html>
