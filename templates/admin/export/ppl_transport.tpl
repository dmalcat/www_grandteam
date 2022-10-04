<form action="" method="post">
	    <h2 class="objednavka_export_nadpis">Adresa příjemce</h2>
        <h2 class="objednavka_export_nadpis">Typ zásilky</h2>
        <div class="cb"></div>
        <table cellspacing="0" cellpadding="0" border="0" class="doprava_export_table" id="">
			<tbody>
				<tr>
					<th>Název firmy</th>
					<td align="left"><input type="text" class="textBox" name="ppl[RecCompany]" value="{$p_cart.PPL_CUSTOMER.RecCompany}"/></td>
				</tr>
				<tr>
					<th>Ulice</th>
					<td align="left"><input type="text" class="textBox" name="ppl[RecStreet]" value="{$p_cart.PPL_CUSTOMER.RecStreet}"/></td>
				</tr>
				<tr>
					<th>Číslo domu</th>
					<td align="left"><input type="text" class="textBox" name="ppl[RecStreetNr]" value="{$p_cart.PPL_CUSTOMER.RecStreetNr}"/></td>
				</tr>
				<tr>
					<th>Město</th>
					<td align="left"><input type="text" class="textBox" name="ppl[RecCity]" value="{$p_cart.PPL_CUSTOMER.RecCity}"/></td>
				</tr>
				<tr>
					<th>PSČ</th>
					<td align="left"><input type="text" class="textBox" name="ppl[RecZipCode]" value="{$p_cart.PPL_CUSTOMER.RecZipCode}"/></td>
				</tr>
				<tr>
					<th>Země</th>
					<td>
						<select id="" name="ppl[RecCountry]">
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
						<select id="" name="ppl[PackageType]">
							<option value="9" {if $p_cart.PPL.PackageType == 9}selected="selected"{/if}>Export</option>
							<option value="10" {if $p_cart.PPL.PackageType == 10}selected="selected"{/if}>Export - dobírka</option>
							<option value="7" {if $p_cart.PPL.PackageType == 7}selected="selected"{/if}>Express</option>
							<option value="8" {if $p_cart.PPL.PackageType == 8}selected="selected"{/if}>Express - dobírka</option>
							<option value="1" {if $p_cart.PPL.PackageType == 1}selected="selected"{/if}>Normální balík</option>
							<option value="2" {if $p_cart.PPL.PackageType == 2 OR $p_cart.PPL.PackageType == ""}selected="selected"{/if}>Normální balík - dobírka</option>
							<option value="15" {if $p_cart.PPL.PackageType == 15}selected="selected"{/if}>PPL Sprint</option>
							<option value="16" {if $p_cart.PPL.PackageType == 16}selected="selected"{/if}>PPL Sprint Dobírka</option>
							<option value="17" {if $p_cart.PPL.PackageType == 17}selected="selected"{/if}>PPL Sprint+</option>
							<option value="18" {if $p_cart.PPL.PackageType == 18}selected="selected"{/if}>PPL Sprint+ Dobírka</option>
							<option value="13" {if $p_cart.PPL.PackageType == 13}selected="selected"{/if}>Soukromá adresa</option>
							<option value="14" {if $p_cart.PPL.PackageType == 14}selected="selected"{/if}>Soukromá adresa - dobírka</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>Vložit zpětnou zásilku</th>
					<td><input type="checkbox" name="ppl[InsertBack]" id="" {if $p_cart.PPL.InsertBack == "on"}checked{/if}></td>
				</tr>
				<tr>
					<th>Počet kusů</th>
					<td align="left"><input type="text" class="textBox" name="ppl[ItemsCount]" value="{$p_cart.PPL.ItemsCount}"/></td>
				</tr>
				<tr>
					<th>Připojistit na</th>
					<td align="left"><input type="text" class="textBox" name="ppl[Insurance]" value="{$p_cart.PPL.Insurance}"/></td>
				</tr>
				<tr>
					<th>Dobírková částka</th>
					<td align="left">
						<input type="text" class="textBox" name="ppl[DobirkaPrice]" value="{if $p_cart.ID_TRANSPORT == 7 || $p_cart.ID_TRANSPORT == 8 || $p_cart.ID_TRANSPORT == 11 || $p_cart.ID_TRANSPORT == 14 || $p_cart.ID_TRANSPORT == 16 || $p_cart.ID_TRANSPORT == 18}{$p_cart.PPL.DobirkaPrice|default:$p_cart.SUM_VAT_CURRENCY}{else}0{/if}"/>
					</td>
				</tr>
				<tr>
					<th>Měna dobírky</th>
					<td>
						<select name="ppl[Currency]">
							<option value="">---</option>
							<option value="CZK" {if $p_cart.PPL.Currency == "CZK" OR $p_cart.PPL.Currency == ""}selected="selected"{/if}>Česká koruna</option>
							<option value="EUR" {if $p_cart.PPL.Currency == "EUR" || $p_cart.CURRENCY->code == "eu"}selected="selected"{/if}>Euro</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>Variabilní symbol</th>
					<td align="left"><input type="text" class="textBox" name="ppl[Varsymb]" value="{$p_cart.PPL.Varsymb|default:$p_cart.VARSYMB}"/></td>
				</tr>
				<tr>
					<th>Kontaktní osoba</th>
					<td align="left"><input type="text" class="textBox" name="ppl[ContactPerson]" value="{$p_cart.PPL_CUSTOMER.ContactPerson}" value="{$p_cart.PPL.ContactPerson}"/></td>
				</tr>
				<tr>
					<th>Telefon</th>
					<td align="left"><input type="text" class="textBox" name="ppl[ContactPhone]" value="{$p_cart.PPL_CUSTOMER.ContactPhone}" value="{$p_cart.PPL.ContactPhone}"/></td>
				</tr>
				<tr>
					<th>Telefon pro SMS</th>
					<td align="left"><input type="text" class="textBox" name="ppl[ContactSms]" value="{$p_cart.PPL_CUSTOMER.ContactSms}" value="{$p_cart.PPL.ContactSms}"/></td>
				</tr>
				<tr>
					<th>E-mail</th>
					<td align="left"><input type="text" class="textBox" name="ppl[ContactEmail]" value="{$p_cart.PPL_CUSTOMER.ContactEmail}" value="{$p_cart.PPL.ContactEmail}"/></td>
				</tr>
				<tr>
					<th>Obsah</th>
					<td align="left"><input type="text" class="textBox" name="ppl[Content]" value="{$p_cart.PPL.Content}" value="{$p_cart.PPL.Content}"/></td>
				</tr>
				<tr>
					<th>Cena zboží</th>
					<td align="left"><input type="text" class="textBox" name="ppl[ItemsPrice]" value="{$p_cart.PPL.ItemsPrice}" value="{$p_cart.PPL.ItemsPrice}"/></td>
				</tr>
				<tr>
					<th>Poznámka pro tisk na etiketě</th>
					<td><textarea id="" cols="20" rows="2" name="ppl[PrintMessage]">{$p_cart.PPL.PrintMessage}</textarea></td>
				</tr>
				<tr>
					<th>Zákaznické reference</th>
					<td align="left"><input type="text" class="textBox" name="ppl[CustomerReference]" value="{$p_cart.PPL.CustomerReference}"/></td>
				</tr>
				<tr>
					<th>Datum doručení</th>
					<td align="left"><input type="text" class="textBox" name="ppl[DeliveryDate]" value="{$p_cart.PPL.DeliveryDate}"/></td>
				</tr>
				<tr>
					<th>Čas doručení</th>
					<td>
						<select class="dropDown" id="" name="ppl[DeliveryTime]">
							<option value="1" {if $p_cart.PPL.DeliveryTime == 1}selected="selected"{/if}>Den</option>
							<option value="2" {if $p_cart.PPL.DeliveryTime == 2}selected="selected"{/if}>Večer</option>
						</select>
					</td>
				</tr>
			</tbody>			
		</table>

        <div class="submit_box">
            <input type="submit" name="ppl_do_save" value="Uložit" class="ulozit_upravy_tlac"/>
            <input type="submit" name="ppl_do_save_export" value="Uložit a exportovat PPL" class="ulozit_upravy_tlac"/>
            
        </div>

</form>