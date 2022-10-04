<form action="" method="post">
        <h2 class="objednavka_export_nadpis">Adresa příjemce</h2>
        <h2 class="objednavka_export_nadpis">Typ zásilky</h2>
        <div class="cb"></div>
        <table cellspacing="0" cellpadding="0" border="0" class="doprava_export_table" id="">
			<tbody>
				<tr>
					<th>Název firmy</th>
					<td align="left"><input type="text" class="textBox" name="dpd[RecCompany]" value="{$p_cart.DPD_CUSTOMER.RecCompany}"/></td>
				</tr>
				<tr>
					<th>Ulice</th>
					<td align="left"><input type="text" class="textBox" name="dpd[RecStreet]" value="{$p_cart.DPD_CUSTOMER.RecStreet}"/></td>
				</tr>
				<tr>
					<th>Číslo domu</th>
					<td align="left"><input type="text" class="textBox" name="dpd[RecStreetNr]" value="{$p_cart.DPD_CUSTOMER.RecStreetNr}"/></td>
				</tr>
				<tr>
					<th>Město</th>
					<td align="left"><input type="text" class="textBox" name="dpd[RecCity]" value="{$p_cart.DPD_CUSTOMER.RecCity}"/></td>
				</tr>
				<tr>
					<th>PSČ</th>
					<td align="left"><input type="text" class="textBox" name="dpd[RecZipCode]" value="{$p_cart.DPD_CUSTOMER.RecZipCode}"/></td>
				</tr>
				<tr>
					<th>Země</th>
					<td>
						<select id="" name="dpd[RecCountry]">
							<option value="CZ ">Česká republika</option>
							<option value="SK" {if $p_cart.CURRENCY->code == "eu"}selected="selected"{/if}>Slovenská republika</option>
						</select>
					</td>
				</tr>
			</tbody>
		</table>
        <table cellspacing="0" cellpadding="0" border="0" class="doprava_export_table" id="">
			<tbody>
				<tr>
					<th>Typ zásilky</th>
					<td>
						<select id="" name="dpd[PackageType]">
							<option value="NP" {if $p_cart.DPD.PackageType == "NP" OR $p_cart.DPD.PackageType == ""}selected="selected"{/if}>DPD CLASSIC doručení Business</option>
							<option value="NP,NN,CD" {if $p_cart.DPD.PackageType == "NP,NN,CD"}selected="selected"{/if}>DPD CLASSIC doručení Business dobírka</option>
							<option value="NCP,PRO,CD" {if $p_cart.DPD.PackageType == "NCP,PRO,CD"}selected="selected"{/if}>DPD CLASSIC doručení Private</option>
							<option value="NCP,NN,PRO,CD" {if $p_cart.DPD.PackageType == "NCP,NN,PRO,CD"}selected="selected"{/if}>DPD CLASSIC doručení Private dobírka</option>
							<option value="NP,E12" {if $p_cart.DPD.PackageType == "NP,E12"}selected="selected"{/if}>DPD 12:00</option>
							<option value="NP,E18,NN" {if $p_cart.DPD.PackageType == "NP,E18,NN"}selected="selected"{/if}>DPD 18:00 dobírka</option>
						</select>
					</td>
				</tr>
<!--				<tr>
					<th>Vložit zpětnou zásilku</th>
					<td><input type="checkbox" name="dpd[InsertBack]" id="" {if $p_cart.DPD.InsertBack == "on"}checked{/if}></td>
				</tr>-->
				<tr>
					<th>Počet kusů</th>
					<td align="left"><input type="text" class="textBox" name="dpd[ItemsCount]" value="{$p_cart.DPD.ItemsCount|default:1}"/></td>
				</tr>
