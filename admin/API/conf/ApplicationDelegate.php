<?php
class conf_ApplicationDelegate {
   /* function getPermissions(&$record){
        // $record is a Dataface_Record object
        $auth =& Dataface_AuthenticationTool::getInstance();
        $user =& $auth->getLoggedInUser();
        if ( $user ) return Dataface_PermissionsTool::ALL();
        else return Dataface_PermissionsTool::NO_ACCESS();
    }*/

    function getPermissions(&$record){
        $user =& Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
        if ( $user and $user->val('Rol') == 'EDITOR' ){
            return Dataface_PermissionsTool::getRolePermissions('EDITOR');
        } else if ( $user and $user->val('Rol') == 'ADMIN' ){
            return Dataface_PermissionsTool::getRolePermissions('ADMIN');
        }
        return Dataface_PermissionsTool::READ_ONLY();
    }





     
}
?>