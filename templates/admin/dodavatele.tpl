<h1 class="clanek_title">DODAVATELÉ</h1>
    <table class="nastaveni_doprava_table" border="0" cellpadding="0" cellspacing="0" style="width:400px;">
            <tr>
            			<th>Zobr.</th>
            			<th>Dodavatel</th>
            			<th>Upravit</th>
            			<th>Smazat</th>
            </tr>
            {foreach name=for_manufacturers from=$p_manufacturers key=id_manufacturer item=manufacturer}
                <form action="" method="post">
                <tr>
            		<td>{html_checkboxes name="visible" options=$s_visible selected=$manufacturer->visible}</td>
            		<td><input type="text" name="firma" value="{$manufacturer->firma}" class="nastaveni_doprava_input_delsi"/></td>
            		<td style="text-align:center;">
            			<input type="hidden" name="id_manufacturer" value="{$id_manufacturer}"/>
            			<input type="submit" name="manufacturer_do_edit_info" value=" " class="nastaveni_doprava_edit"/>
            		</td>
            		<td style="text-align:center;"><input type="submit" name="manufacturer_do_delete" value=" " class="nastaveni_doprava_smazat" onclick="return confirm('Opravdu smazat {$manufacturer->firma} ?')"/></td>
            	</tr>
            	</form>
            {/foreach}
	</table>

<h2 class="clanek_title">PŘIDAT NOVÉHO DODAVATELE</h2>
<form action="" method="post">
    <table class="nastaveni_doprava_table" border="0" cellpadding="0" cellspacing="0" style="width:400px;">
    	<tr>
    			<th>Zobr.</th>
    			<th>Dodavatel</th>
    	</tr>
    	<tr>
    		<td>{html_checkboxes name="visible" options=$s_visible selected=1}</td>
    		<td><input type="text" name="firma"  class="nastaveni_doprava_input_delsi"/></td>
    		<td><input type="submit" name="manufacturer_do_insert_info" value="Vložit" class="objednavka_filtr"/></td>
    	</tr>
	</table>
</form>


{*if $smarty.post.id_manufacturer and $smarty.post.manufacturer_do_show_detail}
	{assign var=id_manufacturer value=$smarty.post.id_manufacturer}
	{assign var=manufacturer value=$p_manufacturers.$id_manufacturer}
    <form action="" method="post">
     <table class="nastaveni_doprava_table" border="0" cellpadding="0" cellspacing="0" style="width:630px;">
    		{if $smarty.foreach.for_manufacturers.first}
    			<tr>
    				<th>Zobr.</th>
    				<th>Výrobce</th>
    			</tr>
    		{/if}
    		<tr>
    			<td>{html_checkboxes name="visible" options=$s_visible selected=$manufacturer->visible}</td>
    			<td><input type="text" name="firma" value="{$manufacturer->firma}"/></td>
    		</tr>

    	</table>
	</form>
{/if*}


