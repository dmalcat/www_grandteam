<?php
// function smarty_block_ifacl($params, $content, &$smarty, &$repeat)
function smarty_block_ifacl($params, $content, $template, &$repeat)
// function smarty_block_textformat($params, $content, $template, &$repeat)
{
    if(!$repeat){
        global $USER;
        $resourceId = array_key_exists('resourceId', $params) ? $params['resourceId'] : null;
        $contentId = array_key_exists('contentId', $params) ? $params['contentId'] : null;
        $privilege = array_key_exists('privilege', $params) ? $params['privilege'] : null;
        $roleId = array_key_exists('roleId', $params) ? $params['roleId'] : null;
        $userId = array_key_exists('userId', $params) ? $params['userId'] : null;
        $reverse = array_key_exists('reverse', $params) ? $params['reverse'] : false;

		
        $allowed = $USER->is_allowed($resourceId, $contentId, $privilege, $userId, $roleId);

        if(array_key_exists('debug', $params) && (bool)$params['debug']){
            $debug = $params;
            $debug['allowed'] = $allowed ? '1' : '0';
            $return =  print_r($debug, true);
            $return .= "<br />content -----------------------<br />";
            $return .= $content;
            return $return;
        }else{
            if($reverse){
                if(!$allowed){
                    return $content;
                }
            }else{
                if($allowed){
                    return $content;
                }
            }
        }
        return '';
    }
}
?>
