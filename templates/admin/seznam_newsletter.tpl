{foreach from=$odeslaneLetaky item=item}
    <div class="seznam_bg">
        <div class="seznam_newsletter_nazev">
            <a href="/admin/newsletter/{$item->id}">{$item->subject}</a>
        </div>
        <div class="seznam_newsletter_upravit">
            <a href="/admin/newsletter/{$item->id}" title="Upravit newsletter"></a>
        </div>

        <div class="seznam_newsletter_smazat">
            <a href="javascript: void(0)" title="Smazat newsletter" class="galleryDelete"></a>
        </div>
        <div class="seznam_newsletter_datum">{$item->created|date_format:'%d.%m.%Y %H:%M'}</div>
    </div>
{/foreach}

