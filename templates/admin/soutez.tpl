<h1 class="clanek_title">SOUTĚŽE</h1>


	<table class="nastaveni_doprava_table" border="0" cellpadding="0" cellspacing="0">
		{*<tr>
			<td colspan="2">Od:<br/><input type="text" id="datepicker4" name="from" value="{$smarty.get.from}"/></td>
			<td colspan="2">Do:<br/><input type="text" id="datepicker5" name="to" value="{$smarty.get.to}"/></td>
			<td><input type="submit" name="doFileter" value="vyhledat" /></td>
		</tr>*}
		<tr>
			<th>#</th>
			<th>Soutež</th>
			<th>Výsledek</th>
			<th>Prodejna</th>
			<th>Datum</th>
			<th>Jméno</th>
			<th>Příjmení</th>
			<th>Telefon</th>
			<th>Email</th>
			<th>Pohlavi</th>
			<th>Věk</th>
		</tr>
		{foreach from=dbSoutez::getAll(true) item=dbSoutez name=forSoutez}
			<tr>
				<td style="border-bottom:1px solid #009933;">{$dbSoutez->id}</td>
				<td style="border-bottom:1px solid #009933;">{$dbSoutez->getSoutezTxt()}</td>
				<td style="border-bottom:1px solid #009933;">{$dbSoutez->result}</td>
				<td style="border-bottom:1px solid #009933;">{$dbSoutez->getProdejna()->prodejna}</td>
				<td style="border-bottom:1px solid #009933;">{$dbSoutez->confirm_date|date_format:"d.m.Y H:i:s"}</td>
				<td style="border-bottom:1px solid #009933;">{$dbSoutez->jmeno}</td>
				<td style="border-bottom:1px solid #009933;">{$dbSoutez->prijmeni}</td>
				<td style="border-bottom:1px solid #009933;">{$dbSoutez->telefon}</td>
				<td style="border-bottom:1px solid #009933;">{$dbSoutez->email}</td>
				<td style="border-bottom:1px solid #009933;">{$dbSoutez->pohlavi}</td>
				<td style="border-bottom:1px solid #009933;">{$dbSoutez->getVekTxt()}</td>
				<td style="border-bottom:1px solid #009933;"><a href="/admin/soutez/delete/{$dbSoutez->id}" onclick='return confirm("Opravdu smazat ?")'>smazat</a></td>
			</tr>
		{/foreach}
	</table>
