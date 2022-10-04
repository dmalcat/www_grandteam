<form action="" method="post">
	<table width="200" cellpadding="0" cellspacing="0" style="margin-bottom:10px;margin-left:25px;margin-top:15px;">
		<tr>
			<th class="label_objednavka">Datum od</th>
        </tr>
        <tr>
			<td>
                <div class="datum_bg" style="margin:0px;">
                    <input type="text" name="date_to" id="datepicker2" value="{$smarty.post.date_to|date_format:'%Y-%m-%d'|default:$smarty.now|date_format:'%Y-%m-%d'}"/>
                </div>
            </td>
        </tr>
        <tr>
            <th class="label_objednavka">Datum do</th>
		</tr>
		<tr>
			<td>
                <div class="datum_bg" style="margin:0px;">
                    <input type="text" name="date_from" id="datepicker3" value="{$smarty.post.date_from|date_format:'%Y-%m-%d'|default:$default_date_from|date_format:'%Y-%m-%d'}"/>
                </div>
            </td>
		</tr>
        <tr>
			<th class="label_objednavka" style="padding-top:20px;padding-bottom:5px;">Stav</th>
		</tr>
        <tr>
            <td class="label_radio">
                <label><input type="radio" name="show_cart_status" value="" checked="checked" />vše</label><br />
				{html_radios name="show_cart_status" options=$s_cart_status selected=$smarty.post.show_cart_status separator="<br/>"}
            </td>
		</tr>
		<tr>
			<th>
                <input type="submit" name="do_cart_filter" value="zobrazit" class="objednavka_filtr"/>
            </th>
		</tr>
	</table>
</form>
<form action="" method="post">
	<table width="200" cellpadding="0" cellspacing="0" style="margin-bottom:10px;margin-left:25px;">
		<tr>
			<th class="label_objednavka">Doklad</th>
        </tr>
		<tr>
			<td>
                <input type="text" name="varsymb" value="{$smarty.post.varsymb}"  class="objednavka_input_delsi"/>
            </td>
		</tr>
		<tr>
			<th><input type="submit" name="do_cart_filter" value="zobrazit" class="objednavka_filtr"/></th>
		</tr>
	</table>
</form>
{*
<form action="" method="post">
	<table style="border: solid 1px white; padding: 3px; width: 200px; margin-bottom: 5px;">
		<tr>
			<th>Stav</th>
			<td>
				<label><input type="radio" name="show_cart_status" value="" checked="checked" />vše</label><br/>
				{html_radios name="show_cart_status" options=$s_cart_status selected=$smarty.post.show_cart_status separator="<br/>"}
			</td>
		</tr>
		<tr>
			<th colspan="2"><input type="submit" name="do_cart_filter" value="zobrazit">
		</tr>
	</table>
</form>
*}
<form action="" method="post">
	<table width="200" cellpadding="0" cellspacing="0" style="margin-bottom:10px;margin-left:25px;">
		<tr>
			<th class="label_objednavka">Posledních</th>
        </tr>
		<tr>
			<td>
				<input type="text" name="limit" value="{$smarty.post.limit}" class="objednavka_input_delsi" />
			</td>
		</tr>
		<tr>
			<th><input type="submit" name="do_cart_filter" value="zobrazit" class="objednavka_filtr"/></th>
		</tr>
	</table>
</form>
<form action="" method="post">
	<table width="200" cellpadding="0" cellspacing="0" style="margin-bottom:10px;margin-left:25px;">
		<tr>
			<th class="label_objednavka">Dle zákazníka</th>
		</tr>
		<tr>
			<td>
				{html_options name="id_user" options=$s_users selected=$smarty.post.id_user}
			</td>
		</tr>
		<tr>
			<th><input type="submit" name="do_cart_filter" value="zobrazit" class="objednavka_filtr"/></th>
		</tr>
	</table>
</form>
<form action="" method="post">
	<table width="200" cellpadding="0" cellspacing="0"style="margin-left:25px;">
		<tr>
			<th class="label_objednavka">Dle objednaného zboží</th>
		</tr>
		<tr>
			<td>
				{html_options name="id_manufacturer" options=$s_manufacturers selected=$smarty.post.id_manufacturer onchange="submit()"}
			</td>
		</tr>
		<tr>
			<td>
				<select name="id_cart_item">
					{foreach from=$p_items item=item}
						<option value="{$item->id_item}" {if $item->id_item == $smarty.post.id_cart_item}selected {/if}>{$item->nazev_alba}</option>
					{/foreach}
				</select>
			</td>
		</tr>
		<tr>
			<th><input type="submit" name="do_cart_filter" value="zobrazit" class="objednavka_filtr" /></th>
		</tr>
	</table>
</form>