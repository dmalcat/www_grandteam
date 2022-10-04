<div class="content_bg">

    <div class="content">
        <h1 class="content_title">Kalendář akcí</h1>

        <div class="content_drobisky">
            <a href="/" title="">Hlavní menu</a> <span>-</span>
				<a href="/turista_a_volny_cas" title="Turista a volný čas">Turista a volný čas</a> <span>-</span>
				<a href="/turista_a_volny_cas/akce" title="Akce">Akce</a> <span>-</span>
				<a href="/kalendar" title="Kalendář akcí">Kalendář akcí</a>
        </div>

        <div class="content_text_aktuality">
	<br style="clear: both;"/>

		<table border="0">
			{foreach from=dbCalendar::getActual() item=aktuality}
					<tr class="{cycle values="odd,even"}">
						<td>
							{if $datumTmp != $aktuality->from}
								{$aktuality->from|date_format:"%d.%m.%Y"}
							{/if}
						</td>
						<td>
							<a href="{$aktuality->getUrl()}" title="{$aktuality->name}" class="aktuality_tlac">{$aktuality->name} ({$aktuality->type}) </a>
							{if $aktuality->from != $aktuality->to}(do {$aktuality->to|date_format:"%d.%m.%Y"}){/if}
						</td>
<!-- 						<td> -->
							
<!-- 						</td> -->
					</tr>
					{assign var=datumTmp value=$aktuality->from}
			{/foreach}
		</table>



        </div>


    </div>

    {include file="boxes/nejnovejsi_z_kategorie.tpl"}

</div>

{include file="boxes/zajimavosti.tpl"}

