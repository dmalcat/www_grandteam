<h1 class="clanek_title">EDITACE CENÍKŮ</h1>
	<table class="nastaveni_doprava_table" border="0" cellpadding="0" cellspacing="0" style="clear: both; padding-left: 15px;">
		<tr>
			<th style="width: 190px;">Název</th>
			<th style="width: 190px;">Kód</th>
			<th style="width: 190px;">Sleva v %</th>
			<th style="width: 55px;">Používat</th>
			<th style="width: 45px;">Upravit</th>
			<th style="">Smazat</th>
		</tr>
	</table>
	{foreach from=$p_price_lists item=price_list}
			<form action="" method="post">
				<table  style="clear: both; padding-left: 15px;">
				<tr>
					<td style="border-bottom:1px solid #009933;"><input name="name" value="{$price_list->name}" class="nastaveni_doprava_input_delsi"/></td>
					<td style="border-bottom:1px solid #009933;"><input name="kod" value="{$price_list->kod}" class="nastaveni_doprava_input_delsi"/></td>
					<td style="border-bottom:1px solid #009933;"><input name="sleva" value="{$price_list->sleva}" class="nastaveni_doprava_input_delsi"/></td>
					<td style="border-bottom:1px solid #009933;text-align:center;width:55px;">{html_checkboxes name="visible" options=$s_yes_no title="zobrazit/skryt" selected=$price_list->visible}</td>
					<td style="border-bottom:1px solid #009933;text-align:center;width:45px;">
						<input type="hidden" name="id_list" value="{$price_list->id}"/>
						<input type="submit" name="price_list_do_edit" value=" " class="nastaveni_doprava_edit"/>
					</td>
					<td style="border-bottom:1px solid #009933;text-align:center;width:50px;"><input type="submit" name="price_list_do_delete" value=" " class="nastaveni_doprava_smazat" onclick="return confirm('Opravdu smazat ceník {$price_list->name} ?')"/></td>
				</tr>
				</table>
			</form>
	{/foreach}
	<br/>

<h2 class="clanek_title">PŘIDAT CENÍK</h2>
<form action="" method="post">
    <table class="nastaveni_doprava_table" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<th>Název</th>
				<th>Kód</th>
				<th>Sleva v %</th>
				<th>Používat</th>
				<th></th>
			</tr>
			<tr>
				<td><input name="name" class="nastaveni_doprava_input_delsi"/></td>
				<td><input name="kod" class="nastaveni_doprava_input_delsi"/></td>
				<td><input name="sleva" class="nastaveni_doprava_input_delsi"/></td>
				<td>{html_checkboxes name="visible" options=$s_yes_no title="zobrazit/skryt" selected=1}</td>
				<td><input type="submit" name="price_list_do_insert" value="Přidat" class="objednavka_filtr"/></td>
			</tr>
	</table>
</form>
		
<h2 class="clanek_title">VÝCHOZÍ CENÍK PRO NEREGISTROVANÉ</h2>
<form action="" method="post">
    <table class="nastaveni_doprava_table" border="0" cellpadding="0" cellspacing="0" style="width:300px;">
	   <tr>
			<td>{html_options name="price_list_id_for_guest" options=$p_price_lists|select:'id':'name' selected=$price_list_for_guest}</td>
			<td><input type="submit" name="price_list_set_for_guest" value="Nastavit" class="objednavka_filtr"/></td>
	   </tr>
	</table>
</form>

<h2 class="clanek_title">VÝCHOZÍ CENÍK PRO NOVĚ REGISTROVANÉ</h2>
<form action="" method="post">
    <table class="nastaveni_doprava_table" border="0" cellpadding="0" cellspacing="0" style="width:300px;">
		<tr>
			<td>{html_options name="price_list_id_for_user" options=$p_price_lists|select:'id':'name' selected=$price_list_for_user}</td>
			<td><input type="submit" name="price_list_set_for_user" value="Nastavit" class="objednavka_filtr"/></td>
		</tr>
    </table>
</form>
