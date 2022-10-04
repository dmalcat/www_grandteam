<h1 class="clanek_title">PLATBY</h1>
	<table class="nastaveni_doprava_table" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<th style="width: 40px;">Zobr.</th>
			<th style="width: 200px;">Název</th>
			<th style="width: 90px;">Popis</th>
			<th style="width: 90px;">Cena</th>
			<th style="width: 210px;">Č.ú.</th>
			<th style="width: 90px;">Kód banky</th>
			<th style="width: 200px;">Typ</th>
			<th style="width: 50px;">Upravit</th>
			<th style="width: 50px;">Smazat</th>
		</tr>
	</table>
	{foreach name=for_payments from=$p_payments item=payment}
		<form action="" method="post">
			<table class="nastaveni_doprava_table" border="0" cellpadding="0" cellspacing="0" style="margin: 0px 10px; padding: 0px;">
				<tr>
					<td style="border-bottom:1px solid #009933; width: 40px; text-align: center;" >{html_checkboxes name="visible" options=$s_visible selected=$payment->visible}</td>
					<td style="border-bottom:1px solid #009933; width: 200px;"><input type="text" name="name" value="{$payment->name}" class="nastaveni_doprava_input_delsi"/></td>
					<td style="border-bottom:1px solid #009933; width: 90px;"><input type="text" name="description" value="{$payment->description}" class="nastaveni_doprava_input_kratky"/></td>
					<td style="border-bottom:1px solid #009933; width: 90px;"><input type="text" name="price" value="{$payment->price}" class="nastaveni_doprava_input_kratky"/></td>
					<td style="border-bottom:1px solid #009933; width: 210px;"><input type="text" name="account" value="{$payment->account}" class="nastaveni_doprava_input_delsi"/></td>
					<td style="border-bottom:1px solid #009933; width: 90px;"><input type="text" name="bank" value="{$payment->bank}" class="nastaveni_doprava_input_kratky"/></td>
					<td style="border-bottom:1px solid #009933; width: 200px;">{html_options name="id_payment_type" options=dbPaymentType::getAll()|select:'id':'name' selected=$payment->id_payment_type}</td>
					<td style="border-bottom:1px solid #009933;text-align:center; width: 50px;">
						<input type="hidden" name="id_payment" value="{$payment->id_payment}"/>
						<input type="submit" name="payment_do_edit" value=" " class="nastaveni_doprava_edit"/>
					</td>
					<td style="border-bottom:1px solid #009933;text-align:center; width: 50px;">
						<input type="submit" name="payment_do_delete" value=" " class="nastaveni_doprava_smazat" onclick="return confirm('Opravdu smazat {$payment->name} ?')"/>
					</td>
				</tr>
			</table>
		</form>
	{/foreach}
	<div style="margin-bottom: 10px; clear: both">&nbsp;</div>




<h2 class="clanek_title">PŘIDAT NOVOU MOŽNOST PLATBY</h2>
<form action="" method="post">
    <table class="nastaveni_doprava_table" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<th>Zobrazit</th>
			<th>Název</th>
			<th>Popis</th>
			<th>Cena</th>
			<th>Č.ú.</th>
			<th>Kód banky</th>
			<th>Typ</th>
			<th></th>
		</tr>
		<tr>
			<td>{html_checkboxes name="visible" options=$s_visible selected=1}</td>
			<td><input type="text" name="name" class="nastaveni_doprava_input_delsi"/></td>
			<td><input type="text" name="description" class="nastaveni_doprava_input_kratky"/></td>
			<td><input type="text" name="price" class="nastaveni_doprava_input_kratky"/></td>
			<td><input type="text" name="account" class="nastaveni_doprava_input_kratky"/></td>
			<td><input type="text" name="bank" class="nastaveni_doprava_input_kratky"/></td>
			<td>{html_options name="id_payment_type" options=dbPaymentType::getAll()|select:'id':'name'}</td>
			<td><input type="submit" name="payment_do_insert" value="Přidat" class="objednavka_filtr"/></td>
		</tr>
	</table>
</form>
