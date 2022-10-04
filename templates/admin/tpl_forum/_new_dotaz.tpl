<div id="novy_dotaz_field"  style="display: none">	<!--vlozeni noveho prispevku z administrace-->
	<table style="float: left; width: 940px;" >
		<tr bgcolor="#FF0000" border="1">
			<td style="padding:5px;" valign="top">
				<form action="" method="post" name="form_forum_content_insert" enctype="multipart/form-data" style="color: white;">
					vložit nový příspěvek ({$smarty.now|date_format:"%d.%b.%y %H:%M"})<br/>
					autor:<input type="text" name="author_name" />&nbsp;email:<input type="text" name="author_email" /><br/>
					<textarea name="text" style="width: 680px;height:100px;"></textarea>
					<br/><hr/>
			</td>
			<td  style="padding:5px;">
				<input type="hidden" name="disable_email" value="true"/>
				{include file=admin/tpl_forum/_forum_content_add_edit.tpl mode=insert}
			</form>
			</td>
			</tr>
			<tr>
							<td >&nbsp; </td>
							<td>&nbsp; </td>
		</tr>
	</table>
</div>
{literal}
<script type="text/javascript">
// 		var frmvalidator = new Validator("form_new_forum");
// 		frmvalidator.addValidation("new_chat[name]","req","Pole 'název' je třeba vyplnit.");
// 		frmvalidator.addValidation("new_chat[datum]","req","Pole 'datum' je třeba vyplnit.");
// 		frmvalidator.addValidation("dotaz_text","req","Pole 'Dotaz' je třeba vyplnit.");
$(document).ready(function() {
	$("#new_dotaz_button").click(function(){
		$("#novy_dotaz_field").toggle({opacity: 'hide', height: 'toggle'});
// 		$("#novy_dotaz_field").show();
		return false;
	})
});
</script>
{/literal}