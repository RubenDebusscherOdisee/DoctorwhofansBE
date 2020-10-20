<?php

class tables_afbeeldingen {

    function getTitle($record){
		return $record->val('id');
    }

  
    function beforeSave(Dataface_Record $record){
      $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
      if ( $user and !$record->val('A_Owner') ){
          $record->setValue('A_Owner', $user->val('User_Id'));
      }
    }
  
    function A_Owner__default(){
      $auth =& Dataface_AuthenticationTool::getInstance();
      $user =& $auth->getLoggedInUser();
      if ( isset($user) ) return $user->val('User_Id');
      return null;
  }
 
    


}
?>