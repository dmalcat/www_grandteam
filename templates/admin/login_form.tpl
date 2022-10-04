<div class="login_form">
	<h1>
		<a href="http://www.3nicom.cz/" title="3nicom"></a>
	</h1>
	<div class="cb"></div>
	<div class="login_form_nadpis">administrační rozhraní</div>
	<div class="cb"></div>

	<h2>{Registry::getDomainName()|upper} ADMINISTRACE</h2>

	{if $dbUser->id}
		<div class="login_form_nadpis" style="font-size: 12px; text-align: center; margin-top: 0px;">
			Přihlášený uživatel {$dbUser->login} <a href="/logout">odhlásit</a>
		</div>
	{/if}

	<form action="/admin/" method="post" id="prihlaseni">
		<label class="login_form_label">Jméno</label>
		<div class="login_form_input">
			<input type="text" name="login_user" class="validate[required]" id="login_user"/>
		</div>
		<label class="login_form_label">Heslo</label>
		<div class="login_form_input">
			<input type="password" name="login_pass" class="validate[required]" id="login_pass"/>
		</div>
		<input type="submit" name="submit" value="Přihlásit do administrace" class="login_form_submit"/>
	</form>
</div>
