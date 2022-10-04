<?php
$data = $_POST;
if(isset($_POST['name']) && isset($_POST['desc'])){
    $res = dbRole::addRole($data['name'], $data['desc']);
}
if($res){
    echo json_encode(array(
        "result" => "success",
        "text"  => "Role byla úspěšně přidána.",
    ));
}else{
    echo json_encode(array(
        "result" => "error",
        "text"  => "Vyskytla se chyba.",
    ));
}
