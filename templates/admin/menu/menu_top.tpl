<ul id="top_menu_1">
	{if $dbUser->isAllowed("SPRAVA OBSAHU")}<li class="obsah"><a href="/admin/seznam_clanku" {if $menuSelected == "obsah"}class="top_menu_1_selected"{/if}>Články</a></li>{/if}
	{if $dbEshop->getEnabledCalendar()}<li class="vnitrni_komunikace"><a href="/admin/kalendar_seznam" {if $menuSelected == "kalendar"}class="top_menu_1_selected"{/if}>Kalendář</a></li>{/if}
{*	{if $dbUser->isAllowed("SPRAVA OBSAHU")}<li class="newsletter"><a href="/admin/seznam_newsletter" {if $menuSelected == "newsletter"}class="top_menu_1_selected"{/if}>Newsletter</a></li>{/if}*}
	{*if $dbUser->isAllowed("SPRAVA OBSAHU")}<li class="newsletter"><a href="/admin/emails" {if $menuSelected == "emails"}class="top_menu_1_selected"{/if}>Seznam emailů</a></li>{/if*}
{*	{if $dbUser->isAllowed("SPRAVA OBSAHU")}<li class="newsletter"><a href="/admin/soutez" {if $menuSelected == "soutez"}class="top_menu_1_selected"{/if}>Soutěže</a></li>{/if}*}
{*	{if $dbUser->isAllowed("SPRAVA OBSAHU")}<li class="newsletter"><a href="/admin/prodejny" {if $menuSelected == "prodejny"}class="top_menu_1_selected"{/if}>Prodejny</a></li>{/if}*}
 	{if $dbEshop->getEnabledEshop()}<li class="eshop"><a href="/admin/produkty" {if $menuSelected == "eshop"}class="top_menu_1_selected"{/if}>Eshop</a></li>{/if}
 	{if $dbEshop->getEnabledEshop()}<li class="objednavky"><a href="/admin/objednavky" {if $menuSelected == "objednavky"}class="top_menu_1_selected"{/if}>Objednávky</a></li>{/if}
{*	{if $dbEshop->getEnabledUsers()}<li class="uzivatele"><a href="/admin/uzivatele" {if $menuSelected == "uzivatele"}class="top_menu_1_selected"{/if}>Uživatelé</a></li>{/if}*}
{*	<li class="nastaveni"><a href="/admin/meny" {if $menuSelected == "nastaveni"}class="top_menu_1_selected"{/if}>Nastavení</a></li>*}
	<li class="odhlasit"><a href="/admin/logout/">Odhlásit</a></li>
</ul>
<ul id="top_menu_2">
	{if $menuSelected == "obsah"}
		<li class="clanky"><a href="/admin/seznam_clanku" {if $par_2 == "seznam_clanku"}class="top_menu_2_selected"{/if}>Seznam článku</a></li>
		<li class="novy_clanek"><a href="/admin/clanek" {if $par_2 == "clanek"}class="top_menu_2_selected"{/if}>Vytvořit článek</a></li>
		<li class="novy_clanek"><a href="/admin/menu" {if $par_2 == "menu"}class="top_menu_2_selected"{/if}>Vytvořit položku</a></li>
		<li class="galerie"><a href="/admin/seznam_fotogalerii" {if $par_2 == "seznam_fotogalerii"}class="top_menu_2_selected"{/if}>Seznam fotogalerií</a></li>
		<li class="nova_galerie"><a href="/admin/fotogalerie" {if $par_2 == "fotogalerie"}class="top_menu_2_selected"{/if}>Vytvořit fotogalerii</a></li>
		<li class="dokumenty"><a href="/admin/seznam_dokumentu" {if $par_2 == "seznam_dokumentu"}class="top_menu_2_selected"{/if}>Seznam dokumentů</a></li>
		<li class="nove_dokumenty"><a href="/admin/dokumenty" {if $par_2 == "dokumenty"}class="top_menu_2_selected"{/if}>Vytvořit dokumenty</a></li>
{*		<li class="dokumenty"><a href="/admin/seznam_videa" {if $par_2 == "seznam_videa"}class="top_menu_2_selected"{/if}>Seznam videí</a></li>*}
{*		<li class="nove_dokumenty"><a href="/admin/videa" {if $par_2 == "videa"}class="top_menu_2_selected"{/if}>Vytvořit videa</a></li>*}
	{elseif $menuSelected == "uzivatele"}
		<li class="seznam_uzivatelu"><a href="/admin/uzivatele" {if $par_2 == "uzivatele"}class="top_menu_2_selected"{/if}>Seznam uživatelů</a></li>
		<li class="novy_uzivatel"><a href="/admin/novy_uzivatel" {if $par_2 == "novy_uzivatel"}class="top_menu_2_selected"{/if}>Nový uživatel</a></li>
		<li class="seznam_uzivatelu"><a href="/admin/uzivatele_log" {if $par_2 == "uzivatele_log"}class="top_menu_2_selected"{/if}>Statistika příhlášení</a></li>
		        <li class="role"><a href="/admin/users_export" target="_blank">Export uživatelů</a></li>

