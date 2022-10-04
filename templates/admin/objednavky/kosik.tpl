{if $p_cart.ITEMS_COUNT}
    <div class="objednavka_detail">
        <table cellpadding="0" cellspacing="0">
			{foreach from=$p_cart.ITEMS item=item name=for_cart_items}
				{assign var=item_status value=$item->status}
				{assign var=dod_termin  value=$item->dod_termin}
				<form action="" method="post">
				{if $smarty.foreach.for_cart_items.index eq 0}
					<tr>
						<th class="table_label_objednavka"></th>
						{foreach from=$p_cart.OPTIONAL_PROPS item=prop}
							<th class="table_label_objednavka">{$prop->prop_name|translate}</th>
						{/foreach}
						<th class="table_label_objednavka">Počet</th>
						<th class="table_label_objednavka">Cena/ks</th>
 						<th class="table_label_objednavka">Cena půvd.</th>
<!--  						<th class="table_label_objednavka">Hmotnost</th> -->
						<th class="table_label_objednavka">Stav</th>
						<th class="table_label_objednavka">Skladem</th>
						<th class="table_label_objednavka">Smazat</th>
					</tr>
				{/if}
				<tr class="{$p_cart_item_status.$item_status.class}" id="cartItem_{$item->id_cart_item}">
					<!--<td><img src="{$item->images.email_url|default:'/design/list_foto_def.png'}" alt="{$item->base_name}"/></td>-->
					<td id="detail_{$item->id_cart_item}" class="cart_item_detail" title="{foreach from=$item->PROPS item=p_prop}<strong>{$p_prop->property|translate}:</strong> {$p_prop->value}<br/>{/foreach}">
                        <img src="/images/admin/ico-info.png" border="0" width="24"/>
                    </td>
					{foreach from=$p_cart.OPTIONAL_PROPS item=prop}
						{assign var=opt_prop_name value=$prop->prop_name}
						{assign var=opt_prop_value value=$item->PROPS.$opt_prop_name->value}
						{if $opt_prop_name == "doba_dodani" AND $item->store > 0}{assign var=opt_prop_value value="1"}{/if}
						<td>{$opt_prop_value}</td>
					{/foreach}
					<td {if $item->count > 1}style="border: solid 3px blue"{/if}>{$item->count} ks</td>
					<td>{$item->price_vat|price:$p_cart.CURRENCY->code:$p_cart.CURRENCY->currency_rate}</td>
					<td>{$item->price_raw_vat|price:$p_cart.CURRENCY->code:$p_cart.CURRENCY->currency_rate}</td>
