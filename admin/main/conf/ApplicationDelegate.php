<?php

class conf_ApplicationDelegate {


    function getPreferences(){
        $table_owner_id = [
            'alles'=>'A_Owner','Users'=>'User_Id','afbeeldingen'=>'A_Owner'
        ];
       if (isset($_GET['-table'])){
           $currentTable=$_GET['-table'];

        }else{$currentTable='alles';};
        $mytable =& Dataface_Table::loadTable($currentTable) ; // load the table named 'my_table'

        $auth =& Dataface_AuthenticationTool::getInstance();
        $user =& $auth->getLoggedInUser();
        if ( $user and  $user->val('Rol') != 'ADMIN' ){
            // We apply the security filter to non admin users.
            $mytable->setSecurityFilter(array($table_owner_id[$currentTable]=>$user->val('User_Id')));
    
        }
        return array();  // Mandatory!! getPreferences() must return array.
    }

    function beforeHandleRequest(){
        Dataface_Application::getInstance()
            ->addHeadContent('<meta name="viewport" content="width=device-width, initial-scale=1.0"><link rel="stylesheet" type="text/css" href="style.css"/>');

    }

    function canSwitchUser(){
        $user = Dataface_AuthenticationTool::getInstance()
        ->getLoggedInUser();
        if ( $user and $user->val('Rol') == 'ADMIN' ) return true;
        else return false;
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



    function getOwnUserId(){
        $auth =& Dataface_AuthenticationTool::getInstance();
        $user =& $auth->getLoggedInUser();
        if ( isset($user) ) return $user->val('User_Id');
        return null;
    }
}
?>