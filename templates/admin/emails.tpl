<h1 class="clanek_title">EMAILY</h1>


	<table class="nastaveni_doprava_table" border="0" cellpadding="0" cellspacing="0">
		{*<tr>
			<td colspan="2">Od:<br/><input type="text" id="datepicker4" name="from" value="{$smarty.get.from}"/></td>
			<td colspan="2">Do:<br/><input type="text" id="datepicker5" name="to" value="{$smarty.get.to}"/></td>
			<td><input type="submit" name="doFileter" value="vyhledat" /></td>
		</tr>*}
		<tr>
			<th>#</th>
			<th>Datum</th>
			<th>Jméno</th>
			<th>Email</th>
		</tr>
		{foreach from=dbUser::getZpravodajUsers() item=dbEmail name=forLog}
			<tr>
				<td style="border-bottom:1px solid #009933;">{$dbEmail->id}</td>
				<td style="border-bottom:1px solid #009933;">{$dbEmail->date|date_format:"d.m.Y H:i:s"}</td>
				<td style="border-bottom:1px solid #009933;">{$dbEmail->jmeno}</td>
				<td style="border-bottom:1px solid #009933;">{$dbEmail->email}</td>
				<td style="border-bottom:1px solid #009933;"><a href="/admin/emails/delete/{$dbEmail->id}" onclick='return confirm("Opravdu odebrat {$dbEmail->email} ?")'>odebrat</a></td>
			</tr>
		{/foreach}
	</table>
