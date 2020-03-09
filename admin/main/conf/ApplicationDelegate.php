<?php
class conf_ApplicationDelegate {
   /* function getPermissions(&$record){
        // $record is a Dataface_Record object
        $auth =& Dataface_AuthenticationTool::getInstance();
        $user =& $auth->getLoggedInUser();
        if ( $user ) return Dataface_PermissionsTool::ALL();
        else return Dataface_PermissionsTool::NO_ACCESS();
    }*/

    function beforeHandleRequest(){
        Dataface_Application::getInstance()
            ->addHeadContent('<meta name="viewport" content="width=device-width, initial-scale=1.0"><link rel="stylesheet" type="text/css" href="style.css"/>');

    }

    function getPermissions(Dataface_Record $record = null){
        $user = Dataface_AuthenticationTool::getInstance()
            ->getLoggedInUser();
        
        if ( $user and $user->val('Rol') == 'ADMIN' ){
            return Dataface_PermissionsTool::ALL();
        }
        else if ( $user and $user->val('Rol') == 'USER' ){
            return Dataface_PermissionsTool::READ_ONLY();
        }
        else if ( $user and $user->val('Rol') == 'MODERATOR' ){
            return Dataface_PermissionsTool::READ_EDIT();
        }else{
            return Dataface_PermissionsTool::NO_ACCESS();

        }
    }
}
?>