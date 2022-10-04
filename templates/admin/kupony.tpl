<h1 class="clanek_title">DÁRKOVÉ POUKAZY</h1>
<table class="nastaveni_kupony_table" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:0px;"> 
	<tr>
		<th style="width:25px;">#&nbsp;&nbsp;&nbsp;&nbsp;</th>
		<th style="width:90px;">Kód</th>
		<th style="width:200px;">Název</th>
		<th style="width:90px;">Částka</th>
		<th style="width:107px;">Procent</th>
<!-- 	<th>vloženo</th> -->
<!-- 	<th>pouzito&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th> -->
		<th style="width:90px;">Zbývá použití</th>
<!-- 	<th>Pouzito uzivatelem</th> -->
		<th style="width:90px;">Aktivní od</th>
		<th style="width:90px;">Aktivní do</th>
		<th>Aktivní</th>
		<th style="width:55px;">Upravit</th>
		<th style="width:55px;">Smazat</th>
	</tr>
</table>
{foreach from=$pKupony item=pKod}
	<form action="" method="post">
		<table class="nastaveni_kupony_table" border="0" cellpadding="0" cellspacing="0" style="margin-top:0px;">
			<tr>
				<td style="width:25px;">{$pKod->id}</td>
				<td style="width:90px;"><input type="text" name="code" value="{$pKod->code}" class="nastaveni_kupony_input_kratky"/></td>
				<td style="width:200px;"><input type="text" name="name" value="{$pKod->name}" class="nastaveni_kupony_input_delsi"/></td>
				<td style="width:90px;"><input type="text" name="price" value="{$pKod->price}" class="nastaveni_kupony_input_kratky"/></td>
				<td style="width:107px;">
					<select name="percent">
							<option value="1">žádná</option>
							<option value="0.95" {if $pKod->percent == '0.95'}selected="selected"{/if}>5%</option>
							<option value="0.90" {if $pKod->percent == '0.90'}selected="selected"{/if}>10%</option>
							<option value="0.85" {if $pKod->percent == '0.85'}selected="selected"{/if}>15%</option>
							<option value="0.80" {if $pKod->percent == '0.80'}selected="selected"{/if}>20%</option>
							<option value="0.75" {if $pKod->percent == '0.75'}selected="selected"{/if}>25%</option>
							<option value="0.70" {if $pKod->percent == '0.70'}selected="selected"{/if}>30%</option>
							<option value="0.65" {if $pKod->percent == '0.65'}selected="selected"{/if}>35%</option>
							<option value="0.60" {if $pKod->percent == '0.60'}selected="selected"{/if}>40%</option>
					</select>
				</td>
				<td style="width:90px;"><input type="text" name="count" value="{$pKod->count|default:0}" class="nastaveni_kupony_input_kratky"/></td>
				<td style="width:90px;"><input type="text" name="valid_from" value="{$pKod->valid_from}" class="date nastaveni_kupony_input_kratky" id="validFrom_{$pKod->id}"/></td>
				<td style="width:90px;"><input type="text" name="valid_to" value="{$pKod->valid_to}" class="date nastaveni_kupony_input_kratky" id="validTo_{$pKod->id}"/></td>
<!-- 					<td>{$pKod->datum_vlozeni|date_format:'%d.%m.%Y'}</td> -->
<!-- 					<td>{$pKod->datum_pouziti|date_format:'%d.%m.%Y'}</td> -->
				<td>
					<input type="checkbox" name="visible" {if $pKod->visible}checked="checked"{/if}/>
				</td>
<!-- 				<td>{$pKod->used_by_user}</td> -->
				<td style="width:55px;">
					<input type="hidden" name="type" value="individual"/>
					<input type="hidden" name="id" value="{$pKod->id}"/>
					<input type="submit" class="nastaveni_kupony_edit" name="do_kod_edit" value=" "/>
				</td>
				<td style="width:55px;"><input type="submit" class="nastaveni_kupony_smazat" name="do_kod_delete" value=" " onclick="return confirm('Opravdu smazat ?')"/></td>
			</tr>
		</table>
    </form> 
{/foreach}

<h2 class="clanek_title">VLOŽIT NOVÝ KÓD</h2>
<form action="" method="post">
    <table class="nastaveni_kupony_table" border="0" cellpadding="0" cellspacing="0">
				<tr>
                    <th>Kód</th>
                    <th>Název</th>
                    <th>Částka</th>
                    <th>Procent</th>
                    <th>Počet</th>
                    <th>Aktivní od</th>
                    <th>Aktivní do</th>
                    <th>Aktivni</th>
                </tr>
                <tr>    
                    <td>
                        <input type="text" name="code" class="nastaveni_kupony_input_kratky"/>
                    </td>
                    <td>
                        <input type="text" name="name" class="nastaveni_kupony_input_delsi"/>
                    </td>
                    <td>
                        <input type="text" name="price" class="nastaveni_kupony_input_kratky"/>
                    </td>
                    <td>
                        <select name="percent">
							<option value="1">žádná</option>
							<option value="0.95">5%</option>
							<option value="0.90">10%</option>
							<option value="0.85">15%</option>
							<option value="0.80">20%</option>
							<option value="0.75">25%</option>
							<option value="0.70">30%</option>
							<option value="0.65">35%</option>
							<option value="0.60">40%</option>
						</select>
                    </td>
                    <td>
                        <input type="text" name="count" class="nastaveni_kupony_input_kratky"/>
                    </td>
                    <td>
                        <input type="text" name="valid_from" class="date nastaveni_kupony_input_kratky" id="validFrom" value=""/>
                    </td>
                    <td>
                        <input type="text" name="valid_to" class="date nastaveni_kupony_input_kratky" id="validTo"/>
                    </td>
                    <td>
                        <input type="checkbox" name="visible"/>
                    </td>
                    <td colspan="2">
    					<input type="hidden" name="type" value="individual"/>
    					<input type="submit" name="do_kod_add" value="Přidat"  class="objednavka_filtr"/>
    				</td>
                </tr>
    </table>
</form>


<script type="text/javascript">
$(document).ready(function()  { 

	$( ".date" ).datepicker({});
	$( "#validFrom" ).datepicker({});
	$( "#validTo" ).datepicker({});

});     
	
</script>