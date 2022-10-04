<h1 class="clanek_title">STATISTIKA PŘIHLÁŠENÍ</h1>


<form action="" method="get">
	<table class="nastaveni_doprava_table" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="2">Od:<br/><input type="text" id="datepicker4" name="from" value="{$smarty.get.from}"/></td>
			<td colspan="2">Do:<br/><input type="text" id="datepicker5" name="to" value="{$smarty.get.to}"/></td>
			<td><input type="submit" name="doFileter" value="vyhledat" /></td>
		</tr>
		<tr>
			<th>#</th>
			<th>Datum</th>
			<th>Společnost</th>
			<th>Jméno</th>
			<th>Příjmení</th>
		</tr>
		{foreach from=dbUserLog::getAll($smarty.get.from|changeDatepickerDate, $smarty.get.to|changeDatepickerDate) item=dbUserLog name=forLog}
			<tr>
			<form action="" method="post">
				<td style="border-bottom:1px solid #009933;">{$smarty.foreach.forLog.iteration}</td>
				<td style="border-bottom:1px solid #009933;">{$dbUserLog->date|date_format:"d.m.Y H:i:s"}</td>
				<td style="border-bottom:1px solid #009933;">{$dbUserLog->getUser()->getPropertyValue("firma")}</td>
				<td style="border-bottom:1px solid #009933;">{$dbUserLog->getUser()->getPropertyValue("jmeno")}</td>
				<td style="border-bottom:1px solid #009933;">{$dbUserLog->getUser()->getPropertyValue("prijmeni")}</td>
			</form>
			</tr>
		{/foreach}
	</table>
</form>