<h1 class="clanek_title">UŽIVATELSKÉ ROLE</h1>
<div class="uzivatele_table">
<div style="float: right; height: 25px;"><button id="pridat_roli">Přidat uživatelskou roli</button></div>
<div id="role_table_wrapper" style="clear: both;">
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="role_table">
	
		<tr>
			<th>Název role</th>
			<th>Popis</th>
			<th></th>
			<th></th>
		</tr>
		
		{foreach from=$roles item=role}
		<tr class="table_tr" style="background-color: {cycle values="#EFEFEF,#FFF"};">
			<td>{$role->name}</td>
			<td>{$role->desc}</td>
			<td><a href="#" data-id="{$role->id}" class="smazat_roli" title="Odebrat roli" style="text-decoration: none;font-weight: bold;">smazat</a></td>
			<td><a href="#" class="upravit_roli" data-id="{$role->id}" data-nazev="{$role->name}" data-popis="{$role->desc}" title="Upravit roli" style="text-decoration: none;font-weight: bold;">upravit</a></td>
		</tr>
		{/foreach}
	</tbody>
</table>
</div>
</div>

<div id="pridat_roli_dialog" style="display: none;">
	<form id="pridat_roli_form">
		<div class="rs-pole-group-bottom">
			<span style="width: 120px; display: inline-block;">Název role: </span>
			<input type="text" name="name" class="uniform" style="width: 260px;" />
			<br /><br />
			<span style="width: 120px; display: inline-block;">Popis role: </span>
			<textarea name="desc" class="uniform" rows="4" style="width: 260px;" ></textarea>
		</div>
	</form>
</div>

<div id="upravit_roli_dialog" style="display: none;">
	<form id="upravit_roli_form">
		<div class="rs-pole-group-bottom">
			<span style="width: 120px; display: inline-block;">Název role: </span>
			<input type="text" name="name" class="uniform upravit_nazev_role" style="width: 260px;" />
			<br /><br />
			<span style="width: 120px; display: inline-block;">Popis role: </span>
			<textarea name="desc" class="uniform upravit_popis_role" rows="4" style="width: 260px;" ></textarea>
			<input type="hidden" name="id" id="id_upravit" />
		</div>
	</form>
</div>

<div id="smazat_roli_dialog" style="display: none;">
	<p>Opravdu si přejete roli smazat?</p>
</div>


<script type="text/javascript">
	$(document).ready(function(){
		$("#pridat_roli").button().click(function(e){
			e.preventDefault();
			$("#pridat_roli_dialog").dialog(
				{ 
					autoOpen: true,
					modal: true,
					minWidth: 200,
					minHeight: 185,
					resizable: false,
					title: "Přidat uživatelskou roli.",
					buttons: {
						Přidat: function() {
							$( this ).dialog( "close" );
							$.ajax({
								url: "/res/ajax.php?mode=addUserRole",
								type: "POST",
								dataType: "json",
								data: $("#pridat_roli_form").serialize(),
								success: function(data){
									successBox(data.text); 
									var url = window.location;
									$("#role_table_wrapper").load(url + " #role_table");
								}
							});
							
						},
						Zrušit: function() { $( this ).dialog( "close" ); }
					}
				});
		});
		$(document).on("click", ".upravit_roli", function(e){
			e.preventDefault();
			var nazev = $( this ).attr("data-nazev");
			var popis = $( this ).attr("data-popis");
			var id_role = $(this).attr("data-id");
			$("#upravit_roli_dialog .upravit_nazev_role").val(nazev);
			$("#upravit_roli_dialog .upravit_popis_role").val(popis);
			$("#id_upravit").val(id_role);
			$("#upravit_roli_dialog").dialog(
				{ 
					autoOpen: true,
					modal: true,
					minWidth: 200,
					minHeight: 185,
					resizable: false,
					title: "Upravit uživatelskou roli.",
					buttons: {
						Upravit: function() {
							$( this ).dialog( "close" );
							$.ajax({
								url: "/res/ajax.php?mode=editUserRole",
								type: "POST",
								dataType: "json",
								data: $("#upravit_roli_form").serialize(),
								success: function(data){
									var url = window.location;
									$("#role_table_wrapper").load(url + " #role_table");
									successBox(data.text); 
								}
							});
						},
						Zrušit: function() { $( this ).dialog( "close" ); }
					}
				});
		});
		
		$(document).on("click", ".smazat_roli", function(e){
			e.preventDefault();
			var id_role = $(this).attr("data-id");
			$("#smazat_roli_dialog").dialog(
				{ 
					autoOpen: true,
					modal: true,
					minWidth: 200,
					minHeight: 185,
					resizable: false,
					title: "Potvrďte.",
					buttons: {
						Ano: function() {
							$( this ).dialog( "close" );
							$.ajax({
								url: "/res/ajax.php?mode=deleteUserRole",
								type: "POST",
								dataType: "json",
								data: { id: id_role },
								success: function(data){
									if(data.result == "success"){
										successBox(data.text);
									}else{
										errorBox(data.text);
									}
									var url = window.location;
									$("#role_table_wrapper").load(url + " #role_table");
								}
							});
						},
						Zrušit: function() { $( this ).dialog( "close" ); }
					}
				});
		});
	});
</script>




