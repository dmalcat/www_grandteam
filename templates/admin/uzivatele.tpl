{if $dbUserEdit}
	<h1 class="clanek_title">
		EDITACE UŽIVATELE => LOGIN: {$dbUserEdit->login} &nbsp;&nbsp;HESLO: {$dbUserEdit->pass_plain}</h1>
{else}<h1 class="clanek_title">SEZNAM UŽIVATELŮ</h1>{/if}

{if $p_user}
	<form action="" method="post" enctype="multipart/form-data">
		<div class="uzivatel_detail">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				{foreach from=$p_user.STEPS item=step}
					<tr align="left" class="deep_blue">
						<th colspan="2"><h2>{$step.DESCRIPTION}</h2></th>
					</tr>
					{foreach from=$step.CATEGORIES item=category}
						<!--
			  <tr align="left">
							<th colspan="2">&nbsp; => {$category.NAME} (kategorie vlastností)</th>
						</tr>
						-->
						{foreach from=$category.PROPERTIES item=property}
							{assign var=prop_name value=$property.PROP_NAME}
							<tr class="{cycle values=","}">
								<td>{$property.PROP_NAME|translate} {if $property.PROP_UNIT}({$property.PROP_UNIT}){/if}</td>
								<td>
									{if $property.PROP_TYPE == "STRING"}<input type="text" name="name[{$prop_name}]" value="{$property.PROP_VALUE}"  class="uzivatel_input"/>{/if}
								{if $property.PROP_TYPE == "TEXTAREA"}{fckeditor BasePath="/fckeditor/" InstanceName="name[$prop_name]" Value=$property.PROP_VALUE Width="400px" Height="100px" ToolbarSet="Basic"}{/if}
								{if $property.PROP_TYPE == "S_CHECKBOX"}
									<input type="hidden" name="name[{$prop_name}]" value=""/>
									{html_checkboxes name="name[$prop_name]" options=$property.PROP_ENUMERATION|@array_compact selected=$property.PROP_VALUE|@enum_values}
								{/if}
							{if $property.PROP_TYPE == "E_SELECT"}{html_options name="name[$prop_name]" options=$property.PROP_ENUMERATION|@array_compact selected=$property.PROP_VALUE|@enum_values}{/if}
						{if $property.PROP_TYPE == "E_RADIO"}{html_radios name="name[$prop_name]" options=$property.PROP_ENUMERATION|@array_compact selected=$property.PROP_VALUE|@enum_values}{/if}
						{if $property.PROP_TYPE == "FILE"}<input type="file" name="name[{$prop_name}]" value="{$property.PROP_VALUE}"/>{/if}
						{if $property.PROP_TYPE == "IMAGE"}<input type="file" name="name[{$prop_name}]" value="{$property.PROP_VALUE}"/><img src="{$property.PROP_VALUE.email_url}"/>{/if}
					</td>
				</tr>
			{/foreach}
		{/foreach}
	{/foreach}
	<tr style="display: none">
		<td>ceník</td>
		<td>{html_options name="id_price_list" options=$s_price_lists selected=$p_user.INFO->id_price_list}</td>
	</tr>
	<tr>
		<td>role</td>
		<td>{html_options options=dbRole::getAll()|select:'id':'name' name='idRole' selected=$p_user.INFO->id_role}</td>
	</tr>
	<tr>
		<td>Heslo</td>
		<td><input type="text" name="password" class="uzivatel_input" /> ( pokud není vyplňeno, zůstane stávající )</td>
	</tr>
	<tr>
		<td>Zasílání e-zpravodaje</td>
		<td>
			<input type="hidden" name="mlist" value="" />
			{html_checkboxes name="mlist" options=$s_yes_no selected=$dbUserEdit->mlist title="Zasílání e-zpravodaje"}
		</td>
	</tr>
	<tr>
		<td>Aktivován</td>
		<td>
			<input type="hidden" name="enabled" value="" />
			{html_checkboxes name="enabled" options=$s_yes_no selected=$dbUserEdit->enabled title="Aktivován"}
		</td>
	</tr>
</table>
</div>

<div class="submit_box">
	<input type="hidden" name="prop_name" value="{$property.PROP_NAME}"/>
	<input type="submit" name="user_property_edit" value="Upravit uživatele" class="ulozit_upravy_tlac pozice_uprostred"/>
</div>

</form>
{/if}

<div class="uzivatele_zaznamy">
	<span style="float:left;">Počet nalezených záznamů: <strong>{$pager->pocet}</strong></span>
	<span style="float:right;">strana: {$pager->strana}/{$pager->pocetStran}</span>
	<div class="cb"></div>
	{if $pager->dalsi}
		<a href="/admin/uzivatele/{$pager->dalsi}/">další strana >></a>
	{/if}
	{if $pager->predchozi}
		<a href="/admin/uzivatele/{$pager->predchozi}/"><< předchozí strana</a>
	{/if}
</div>
{if $p_users}
	<div class="uzivatele_table">
		<table border="0" width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<th title="login">login</th>
				<th>heslo</th>
					{foreach from=$p_user_list_properties item=property}
					<th title="{$property.PROP_NAME}">{$property.PROP_NAME|translate}</td>
					{/foreach}
				<th>role</th>
				<th>aktivován</th>
				<th></th>
				<th></th>
			</tr>
			{foreach from=$p_users item=user}
				{assign var=dbUser value=dbUser::getById($user.INFO->id_user)}
				<tr class="table_tr" style="background-color:{cycle values="#EFEFEF,#fff"};">
					<td><strong>{$user.INFO->login}</strong></td>
					<td>{$dbUser->pass_plain}</td>
					{foreach from=$user.STEPS item=step}
						{foreach from=$step.CATEGORIES item=category}
							{foreach from=$category.PROPERTIES item=property}
								<td>{$property.PROP_VALUE}</td>
							{/foreach}
						{/foreach}
					{/foreach}
					<td>{dbRole::getById($user.INFO->id_role)->name}</td>
					<td><input type="checkbox" name="activate" class="user_activate" rel="{$dbUser->id}" {if $dbUser->enabled}checked="checked"{/if}/></td>
					<td>
						<a href="/admin/uzivatele/id_user/{$user.INFO->id_user}/" class="btn_edit_user" title="detail uživatele">detail</a>
					</td>
					<td>
						<a href="/admin/uzivatele/id_user_to_delete/{$user.INFO->id_user}/" class="btn_delete_user" onclick="return confirm('Smazat {$user.INFO->login} ?')"  title="smazat uživatele">smazat</a>
					</td>
				</tr>
			{/foreach}
		</table>
	</div>
{/if}
<div class="clear"></div>
