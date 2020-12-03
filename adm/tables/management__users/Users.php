<?php
class tables_Users {

  function isAdmin(){
    $auth =& Dataface_AuthenticationTool::getInstance();
    $user =& $auth->getLoggedInUser();
    if ( $user and $user->val('user_Role') == 'ADMIN')  return true;
    return false;
  }
  function Rol__permissions(&$record){
    if (!tables_Users::isAdmin() ) return array('edit'=>0);
    return null;
  }
}

?>