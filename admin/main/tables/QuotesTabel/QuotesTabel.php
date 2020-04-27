<?php

class tables_QuotesTabel{
    function getTitle($record){
		return $record->val('id');
    }
}


?>