{*		{if $dbEshop->getEnabledPermissions() || $dbUser->isAdmin()}<li class="opravneni"><a href="/admin/opravneni" {if $par_2 == "opravneni"}class="top_menu_2_selected"{/if}>Oprávnění</a></li>{/if}*}
		{if $dbUser->isAdmin()}<li class="role"><a href="/admin/role" {if $par_2 == "role"}class="top_menu_2_selected"{/if}>Uživatelské role</a></li>{/if}
		<li class="seznam_uzivatelu"><a href="/admin/dotazy" {if $par_2 == "dotazy"}class="top_menu_2_selected"{/if}>Uživatelské dotazy</a></li>
		<li class="seznam_uzivatelu"><a href="/admin/prodejny" {if $par_2 == "prodejny"}class="top_menu_2_selected"{/if}>Seznam prodejen</a></li>
		{if $dbEshop->getEnabledEshop()}<li class="role"><a href="/admin/role" {if $par_2 == "role"}class="top_menu_2_selected"{/if}>Nastavení slev</a></li>{/if}
    {elseif $menuSelected == "newsletter"}
		<li class="clanky"><a href="/admin/seznam_newsletter" {if $par_2 == "seznam_newsletter"}class="top_menu_2_selected"{/if}>Seznam newsletterů</a></li>
		<li class="dokumenty"><a href="/admin/newsletter" {if $par_2 == "newsletter"}class="top_menu_2_selected"{/if}>Nový newsletter</a></li>
    {elseif $menuSelected == "kalendar"}
		<li class="clanky"><a href="/admin/kalendar_seznam" {if $par_2 == "kalendar_seznam"}class="top_menu_2_selected"{/if}>Seznam událostí</a></li>
		<li class="novy_clanek"><a href="/admin/kalendar" {if $par_2 == "kalendar"}class="top_menu_2_selected"{/if}>Vytvořit událost</a></li>
	{elseif $menuSelected == "eshop"}
		<li class="clanky"><a href="/admin/kategorie_produktu" {if $par_2 == "kategorie_produktu"}class="top_menu_2_selected"{/if}>Kategorie produktů</a></li>
		<li class="dokumenty"><a href="/admin/produkty" {if $par_2 == "produkty"}class="top_menu_2_selected"{/if}>Produkty</a></li>
		<li class="sklad"><a href="/admin/sklad" {if $par_2 == "sklad"}class="top_menu_2_selected"{/if}>Sklad</a></li>
		<li class="novy_clanek"><a href="/admin/kupony" {if $par_2 == "kupony"}class="top_menu_2_selected"{/if}>Slevové kupóny</a></li>
	{elseif $menuSelected == "nastaveni"}
		{if $dbEshop->getEnabledEshop()}<li class="clanky"><a href="/admin/meny" {if $par_2 == "meny"}class="top_menu_2_selected"{/if}>Měny</a></li>{/if}
		{if $dbEshop->getEnabledEshop()}<li class="clanky"><a href="/admin/doprava" {if $par_2 == "doprava"}class="top_menu_2_selected"{/if}>Dopravy</a></li>{/if}
		{if $dbEshop->getEnabledEshop()}<li class="clanky"><a href="/admin/platba" {if $par_2 == "platba"}class="top_menu_2_selected"{/if}>Platby</a></li>{/if}
		{if $dbEshop->getEnabledEshop()}<li class="clanky"><a href="/admin/doprava_platba" {if $par_2 == "doprava_platba"}class="top_menu_2_selected"{/if}>Doprava => Platba</a></li>{/if}
		{if $dbEshop->getEnabledEshop()}<li class="clanky"><a href="/admin/dodavatele" {if $par_2 == "dodavatele"}class="top_menu_2_selected"{/if}>Dodavatelé</a></li>{/if}
		{if $dbEshop->getEnabledEshop()}<li class="clanky"><a href="/admin/ceniky" {if $par_2 == "ceniky"}class="top_menu_2_selected"{/if}>Ceníky</a></li>{/if}
		<li class="clanky"><a href="/admin/preklady" {if $par_2 == "preklady"}class="top_menu_2_selected"{/if}>Překlady</a></li>
		{if $dbEshop->getEnabledEshop()}<li class="clanky"><a href="/admin/vlastnosti" {if $par_2 == "vlastnosti"}class="top_menu_2_selected"{/if}>Vlastnosti</a></li>{/if}
	{/if}
</ul>