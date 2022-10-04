<h1 class="clanek_title">SEZNAM DOTAZŮ</h1>

<div class="uzivatele_zaznamy">
	{*	<span style="float:left;">Počet nalezených záznamů: <strong>{dbDotaz::getAll()|count}</strong></span>*}
</div>

<div class="uzivatele_table">

	<table border="0" width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<th></th>
			<th>#</th>
{*			<th>Dotazující</th>*}
			<th>Dotazující email</th>
			<th>Příjemce dotazu</th>
			<th title="">Datum</th>
			<th>Dotaz</th>
			<th>Status</th>
		</tr>
		<tbody id="accordion">
			{foreach from=$pDotazy item=dbDotaz}
				<tr class="xtable_tr acc_header" style="background-color:{cycle values="#EFEFEF,#fff"};" id="dotaz_{$dbDotaz->id}">
					<td>&nbsp;&nbsp;&nbsp;{$dbDotaz->id}</td>
{*					<td>{if $dbDotaz->getOwner()}{$dbDotaz->getOwner()->getPropertyValue("jmeno")} {$dbDotaz->getOwner()->getPropertyValue("prijmeni")}{/if}</td>*}
					<td>{$dbDotaz->from_email}</td>
					<td>{$dbDotaz->getEditor()->name} ({$dbDotaz->getEditor()->external_url})</td>
					<td>{$dbDotaz->date|date_format:"%d.%m.%Y"}</td>
					<td>{$dbDotaz->text|nl2br}</td>
					<td id="dotaz_status_{$dbDotaz->id}">{$dbDotaz->getStatusTxt()}</td>
				</tr>
				<tr>
					<td></td>
					<td colspan="2" style="background-color: #33be40;" valign="top">
						dotaz: <br/><textarea name="text" id="dotaz_text_{$dbDotaz->id}" cols="50" rows="10" >{$dbDotaz->text}</textarea>
					</td>
					<td colspan="2" style="background-color: #33be40;">
						odpověď: <br/><textarea name="answer" id="dotaz_answer_{$dbDotaz->id}" cols="50" rows="10">{$dbDotaz->answer}</textarea>
					</td>
					<td style="background-color: #33be40;">
						<input type="hidden" id="idEditor_{$dbDotaz->id}" value="{$dbUser->id}" />
						<input type="submit" value="uložit opověď" name="doAnswer" onclick="return doAnswer({$dbDotaz->id});"/><br/><br/>
						{if $dbUser->isAdmin()}<input type="submit" value="odeslat opověď" name="doSendAnswer" onclick="return doSendAnswer({$dbDotaz->id});"/>{/if}
					</td>
				</tr>
			{/foreach}
		</tbody>
	</table>
</div>


<div class="clear"></div>

<script type="text/javascript">
	$(document).ready(function() {
	{*		$("#accordion").accordion({ header: "> li > :first-child,> :not(li):even" });*}
	{*		$("#accordion").accordion({ header: "tr:first-child,> :not(li):even" });*}
		$("#accordion").accordion({
			header: ".acc_header", collapsible: true, active: false
		});
	});
	function doAnswer(idDotaz) {
		if (!$("#dotaz_answer_" + idDotaz).val()) {
			alert("Zadejte odpověd.");
			return false;
		}
		$.post("/res/ajax.php?mode=doAnswer", {
			idDotaz: idDotaz,
			text: $("#dotaz_text_" + idDotaz).val(),
			answer: $("#dotaz_answer_" + idDotaz).val(),
			idEditor: $("#idEditor_" + idDotaz).val(),
		}).done(function(data) {
			$("#dotaz_status_" + idDotaz).text("předáno na odeslání");
			alert(data);
		});
		return false;
	}
	
	function doSendAnswer(idDotaz) {
		if (!$("#dotaz_answer_" + idDotaz).val()) {
			alert("Zadejte odpověd.");
			return false;
		}
		$.post("/res/ajax.php?mode=doSendAnswer", {
			idDotaz: idDotaz,
			text: $("#dotaz_text_" + idDotaz).val(),
			answer: $("#dotaz_answer_" + idDotaz).val(),
			idEditor: $("#idEditor_" + idDotaz).val(),
		}).done(function(data) {
			$("#dotaz_status_" + idDotaz).text("zodpovězeno");
			alert(data);
		});
		return false;
	}

</script>
