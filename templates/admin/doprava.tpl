<h1 class="clanek_title">DOPRAVY</h1>
<table class="nastaveni_doprava_table" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<th style="width: 30px;" align="left">Zobr.</th>
		<th style="width: 200px;">Název</th>
		<th style="width: 90px;">Cena</th>
		<th style="width: 90px;">Zdarma <br /> nad částku</th>
		<th style="width: 200px;">DPH</th>
		<th style="width: 200px;">Popis</th>
		<th style="width: 40px;">Upravit</th>
		<th style="width: 40px;">Smazat</th>
	</tr>
</table>

{foreach name=for_transports from=dbTransport::getAll() item=transport}
	<form action="" method="post">
		<table class="nastaveni_doprava_table" border="0" cellpadding="0" cellspacing="0" style="margin: 0px 15px;">
			<tr>
				<td style="width: 30px; border-bottom:1px solid #009933;">{html_checkboxes name="visible" options=$s_visible selected=$transport->visible}</td>
				<td style="width: 200px; border-bottom:1px solid #009933;"><input type="text" name="name" value="{$transport->name}" class="nastaveni_doprava_input_delsi"/></td>
				<td style="width: 90px; border-bottom:1px solid #009933;"><input type="text" name="price" value="{$transport->price}" class="nastaveni_doprava_input_kratky"/></td>
				<td style="width: 90px; border-bottom:1px solid #009933;"><input type="text" name="free_after" value="{$transport->free_after}" class="nastaveni_doprava_input_kratky"/></td>
				<td style="width: 200px; border-bottom:1px solid #009933;">{html_options name="id_dph" options=$s_dph selected=$transport->id_dph}</td>
				<td style="width: 200px; border-bottom:1px solid #009933;"><textarea name="description">{$transport->description}</textarea></td>
				<td style="width: 40px; border-bottom:1px solid #009933;text-align:center;">
					<input type="hidden" name="id_transport" value="{$transport->id_transport}"/>
					<input type="submit" name="transport_do_edit" value=" " class="nastaveni_doprava_edit"/>
				</td>
				<td style="width: 40px; border-bottom:1px solid #009933;text-align:center;">
					<input type="submit" name="transport_do_delete" value=" " class="nastaveni_doprava_smazat" onclick="return confirm('Opravdu smazat {$transport->name} ?')"/>
				</td>
			</tr>
		</table>
	</form>
{/foreach}



<h2 class="clanek_title">PŘIDAT NOVOU MOŽNOST DOPRAVY</h2>
<form action="" method="post">
    <table class="nastaveni_doprava_table" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<th>Zobrazit</th>
			<th>Název</th>
			<th>Cena</th>
			<th>Zdarma nad částku</th>
			<th>DPH</th>
			<th></th>
		</tr>
		<tr>
			<td>{html_checkboxes name="visible" options=$s_prop_visible selected=1}</td>
			<td><input type="text" name="name" class="nastaveni_doprava_input_delsi"/></td>
			<td><input type="text" name="price" class="nastaveni_doprava_input_kratky"/></td>
			<td><input type="text" name="free_after" class="nastaveni_doprava_input_kratky"/></td>
			<td>{html_options name="id_dph" options=$s_dph}</td>
			<td><input type="submit" name="transport_do_insert" value="Přidat" class="objednavka_filtr"/></td>
		</tr>
	</table>
</form>
