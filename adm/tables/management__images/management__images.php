<?php
  class tables_management__images {

    function getTitle($record){
      return 'https://www.doctorwhofans.be/images/management__images/'.$record->getValue('image_File');
      }
    function beforeInsert(Dataface_Record $record){
      $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
      if ( $user and !$record->val('image_Owner_Id') ){
          $record->setValue('image_Owner_Id', $user->val('user_Id'));
          $record->setValue('image_Last_modifier', $user->val('user_Id'));
      }
    }
    function beforeUpdate(Dataface_Record $record){
      $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
      if ( $user){
          $record->setValue('image_Last_modifier', $user->val('user_Id'));

      }
    }
    function image_Last_modifier__default(){
      return 0;
    }
    function image_Owner_Id__default(){
      return 0;
    }
    

    
  }
?>
