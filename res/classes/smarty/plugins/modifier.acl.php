<?php

function smarty_modifier_acl($resourceId, $contentId = null, $roleId = null, $userId = null, $privilege = null)
{
    global $USER;
    $allowed = $USER->is_allowed($resourceId, $contentId, $privilege, $userId, $roleId);
    return $allowed;
}