<div class="galerie_detail"> 
    <h2 class="galerie_detail_name">{$dbGallery->name}</h2>
    <div class="row">
        {foreach from=$dbGallery->getImages(false) item=p_file name=forFile}
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <div class="offer offer-radius offer-primary">
                    <div class="shape">
                        <div class="shape-text">
                            {*							PDF*}
                        </div>
                    </div>
                    <div class="offer-content">
                        <h4 class="lead font-size-15">
                            <a href="{$p_file->file}" target="_blank" class="galerie_detail_file">
                                <strong>{$p_file->description}</strong>
                                <img src="/images/icons/{$p_file->fileInfo->big_icon_url}" width="35" height="42" border="0" align="center"  />
                                &nbsp;&nbsp;
                                {$p_file->original_size|file_size}
                            </a>

                        </h4>
                        <p>
                            <a href="{$p_file->file}" target="_blank">
                                {$p_file->name}
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            {if $smarty.foreach.forFile.iteration % 4 == 0} <div class="clearfix"></div> {/if}
        {/foreach}
    </div>
</div>
