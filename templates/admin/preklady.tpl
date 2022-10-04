<h1 class="clanek_title">PŘEKLADY</h1>
<table class="nastaveni_doprava_table" border="0" cellpadding="0" cellspacing="0">
		<th>Zdroj</th>
        <th>CZ</th>
        <th>SK</th>
        <th>DE</th>
        <th>Skrýt</th>
        <th>Upravit</th>
		{foreach from=$pTranslates item=pTranslate}
			<tr>
				<form action="" method="post">
					<td style="border-bottom:1px solid #009933;">{$pTranslate->text}</td>
					<td style="border-bottom:1px solid #009933;">
						{if $pTranslate->text|strpos:'<br'}
							<textarea name="cs">{$pTranslate->cs}</textarea>
						{else}
							<input type="text" name="cs" value="{$pTranslate->cs}" class="nastaveni_doprava_input_delsi"/>
						{/if}

					</td>
					<td style="border-bottom:1px solid #009933;">
						{if $pTranslate->text|strpos:'<br'}
							<textarea name="sk">{$pTranslate->sk}</textarea>
						{else}
							<input type="text" name="sk" value="{$pTranslate->sk}" class="nastaveni_doprava_input_delsi"/>
						{/if}
					</td>
					<td style="border-bottom:1px solid #009933;">
						{if $pTranslate->text|strpos:'<br'}
							<textarea name="de">{$pTranslate->de}</textarea>
						{else}
							<input type="text" name="de" value="{$pTranslate->de}" class="nastaveni_doprava_input_delsi"/>
						{/if}
					</td>
					<td style="border-bottom:1px solid #009933;text-align:center;">
						<input type="submit" name="doTranslate" value=" " class="nastaveni_doprava_edit"/>
					</td>
					<td style="border-bottom:1px solid #009933;text-align:center;width:40px;">
						<input type="hidden" name="id" value="{$pTranslate->id}"/>
						<input type="submit" name="hideTranslate" value=" " class="nastaveni_doprava_skryt" onclick="return confirm('Opravdu tento překlad chcete skrýt ?')"/>
					</td>
				</form>
			</tr>
		{/foreach}
</table>