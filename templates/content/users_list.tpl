<table border="0" width="90%" class="content_text2" style="text-align: left">
	<tr><td colspan="4"><h2>Kontakty</h2></td></tr>
	<tr>
		<th></th>
		<th>jméno a příjmení</th>
<!--		<th>email</th>-->
		<th>telefon</th>
		<th>certifikát</th>
		<th>odbor</th>
	</tr>
	{*
	{foreach from=dbUser::getOdbory() item=odbor}
		{assign var=pUsers value=dbUser::getByOdborId($odbor->id_enumeration)}
		{if $pUsers|@count}
			<tr><th colspan="4"><h2 style="color: #9A1935;">{$odbor->value}</h2></th></tr>
			{foreach from=$pUsers item=user}
				<tr class="{cycle values="odd,even"}">
					<td>{$user->getPropertyValue('titul')} {$user->getPropertyValue('jmeno')} {$user->getPropertyValue('prijmeni')} {if $user->getPropertyValue('funkce') == "vedoucí"}({$user->getPropertyValue('funkce')}){/if}</td>
					<td>{if $user->getPropertyValue('email')}<a href="mailto:{$user->getPropertyValue('email')}">{$user->getPropertyValue('email')}</a>{/if}</td>
					<td>{$user->getPropertyValue('telefon')}</td>
					<td>{if $user->getCertifikat()}<a href="{$user->getCertifikat()}" target="_blank">osobní certifikát</a>{/if}</td>
				</tr>
			{/foreach}
		{/if}
	{/foreach}
	*}

	{foreach from=dbUser::getZamestnanci() item=user}
		<tr class="{cycle values="odd,even"}">
			<td>
				{if $user->getPropertyValue('id_dochazka')}
					{if $user->checkDochazka()}
						<img src="/images/proved.gif" alt="přítomen" title="přítomen"/>
					{else}
						<img src="/images/disproved.gif" alt="nepřítomen" title="nepřítomen"/>
					{/if}
				{/if}
			</td>
			<td>
				{if $user->getPropertyValue('email')}
					<a href="mailto:{$user->getPropertyValue('email')}">
						{$user->getPropertyValue('prijmeni')} {$user->getPropertyValue('jmeno')} {$user->getPropertyValue('titul')} </a>
						{if $user->getPropertyValue('funkce') == "vedoucí"}({$user->getPropertyValue('funkce')}){/if}


				{else}
					{$user->getPropertyValue('prijmeni')} {$user->getPropertyValue('jmeno')} {$user->getPropertyValue('titul')}  {if $user->getPropertyValue('funkce') == "vedoucí"}({$user->getPropertyValue('funkce')}){/if}
				{/if}
			</td>
			<td>{$user->getPropertyValue('telefon')}</td>
			<td>{if $user->getCertifikat()}<a href="{$user->getCertifikat()}" target="_blank">certifikát</a>{/if}</td>
			<td>{$user->getPropertyValue('odbor')}</td>
		</tr>
	{/foreach}

</table>

