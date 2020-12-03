<?php
class tables_content__downloads {
  function beforeInsert(Dataface_Record $record){
    $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
    if ( $user and !$record->val('download_Owner_Id') ){
        $record->setValue('download_Owner_Id', $user->val('user_Id'));
        $record->setValue('download_Last_modifier', $user->val('user_Id'));
    }
  }
  function beforeUpdate(Dataface_Record $record){
    $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
    if ( $user){
        $record->setValue('download_Last_modifier', $user->val('user_Id'));

    }
  }
  function download_Last_modifier__default(){
    return 0;
  }
  function download_Owner_Id__default(){
    return 0;
  }

}
?>