<?php
class tables_content__items {
  function beforeInsert(Dataface_Record $record){
    $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
    if ( $user and !$record->val('item_Owner_Id') ){
        $record->setValue('item_Owner_Id', $user->val('user_Id'));
        $record->setValue('item_Last_modifier', $user->val('user_Id'));
    }
  }
  function beforeUpdate(Dataface_Record $record){
    $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
    if ( $user){
        $record->setValue('item_Last_modifier', $user->val('user_Id'));

    }
  }
  function item_Last_modifier__default(){
    return 0;
  }
  function item_Owner_Id__default(){
    return 0;
  }

  function css__tableRowClass( $record ){
    if ( $record->val('item_Active') == 1 ) return 'active-row';
    else return 'dormant-row';
  }


}
?>