<?php
if(isset($_POST['id'])){
    $uzivatele = dbI::query("SELECT count(*) FROM s3n_users WHERE id_role = %i", (int)$_POST['id'])->fetchSingle();
    if($uzivatele == 0){
        $res = dbRole::deleteRole((int)$_POST['id']);
    }
}
if($res){
    echo json_encode(array(
        "result" => "success",
        "text"  => "Role byla úspěšně odstraněna.",
    ));
}else{
    echo json_encode(array(
        "result" => "error",
        "text"  => "Role obsahuje uživatele, není možné ji smazat.",
    ));
}