<!--  					<td>{*$item->PROPS.hmotnost.PROP_VALUE*} kg</td> -->
					<th>
						<input type="hidden" name="id_cart_item" value="{$item->id_cart_item}"/>
						{html_options options=$s_cart_item_status name="item_status" selected=$item_status rel=$item->id_cart_item class="cartItemStatus"}
					</th>
					<th>{$item->store} ks</th>
					<!--<th>{html_options name="dod_termin" options=$s_dod_termin selected=$dod_termin onchange="submit()" readonly=$disabled}</th> -->
					<th style="text-align:center;">
                        <input type="submit" name="do_delete_cart_item" value=" " class="objednavka_delete" onclick="return confirm('Opravdu odebrat produkt z objednávky ?')">
                    </th>
				</tr>
				</form>
			{/foreach}
		</table>
    	<div class="cb"></div>
        <table cellpadding="0" cellspacing="0" style="width:400px;float:right;">
    		<tr>
    			<th class="objednavka_detail_souhrn">Cena zboží celkem:</th>
    			<th  class="objednavka_detail_souhrn">{$p_cart.ITEMS_SUM_VAT|price:$p_cart.CURRENCY->code:$p_cart.CURRENCY->currency_rate}</th>
    		</tr>
			{if $dbCart->getUsedKupon()}
				<tr>
					<th class="objednavka_detail_souhrn">Kupónová sleva:<br/>{$dbCart->getUsedKupon()->code}</th>
					<th  class="objednavka_detail_souhrn"> {$dbCart->getSlevaKupon(1)|price}</th>
				</tr>
			{/if}
    		<tr>
    			<th class="objednavka_detail_souhrn">Doprava:<br/> {$dbCart->getTransport()->name} {if $dbCart->getTransport()->isZasilkovna()} {Zasilkovna::getById($dbCart->getZasilkovna())->mesto} {Zasilkovna::getById($dbCart->getZasilkovna())->adresa} {/if}</th>
    			<th  class="objednavka_detail_souhrn">{$dbCart->getTransportPaymentSum(1)|price:$p_cart.CURRENCY->code:$p_cart.CURRENCY->currency_rate}</th>
    		</tr>
    		<tr>
    			<th class="objednavka_detail_souhrn">Celkem vč. DPH:</th>
    			<th class="objednavka_detail_souhrn">{$dbCart->getSum(1)|price:$p_cart.CURRENCY->code:$p_cart.CURRENCY->currency_rate}</th>
    		</tr>
     		<tr>
     			<th class="objednavka_detail_souhrn">Celková hmotnost:</th>
     			<th class="objednavka_detail_souhrn">{$p_cart.CELKOVA_HMOTNOST} kg</th>
     		</tr>
    	</table>
	</div>
	<div class="objednavka_detail_box" style="width:935px;border-bottom: 1px solid #9C9C9C;padding-bottom:20px;">
        <h3>INFORMACE O ZÁKAZNÍKOVI</h3>
        <table cellspacing="0" cellpadding="0" border="0" class="doprava_export_table" style="width:480px;">
			{foreach from=$p_cart.CUSTOMER.STEPS item=step}
			<tr>
				<th colspan="2">{$step.NAME}</th>
			</tr>
			{foreach from=$step.CATEGORIES item=category}
			<tr>
				<th colspan="2">=>{$category.NAME}</th>
			</tr>
			{foreach from=$category.PROPERTIES item=property}
			<tr>
				<th>{$property.PROP_NAME}</th>
				<td>
					{if $property.PROP_TYPE == "STRING"}<input readonly="readonly" type="text" value="{$property.PROP_VALUE}" />{/if}
					{if	$property.PROP_TYPE == "TEXTAREAA"}<textarea readonly="readonly">{$property.PROP_VALUE}</textarea>{/if}
					{if $property.PROP_TYPE == "S_CHECKBOX"}{html_checkboxes disabled="disabled" options=$property.PROP_ENUMERATION|@array_compact 	selected=$property.PROP_VALUE|@enum_values}{/if}
					{if	$property.PROP_TYPE == "E_SELECT"}{html_options disabled="disabled" name="name[$prop_name]"	options=$property.PROP_ENUMERATION|@array_compact selected=$property.PROP_VALUE|@enum_values}{/if}
					{if	$property.PROP_TYPE == "E_RADIO"}{html_radios disabled="disabled"	name="name[$prop_name]"	options=$property.PROP_ENUMERATION|@array_compact selected=$property.PROP_VALUE|@enum_values}{/if}
					{if	$property.PROP_TYPE == "FILE"}<input type="file" disabled="disabled" 	value="{$property.PROP_VALUE}" />{/if}
					{if $property.PROP_TYPE =="IMAGE"}<input type="file" disabled="disabled"	value="{$property.PROP_VALUE}" />{/if}
				</td>
			</tr>
			{/foreach} {/foreach} {/foreach}
		</table>
    </div>

	{if !$compact_cart}
	<div id="doprava_patba">
		<div id="doprava" style="float: left; width: 45%; ">
			<form action="" method="post">
				<table style="font-size: 9px; width: 870px; border: solid 1px white;">
					<tr>
						<td colspan="2">Doprava</td>
					</tr>
					<tr>
						<td>{html_radios name="id_transport" options=$s_transports selected=$id_transport separator="<br/>" onclick="submit()"}</td>
					</tr>
					<tr>
						<th colspan="2">
							<input class="none" type="submit" name="do_change_transport" value="zmenit"/>
						</th>
					</tr>
				</table>
			</form>
		</div>
		<div id="doprava" style="float: right; width: 45%; ">
			<form action="" method="post">
				<table style="font-size: 9px; width: 870px; border: solid 1px white;">
					<tr>
						<td colspan="2">Platba</td>
					</tr>
					<tr>
						<td>{html_radios name="id_payment" options=$s_payments selected=$id_payment separator="<br/>" onclick="submit()"}</td>
					</tr>
					<tr>
						<th colspan="2">
							<input type="hidden" name="id_transport" value="{$id_transport}" />
							<input class="none" type="submit" name="do_change_transport" value="zmenit"/>
						</th>
					</tr>
				</table>
			</form>
		</div>
	</div>
	{/if}
{/if}
<div class="objednavka_detail_box" style="border-right: 1px solid #9C9C9C;">
	<h3>PŘIDAT POLOŽKU DO OBJEDNÁVKY</h3>
	<form action="" method="post" style="display: inline;">
		kód: <input type="text" name="newOrderItem" id="newOrderItem" class="kategorie_input_delsi"/>
		počet: <input type="text" name="newOrderItemCount" id="newOrderItemCount" value="1" class="kategorie_input_delsi"/>
		<input type="hidden" name="newOrderItemIdItem" id="newOrderItemIdItem" value=""/>
		<input type="submit" name="do_add_to_cart" value="Přidat" class="objednavka_filtr" disabled="true" id="do_add_to_cart"/>
	</form>
