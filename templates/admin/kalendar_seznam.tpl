{foreach from=dbCalendar::getAll(null) item=dbCalendar}
    <div class="seznam_bg" id="calendarList_{$dbCalendar->id}">
        <div class="seznam_kalen_nazev" style="font-size: 14px;">
            <a href="/admin/kalendar/{$dbCalendar->id}" title="Upravit událost">{$dbCalendar->name}</a>
        </div>
        <div class="seznam_kalen_misto">
		{$dbCalendar->type}
        </div>
	<div class="seznam_kalen_misto">
		{$dbCalendar->place}
        </div>
        <div class="seznam_kalen_zobrazit">
            <input type="checkbox" name="visible" onclick="setCalendarVisibility(this, {$dbCalendar->id})" {if $dbCalendar->visible}checked="checked"{/if}/>
        </div>
        <div class="seznam_kalen_datum">{$dbCalendar->from|default:$smarty.now|date_format:"%d.%m.%Y"}</div>
        <div class="seznam_kalen_datum">{$dbCalendar->to|default:$smarty.now|date_format:"%d.%m.%Y"}</div>
        <div class="seznam_kalen_upravit">
            <a href="/admin/kalendar/{$dbCalendar->id}" title="Upravit událost"></a>
        </div>

        <div class="seznam_kalen_smazat">
            <a href="javascript: void(0)" title="Smazat událost" class="calendarDelete" rel="{$dbCalendar->id}"></a>
        </div>
    </div>
{/foreach}
<script type="text/javascript" src="/js/admin/calendar.js"></script>