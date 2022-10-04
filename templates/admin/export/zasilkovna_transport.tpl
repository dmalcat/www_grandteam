{if $dbCart->getTransport()->isZasilkovna()}
	<form action="" method="post">
		<select name="idZasilkovna" onchange="submit()">
			{foreach from=Zasilkovna::getVydejny() item=pVydejna}
				<option value="{$pVydejna.id}" {if $dbCart->getZasilkovna() == $pVydejna.id}selected="selected"{/if}>{$pVydejna.popis}</option>
			{/foreach}
				<!--<option value="13">Česká pošta</option>-->
				<!--<option value="13" {if $p_cart.ID_TRANSPORT == 11}selected="selected"{/if}>Slovenská pošta</option>-->
		</select>
	</form>
{/if}
<form action="" method="post">
    <div class="submit_box">
            <input type="submit" name="zasilkovna_export" value="Exportovat" class="ulozit_upravy_tlac pozice_uprostred"/>
    </div>
</form>
