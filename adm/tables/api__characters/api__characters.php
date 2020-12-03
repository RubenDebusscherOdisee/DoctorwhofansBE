<?php
class tables_api__characters {
  function getTitle($record){
		return $record->val('character_Id').': '.$record->val('character_First_name').' '.$record->val('character_Last_name');
    }
  function beforeInsert(Dataface_Record $record){
    $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
    if ( $user and !$record->val('character_Owner_Id') ){
        $record->setValue('character_Owner_Id', $user->val('user_Id'));
        $record->setValue('character_Last_modifier', $user->val('user_Id'));


    }
  }
  function beforeUpdate(Dataface_Record $record){
    $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
    if ( $user){
        $record->setValue('character_Last_modifier', $user->val('user_Id'));

    }
  }

  function __import__csv($data, $defaultValues=array()){
    $records = array();
    $rows = explode("\n", $data);
    foreach ( $rows as $row ){
      list($character_First_name,$character_Last_name,$character_Type,$character_Actor_first_name,$character_Actor_last_name) = explode(',', $row);
      
      $record = new Dataface_Record('api__characters', array());            
      $record->setValues($defaultValues);
      $record->setValues(
        array(
          'character_First_name'=>$character_First_name,
          'character_Last_name'=>$character_Last_name,
          'character_Type'=>$character_Type,
          'character_Actor_Id'=>df_get_record('api__actors', array('actor_First_name'=>'='.$character_Actor_first_name, 'actor_Last_name'=>'='.$character_Actor_last_name))->val('actor_Id'),
        )
      );
      $records[] = $record;
    }
    return $records;
  }

  function __import__excel_spreadsheet($data, $defaultValues=array()){
    import(DATAFACE_SITE_PATH."/include/PHPExcel/Classes/PHPExcel.php");
    $records = array();  // the array that will hold the records to be imported.
    $tempdir = DATAFACE_SITE_PATH.'/templates_c';
    $tmpnam = tempnam($tempdir, 'import_excel');
    $handle = fopen($tmpnam,'w');
    fwrite($handle,$data);
    fclose($handle);
    $objReader = PHPExcel_IOFactory::createReader('Excel2007');
    $objReader->setReadDataOnly(true);
    $objPHPExcel = $objReader->load($tmpnam);
    $objWorksheet = $objPHPExcel->getActiveSheet();
    $app = Dataface_Application::getInstance();
    $ligne=2; // starting line for reading cells
    while ($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $ligne)!=""){
      $record = new Dataface_Record('api__characters', array());
      $record->setValues($defaultValues);
      $current_actor_First_Name = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $ligne)->getValue();
      $current_actor_Last_Name = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $ligne)->getValue();

      $current_actor = df_get_record('api__actors', array('actor_First_name'=>'='.$current_actor_First_Name, 'actor_Last_name'=>'='.$current_actor_Last_Name));
      
      if(!$current_actor){
      }else{
        $current_actor_Id = $current_actor->val('actor_Id');
      }
      $record->setValues(
        array(
          'character_First_name'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $ligne)->getValue(),
          'character_Last_name'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $ligne)->getValue(),
          'character_Type'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $ligne)->getValue(),
          'character_Actor_Id'=>$current_actor_Id,
          )
      );
      $records[] =$record;
      $ligne++;
    } 
      // Return our array of records and let Xataface handle the rest.
    return $records;
      
  }

}
?>