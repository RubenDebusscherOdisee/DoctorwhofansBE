<?php
class tables_api__serials {
  function getTitle($record){
		return $record->val('serial_Id').': '.$record->val('serial_Title');
    }
  function beforeInsert(Dataface_Record $record){
    $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
    if ( $user and !$record->val('serial_Owner_Id') ){
        $record->setValue('serial_Owner_Id', $user->val('user_Id'));
        $record->setValue('serial_Last_modifier', $user->val('user_Id'));
    }
  }
  function beforeUpdate(Dataface_Record $record){
    $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
    if ( $user){
        $record->setValue('serial_Last_modifier', $user->val('user_Id'));
    }
  }
  function __import__csv($data, $defaultValues=array()){
    $records = array();
    $rows = explode("\n", $data);
    foreach ( $rows as $row ){
      list($serial_Story,$serial_Order,$serial_Title,$serial_Production_code) = explode(',', $row);
      $record = new Dataface_Record('api__serials', array());
      $record->setValues($defaultValues);
      $record->setValues(
        array(
          'serial_Story'=>$serial_Story,
          'serial_Order'=>$serial_Order,
          'serial_Title'=>$serial_Title,
          'serial_Production_code'=>$serial_Production_code,
          'serial_Image'=>''
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
      $record = new Dataface_Record('api__serials', array());
      $record->setValues($defaultValues);
      $record->setValues(
        array(
          'serial_Story'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $ligne)->getValue(),
          'serial_Order'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $ligne)->getValue(),
          'serial_Title'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $ligne)->getValue(),
          'serial_Production_code'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $ligne)->getValue()

          )
      );
      $records[] =$record;
      $ligne++;
    }
      // Return our array of records and let Xataface handle the rest.
      return $records;
  }

  function Crew__addTag($record, $value){
    list($first,$last) = explode(' ', $value);

    $rec = new Dataface_Record('api__crew', array());
    $rec->setValues(array(
      'crew_First_name'=>$first,
      'crew_Last_name'=>$last
    ));
    return $rec;
  }
  function Characters__addTag($record, $value){
    list($first,$last) = explode(' ', $value);
    $rec = new Dataface_Record('api__characters', array());
    $rec->setValues(array(
      'character_First_name'=>$first,
      'character_Last_name'=>$last
    ));
    return $rec;
  }
}
?>