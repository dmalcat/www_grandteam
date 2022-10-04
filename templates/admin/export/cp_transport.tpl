<form action="" method="post">
        <h2 class="objednavka_export_nadpis">Adresa příjemce</h2>
        <h2 class="objednavka_export_nadpis">Typ zásilky</h2>
        <div class="cb"></div>
        <table cellspacing="0" cellpadding="0" border="0" class="doprava_export_table" id="">
			<tbody>
				<tr>
					<th>Příjmení / název</th>
					<td align="left"><input type="text" class="textBox" name="cp[prijmeni_nazev]" value="{$p_cart.CP_CUSTOMER.prijmeni_nazev}"/></td>
				</tr>
				<tr>
					<th>Jméno</th>
					<td align="left"><input type="text" class="textBox" name="cp[jmeno]" value="{$p_cart.CP_CUSTOMER.jmeno}"/></td>
				</tr>
				<tr>
					<th>Ulice</th>
					<td align="left"><input type="text" class="textBox" name="cp[ulice]" value="{$p_cart.CP_CUSTOMER.ulice}"/></td>
				</tr>
				<tr>
					<th>Číslo popisné</th>
					<td align="left"><input type="text" class="textBox" name="cp[c_popisne]" value="{$p_cart.CP_CUSTOMER.c_popisne}"/></td>
				</tr>
				<tr>
					<th>Obec</th>
					<td align="left"><input type="text" class="textBox" name="cp[obec]" value="{$p_cart.CP_CUSTOMER.obec}"/></td>
				</tr>
				<tr>
					<th>PSČ</th>
					<td align="left"><input type="text" class="textBox" name="cp[psc]" value="{$p_cart.CP_CUSTOMER.psc}"/></td>
				</tr>
				<tr>
					<th>IČ</th>
					<td align="left"><input type="text" class="textBox" name="cp[ic]" value="{$p_cart.CP_CUSTOMER.ic}"/></td>
				</tr>
				<tr>
					<th>DIČ</th>
					<td align="left"><input type="text" class="textBox" name="cp[dic]" value="{$p_cart.CP_CUSTOMER.dic}"/></td>
				</tr>
			</tbody>
		</table>
        <table cellspacing="0" cellpadding="0" border="0" class="doprava_export_table" id="">
			<tbody>
				<tr>
					<th>Typ zásilky</th>
					<td>
						<select id="typ_zasilky" name="cp[typ_zasilky]">
 							<option value="" {if $p_cart.CP.typ_zasilky == ""}selected="selected"{/if}>vyberte</option>
 							<option value="BB" {if $p_cart.CP.typ_zasilky == "BB"}selected="selected"{/if}>BB-Cenný balík do 10 tis.</option>
							<option value="BO" {if $p_cart.CP.typ_zasilky == "BO"}selected="selected"{/if}>BO-Obchodní balík</option>
							<option value="RR-50" {if $p_cart.CP.typ_zasilky == "RR-50"}selected="selected"{/if}>RR-Doporučená zásilka</option>
 							<option value="RR-51" {if $p_cart.CP.typ_zasilky == "RR-51"}selected="selected"{/if}>RR-Dop.zásilka standard</option>
<!-- 							<option value="RR">RR-Dop. slepecká zásilka</option> -->
<!-- 							<option value="RR">RR-Úřední psaní</option> -->
<!-- 							<option value="RR">RR-Úřední psaní standard</option> -->
						</select>
					</td>
				</tr>
				<tr>
					<th>Hmotnost</th>
					<td align="left"><input type="text" class="textBox" name="cp[hmotnost]" value="{$p_cart.CP.hmotnost|default:$p_cart.CELKOVA_HMOTNOST}"/></td>
				</tr>
				<tr>
					<th>Počet VK</th>
					<td align="left"><input type="text" class="textBox" name="cp[pocet_vk]" value="{$p_cart.CP.pocet_vk}"/></td>
				</tr>
				<tr>
					<th>Udaná cena (neuvádět u dobírky)</th>
					<td><input type="text" class="textBox" name="cp[udana_cena]" value="{if $p_cart.ID_TRANSPORT != 7 && $p_cart.ID_TRANSPORT != 8 && $p_cart.ID_TRANSPORT != 11 && $p_cart.ID_TRANSPORT != 14 && $p_cart.ID_TRANSPORT != 16 && $p_cart.ID_TRANSPORT != 18}{$p_cart.CP.dobirka|default:$p_cart.SUM_VAT_CURRENCY}{else}0{/if}" id="udanaCena"/></td>
				</tr>
				<tr>
					<th>Dobírková částka</th>
					<td align="left">
						<input type="text" class="textBox" name="cp[dobirka]" value="{if $p_cart.ID_TRANSPORT == 7 || $p_cart.ID_TRANSPORT == 8 || $p_cart.ID_TRANSPORT == 11 || $p_cart.ID_TRANSPORT == 14 || $p_cart.ID_TRANSPORT == 16 || $p_cart.ID_TRANSPORT == 18}{$p_cart.CP.dobirka|default:$p_cart.SUM_VAT_CURRENCY}{else}0{/if}"/>
					</td>
				</tr>
				<tr>
					<th>Subjekt</th>
					<td>
						<select name="cp[subjekt]">
							<option value="">fyzická osoba</option>
							<option value="P" {if $p_cart.CP.subjekt == "P"}selected="selected"{/if}>právnická osoba</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>Variabilní symbol zásilky</th>
					<td align="left"><input type="text" class="textBox" name="cp[vs_zasilka]" value="{$p_cart.CP.vs_zasilka|default:$p_cart.VARSYMB}"/></td>
				</tr>
				<tr>
					<th>Telefon</th>
					<td align="left"><input type="text" class="textBox" name="cp[telefon]" value="{$p_cart.CP_CUSTOMER.telefon}"/></td>
				</tr>
				<tr>
					<th>Mobil</th>
					<td align="left"><input type="text" class="textBox" name="cp[mobil]" value="{$p_cart.CP_CUSTOMER.mobil}" /></td>
				</tr>
				<tr>
					<th>E-mail</th>
					<td align="left"><input type="text" class="textBox" name="cp[email]" value="{$p_cart.CP_CUSTOMER.email}"/></td>
				</tr>
				<tr>
					<th>Poznámka</th>
					<td><textarea id="" cols="20" rows="2" name="cp[poznamka]">{$p_cart.CP.poznamka}</textarea></td>
				</tr>
			</tbody>			
		</table>
        <div class="submit_box">
            <input type="submit" name="cp_do_save" value="Uložit" class="ulozit_upravy_tlac"/>
            <input type="submit" name="cp_do_save_export" value="Uložit a exportovat pro ČP" class="ulozit_upravy_tlac"/>
        </div>
</form>
<!-- <script type="text/javascript" src="/templates/admin/js/cp.js"></script> -->
{literal}
<script type="text/javascript">
$("#typ_zasilky").change(function(){
	udanaCena = 0;
    var typZasilky = $("#typ_zasilky").val();
    var cena = {/literal}{$p_cart.ITEMS_SUM_VAT}{literal};
	if(typZasilky == "BB") {
		udanaCena = 500;
		if(cena > 900) {
			udanaCena = 5000;
		}
	}
	$('#udanaCena').val(udanaCena);
    
})
</script>
{/literal}