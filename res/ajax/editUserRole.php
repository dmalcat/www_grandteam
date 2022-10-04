<?php
$res = false;
if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['desc'])){
    $role = dbRole::getById((int)$_POST['id']);
    $res = $role->editRole($_POST);
}
if($res){
    echo json_encode(array(
        "result" => "success",
        "text"  => "Role byla úspěšně upravena.",
    ));
}else{
    echo json_encode(array(
        "result" => "error",
        "text"  => "Vyskytla se chyba.",
    ));
}
