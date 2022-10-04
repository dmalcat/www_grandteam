<h1 class="clanek_title">NOVÝ UŽIVATEL</h1>
<form action="/admin/uzivatele" method="post" id="novyUzivatel">
    <div class="uzivatele_zaznamy">
    		<table border="0" cellpadding="0" cellspacing="0">
    			<tr>
    				<th>login</th>
    				<th>heslo</th>
    				<th>heslo potvr.</th>
    				<th>role</th>
    			</tr>
    			<tr class="new">
    				<td><input type="text" name="login" class="validate[required]" id="newUserLogin"/></td>
    				<td><input type="password" name="pass" class="validate[required]" id="pass"/></td>
    				<td><input type="password" name="pass_confirm" class="validate[required,equals[pass]]" id="newUserPassConfirm"/></td>
    				<td>{html_options options=dbRole::getAll()|select:'id':'name' name='idRole'}</td>
    			</tr>
    		</table>
    </div>
    <div class="submit_box">
        <input type="submit" name="user_do_insert" value="Nový uživatel" class="ulozit_upravy_tlac pozice_uprostred" />
    </div>

</form>