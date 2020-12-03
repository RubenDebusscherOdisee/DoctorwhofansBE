<?php
  class tables_management__pagetypes {
    function beforeInsert(Dataface_Record $record){
      $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
      if ( $user and !$record->val('pagetype_Owner_Id') ){
          $record->setValue('pagetype_Owner_Id', $user->val('user_Id'));
          $record->setValue('pagetype_Last_modifier', $user->val('user_Id'));
      }
    }
    function beforeUpdate(Dataface_Record $record){
      $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
      if ( $user){
          $record->setValue('pagetype_Last_modifier', $user->val('user_Id'));

      }
    }
    function pagetype_Last_modifier__default(){
      return 0;
    }
    function pagetype_Owner_Id__default(){
      return 0;
    }
    function __import__csv($data, $defaultValues=array()){
      $records = array();
      $rows = explode("\n", $data);
      foreach ( $rows as $row ){
        list($pagetype_Name,$pagetype_Description) = explode(',', $row);
        $record = new Dataface_Record('management__pagetypes', array());
        $record->setValues($defaultValues);
        $record->setValues(
          array(
            'pagetype_Name'=>$pagetype_Name,
            'pagetype_Description'=>$pagetype_Description
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
        $record = new Dataface_Record('management__pagetypes', array());
        $record->setValues($defaultValues);
        $record->setValues(
          array(
            'pagetype_Name'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $ligne)->getValue(),
            'pagetype_Description'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $ligne)->getValue(),
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
