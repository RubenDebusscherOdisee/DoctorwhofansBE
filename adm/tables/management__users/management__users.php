<?php
class tables_management__users {

  function getPreferences(){
    $myTable =& Dataface_Table::loadTable('management__users') ;
    $auth =& Dataface_AuthenticationTool::getInstance();
    $user =& $auth->getLoggedInUser();
    if ( $user and  $user->val('user_Role') != 'ADMIN' ){
        // We apply the security filter to non admin users.
        $myTable->setSecurityFilter(array('user_Id'=>$user->val('user_Id')));

    }
    return array();  // Mandatory!! getPreferences() must return array.
  }
  function user_Password__permissions($record){
    $auth =& Dataface_AuthenticationTool::getInstance();
    $user =& $auth->getLoggedInUser();
    if ( $user and  $user->val('user_Role') != 'ADMIN' ){
        // We apply the security filter to non admin users.
        return array('edit'=>0);

    }

  }
  
}

?>