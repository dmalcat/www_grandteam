{if $dbProdejna}
	<h1 class="clanek_title">EDITACE PRODEJNY {$dbProdejna->prodejna} </h1>
{elseif $par_3 == "zalozit"}
	<h1 class="clanek_title">Založit prodejnu</h1>
{else}
	<h1 class="clanek_title">
		SEZNAM PRODEJEN
		<div style="float: right; margin-right: 10px; margin-top: 2px;">
			<a href="/admin/prodejny/zalozit" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button"><span class="ui-button-text">Založit novou prodejnu</span></a>
		</div>
	</h1>

{/if}

{if $dbProdejna || $par_3 == "zalozit"}
	<form action="" method="post" enctype="multipart/form-data">
		<div class="uzivatel_detail">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<th>Označení</th><td><input class="uzivatel_input" type="text" name="oznaceni" value="{$dbProdejna->oznaceni}" /></td>
				</tr>
				<tr>
					<th>Prodejna</th><td><input class="uzivatel_input" type="text" name="prodejna" value="{$dbProdejna->prodejna}" /></td>
				</tr>
				<tr>
					<th>Adresa</th><td><input class="uzivatel_input" type="text" name="adresa" value="{$dbProdejna->adresa}" /></td>
				</tr>
				<tr>
					<th>Město</th><td><input class="uzivatel_input" type="text" name="mesto" value="{$dbProdejna->mesto}" /></td>
				</tr>
				<tr>
					<th>Vedoucí</th><td><input class="uzivatel_input" type="text" name="vedouci" value="{$dbProdejna->vedouci}" /></td>
				</tr>
				<tr>
					<th>Telefon</th><td><input class="uzivatel_input" type="text" name="telefon" value="{$dbProdejna->telefon}" /></td>
				</tr>
				<tr>
					<th>Mobil</th><td><input class="uzivatel_input" type="text" name="mobil" value="{$dbProdejna->mobil}" /></td>
				</tr>
				<tr>
					<th>IČO</th><td><input class="uzivatel_input" type="text" name="ico" value="{$dbProdejna->ico}" /></td>
				</tr>
				<tr>
					<th>SKL</th><td><input class="uzivatel_input" type="text" name="skl" value="{$dbProdejna->skl}" /></td>
				</tr>
				<tr>
					<th>Skupina</th><td><input class="uzivatel_input" type="text" name="skupina" value="{$dbProdejna->skupina}" /></td>
				</tr>
				<tr>
					<th>Aktivní</th><td>{html_checkboxes name="visible" options=$s_yes_no selected=$dbProdejna->visible title="Aktivován"}</td>
				</tr>
			</table>
		</div>

		<div class="submit_box">
			<input type="hidden" name="id_prodejna" value="{$dbProdejna->id}"/>
			<input type="submit" name="doProdejna" value="{$dbProdejna->id|if:'Upravit prodejnu':'Založit prodejnu'}" class="ulozit_upravy_tlac pozice_uprostred"/>
		</div>

	</form>
{else}
	{if $dbProdejny}
		<div class="uzivatele_table">
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<th>označení</th>
					<th>prodejna</th>
					<th>adresa</th>
					<th>město</th>
					<th>vedoucí</th>
					<th>telefon</th>
					<th>mobil</th>
					<th>ico</th>
					<th>skl</th>
					<th>skupina</th>
					<th>aktivován</th>
					<th></th>
					<th></th>
				</tr>
				{foreach from=$dbProdejny item=dbProdejnaTmp}
					<tr class="table_tr" style="background-color:{cycle values="#EFEFEF,#fff"};">
						<td>{$dbProdejnaTmp->oznaceni}</td>
						<td>{$dbProdejnaTmp->prodejna}</td>
						<td>{$dbProdejnaTmp->adresa}</td>
						<td>{$dbProdejnaTmp->mesto}</td>
						<td>{$dbProdejnaTmp->vedouci}</td>
						<td>{$dbProdejnaTmp->telefon}</td>
						<td>{$dbProdejnaTmp->mobil}</td>
						<td>{$dbProdejnaTmp->ico}</td>
						<td>{$dbProdejnaTmp->skl}</td>
						<td>{$dbProdejnaTmp->skupina}</td>
						<td>{$dbProdejnaTmp->visible|if:'ano':'ne'}</td>
						<td>
							<a href="/admin/prodejny/id_prodejna/{$dbProdejnaTmp->id}/" class="btn_edit_user" title="detail prodejny">detail</a>
						</td>
						<td>
							<a href="/admin/prodejny/id_prodejna_to_delete/{$dbProdejnaTmp->id}/" class="btn_delete_user" onclick="return confirm('Smazat {$dbProdejnaTmp->prodejna} ?')"  title="smazat prodejnu">smazat</a>
						</td>
					</tr>
				{/foreach}
			</table>
		</div>
	{/if}
{/if}
<div class="clear"></div>
