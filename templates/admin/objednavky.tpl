{if $id_cart}
	<h1 class="clanek_title">
		Editace objednávky č. {$p_cart.VARSYMB}
        ( zpět na <a href="/admin/objednavky/">seznam</a> )
	</h1>
	{assign var=status value=$p_cart.STATUS}
	<form action="" method="post">
        <div class="objednavka_detail">
            <table cellpadding="0" cellspacing="0">
        		<tr>
        			<th class="table_label_objednavka">#</th>
        			<th class="table_label_objednavka">Zák.</th>
        			<th class="table_label_objednavka">Datum</th>
        			<th class="table_label_objednavka">Pol.</th>
        			<th class="table_label_objednavka">Platba</th>
        			<th class="table_label_objednavka">Uhrazeno</th>
        			<th class="table_label_objednavka">Cena s DPH</th>
        			<th class="table_label_objednavka">Doprava</th>
        <!-- 			<th class="table_label_objednavka">Dárkove balení</th> -->
        			<th class="table_label_objednavka">Kupónová sleva</th>
        			<th class="table_label_objednavka">Stav</th>
        		</tr>
        		<tr class="{$p_cart_status.$status.class}" {if $p_cart.PAYED} style="background-color: green;"{/if}>
        			<th>{$p_cart.VARSYMB}</th>
        			<th>{$p_cart.CUSTOMER.firma.PROP_VALUE}</th>
        			<th>{$dbCart->closed|date_format:'d.m.y H:i'}</th>
        			<th>{$p_cart.ITEMS_COUNT}</th>
        			<th>{$dbCart->getPayment()->name}</th>
        			<th><input type="hidden" name="payed" value="0" /> {html_checkboxes options=$s_yes_no selected=$p_cart.PAYED name="payed" onchange="submit()"}</th>
        			<th nowrap="nowrap">{$p_cart.SUM_VAT|price:$p_cart.CURRENCY->code:$p_cart.CURRENCY->currency_rate}</th>
        <!-- 			<th>{$p_cart.TRANSPORT->name}</th> -->
        			<th>{html_options name="id_transport" options=dbTransport::getAll()|select:'id_transport':'name' selected=$p_cart.TRANSPORT->id_transport onchange="submit()"}</th>
        <!-- 			<th>{if $p_cart.typDarkovehoBaleni == 2}ANO{else}NE{/if}</th> -->
        			<th>{if $dbCart->getUsedKupon()}{$dbCart->getUsedKupon()->code} {$dbCart->getSlevaKupon(1)|price}{else}Žádná{/if}</th>
        			<th>{html_options options=$s_cart_status name="status" selected=$dbCart->getStatus() onchange="submit()"}</th>
        		</tr>
        	</table>
    	</div>
	</form>


	{assign var=compact_cart value=true}
	{include file="admin/objednavky/kosik.tpl"}
	


    <div class="objednavka_doprava_ppl_title ui-accordion-header">
    	<span class="ui-icon ui-icon-circle-plus"></span>
            MODUL PPL - NASTAVENÍ DOPRAVY
    </div>
    <div class="objednavka_doprava_ppl">
		{include file="admin/export/ppl_transport.tpl"}
	</div>
	<div class="objednavka_doprava_dpd_title ui-accordion-header">
    	<span class="ui-icon ui-icon-circle-plus"></span>
            MODUL DPD - NASTAVENÍ DOPRAVY
    </div>
    <div class="objednavka_doprava_dpd">
		{include file="admin/export/dpd_transport.tpl"}
	</div>
	<div class="objednavka_doprava_posta_title ui-accordion-header">
    	<span class="ui-icon ui-icon-circle-plus"></span>
            MODUL ČESKÁ POŠTA - NASTAVENÍ DOPRAVY
    </div>
    <div class="objednavka_doprava_posta">
		{include file="admin/export/cp_transport.tpl"}
	</div>

	{if $pZasilkovna.popis || true}
        <div class="objednavka_doprava_zasilkovna_title ui-accordion-header">
            <span class="ui-icon ui-icon-circle-plus"></span>
                INFORMACE O ZÁSILKOVNĚ
        </div>
        <div class="objednavka_doprava_zasilkovna">
            <div style="float:left;color:#009933;font-size:12px;padding:0px 20px;font-weight:bold;">
              {if $pZasilkovna.popis}
				{$pZasilkovna.popis}
			{else}
				Export pro dopravu: {$p_cart.TRANSPORT->name}
			{/if}
            </div>
				{include file="admin/export/zasilkovna_transport.tpl"}
    	</div>
	{/if}

	<div class="cb"></div>
{else}
	<h1 class="clanek_title">
		Editace objednávek ( zpět na <a href="/admin/objednavky/">seznam</a> )
	</h1>
    <div id="kategorie_produktu" style="background-position: -10px top;">
    	<div style="float: left; width:240px;">
    		{include file="admin/objednavky/filter.tpl"}
    	</div>
    	<div class="objednavka_strankovani">
    		Celkem objednávek: <strong>{$celkovyPocetObjednavek}</strong>
    		<div class="cb"></div>
    		{section name="page_loop" start=0 loop=$pages}
    			{if $smarty.section.page_loop.first}Strana: |&nbsp;{/if}<a href="/admin/objednavky/page/{$smarty.section.page_loop.iteration}/">{$smarty.section.page_loop.iteration}</a> {if !$smarty.section.page_loop.last}|{/if}
    		{/section}
    	</div>
        <div class="objednavka_list">
            <table cellpadding="0" cellspacing="0">
        		 <tr align="right">
        			<th class="table_label_objednavka">#</th>
        			<th class="table_label_objednavka">Zákazník</th>
        			<th class="table_label_objednavka">Datum</th>
        			<th class="table_label_objednavka">Doprava</th>
        			<th class="table_label_objednavka">Platba</th>
        			<th class="table_label_objednavka">Cena s DPH</th>
        			<th class="table_label_objednavka">Stav</th>
        			<th class="table_label_objednavka">Dod.list</th>
        			<th class="table_label_objednavka">Smazat</th>
        		</tr>
        		{assign var=sum_price_page value=0}
        		{assign var=sum_price_page_vat value=0}
        		{section name=order loop=$p_cart}
        		{assign var=sum_price_page value=$sum_price_page+$p_cart[order].price}
        		{assign var=sum_price_page_vat value=$sum_price_page_vat+$p_cart[order].price_vat}
        		{assign var=status value=$p_cart[order].status}
        		<tr align="right" class="{$p_cart_status.$status.class}" style="{if $p_cart[order].PAYED} background-color: green;{/if}">
        			<th><a href="/admin/objednavky/{$ID_DELIMITER}{$p_cart[order].id_cart}/">{$p_cart[order].varsymb|default:'- - -'}</a></th>
        			<th><a href="/admin/objednavky/{$ID_DELIMITER}{$p_cart[order].id_cart}/">{$p_cart[order].customer.firma.PROP_VALUE} ({$p_cart[order].customer.prijmeni.PROP_VALUE} {$p_cart[order].customer.jmeno.PROP_VALUE})</a></th>
        			<td>{$p_cart[order].closed|date_format:'%d.%m.%y'}</td>
        			<td>{$p_cart[order].TRANSPORT->name}</td>
        			<td>{$p_cart[order].PAYMENT->name}</td>
        			<td nowrap="nowrap">{$p_cart[order].price_vat|price:$p_cart[order].CURRENCY->code:$p_cart[order].CURRENCY->currency_rate}</td>
        			<td>{$p_cart_status.$status.name}</td>
        			<td>
					<a href="/admin/objednavky/print_2/{$ID_DELIMITER}{$p_cart[order].id_cart}/" target="_blank">dod.list</a><br />
					<a href="/admin/objednavky/print/{$ID_DELIMITER}{$p_cart[order].id_cart}/" target="_blank">objednavka</a>
				</td>
        			<td style="text-align:center;"><a href="/admin/objednavky/delete/{$p_cart[order].id_cart}/id_user/{$p_cart[order].id_user}/" class="objednavka_delete" onclick="return confirm('Opravdu smazat ?')"></a></td>
        		</tr>
        		{sectionelse}
        		<tr>
        			<th colspan="11" style="text-align:center;padding:20px 0px;"><h2>Žádné objednávky nenelazeny</h2></th>
        		</tr>
        		{/section}
        	</table>
        </div>
    	<div class="objednavka_strankovani">
    		{section name="page_loop" start=0 loop=$pages}
    			{if $smarty.section.page_loop.first}Strana: |&nbsp;{/if}
    			<a href="/admin/objednavky/page/{$smarty.section.page_loop.iteration}/">{$smarty.section.page_loop.iteration}</a> {if !$smarty.section.page_loop.last}|{/if}
    		{/section}
    	</div>
    </div>
{/if}
<div class="cb"></div>