
<div class="container-fluid">
	<div class="row margin-bottom-40">
		<div id="Carousel" class="carousel slide carousel-fade drop-shadow" data-ride="carousel" data-interval="6000">

			{*<ol class="carousel-indicators">
			{foreach from=dbGallery::getById(1)->getImages() item=image name=forSlider}
			<li data-target="Carousel" data-slide-to="{$smarty.foreach.forSlider.iteration}" {if $smarty.foreach.forSlider.first}class="active"{/if}></li>
			{/foreach}
			</ol>*}

			{if $language == "en"}
				{assign var=idGallery value=5}
			{elseif $language == "de"}
				{assign var=idGallery value=6}
			{elseif $language == "pl"}
				{assign var=idGallery value=7}
			{elseif $language == "es"}
				{assign var=idGallery value=8}
			{else}
				{assign var=idGallery value=1}
			{/if}

			<div class="carousel-inner">
				{foreach from=dbGallery::getById($idGallery)->getImages() item=image name=forSlider}
					<div class="item {if $smarty.foreach.forSlider.first}active{/if}">
						<img src="{$image->dImage}" class="img-responsive img-full"/>
						<div class="carousel-caption hidden">
							<h3>{$image->name}</h3>
							<p>{$image->description}</p>
							<a href="#" class="move_down font-size-45 text-white"><i class="glyphicon glyphicon-chevron-down text-white"></i> posunout</a>
						</div>
					</div>
				{/foreach}
			</div>
			<a class="left carousel-control" href="#Carousel" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left"></span>
			</a>
			<a class="right carousel-control" href="#Carousel" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right"></span>
			</a>
		</div>
	</div>
</div>
