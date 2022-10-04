<div id="accordion" data-content_type="{$idContentType}">
	{if $filterContentCategory == 'filterZajimavosti'}
		{assign var=from value=dbContentCategory::getZajimavosti()}
	{elseif $filterContentCategory == 'filterAktuality'}
		{assign var=from value=dbContentCategory::getAktuality()}
	{else}
		{assign var=from value=dbContentCategory::getAll(null)->sort('priority')}
	{/if}
	{foreach from=$from item=item}
	{if $dbUser->isAllowed('editovat',$item->id)}
		<div id="accordion_item_{$item->id}" class="ac_item {if dbContentCategory::getSubcategoriesCount(null, $item->id) > 0}parent{/if}">
			{include file="admin/_accordion_item.tpl"}
		</div>
	{/if}
    {/foreach}
</div>

<script type="text/javascript">
$(document).ready(function(){

	$(document).on("click", "h3.bg", function(e){
		e.preventDefault();
		//	console.log((e.target || e.eventSrc).nodeName);
			//	magie k zastaveni propagace u nechtenych elementu
		if( ( ( (e.target || e.eventSrc).nodeName) != "H3") && ( ( (e.target || e.eventSrc).nodeName) != "SPAN") )return 0;
		//	console.log(e);
		$clicked = $(this);
		$clicked.toggleClass("expanded");
		var level = 0;
		$rodic = $clicked;
			//	jak jsme hluboko?
		while(!$rodic.parent().hasClass("ac_item")){
			$rodic = $rodic.parent();
			level++;
		}

		if($clicked.parent().hasClass("parent") && !$clicked.find(".ikona > span").hasClass("ui-icon-triangle-1-e")){
				//	expanded = rozvinuty
			if($clicked.hasClass("expanded")){
				$clicked.parent().children(".appended").slideDown("fast");
				$clicked.find(".ikona span").removeClass("ui-icon ui-icon-circle-plus");
				$clicked.find(".ikona span").addClass("ui-icon ui-icon-circle-minus");
			}else{
				$clicked.parent().children(".appended").slideUp("fast");
				$clicked.find(".ikona span").removeClass("ui-icon ui-icon-circle-minus");
				$clicked.find(".ikona span").addClass("ui-icon ui-icon-circle-plus");
			}
		}


		var id = $clicked.attr("data-id");
		var content_type = $("#accordion").attr("data-content_type");
		$.ajax({
			url: "/res/ajax.php?mode=fetchSub",
			type: "POST",
			dataType: "json",
			data: { id_item: id, level: level, content_type: content_type },
			success: function(data){
				//	console.log(data);
				if(!$clicked.next().hasClass("appended")){
					$.each(data.obsah, function(key, value){
						$clicked.after(value);
					});
				}
			},
			error: function(data){
				//	console.log(data);
			}
		});

	});

	$(document).on("change", ".contentCategoryType", function(e){
		e.preventDefault();
		$vybrano = $(this);
			//	slozitejsi kvuli dynamickemu DOMu
		$vybrana_option = $vybrano.find("option:selected");
		$nevybrane_option = $vybrano.find("option").not($vybrana_option);
		$nevybrane_option.attr("selected", false);
		$vybrana_option.attr("selected", true);
		$vybrano.prev("span").html($vybrana_option.html());
		//	console.log($vybrana_option);
		loading('show');
		$option = $(this);
		$.ajax({
			url: "/res/ajax.php?mode=setContentCategoryType",
			type: "GET",
			dataType: "json",
			data: { idContentCategory: $option.attr('rel'), type: $option.val() },
			success: function(data){
				successBox('Typ položky byl upraven.');
				//	console.log($option);
				loading('hide');
				//	window.location.reload();
			}
		});
		return 0;
	});

	{if $dbCC}
		{assign var="counter" value=300}
		{foreach from=$dbCC->getNavigation() item=dbContentCategory}
			{if $dbContentCategory->id_parent}
				setTimeout( "rozbalClanky({$dbContentCategory->id_parent})", {$counter} );
			{/if}
			{$counter = $counter + 300}
		{/foreach}
	{/if}
});

function rozbalClanky(id){
	$('h3.bg[data-id="'+id+'"]').click();
}
</script>