<!--				<tr>
					<th>Připojistit na</th>
					<td align="left"><input type="text" class="textBox" name="dpd[Insurance]" value="{$p_cart.DPD.Insurance}"/></td>
				</tr>-->
				<tr>
					<th>Dobírková částka</th>
					<td align="left">
						<input type="text" class="textBox" name="dpd[DobirkaPrice]" value="{if $p_cart.ID_TRANSPORT == 7 || $p_cart.ID_TRANSPORT == 14 || $p_cart.ID_TRANSPORT == 16 || $p_cart.ID_TRANSPORT == 18}{$p_cart.DPD.DobirkaPrice|default:$p_cart.SUM_VAT_CURRENCY}{else}0{/if}"/>
					</td>
				</tr>
				<tr>
					<th>Měna dobírky</th>
					<td>
						<select name="dpd[Currency]">
							<option value="">---</option>
							<option value="CZK" {if $p_cart.DPD.Currency == "CZK" OR $p_cart.DPD.Currency == ""}selected="selected"{/if}>Česká koruna</option>
							<option value="EUR" {if $p_cart.DPD.Currency == "EUR" || $p_cart.CURRENCY->code == "eu"}selected="selected"{/if}>Euro</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>Variabilní symbol</th>
					<td align="left"><input type="text" class="textBox" name="dpd[Varsymb]" value="{$p_cart.DPD.Varsymb|default:$p_cart.VARSYMB}"/></td>
				</tr>
				<tr>
					<th>Kontaktní osoba</th>
					<td align="left"><input type="text" class="textBox" name="dpd[ContactPerson]" value="{$p_cart.DPD_CUSTOMER.ContactPerson}" value="{$p_cart.DPD.ContactPerson}"/></td>
				</tr>
				<tr>
					<th>Telefon</th>
					<td align="left"><input type="text" class="textBox" name="dpd[ContactPhone]" value="{$p_cart.DPD_CUSTOMER.ContactPhone}" value="{$p_cart.DPD.ContactPhone}"/></td>
				</tr>
<!--				<tr>
					<th>Telefon pro SMS</th>
					<td align="left"><input type="text" class="textBox" name="dpd[ContactSms]" value="{$p_cart.DPD_CUSTOMER.ContactSms}" value="{$p_cart.DPD.ContactSms}"/></td>
				</tr>-->
<!--				<tr>
					<th>E-mail</th>
					<td align="left"><input type="text" class="textBox" name="dpd[ContactEmail]" value="{$p_cart.DPD_CUSTOMER.ContactEmail}" value="{$p_cart.DPD.ContactEmail}"/></td>
				</tr>-->
<!--				<tr>
					<th>Obsah</th>
					<td align="left"><input type="text" class="textBox" name="dpd[Content]" value="{$p_cart.DPD.Content}" value="{$p_cart.DPD.Content}"/></td>
				</tr>-->
<!--				<tr>
					<th>Cena zboží</th>
					<td align="left"><input type="text" class="textBox" name="dpd[ItemsPrice]" value="{$p_cart.DPD.ItemsPrice}" value="{$p_cart.DPD.ItemsPrice}"/></td>
				</tr>-->
<!--				<tr>
					<th>Poznámka pro tisk na etiketě</th>
					<td><textarea id="" cols="20" rows="2" name="dpd[PrintMessage]">{$p_cart.DPD.PrintMessage}</textarea></td>
				</tr>-->
<!--				<tr>
					<th>Zákaznické reference</th>
					<td align="left"><input type="text" class="textBox" name="dpd[CustomerReference]" value="{$p_cart.DPD.CustomerReference}"/></td>
				</tr>-->
<!--				<tr>
					<th>Datum doručení</th>
					<td align="left"><input type="text" class="textBox" name="dpd[DeliveryDate]" value="{$p_cart.DPD.DeliveryDate}"/></td>
				</tr>-->
<!--				<tr>
					<th>Čas doručení</th>
					<td>
						<select class="dropDown" id="" name="dpd[DeliveryTime]">
							<option value="1" {if $p_cart.DPD.DeliveryTime == 1}selected="selected"{/if}>Den</option>
							<option value="2" {if $p_cart.DPD.DeliveryTime == 2}selected="selected"{/if}>Večer</option>
						</select>
					</td>
				</tr>-->
			</tbody>			
		</table>
        <div class="submit_box">
            <input type="submit" name="dpd_do_save" value="Uložit" class="ulozit_upravy_tlac"/>
            <input type="submit" name="dpd_do_save_export" value="Uložit a exportovat pro DPD" class="ulozit_upravy_tlac"/>
        </div>
</form>