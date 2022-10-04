<h1 class="clanek_title">MĚNY</h1>
	<form action="" method="post">
    	<table class="nastaveni_mena_table" border="0" cellpadding="0" cellspacing="0">
    		<tr>
    			<th>Kód</th>
    			<th>Kurz</th>
    		</tr>
    		{foreach from=$meny item=mena}
    		<tr>
    			<td>{$mena->code}</td>
    			<td><input type="text" value="{$mena->rate}" name="kurz[{$mena->id}]" />,- Kč</td>
    		</tr>
    		{/foreach}
    	</table>

        <div class="submit_box">
        	<input type="submit" value="Uložit změny" name="edit" class="ulozit_upravy_tlac pozice_uprostred" />
        </div>
    </form>
