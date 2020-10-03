<?php

class tables_afbeeldingen {

    function getTitle($record){
		return $record->val('id');
    }

  
    function A_Owner__default(){
      $auth =& Dataface_AuthenticationTool::getInstance();
      $user =& $auth->getLoggedInUser();
      if ( isset($user) ) return $user->val('User_Id');
      return null;
  }
  
 
    


}
?>