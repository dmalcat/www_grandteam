<div id="poradna_nove_tema" style="float:left; width: 458px; height:auto; background-image:url(/images/ctverecek_75.png); _background-image:url(/images/ctverecek_75.gif); margin-left: 300px;  position:absolute; top: 0px; left:0px; display:none;">
<div style="width: 450px; height:auto;border: solid 1px black; background-color: #e5ebff; margin-top:-10px; margin-left:-10px; margin-bottom:10px; padding-left:10px; ">
	<form action="/admin/forum/" method="post" name="form_new_forum" enctype="multipart/form-data">
    <table>
        <tr>
			<td colspan="2"><a id="poradna_novy_dotaz_close" href="#" onclick="" style="color: black; text-decoration:none; font-style:normal; float:right; ">[X] zavřít </a></td>
		</tr>		
		<tr>
			<td colspan="2"><div align="center"><h2>Vložení nového tématu</h2></div></td>
        <tr>
			<td width="110">Kategorie chatu:</td>
			<td width="318"><select name="new_chat[id_forum_category]" style="width: 200px;">
						<option value="">nezařazeno</option>
						{foreach from=$p_forum_categories item=p_poradna_category}
							<option value="{$p_poradna_category->id_forum_category}">{$p_poradna_category->name}</option>
						{/foreach}
					</select>
			</td>
		  </tr>
		<tr>
				<td>Autor:</td>
				<td>
					<fieldset style="float: left; width:290px; margin-bottom:0px; padding:0px;">
<!-- 						<form action="{$lnk_base}" method="post" style="float: left;"> -->
							<select name="new_chat[author_id]"  style="width:200px;">
								<option value="">vše</option>{foreach from=$p_forum_authors item=p_forum_author}
										<option value="{$p_forum_author->id_author}" {if $forum_author == $p_forum_author->id_author} selected{/if}>{$p_forum_author->name}</option>
									{/foreach}
							</select>
<!-- 						</form> -->
					</fieldset>
				</td>
			</tr>
			<tr>
				<td>zobrazit:</td><td><input type="checkbox"  style=""  name="new_chat[visible]"/></td>
			</tr>
			<tr>
				<td>název:</td><td><input type="text"  style="width: 295px;"  name="new_chat[name]"/></td>
			</tr>
			<tr>
				<td>datum:</td><td valign="top"><input type="text"  style="width: 295px;"  name="new_chat[datum]" onclick='scwShow(this,event);'/></td>
			</tr>
<!-- 			<tr> -->
<!-- 				<td>popis:</td> -->
<!-- 				<td><textarea name="new_chat[description]" style="width: 300px; height: 150px;"></textarea></td> -->
<!-- 			</tr> -->
			<tr>
				<td ></td><td ><input type="submit" name="do_forum_add" value="vytvořit" style="background:#F00; border:1px #666 solid; cursor:pointer; margin-left:5px; color:#FFF; width:97px; height:23px; margin-top:0px; float:right; margin-bottom:5px; margin-right:15px;" /></td>
			</tr>
            </table>
	</form>
	
</div>
</div>

{literal}
<script type="text/javascript">
		var frmvalidator = new Validator("form_new_forum");
		frmvalidator.addValidation("new_chat[name]","req","Pole 'název' je třeba vyplnit.");
		frmvalidator.addValidation("new_chat[datum]","req","Pole 'datum' je třeba vyplnit.");
// 		frmvalidator.addValidation("dotaz_text","req","Pole 'Dotaz' je třeba vyplnit.");
$(document).ready(function() {
	$("#new_chat_button").click(function(){
		$("#poradna_nove_tema").animate({opacity: 'toggle', height: 'toggle'});
		return false;
	})
	$("#poradna_novy_dotaz_close").click(function(){
		$("#poradna_nove_tema").animate({opacity: 'hide', height: 'toggle'});
		return false;
	})
});
</script>
{/literal}