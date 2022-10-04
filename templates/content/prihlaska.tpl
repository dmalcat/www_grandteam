  <div class="content_bg">
{*           <div class="content_img"><img src="{dbContentCategory::IMAGES_PATH}{$dbCC->id}/{$dbCC->image_1}" alt="{$dbCC->name}" border="0" /></div> *}
      <div class="content_sloupec">
          <h1 class="content_title">Nezávazná přihláška</h1>
          <div class="content_text2">
		<form class="form-horizontal" action="" method="post">
		<fieldset>

		<!-- Form Name -->
{* 		<legend>Nezávazná přihláška</legend> *}

		<!-- Text input-->
		<div class="control-group">
		  <label class="control-label" for="jmeno">Jméno *</label>
		  <div class="controls">
		    <input id="jmeno" name="jmeno" placeholder="" class="input-xlarge" required="" type="text" value="{$data.jmeno}">
		    
		  </div>
		</div>

		<!-- Text input-->
		<div class="control-group">
		  <label class="control-label" for="prijmeni">Příjmení *</label>
		  <div class="controls">
		    <input id="prijmeni" name="prijmeni" placeholder="" class="input-xlarge" required="" type="text" value="{$data.prijmeni}">
		    
		  </div>
		</div>

		<!-- Text input-->
		<div class="control-group">
		  <label class="control-label" for="textinput">Email *</label>
		  <div class="controls">
		    <input id="email" name="email" placeholder="" class="input-xlarge" required="" type="text" value="{$data.email}">
		    
		  </div>
		</div>

		<!-- Text input-->
		<div class="control-group">
		  <label class="control-label" for="telefon">Telefon *</label>
		  <div class="controls">
		    <input id="telefon" name="telefon" placeholder="" class="input-xlarge" required="" type="text" value="{$data.telefon}">
		    
		  </div>
		</div>

		<!-- Text input-->
		<div class="control-group">
		  <label class="control-label" for="firma">Společnost</label>
		  <div class="controls">
		    <input id="firma" name="firma" placeholder="" class="input-xlarge" type="text" value="{$data.firma}">
		    
		  </div>
		</div>

		<!-- Text input-->
		<div class="control-group">
		  <label class="control-label" for="mesto">Město</label>
		  <div class="controls">
		    <input id="mesto" name="mesto" placeholder="" class="input-xlarge" type="text" value="{$data.mesto}">
		    
		  </div>
		</div>

		<!-- Multiple Radios -->
		<div class="control-group">
		  <label class="control-label" for="typ">Mám zájem o:</label>
		  <div class="controls">
		    <label class="radio" for="typ-0">
		      <input name="typ" id="typ-0" value="Individuální hodiny" checked="checked" type="radio">
		      Individuální hodiny
		    </label>
		    <label class="radio" for="typ-1">
		      <input name="typ" id="typ-1" value="Skupinové hodiny" type="radio">
		      Skupinové hodiny
		    </label>
            <label class="radio" for="typ-2">
		      <input name="typ" id="typ-2" value="Lekce jogy" type="radio">
		      Lekce jogy
		    </label>
            <label class="radio" for="typ-3">
		      <input name="typ" id="typ-3" value="Lekce pilates" type="radio">
		      Lekce pilates
		    </label>
		  </div>
		</div>

		{*<!-- Multiple Checkboxes -->
		<div class="control-group">
		  <label class="control-label" for="nejradeji">Nejraději bych cvičil/-la</label>
		  <div class="controls">
		    <label class="checkbox" for="nejradeji-0">
		      <input name="nejradeji[]" id="nejradeji-0" value="Jóga pro radost" type="checkbox">
		      Jóga pro radost
		    </label>
		    <label class="checkbox" for="nejradeji-1">
		      <input name="nejradeji[]" id="nejradeji-1" value="Jóga pro sportovce" type="checkbox">
		      Jóga pro sportovce
		    </label>
		    <label class="checkbox" for="nejradeji-2">
		      <input name="nejradeji[]" id="nejradeji-2" value="Jóga pro manažery" type="checkbox">
		      Jóga pro manažery
		    </label>
		    <label class="checkbox" for="nejradeji-3">
		      <input name="nejradeji[]" id="nejradeji-3" value="Jóga pro těhotné" type="checkbox">
		      Jóga pro těhotné
		    </label>
		    <label class="checkbox" for="nejradeji-4">
		      <input name="nejradeji[]" id="nejradeji-4" value="Pilates pro zdraví a krásu" type="checkbox">
		      Pilates pro zdraví a krásu
		    </label>
		    <label class="checkbox" for="nejradeji-5">
		      <input name="nejradeji[]" id="nejradeji-5" value="Pilates pro náročné" type="checkbox">
		      Pilates pro náročné
		    </label>
		    <label class="checkbox" for="nejradeji-6">
		      <input name="nejradeji[]" id="nejradeji-6" value="Pilates pro manažery" type="checkbox">
		      Pilates pro manažery
		    </label>
		    <label class="checkbox" for="nejradeji-7">
		      <input name="nejradeji[]" id="nejradeji-7" value="Pilates pro těhotné" type="checkbox">
		      Pilates pro těhotné
		    </label>
		  </div>
		</div>*}

		{*<!-- Multiple Radios -->
		<div class="control-group">
		  <label class="control-label" for="zkusenost">Mám předchozí zkušenost s jógou/pilates</label>
		  <div class="controls">
		    <label class="radio" for="zkusenost-0">
		      <input name="zkusenost" id="zkusenost-0" value="Ano" checked="checked" type="radio">
		      Ano
		    </label>
		    <label class="radio" for="zkusenost-1">
		      <input name="zkusenost" id="zkusenost-1" value="Ne" type="radio">
		      Ne
		    </label>
		  </div>
		</div>

		<!-- Textarea -->
		<div class="control-group">
		  <label class="control-label" for="zkusenost_text">Prosím popište více</label>
		  <div class="controls">                     
		    <textarea id="zkusenost_text" name="zkusenost_text"></textarea>
		  </div>
		</div>

		<!-- Textarea -->
		<div class="control-group">
		  <label class="control-label" for="zdravostni_omezeni">Zdravotní omezení</label>
		  <div class="controls">                     
		    <textarea id="zdravostni_omezeni" name="zdravostni_omezeni"></textarea>
		  </div>
		</div>
        *}
		<!-- Multiple Checkboxes -->
		<div class="control-group">
		  <label class="control-label" for="den">Preferuji tento čas cvičení</label>
		  <div class="controls">
		    <label class="checkbox" for="den-0">
		      <input name="den[]" id="den-0" value="Pondělí" type="checkbox">
		      Pondělí
		    </label>
		    <label class="checkbox" for="den-1">
		      <input name="den[]" id="den-1" value="Úterý" type="checkbox">
		      Úterý
		    </label>
		    <label class="checkbox" for="den-2">
		      <input name="den[]" id="den-2" value="Středa" type="checkbox">
		      Středa
		    </label>
		    <label class="checkbox" for="den-3">
		      <input name="den[]" id="den-3" value="Čtvrtek" type="checkbox">
		      Čtvrtek
		    </label>
		  </div>
		</div>

		<!-- Multiple Radios -->
		<div class="control-group">
		  <label class="control-label" for="zacatek">Začátek hodiny</label>
		  <div class="controls">
		    <label class="checkbox" for="zacatek-0">
		      <input name="zacatek[]" id="zacatek-0" value="7:00" type="checkbox">
		      7:00
		    </label>
		    <label class="checkbox" for="zacatek-1">
		      <input name="zacatek[]" id="zacatek-1" value="8:00" type="checkbox">
		      8:00
		    </label>
		    <label class="checkbox" for="zacatek-2">
		      <input name="zacatek[]" id="zacatek-2" value="9:00" type="checkbox">
		      9:00
		    </label>
		    <label class="checkbox" for="zacatek-3">
		      <input name="zacatek[]" id="zacatek-3" value="10:00" type="checkbox">
		      10:00
		    </label>
		    <label class="checkbox" for="zacatek-4">
		      <input name="zacatek[]" id="zacatek-4" value="11:00" type="checkbox">
		      11:00
		    </label>
		    <label class="checkbox" for="zacatek-5">
		      <input name="zacatek[]" id="zacatek-5" value="12:00" type="checkbox">
		      12:00
		    </label>
		    <label class="checkbox" for="zacatek-6">
		      <input name="zacatek[]" id="zacatek-6" value="13:00" type="checkbox">
		      13:00
		    </label>
		    <label class="checkbox" for="zacatek-7">
		      <input name="zacatek[]" id="zacatek-7" value="14:00" type="checkbox">
		      14:00
		    </label>
		    <label class="checkbox" for="zacatek-8">
		      <input name="zacatek[]" id="zacatek-8" value="15:00" type="checkbox">
		      15:00
		    </label>
		    <label class="checkbox" for="zacatek-9">
		      <input name="zacatek[]" id="zacatek-9" value="16:00" type="checkbox">
		      16:00
		    </label>
		    <label class="checkbox" for="zacatek-10">
		      <input name="zacatek[]" id="zacatek-10" value="17:00" type="checkbox">
		      17:00
		    </label>
		    <label class="checkbox" for="zacatek-11">
		      <input name="zacatek[]" id="zacatek-11" value="18:00" type="checkbox">
		      18:00
		    </label>
		    <label class="checkbox" for="zacatek-12">
		      <input name="zacatek[]" id="zacatek-12" value="19:00" type="checkbox">
		      19:00
		    </label>
		    <label class="checkbox" for="zacatek-13">
		      <input name="zacatek[]" id="zacatek-13" value="20:00" type="checkbox">
		      20:00
		    </label>
		  </div>
		</div>

        <!-- Textarea -->
		<div class="control-group">
		  <label class="control-label" for="poznamky_text">Další poznámky, dotazy</label>
		  <div class="controls">                     
		    <textarea id="poznamky_text" name="poznamky_text"></textarea>
		  </div>
		</div>

		<!-- Button -->
		<div class="control-group">
		  <label class="control-label" for="doOdeslat">Odeslat nezávaznou přihlášku</label>
		  <div class="controls">
		    <button id="doOdeslat" name="doOdeslat" class="btn btn-primary">Odeslat</button>
		  </div>
		</div>

		</fieldset>
		</form>
              
          </div>
          
              {if $dbCC->file1->original || $dbCC->file2->original}
          <div class="galerie_detail">
              <ul style="list-style-type:none;">
  				{if $dbCC->file1->original}
                  <li>
          			<div class="galerie_detail_file_name">
                          <a href="{$dbCC->file1->original}" target="_blank">
                              <img src="{dbGallery::GALLERY_PATH}icons/{$dbCC->file1->fileInfo->big_icon_url}" width="35" height="42" border="0" align="center" alt=" " />
                              &nbsp;&nbsp;{$dbCC->file1->original|basename}&nbsp;&nbsp;
                              ({$dbCC->file1->size|file_size})
                          </a>
                      </div>
          		</li>
  				{/if}
  				{if $dbCC->file2->original}
          		<li>
          			<div class="galerie_detail_file_name">
                          <a href="{$dbCC->file2->original}" target="_blank">
                              <img src="{dbGallery::GALLERY_PATH}icons/{$dbCC->file2->fileInfo->big_icon_url}" width="35" height="42" border="0" align="center" alt=" " />
                              &nbsp;&nbsp;{$dbCC->file2->original|basename}&nbsp;&nbsp;
                              ({$dbCC->file2->size|file_size})
                          </a>
                      </div>
          		</li>
  				{/if}
          	</ul>
          </div>
      {/if}
          <div class="cb"></div>  
      </div>
  </div>




<script type="text/javascript">
  {if $form_sent_ok}
    alert('Formulář byl v pořádku odeslán. Děkuji, budu Vás brzy kontaktovat. Ivona Pobežalová');
   {/if}
</script>