<?php
  class tables_management__types {
    function beforeInsert(Dataface_Record $record){
      $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
      if ( $user and !$record->val('type_Owner_Id') ){
          $record->setValue('type_Owner_Id', $user->val('user_Id'));
          $record->setValue('type_Last_modifier', $user->val('user_Id'));
      }
    }
    function beforeUpdate(Dataface_Record $record){
      $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
      if ( $user){
          $record->setValue('type_Last_modifier', $user->val('user_Id'));

      }
    }
    function type_Last_modifier__default(){
      return 0;
    }
    function type_Owner_Id__default(){
      return 0;
    }
    function __import__csv($data, $defaultValues=array()){
      $records = array();
      $rows = explode("\n", $data);
      foreach ( $rows as $row ){
        list($type_Name,$type_Description,$type_Default_Level) = explode(',', $row);
        $record = new Dataface_Record('management__types', array());
        $record->setValues($defaultValues);
        $record->setValues(
          array(
            'type_Name'=>$type_Name,
            'type_Description'=>$type_Description,
            'type_Default_Level'=>$type_Default_Level
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
        $record = new Dataface_Record('management__types', array());
        $record->setValues($defaultValues);
        $record->setValues(
          array(
            'type_Name'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $ligne)->getValue(),
            'type_Description'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $ligne)->getValue(),
            'type_Default_Level'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $ligne)->getValue()
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
