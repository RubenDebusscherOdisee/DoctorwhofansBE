<?php

class tables_QuotesTabel{
    function getTitle($record){
		return $record->val('id');
    }

    function beforeInsert(Dataface_Record $record){
      $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
      if ( $user and !$record->val('Q_Owner') ){
          $record->setValue('Q_Owner', $user->val('User_Id'));
      }
    }
}


?>