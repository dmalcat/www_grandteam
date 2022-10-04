<script type="text/javascript">
	{if $error_message}
	$(document).ready(function () {
			bootbox.alert("{$error_message}", function () {}
			);
		});
	{/if}
	{if $success_message}
		$(document).ready(function () {
				bootbox.alert("{$success_message}", function () {}
				);
			});
	{/if}
	{foreach from=$modals item=modal}
			$(document).ready(function () {
				$('#{$modal}').modal('show');
			});
	{/foreach}
</script>


<div id="loginModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title">{'Přihlášení'|translate}</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-5" >
						<p>
							{*							Pokud nemáte registraci pokračujte zde. <br /><br />*}
							<a href="/registrace" class="btn btn-primary btn-sm btn-block">{'Registrace'|translate}</a><br />
							{*<a class="btn btn-sm btn-primary btn-block" href="/fblogin"><i class="fa fa-facebook"></i> | {'Přihlásit pomocí'|translate} FB</a>
							<br />*}
							<a href="/registrace/ztracene_heslo" class="btn btn-sm btn-info btn-block">{'Zapomenuté heslo'|translate}</a>
						</p>
						{*						<a href="#"><img src="http://techulus.com/buttons/fb.png" class="img-responsive"/></a><br/>*}
						{*						<a href="#"><img src="http://techulus.com/buttons/tw.png" class="img-responsive" /></a><br/>*}
						{*						<a href="#"><img src="http://techulus.com/buttons/gplus.png" /></a>*}
					</div>

					<div class="col-md-7" style="border-left:1px solid #ccc; ">
						<form class="form-horizontal form-valid-no-scroll" method="post" action="">
							<fieldset>
								<input id="login" name="login_user" type="text" placeholder="přihlašovací jméno" class="form-control input-md validate[required, custom[email]]">
								<div style='height: 16px;'></div>
								{*								<div class="spacing"><input type="checkbox" name="checkboxes" id="checkboxes-0" value="1"><small> Remember me</small></div>*}
								<input id="heslo" name="login_pass" type="password" placeholder="heslo" class="form-control input-md validate[required]">
								<div style='height: 16px;'></div>
								<button id="singlebutton" name="singlebutton" class="btn btn-primary btn-sm pull-right">Přihlásit</button>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div id="addToCart" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addToCartLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title">{'Košík'|translate}.</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12" >
						<p>
							Zboží bylo přídáno do košíku. <br />
						</p>
						<a href="#" data-dismiss="modal" data-target="#" class="btn btn-primary pull-left">zpět na zboží</a>
						<a href="/objednavka" class="btn btn-success pull-right">zobrazit košík</a>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>