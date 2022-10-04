<h1 class="clanek_title">DOPRAVA A PLATBY</h1>
{if $p_transport_map_payment}
		<table class="nastaveni_doprava_table" border="0" cellpadding="0" cellspacing="0" style="width:630px; margin-bottom: 0px; padding-bottom: 0px;">
			<tr>
				<th style="width: 200px;">Doprava</th>
				<th style="width: 200px;">Platba</th>
				<th style="width: 70px;">Výchozí</th>
				<th style="width: 70px;">Upravit</th>
				<th style="width: 70px;">Smazat</th>
			</tr>
		</table>
			{foreach from=$p_transport_map_payment item=map}
				<form action="" method="post">				
					<table class="nastaveni_doprava_table" border="0" cellpadding="0" cellspacing="0" style="width:630px; margin: 0px 10px; padding: 0px;">
						<tr>
							<td style="width: 200px;">{html_options name="id_transport" options=dbTransport::getAll()|select:'id':'name' selected=$map->id_transport}</td>
							<td style="width: 200px;">{html_options name="id_payment" options=$s_payments selected=$map->id_payment}</td>
							<td style="width: 70px; text-align:center;">{html_checkboxes name="default" options=$s_yes_no selected=$map->default}</td>
							<td style="width: 70px; text-align:center;">
								<input type="hidden" name="id_map" value="{$map->id_map}"/>
								<input type="submit" name="transport_map_payment_do_edit" value=" " class="nastaveni_doprava_edit"/>
							</td>
							<td style="width: 70px; text-align:center;"><input type="submit" name="transport_map_payment_do_delete" value=" " class="nastaveni_doprava_smazat" onclick="return confirm('Opravdu smazat ?')"/></td>
						</tr>
					</table>
				</form>
			{/foreach}
{/if}
		
		<form action="" method="post">
    		<h2 class="clanek_title">NOVÁ DEFINICE DOPRAVY A PLATBY</h2>
            <table class="nastaveni_doprava_table" border="0" cellpadding="0" cellspacing="0" style="width:630px;">
                <tr>
    				<th>Doprava</th>
    				<th>Platba</th>
    				<th>Výchozí</th>
    			</tr>
    			<tr>
    						<td>{html_options name="id_transport" options=dbTransport::getAll()|select:'id':'name'}</td>
    						<td>{html_options name="id_payment" options=dbPayment::getAll()|select:'id':'name'}</td>
    						<td>{html_checkboxes name="default" options=$s_yes_no}</td>
    						<td><input type="submit" name="transport_map_payment_do_insert" value="Vložit" class="objednavka_filtr"/></td>
    			</tr>

    		</table>
		</form>
