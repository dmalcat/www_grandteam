<h1 class="clanek_title">NEWSLETTER</h1>
<form action="" method="post">
	<div class="clanek_levy_sloupec">
		<span class="label">Předmět *</span>
		<div class="nazev_hd"></div>
		<div class="nazev_bg">
			<input type="text" name="predmet" value="{$vybranyLetak->predmet|default:"Zpravodaj"}" class="validate[required]" id="nazev"/>
		</div>
		<div class="nazev_ft"></div>
		<span class="label">Extra maily oddělujte středníkem (;)</span>
		<div class="text_2_hd"></div>
		<div class="text_2_bg">
			<textarea name="extraMaily">{$vybranyLetak->extraMaily}</textarea>
		</div>
		<div class="cb"></div>
		<div class="text_2_ft"></div>

	</div>
	<div class="clanek_pravy_sloupec">
		<table class="zarazeni_table" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td nowrap="nowrap">ROZESLAT KOMU</td>
				<td style="padding-left:35px;">
					<select name="rozeslatKomu">
						<option value="extra" {if $vybranyLetak->rozeslatKomu == 'extra'} selected='selected' {/if}>Pouze extra</option>
						<option value="vsem" {if $vybranyLetak->rozeslatKomu == 'vsem'} selected='selected' {/if}>Všem (+ extra)</option>
{*						<option value="registrovanym" {if $vybranyLetak->rozeslatKomu == 'registrovanym'} selected='selected' {/if}>Registrovaným (+ extra)</option>*}
					</select>
				</td>
			</tr>
		</table>
	</div>
	<div class="cb"></div>
	<h1 class="clanek_title">Náhled</h1>
	<div class="cb"></div>
	<div id="newsletterPreview" style="width: 700px; margin-left: auto; margin-right: auto; border: solid 1px gray; margin-top: 10px;">
		{include file="admin/emails/newsletter.tpl"}
	</div>






	<div class="submit_box">
		{if $pContentCategory}
			<input type="submit" value="Uložit newsletter" name="do_clanek" class="ulozit_upravy_tlac" />
			<input type="submit" value="Smazat newsletter" class="smazat_tlac contentCategoryDelete"/>
		{else}
			<input type="submit" value="Odeslat newsletter" name="doSend" class="ulozit_upravy_tlac " style="float: left;" />
			<input type="submit" value="Odeslat test newsletter" name="doSendTest" class="ulozit_upravy_tlac "  style="float: right;"/>
		{/if}

	</div>

</form>

