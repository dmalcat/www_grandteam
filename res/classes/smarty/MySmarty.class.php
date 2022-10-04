<?php
class IRSmarty extends Smarty {

	function _parse_attrs( $tag_args ){
      $attrs = parent::_parse_attrs( $tag_args );
      foreach( $attrs as $key=>$value ) {
         // perhaps this was intended as a static callback?
         if( preg_match( '#^["\']([a-zA-Z_]\w*::[a-zA-Z_]\w*)\((.*)?\)["\']$#', $value, $matches ) ) {
            $arguments = '()';
            if( isset( $matches[2] ) ){
               // strip '".' and '."' from beginning and end
               $arguments = substr( $matches[2], 2, -2 );
               // remove '.",".' from between parameters
               $arguments = explode( '.",".', $arguments );
               // combine arguments into string
               $arguments = '('.implode( ',', $arguments ).')';
            }
            $attrs[$key] = $matches[1].$arguments;
         }
      }
      return $attrs;
   } 
}
?>