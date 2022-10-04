<div class="menu_clanky_popis">
	<!--TO DO opravit-->
	{if $menuSelected == "obsah"}
		{if $par_2 == 'seznam_clanku' && !$par_3}
			<div class="contentTypeSelect">
				{if !$filterZajimavosti or !$filterAktuality}
					<form action="" method="post">
						Vyberte typ obsahu:
						{html_options options=dbContentType::getAll()|select:'id':'name' name='idContentType' selected=$idContentType onchange="submit()"}
					</form>
				{/if}
			</div>
			<div class="contentTypeSelect">
				<form action="" method="post">
					Zobrazit:
					<select onchange="submit()" name="filterContentCategory">
						<option value="" {if !$filterContentCategory}selected="selected"{/if}>vše</option>
						<option value="filterAktuality" {if $filterContentCategory == 'filterAktuality'}selected="selected"{/if}>aktuality</option>
						<option value="filterZajimavosti" {if $filterContentCategory == 'filterZajimavosti'}selected="selected"{/if}>zajímavosti</option>
					</select>
				</form>
				{*<input type="hidden" name="filterZajimavosti" value=""/>
				<input type="checkbox" value="1" name="filterZajimavosti" {if $filterZajimavosti}checked="checked"{/if}/>
				</form> *}
			</div>
			{*<div class="contentTypeSelect">
			<form action="" method="post">
			Zobrazit pouze aktuality:
			<input type="hidden" name="filterAktuality" value=""/>
			<input type="checkbox" value="1" name="filterAktuality" {if $filterAktuality}checked="checked"{/if} onchange="submit()"/>
			</form>
			</div>   *}
		{/if}
		<div class="vyhledavani">
			<form method="post">
				{if $par_2 == "seznam_fotogalerii" || $par_2 == "fotogalerie" || $par_2 == "seznam_dokumentu" || $par_2 == "dokumenty" || $par_2 == "editace_fotogalerie"}
					<input type="text" id="hledatFulltextGallery" value="" class="vyhledavani_input" />
				{else}
					<input type="text" id="hledatFulltext" value="" class="vyhledavani_input" />
				{/if}
				<input type="button" value=" " id="vyhledatProdukty" class="vyhledavani_submit" />
			</form>
		</div>
		<div class="vyhledavani_popis">Vyhledávání:</div>
		<div class="cb"></div>
		{if $par_2=="seznam_clanku"}
				<div class="popis1">+/-</div>
				<div class="popis2">Název</div>
				<div class="popis3">Pořadí</div>
				<div class="popis4">Typ</div>
				<div class="popis5">Zobrazit</div>
				<div class="popis6">Zobrazit na HP</div>
				<div class="popis11">Aktuality</div>
				<div class="popis7">Newsletter</div>
				<div class="popis10">Přidat článek</div>
				<div class="popis8">Smazat</div>
				<div class="popis9">Datum</div>
		{elseif $par_2=="seznam_dokumentu" || $par_2=="seznam_fotogalerii"}
			<div class="seznam_popis1">Název</div>
			<div class="seznam_popis2">Zobrazit</div>
			<div class="seznam_popis3">Editace obsahu</div>
			<div class="seznam_popis4">Upravit</div>
			<div class="seznam_popis5">Smazat</div>
			<div class="seznam_popis6">Datum</div>
		{/if}
	{/if}
	{if $menuSelected == "uzivatele"}
		{if $par_2=="prodejny"}
{*			<a href="/admin/prodejny/zalozit" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button"><span class="ui-button-text">Založit novou prodejnu</span></a>*}
		{/if}
		{if $par_2 == 'uzivatele'}
			<form action="/admin/uzivatele/" method="post">
				<div class="vyhledavani">
					<input type="text" name="find_what" value="{$smarty.post.find_what}" class="vyhledavani_input"  id="hledatFulltextUser"/>
					<input type="hidden" name="user_search" value="true"/>
					<input type="submit" name="user_do_search" value=" " class="vyhledavani_submit"/>
				</div>
				<div class="vyhledavani_popis">hledat:</div>
				<div class="vyhledavani_uzivatele">
					{html_options name="find_where" options=$s_user_list_properties selected=$smarty.post.find_where}
				</div>
				<div class="vyhledavani_popis">hledání podle:</div>
				<div class="vyhledavani_uzivatele">
					{html_options2 options=dbRole::getAll()|select:'id':'name' name='idRole' selected=$smarty.post.idRole onchange="submit()" emptyLabel="---vyberte---"}
				</div>
				<div class="vyhledavani_popis">Vybrat podle role:</div>
				<div class="cb"></div>
			</form>
		{/if}
		{if $par_2 == 'opravneni'}
			<div class="vyhledavani_uzivatele">
				<select id="vyberRoli">
					<option value="/admin/opravneni/">Vyberte roli</option>
					{foreach from=$vsechnyRole item=role}
						<option	{if $role->id eq $roleId} selected="selected" {/if} value="/admin/opravneni/{$role->id}">{$role->name}</option>
					{/foreach}
				</select>
			</div>
			<div class="vyhledavani_popis">Vyberte roli uživatele:</div>
			<div class="cb"></div>
		{/if}
	{/if}
	{if $menuSelected == "kalendar"}
		{if $par_2=="kalendar_seznam"}
			<div class="seznam_kal_popis1">Název</div>
			<div class="seznam_kal_popis2">Typ akce</div>
			<div class="seznam_kal_popis2">Místo</div>
			<div class="seznam_kal_popis3">Zobrazit</div>
			<div class="seznam_kal_popis4">Datum od</div>
			<div class="seznam_kal_popis4">Datum do</div>
			<div class="seznam_kal_popis5">Upravit</div>
			<div class="seznam_kal_popis6">Smazat</div>
		{/if}
	{/if}
	{if $menuSelected == "newsletter"}
		{if $par_2=="seznam_newsletter"}
			<div class="seznam_newsletter_popis1">Název</div>
			<div class="seznam_newsletter_popis2">Upravit</div>
			<div class="seznam_newsletter_popis3">Smazat</div>
			<div class="seznam_newsletter_popis4">Datum </div>
		{/if}
	{/if}
	{if $menuSelected == "eshop"}
		{if $par_2=="produkty"}
			<form action="" method="post" style="float: left;">
				<table border="0" cellpadding="0" cellspacing="0" class="vlozit_produkt_table">
					<tr>
						<th>Zobr</th>
						<th>Název</th>
						<th></th>
					</tr>
					<tr>
						<td>{html_checkboxes name="item_visible" options=$s_yes_no title="zobrazit/skryt"}</td>
						<td><input type="text" name="name" class="produkt_input_delsi"/></td>
						<td>
							<input type="submit" name="item_insert" value="Vložit" class="sklad_filtr"/>
						</td>
					</tr>
				</table>
				<div class="vyhledavani_popis" style="margin-top:5px;">Vložit produkt: &nbsp;&nbsp;&nbsp;</div>
				<div class="cb"></div>
			</form>
			<div style="float: right">
				Vyhledavání: <input type="text" id="hledatFulltextAdmin" value="" class="produkt_input_delsi"/><input type="button" value="Hledat" id="vyhledatProdukty" class="sklad_filtr">
			</div>
		{/if}
		{if $par_2=="sklad"}
			<form action="" method="post">
				<div class="vyhledavani_popis"><input type="submit" value="zobrazit" class="sklad_filtr" /></div>
				<div class="vyhledavani_uzivatele">
					{html_options name="id_category" options=dbCategory::getAll(dbCategory::TYPE_CATEGORY)|select:'id':'name' selected=$smarty.post.id_category onchange="submit()"}

				</div>

				<div class="vyhledavani_popis">Vyberte kategorii nebo produkt:</div>
				<div class="cb"></div>
			</form>
		{/if}
	{/if}
</div>
<div class="cb"></div>

<div id="errorBox">
	<div id="errorBox_text"></div>
	<a href="javascript:void(0);" title="Zavřít" onclick="$('#errorBox').fadeOut(400);" class="tlacitko_zavrit"></a>
</div>
<div id="successBox">
	<div id="successBox_text"></div>
	<a href="javascript:void(0);" title="Zavřít" onclick="$('#successBox').fadeOut(400);" class="tlacitko_zavrit"></a>
</div>