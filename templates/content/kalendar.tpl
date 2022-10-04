<div class="content_bg">

    <div class="content">
        <h1 class="content_title">{'Kalendář akcí'|translate}</h1>

        <div class="content_drobisky">
            <a href="/" title="">Hlavní menu</a> <span>-</span>
				<a href="/turista_a_volny_cas" title="Turista a volný čas">Turista a volný čas</a> <span>-</span>
				<a href="/turista_a_volny_cas/akce" title="Akce">Akce</a> <span>-</span>
				<a href="/kalendar" title="Kalendář akcí">Kalendář akcí</a> <span>-</span>
				<a href="/kalendar/{$dbCalendar->id}" title="Městský úřad">{$dbCalendar->name}</a>
        </div>


        <div class="content_text_aktuality">

	<div class="clanek_levy_sloupec">

		{$dbCalendar->from|date_format:'%d.%m.%Y'} - {$dbCalendar->to|date_format:'%d.%m.%Y'}<br/>
        <h2>{$dbCalendar->name}</h2>
		Typ akce: {$dbCalendar->type}<br/>

			{if 'mo'|in_array:$dbCalendar->weekDays && 'tu'|in_array:$dbCalendar->weekDays && 'we'|in_array:$dbCalendar->weekDays && 'th'|in_array:$dbCalendar->weekDays && 'fr'|in_array:$dbCalendar->weekDays && 'sa'|in_array:$dbCalendar->weekDays && 'su'|in_array:$dbCalendar->weekDays}
			{else}
				<strong>Akce probíhá ve dnech:</strong><br/>
				{if 'mo'|in_array:$dbCalendar->weekDays}Pondělí{/if}
				{if 'tu'|in_array:$dbCalendar->weekDays}Úterý{/if}
				{if 'we'|in_array:$dbCalendar->weekDays}Středa{/if}
				{if 'th'|in_array:$dbCalendar->weekDays}Čtvrtek{/if}
				{if 'fr'|in_array:$dbCalendar->weekDays}Pátek{/if}
				{if 'sa'|in_array:$dbCalendar->weekDays}Sobota{/if}
				{if 'su'|in_array:$dbCalendar->weekDays}Neděle{/if}
			{/if}


<!-- 		GPS: {$dbCalendar->gps_lat} {$dbCalendar->gps_lng} -->
		<br/><br/>





<!-- 			<a href="{$dbCalendar->image}" rel="shadowbox[trip]"> -->
			{if $dbCalendar->image_1}
				<img src="{if $dbCalendar->image}{$dbCalendar->image}{else}/images/admin/obr.png{/if}" alt="{$dbCalendar->name}" align="right" style="padding-left: 5px;"/>
			{/if}
<!-- 			</a> -->
<!-- 			<br/><br/> -->
        {$dbCalendar->description}<br/>

<!-- 		<div style="clear: both"></div><br/> -->


	<br/>
        <strong>Organizátor akce</strong><br/>
        {if $dbCalendar->organizer_name}{$dbCalendar->organizer_name}<br/>{/if}
        {if $dbCalendar->organizer_person}{$dbCalendar->organizer_person}<br/>{/if}
        {if $dbCalendar->organizer_phone}{$dbCalendar->organizer_phone}<br/>{/if}
		{if $dbCalendar->organizer_address}{$dbCalendar->organizer_address}<br/>{/if}
		{if $dbCalendar->organizer_email}<a href="mailto:{$dbCalendar->organizer_email}">{$dbCalendar->organizer_email}</a><br/>{/if}
		{if $dbCalendar->organizer_url}<a href="{$dbCalendar->organizer_url}" target="_blank">{$dbCalendar->organizer_url}</a><br/>{/if}<br/><br/>

		<div style="clear: both"></div>
		<strong>Místo konání: </strong>{$dbCalendar->place}<br/><br/>
		{include file="content/kalendar_mapa.tpl"}
		<div style="clear: both"></div><br/>



		</div>
		</div>
		</div>

    {include file="boxes/nejnovejsi_z_kategorie.tpl"}

</div>

{include file="boxes/zajimavosti.tpl"}