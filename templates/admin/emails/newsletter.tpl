<table width="700" style="font-size: 13px; font-family: 'Arial';" border="0" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td style="background-color: #038A4B" width="70%">
			<img src="/images/logonewsletter.png" alt="" width="195"/>
		</td>
		<td style="background-color: #038A4B; text-align: center;">
			<a href="{Registry::getDomain()}" style="color: white;">{Registry::getDomainName()}</a><br />
			<a href="mailto:forum@forumjihlava.cz" style="color: white;" class="text-red">info@jap.cz</a><br><br />
			<a href="https://www.facebook.com" target="_blank"><img src="/images/facebook.png" alt="FACEBOOK"></a><br />
		</td>
	</tr>
</table>
<table width="700" style="font-size: 13px; font-family: 'Arial';" border="0">
	{foreach from=dbContentCategory::getZajimavosti() item=dbCC}
		<tr>
			<td colspan="3"><hr /></td>
		</tr>
		<tr>
			<td colspan="3"><h2 style="color: #038A4B; font-size: 16px;  font-family: Arial;">{$dbCC->name}</h2></td>
		</tr>
		<tr>
			<td>
				{*				<img src="{dbContentCategory::IMAGES_PATH}{$dbCC->id}/P-{$dbCC->image_1}" width="208" height="115" style=" margin-right:10px; float:left;" />*}
				<img src="{dbContentCategory::IMAGES_PATH}{$dbCC->id}/T-{$dbCC->image_1}" width="150" style=" margin-right:10px; float:left;" />
			</td>
			<td>&nbsp;</td>
			<td valign="top" style="font-style: italic; font-family: Arial;">
				{$dbCC->getContent()->text_1} 
					<br/>
					<a href="{$dbCC->getUrl(true)}" style="margin-top:2px; float:right; color:#038A4B; font-size:11px; text-decoration: none; margin-right:20px;" >VÍCE...</a> 
			</td>
		</tr>
	{/foreach}
	<tr>
		<td colspan="3"><hr /></td>
	</tr>
	<tr>
		<td style="background-color: #038A4B; text-align: center;" colspan="3"><br />
			<a href="{Registry::getDomain()}/emailing" style="color: white;">Přihlásit se k odběru</a><br />
			<br />
			<a href="{Registry::getDomain()}/odhlasit/#email#" style="color: white;">Odhlásit se z odběru</a><br /><br />
		</td>

		{*			<img src="/images/logo_bottom.jpg" alt="" />*}
		</td>
	</tr>
</table>