</div>

<div class="objednavka_detail_box">
	<h3>POZNÁMKA ZÁKAZNÍKA</h3>
	<div class="objednavka_poznamka">
       {$p_cart.MESSAGE|nl2br}
    </div>
</div>
<div class="objednavka_detail_box" style="border-right: 1px solid #9C9C9C;">
    <h3>ODESLAT SMS NA: {$user_telefon}</h3>
	<form action="" method="post">
		<textarea name="sms_text">{$smarty.post.sms_text|default:$sms_dodani_message}</textarea>
		<input type="submit" name="do_send_sms" value="Odeslat sms" class="objednavka_filtr"/>
	</form>
</div>
<div class="objednavka_detail_box">
	<h3>ODESLAT EMAIL NA: {$user_email}</h3>
	<form action="" method="post" enctype="multipart/form-data">
        <table cellspacing="0" cellpadding="0" border="0" class="doprava_export_table" style="margin:0px;">
			<tr>
				<th>cena dopravy:</th>
				<td><input type="text" name="sum_transport" value="{$p_cart.TRANSPORT_SUM_VAT|price:$p_cart.CURRENCY->code:$p_cart.CURRENCY->currency_rate}"  class="kategorie_input_delsi"/></td>
			</tr>
			<tr>
				<th>pdf faktury</th>
				<td><input type="file" name="invoice"/></td>
			</tr>
        </table>
        <div class="cb"></div>
        <input type="submit" name="do_send_email" value="Potvrzující email" class="objednavka_filtr" style="margin-right:25px;"/>
		<input type="submit" name="do_send_email" value="Storno email" class="objednavka_filtr"/>
	</form>
</div>


<div class="objednavka_nasledne_upravy_title ui-accordion-header">
    <span class="ui-icon ui-icon-circle-plus"></span>
        NÁSLEDNÉ ÚPRAVY
</div>
<div class="objednavka_nasledne_upravy">
    <form action="" method="post">
            <table cellspacing="0" cellpadding="0" border="0" class="doprava_export_table" id="">
			    <tr>
    				<th>podací číslo</th>
    				<th>sleva (částka)</th>
    				<th>procentuelni uprava ceny</th>
    				<th>spec.typ slevy</th>
			    </tr>
			    <tr>
				<td><input type="text" name="transport_number" value="{$p_cart.TRANSPORT_NUMBER}" /></td>
				<td><input type="text" name="nasledna_sleva_pocet" value="{$p_cart.NASLEDNA_SLEVA_POCET}"/></td>
				<td><input type="text" name="nasledna_sleva_procenta" value="{$p_cart.NASLEDNA_SLEVA_PROCENTA}"/></td>
				<td>

				    <select name="special_order_type">
					{foreach from=$p_special_order_sleva key=key item=sleva}
					    <option value="{$key}" {if $key == $p_cart.SPECIAL_ORDER_TYPE} selected{/if}>{$sleva.name}</sleva>
					{/foreach}
				    </select>
				</td>
			    </tr>
			</table>
            <div class="submit_box">
                <input type="submit" name="do_change_order" value="Upravit" class="ulozit_upravy_tlac pozice_uprostred"/>
            </div>
    </form>
</div>
<div class="cb"></div>


{literal}
<script type="text/javascript">
	$(document).ready(function(){
			$("input#newOrderItem").autocomplete({
				source: function(request, response) {
					$('#loading').show();
					$.ajax({
						url: "/res/ajax.php?mode=adminOrdersProductSearch",
						dataType: "json",
						data: { search: request.term },
						success: function(data) {
							$('#loading').hide();
							response($.map(data, function(item) {
								return { label: item.nazev + " " + item.kod, value: item.nazev + " " + item.kod, kod: item.kod, id_item: item.id_item}
							}))
						}
					})
				},
				minLength: 1,
				select: function(event, ui) {
					$(this).data("uiItem",ui.item.value);
// 					alert(ui.item ? ("Selected: " + ui.item.label) : "Nothing selected, input was " + this.value);
					$('#do_add_to_cart').removeAttr('disabled');
					$("#newOrderItemIdItem").val(ui.item.id_item);
				},
				open: function() {  },
				close: function() {  }
			}).bind("blur",function(){
						var data_tmp = $(this).data("uiItem");
						$(this).val($(this).data("uiItem"));
				}).data("uiItem",$("input[name='newOrderItem']").val());

	});


	$('.cart_item_detail').tooltip({
// 		track: true,
		delay: 0,
		showURL: false,
		showBody: " - ",
		fade: 250
	});
</script>
{/literal}