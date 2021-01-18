<?php
class tables_content__quotes {
  function beforeInsert(Dataface_Record $record){
    $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
    if ( $user and !$record->val('quote_Owner_Id') ){
        $record->setValue('quote_Owner_Id', $user->val('user_Id'));
        $record->setValue('quote_Last_modifier', $user->val('user_Id'));
    }
  }
  function beforeUpdate(Dataface_Record $record){
    $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
    if ( $user){
        $record->setValue('quote_Last_modifier', $user->val('user_Id'));

    }
  }
  function quote_Last_modifier__default(){
    return 0;
  }
  function quote_Owner_Id__default(){
    return 0;
  }

 


}
?>