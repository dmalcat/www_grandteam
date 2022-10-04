<h1 class="clanek_title">{if $dbCalendar}UPRAVIT UDÁLOST {$dbCalendar->name}  : náhled <a href="/kalendar/{$dbCalendar->id}" target="_blank">zde</a> &nbsp;&nbsp;&nbsp;[odkaz: {$dbCalendar->getUrl()}]{else}VYTVOŘIT UDÁLOST{/if}</h1>
<form method="post" id="new_event" enctype="multipart/form-data" action="">

    <div class="clanek_levy_sloupec">
        <span class="label"><strong>Název *</strong></span>
        <div class="nazev_hd"></div>
        <div class="nazev_bg">
            <input type="text" name="name" value="{$dbCalendar->name}" class="validate[required]" id="name"/>
        </div>
        <div class="nazev_ft"></div>
        <table class="dny_table" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<th colspan="7" style="text-align:left;"><strong>Dny&nbsp;&nbsp;&nbsp;</strong>
                    <span>Po:</span> <input type="checkbox" name="week_day[mo]" {if !$dbCalendar || 'mo'|in_array:$dbCalendar->weekDays}checked="checked"{/if}/>
                    <span>Út:</span> <input type="checkbox" name="week_day[tu]" {if !$dbCalendar || 'tu'|in_array:$dbCalendar->weekDays}checked="checked"{/if}/>
                    <span>St:</span> <input type="checkbox" name="week_day[we]" {if !$dbCalendar || 'we'|in_array:$dbCalendar->weekDays}checked="checked"{/if}/>
                    <span>Čt:</span> <input type="checkbox" name="week_day[th]" {if !$dbCalendar || 'th'|in_array:$dbCalendar->weekDays}checked="checked"{/if}/>
                    <span>Pá:</span> <input type="checkbox" name="week_day[fr]" {if !$dbCalendar || 'fr'|in_array:$dbCalendar->weekDays}checked="checked"{/if}/>
                    <span>So:</span> <input type="checkbox" name="week_day[sa]" {if !$dbCalendar || 'sa'|in_array:$dbCalendar->weekDays}checked="checked"{/if}/>
                    <span>Ne:</span> <input type="checkbox" name="week_day[su]" {if !$dbCalendar || 'su'|in_array:$dbCalendar->weekDays}checked="checked"{/if}/>
                </td>
			</tr>
        </table>
        <span class="label"><strong>Organizátor akce</strong></span>
        <span class="label_kalendar">Název</span>
        <span class="label_kalendar" style="width:215px;float:right;">Osoba</span>
        <div class="organizator_kalendar">
            <input type="text" name="organizer_name" value="{$dbCalendar->organizer_name}"/>
		</div>
		<div class="organizator_kalendar" style="float:right;">
            <input type="text" name="organizer_person" value="{$dbCalendar->organizer_person}"/>
		</div>
        <span class="label_kalendar">Telefon</span>
        <span class="label_kalendar" style="width:215px;float:right;">Email</span>
        <div class="organizator_kalendar">
            <input type="text" name="organizer_phone" value="{$dbCalendar->organizer_phone}"/>
	</div>
        <div class="organizator_kalendar" style="float:right;">
            <input type="text" name="organizer_email" value="{$dbCalendar->organizer_email}"/>
	</div>

	<span class="label_kalendar">Odkaz</span>
        <span class="label_kalendar" style="width:215px;float:right;">Adresa</span>
        <div class="organizator_kalendar">
            <input type="text" name="organizer_url" value="{$dbCalendar->organizer_url}"/>
	</div>
        <div class="organizator_kalendar" style="float:right;">
            <input type="text" name="organizer_address" value="{$dbCalendar->organizer_address}"/>
	</div>

        <span class="label_kalendar">Místo</span>
        <span class="label_kalendar" style="width:215px;float:right;">GPS</span>
        <div class="organizator_kalendar">
			<input type="text" name="place" value="{$dbCalendar->place}"/>
		</div>
        <div class="organizator_kalendar" style="float:right;">
			<input type="text" name="gps" value="{$dbCalendar->gps_lat} {$dbCalendar->gps_lng}"/>
        </div>

    </div>

    <div class="clanek_pravy_sloupec">
        <table class="zarazeni_table" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:10px;margin-top:15px;">
            <tr>
      			<td style="font-size:12px;"><strong>Typ akce</strong></td>
      			<td style="padding-left:35px;">
                    <select name="id_type">
                    	{foreach from=dbCalendar::$type key=id_type item=type_name}
                    		<option value="{$id_type}" {if $dbCalendar->id_type == $id_type}selected="selected"{/if}>{$type_name}</option>
                    	{/foreach}
        	        </select>
      			</td>
      		</tr>
		<tr>
			<td>Predvyplnit organizátora</td>
			<td style="padding-left:35px;">{html_options2 name="id_organizer" options=dbCalendar::getAllOrganizers()|select:'id':'name' emptyLabel='Vyberte' id="organizerPreset"}</td>
		</tr>
        </table>
        <table class="datum_table" border="0" cellpadding="0" cellspacing="0" style="margin-top:18px;border:0px;">
			<tr>

				<th style="text-align:left;padding-left:31px;">Datum od</th>
				<th style="text-align:left;padding-left:31px;">Datum do</th>
			</tr>
			<tr>
				<td>
					<div class="datum_bg">
						<input type="text" id="datepicker2" class="validate[required]" name="from" value="{$dbCalendar->from|default:$smarty.now|date_format:'%d.%m.%Y'}"/>
					</div>
				</td>
				<td>
					<div class="datum_bg">
						<input type="text" id="datepicker3" class="validate[required]" name="to" value="{$dbCalendar->to|default:$smarty.now|date_format:'%d.%m.%Y'}"/>
					</div>
				</td>
			</tr>
        </table>
        <table class="anotacni_obr_table" border="0" cellpadding="0" cellspacing="0" style="margin-top:30px;">
			<tr>
				<th style="text-align:left;padding-left:30px;">Obrázek události</th>
			</tr>
			<tr>
				<td>
					<div class="anotacni_obr">
						<a href="{$dbCalendar->image}" rel="shadowbox[trip]">
							<div id="calendarObrazek" class="anotacni_obr_image" style="background-image:url({if $dbCalendar->image}{$dbCalendar->image}{else}/images/admin/obr.png{/if});"></div>
						</a>
						<a href="javascript:void(0)" title="Přidat obrázek" class="anotacni_obr_pridat" id="upload_foto_1"></a>
						<a href="javascript:void(0)" title="Smazat obrázek" class="anotacni_obr_smazat" id="delete_foto" onclick="calendarObrazekDelete({$dbCalendar->id})"></a>
						<div id="div_upload_foto_1" class="ui-datepicker">
							<div class="ui-datepicker-header ui-widget-header ui-helper-clearfix ui-corner-all">
								<div class="ui-datepicker-title">Nahrát foto</div>
								<a class="ui-datepicker-next ui-corner-all" onclick="$('#div_upload_foto_1').hide();">
									<span class="ui-icon ui-icon-closethick"></span>
								</a>
							</div>
							<div style="width:250px;margin-top:10px;margin-left:5px;">
								<input type="file" name="image"/>
							</div>
						</div>
					</div>
				</td>
			</tr>
        </table>


    </div>

    <div class="cb"><br /></div>
    <span class="label popis_text_hlavni">Popis události</span>
    <div class="text_3">
        {fckeditor BasePath="/fckeditor/" InstanceName="description" Value=$dbCalendar->description|default:'' Width="950" Height="290px" ToolbarSet="Default" CheckBrowser="true" DisplayErrors="true"}
    </div>

	<div class="submit_box" style="bottom:20px;left:0px;position:absolute;">
    		{if $dbCalendar}
    			<input type="hidden" name="id" value="{$dbCalendar->id}"/>
			<input type="hidden" name="visible" value="{$dbCalendar->visible}"/>
    			<input type="submit" value="Uložit úpravy" name="do_calendar" class="ulozit_upravy_tlac" />
				<input type="submit" name="do_calendar_delete" value="Smazat záznam" class="smazat_tlac calendarDelete" rel="{$dbCalendar->id}" title="Smazat událost" alt="{$dbCalendar->name}" onclick="return confirm('Opravdu smazat ?')"/>
    		{else}
    			<input type="submit" value="Vložit událost" name="do_calendar" class="ulozit_upravy_tlac pozice_uprostred" />
    		{/if}
    </div>

</form>
