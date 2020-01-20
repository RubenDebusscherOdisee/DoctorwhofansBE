<?
class tables_Topics{

	function getTitle(&$record){
		return $record->val('link').' : '.$record->val('topic');
	}
}

?>