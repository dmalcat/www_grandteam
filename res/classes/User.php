<?php
class User extends User_3n {
    var $owner;
  
    public function __construct($DB, $tbl_prefix = "") {
    	parent::__construct($DB,$tbl_prefix);
    }
    public function __destruct() {
    	parent::__destruct();
    }
    public function get_user_id_by_property_value($prop_name, $prop_value) {
	$sql = "select ump.id_user from s3n_user_map_property as ump 
		    inner join s3n_user_property as up on up.prop_name = '$prop_name' and ump.id_property = up.id_property
		    where ump.value = '$prop_value'";
	$res = $this->DB->getone($sql);
	$this->check($res);
	return $res;
    }
    public function create_new_password($length = 5) {
	$password = "";
	$possible = "0123456789bcdfghjkmnpqrstvwxyz"; 
	$i = 0; 
	while ($i < $length) { 
	    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
	    if (!strstr($password, $char)) { 
		$password .= $char;
		$i++;
	    }
	}
	return $password;


    }
    public function send_new_password_confirm_email($id_user) {
		$p_user = $this->get_user_info($id_user);
		$p_user_email = $this->get_user_property($id_user, "email");
		$user_email = $p_user_email["PROP_VALUE"];
		if (!$user_email) return false;
		$hash = md5($p_user->id_user.$p_user->login.$p_user->date);
		$text = "Pro potvrzení vygenerování nového hesla klikněte na následující odkaz. <br/><br/> <a href='http://www.bojovesporty.cz/login/confirmhash/".$hash."/$id_user/'>zde</a>";

		$headers  = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=utf-8\n";
		$headers .= "X-Priority: 3\n";
		$headers .= "X-MSMail-Priority: Normal\n";
		$headers .= "X-Mailer: php\n";
		$headers .= "From: <bojovesporty@bojovesporty.cz>\n";
		mail($user_email, "Požadavek na změnu hesla z www.bojovesporty.cz", $text, $headers);
		return true;
    }

    public function get_username_by_id($id_user) {
		$res = $this->DB->getone("select login from s3n_users where id_user = $id_user");
		$this->check($res);
		return $res;
    }

    public function confirm_hash($id_user, $hash) {
		$p_user = $this->get_user_info($id_user);
		$cur_hash = md5($p_user->id_user.$p_user->login.$p_user->date);
		if ($cur_hash == $hash) return true;
		return false;
    }

}
?>