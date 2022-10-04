<?php
function smarty_block_ifmujpodrizeny($params, $content, $template, &$repeat) {
	global $USER;

	$idMakler = array_key_exists('idMakler', $params) ? $params['idMakler'] : null;
	$idVedouci = $USER->data["id_user"];
	if($idMakler == $idVedouci || $USER->data["role_code"] == "rk") return $content;
	
	if($idMakler) {
		$pPodrizeni = RealityUser::getPodrizeni($idVedouci);
		if(in_array($idMakler, $pPodrizeni)) return $content;
//		print_p($pPodrizeni); 
//		return dibi::fetchSingle("SELECT id_user FROM s3n_users WHERE id_vedouci = %i AND id_user = %i", $USER->data["id_user"], $idMakler) ? $content : '';	
	} 
	return '';
	
	
	
	
	 
	
}
?>
