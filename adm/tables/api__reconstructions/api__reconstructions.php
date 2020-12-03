<?php
class tables_api__reconstructions {
  function getTitle($record){
		return $record->val('reconstruction_Id').': '.$record->val('reconstruction_Name');
    }
  function beforeInsert(Dataface_Record $record){
    $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
    if ( $user and !$record->val('reconstruction_Owner_Id') ){
        $record->setValue('reconstruction_Owner_Id', $user->val('user_Id'));
        $record->setValue('reconstruction_Last_modifier', $user->val('user_Id'));
    }
  }
  function beforeUpdate(Dataface_Record $record){
    $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
    if ( $user){
        $record->setValue('reconstruction_Last_modifier', $user->val('user_Id'));
    }
  }

  function __import__csv($data, $defaultValues=array()){
    $records = array();
    $rows = explode("\n", $data);
    foreach ( $rows as $row ){
      list($reconstruction_Name,$reconstruction_Show,$reconstruction_order) = explode(',', $row);
      $SHOW = df_get_record('api__shows', array('show_Name'=>$reconstruction_Show));
      $record = new Dataface_Record('api__reconstructions', array());
      $record->setValues($defaultValues);
      $record->setValues(
        array(
          'reconstruction_Name'=>$reconstruction_Name,
          'reconstruction_Order'=>$reconstruction_order,
          'reconstruction_Show_Id'=>$SHOW->val('show_Id')
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
      $reconstruction_Show = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $ligne)->getValue();
      $SHOW = df_get_record('api__shows', array('show_Name'=>$reconstruction_Show));
      $show_Id = $SHOW->val('show_Id');
      $record = new Dataface_Record('api__reconstructions', array());
      $record->setValues($defaultValues);
      $record->setValues(
        array(
          'reconstruction_Name'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $ligne)->getValue(),
          'reconstruction_Order'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $ligne)->getValue(),
          'reconstruction_Show_Id '=>$show_Id
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