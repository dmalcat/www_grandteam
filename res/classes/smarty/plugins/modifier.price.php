<?php

function smarty_modifier_price($price, $type = null, $kurz = null)
{
	return priceFormat($price, $type, $kurz);
}
?>