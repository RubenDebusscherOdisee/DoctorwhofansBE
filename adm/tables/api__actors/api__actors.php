<?php
class tables_api__actors {


  function getTitle($record){
		return $record->val('actor_Id').': '.$record->val('actor_First_name').' '.$record->val('actor_Last_name');
    }
  function beforeInsert(Dataface_Record $record){
    $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
    if ( $user and !$record->val('actor_Owner_Id') ){
        $record->setValue('actor_Owner_Id', $user->val('user_Id'));
        $record->setValue('actor_Last_modifier', $user->val('user_Id'));
    }
  }
  function beforeUpdate(Dataface_Record $record){
    $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
    if ( $user){
        $record->setValue('actor_Last_modifier', $user->val('user_Id'));

    }
  }
  function actor_Last_modifier__default(){
    return 0;
  }
  function actor_Owner_Id__default(){
    return 0;
  }
  function __import__csv($data, $defaultValues=array()){
    $records = array();
    $rows = explode("\n", $data);
    foreach ( $rows as $row ){
      list($actor_First_name,$actor_Last_name,$actor_gender,$actor_Birthdate,$actor_Deathdate) = explode(',', $row);
      $record = new Dataface_Record('api__actors', array());
      $record->setValues($defaultValues);
      $record->setValues(
        array(
          'actor_First_name'=>$actor_First_name,
          'actor_Last_name'=>$actor_Last_name,
          'actor_gender'=>$actor_gender,
          'actor_Birthdate'=>$actor_Birthdate,
          'actor_Deathdate'=>$actor_Deathdate
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
      $record = new Dataface_Record('api__actors', array());
      $record->setValues($defaultValues);
      $record->setValues(
        array(
          'actor_First_name'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $ligne)->getValue(),
          'actor_Last_name'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $ligne)->getValue(),
          'actor_gender'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $ligne)->getValue(),
          'actor_Birthdate'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $ligne)->getValue(),
          'actor_Deathdate'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $ligne)->getValue()
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