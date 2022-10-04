<?php

////print_p(dbItemProperty::getByName('velikost')->getEnumarations());
//foreach(dbItemProperty::getByName('velikost')->getEnumarations() AS $enumeration) {
//    if($enumeration->id_enumeration == )
//}

echo json_encode(array("value" => dbItem::getById($_GET['idItem'])->getPropertyValue($_GET['property'])));

?>
