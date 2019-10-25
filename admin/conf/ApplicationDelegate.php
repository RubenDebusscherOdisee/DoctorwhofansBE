<?php
class conf_ApplicationDelegate {
    function getPermissions(&$record){
        // $record is a Dataface_Record object
        $auth =& Dataface_AuthenticationTool::getInstance();
        $user =& $auth->getLoggedInUser();
        if ( $user ) return Dataface_PermissionsTool::ALL();
        else return Dataface_PermissionsTool::NO_ACCESS();
    }
}
?>