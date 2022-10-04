<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		{include file="head.tpl"}
	</head>
	<body>
		<div class="container">
			<div class="container_2" style=" ">
				<div class="header"><a href="/" title="{Registry::getDomainName()}" class="header_a"> <img src="/images/logo.png" alt="{Registry::getDomainName()}" width="224" height="171" border="0" align="left" /></a>       
				</div>
				<div class="main_content" style="background-image:none; ">
					<div class="content_bg" style="background:#FFF; margin-top:20px; margin-bottom:20px; width:100%; padding-top:30px;padding-bottom:10px; min-height:200px; " >
						<form action="" method="post">
							<div class="left_text" style="width:450px; margin-left: auto; margin-right: auto; text-align: center;">
								<div class="login_label">Uživatelské jméno:</div>
								<input name="login_user" type="text" class="login_input" size="50"/>
								<div class="login_label">Heslo</div>
								<input type="password" name="login_pass" class="login_input" size="50"/>

								<input type="submit" name="login" value="Přihlásit" class="zel_tlacitko_login" style="margin-top: 5px; "/>
						</form>
						<br />
						<a href="/registrace" class="zel_tlacitko_login"  style="color: white; margin-top: 5px; display: inline-block; padding-top: 5px; height: 25px; font-size: 15px;">Nová registrace</a><br /><br />
						<span style="font-size: 12px;">Zapomněli jste své heslo? Klikněte <a href="/registrace/ztracene_heslo">zde</a>.</span>



					</div>
				</div>
				<div class="content_ft"></div>
			</div>
			<div class="paticka">
				<div class="footer"> 
					<a href="/" title="{Registry::getDomainName()}" class="header_a"> <img src="/images/logo_bottom.jpg" alt="{Registry::getDomainName()}" width="218" height="78" border="0" align="left" /> </a>  </a> 
				</div>
			</div>
		</div>

		<div style="display:none;" id="error-message" title="Chyba">
			{$error_message}
		</div>
		<div style="display:none;" id="success-message" title="Info">
			{$success_message}
		</div>

		{include file="counter.tpl"}
	</body>
</html>


