<?php
  class tables_management__pages {
    function getTitle($record){
      return $record->val('page_Id').': '.$record->val('page_Name').': '.$record->val('page_Link');
      }
    function beforeInsert(Dataface_Record $record){
      $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
      if ( $user and !$record->val('page_Owner_Id') ){
          $record->setValue('page_Owner_Id', $user->val('user_Id'));
          $record->setValue('page_Last_modifier', $user->val('user_Id'));
      }
    }
    function beforeUpdate(Dataface_Record $record){
      $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
      if ( $user){
          $record->setValue('page_Last_modifier', $user->val('user_Id'));

      }
    }
    function page_Last_modifier__default(){
      return 0;
    }
    function page_Owner_Id__default(){
      return 0;
    }
    function __import__csv($data, $defaultValues=array()){
      $records = array();
      $rows = explode("\n", $data);
      foreach ( $rows as $row ){
        list($page_name,$page_link,$page_parent_id,$page_active,$page_order) = explode(',', $row);
        $record = new Dataface_Record('management__pages', array());
        $record->setValues($defaultValues);
        $record->setValues(
          array(
            'page_Name'=>$page_name,
            'page_Parent_Id'=>$page_parent_id,
            'page_Link'=>$page_link,
            'page_Active'=>$page_active,
            'page_Order'=>$page_order
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
        $record = new Dataface_Record('management__pages', array());
        $record->setValues($defaultValues);
        $record->setValues(
          array(
            'page_Name'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $ligne)->getValue(),
            'page_Parent_Id'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $ligne)->getValue(),
            'page_Link'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $ligne)->getValue(),
            'page_Active'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $ligne)->getValue(),
            'page_Order'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $ligne)->getValue()
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
