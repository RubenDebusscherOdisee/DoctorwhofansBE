<?php

class conf_ApplicationDelegate {


    function block__custom_javascripts(){
        echo '<script src="javascripts.js" type="text/javascript" language="javascript"></script>';
    }

    function getPreferences(){
        $table_owner_id = [
            'alles'=>'A_Owner',
            'Users'=>'User_Id',
            'afbeeldingen'=>'A_Owner',
            'birthdays'=>'B_Owner',
            'Videos'=>'V_Owner',
            'QuotesTabel'=>'Q_Owner'
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

            
            $auth =& Dataface_AuthenticationTool::getInstance();
            $user =& $auth->getLoggedInUser();
            if ( $user and  $user->val('Rol') != 'ADMIN' ){
                  $app =& Dataface_Application::getInstance();
          
                  // Makes sure that the NavMenu cannot see these tables
                  unset($app->_conf['_tables']['Users']);
          
                  // Makes sure that a non-admin user cannot access the tables
                  // from the browser.
                  //$app->_conf['_disallowed_tables']['hide_admin1'] = 'Users';
            }
              
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
            return (new Dataface_PermissionsTool)->ALL();
        }
        else if ( $user and $user->val('Rol') == 'USER' ){
            return (new Dataface_PermissionsTool)->READ_ONLY();
        }
        else if ( $user and $user->val('Rol') == 'MODERATOR' ){
            return (new Dataface_PermissionsTool)->READ_EDIT();
        }else{
            return (new Dataface_PermissionsTool)->NO_ACCESS();

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