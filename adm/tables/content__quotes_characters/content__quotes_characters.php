<?php
class tables_content__quotes_characters {
  
  function beforeInsert(Dataface_Record $record){
    $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
    if ( $user and !$record->val('QC_Owner_Id') ){
        $record->setValue('QC_Owner_Id', $user->val('user_Id'));
        $record->setValue('QC_Last_modifier', $user->val('user_Id'));


    }
  }
  function beforeUpdate(Dataface_Record $record){
    $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
    if ( $user){
        $record->setValue('QC_Last_modifier', $user->val('user_Id'));

    }
  }

  function __import__csv($data, $defaultValues=array()){
    $records = array();
    $rows = explode("\n", $data);
    foreach ( $rows as $row ){
      list($Character_Id,$Quote_Id,) = explode(',', $row);
      $record = new Dataface_Record('content__quotes_characters', array());
      $record->setValues($defaultValues);

      $record->setValues(
        array(
          'QC_Character_Id'=>$Character_Id,
          'QC_Quote_Id'=>$Quote_Id
        )
      );
      $records[] = $record;
    }
    return $records;
  }

  function __import__excel_spreadsheet($data, $defaultValues=array()){
    import(DATAFACE_SITE_PATH."/include/PHPExcel/Classes/PHPExcel.php");
    $records = array();  // the array that wQCl hold the records to be imported.
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
      $record = new Dataface_Record('content__quotes_characters', array());
      $record->setValues($defaultValues);
      $record->setValues(
        array(
          'QC_Character_Id'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $ligne)->getValue(),
          'QC_Quote_Id'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $ligne)->getValue(),

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