
<div class="row">
	<div class="col-md-12">
		<div class="thumbnail margin-top-15 padding-left-10 padding-right-10">
			<h1>{'Rychlý kontakt'|translate}</h1>
			<div class="clearfix"></div>

			<form class="form-horizontal" action="" method="post"  id="form_kontaktni_formular">
				<fieldset>
					<div class="form-group">
						<label class="col-md-4 control-label" for="email">{'Váš e-mail'|translate}:</label>  
						<div class="col-md-6">
							<input id="textinput" name="kontakt[email]" type="email" placeholder="" class="form-control input-sm" required="" value="{if $dbUser->id}{$dbUser->getPropertyValue("email")}{else}{$smarty.post.kontakt.email}{/if}">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label" for="telefon">{'Váš telefon'|translate}:</label>  
						<div class="col-md-6">
							<input id="textinput" name="kontakt[telefon]" type="tel" placeholder="" class="form-control input-sm" value="{if $dbUser->id}{$dbUser->getPropertyValue("telefon")}{else}{$smarty.post.kontakt.telefon}{/if}">
						</div>
					</div>

					<!-- Textarea -->
					<div class="form-group">
						<label class="col-md-4 control-label" for="vzkaz">{'Vzkaz'|translate}:</label>
						<div class="col-md-6">                     
							<textarea class="form-control" id="vzkaz" name="kontakt[vzkaz]" rows="2" style="height: 100px;">{$smarty.post.kontakt.vzkaz}</textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label">Opište text z obrázku:</label>
						<div class="col-md-6">
							<div id="captcha_div" style="margin-top: 10px;">
								<div id="wrap" align="left" class="row">
									<div class="col-md-6">
										<img src="/plugins/captcha_stylish_99/get_captcha.php" alt="" id="captcha" class="pull-left"/>
										<div id="captcha_refresh">
											<img src="/plugins/captcha_stylish_99/refresh.jpg" width="25" alt="" id="refresh" title="Znovu generovat kód"/>
											změnit obrázek
										</div>
									</div>
									<div class="col-md-6">
										<input name="code" type="text" id="code" class="form-control check_input upper pull-left margin-top-5" placeholder="  Opište text" required="">

									</div>
								</div>
							</div>
						</div>
					</div>			
					<!-- Button -->
					<div class="form-group">
						<label class="col-md-4 control-label"></label>
						<div class="col-md-6">
							<div id="captchaOdeslatRow">
								<input type="submit" name="do_send_vzkaz" value="ODESLAT" class="vzkaz_submit btn btn-primary" alt="Odeslat" title="Odeslat"/>
							</div>	
						</div>
					</div>

				</fieldset>
			</form>

		</div>
	</div>		
</div>
