<?php
class tables_api__crew {
  function getTitle($record){
		return $record->val('crew_Id').': '.$record->val('crew_First_name').' '.$record->val('crew_Last_name');
    }
  function beforeInsert(Dataface_Record $record){
    $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
    if ( $user and !$record->val('crew_Owner_Id') ){
        $record->setValue('crew_Owner_Id', $user->val('user_Id'));
        $record->setValue('crew_Last_modifier', $user->val('user_Id'));
    }
  }
  function beforeUpdate(Dataface_Record $record){
    $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
    if ( $user){
        $record->setValue('crew_Last_modifier', $user->val('user_Id'));

    }
  }
  function crew_Last_modifier__default(){
    return 0;
  }
  function crew_Owner_Id__default(){
    return 0;
  }
  function __import__csv($data, $defaultValues=array()){
    $records = array();
    $rows = explode("\n", $data);
    foreach ( $rows as $row ){
      list($crew_First_name,$crew_Middle_name,$crew_Last_name,$crew_gender,$crew_Birthdate,$crew_Deathdate,$crew_Type) = explode(',', $row);
      $record = new Dataface_Record('api__crew', array());            
      $record->setValues($defaultValues);
      $record->setValues(
        array(
          'crew_First_name'=>$crew_First_name,
          'crew_Middle_name'=>$crew_Middle_name,
          'crew_Last_name'=>$crew_Last_name,
          'crew_gender'=>$crew_gender,
          'crew_Birthdate'=>$crew_Birthdate,
          'crew_Deathdate'=>$crew_Deathdate,
          'crew_Type'=>$crew_Type
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
      $record = new Dataface_Record('api__crew', array());
      $record->setValues($defaultValues);
      $record->setValues(
        array(
          'crew_First_name'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $ligne)->getValue(),
          'crew_Middle_name'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $ligne)->getValue(),
          'crew_Last_name'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $ligne)->getValue(),
          'crew_gender'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $ligne)->getValue(),
          'crew_Birthdate'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $ligne)->getValue(),
          'crew_Deathdate'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $ligne)->getValue(),
          'crew_Type'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $ligne)->getValue()

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