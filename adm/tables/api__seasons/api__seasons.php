<?php
class tables_api__seasons {
  function getTitle($record){
		return $record->val('season_Id').': '.$record->val('season_Name');
    }
  function beforeInsert(Dataface_Record $record){
    $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
    if ( $user and !$record->val('season_Owner_Id') ){
        $record->setValue('season_Owner_Id', $user->val('user_Id'));
        $record->setValue('season_Last_modifier', $user->val('user_Id'));


    }
  }
  function beforeUpdate(Dataface_Record $record){
    $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
    if ( $user){
        $record->setValue('season_Last_modifier', $user->val('user_Id'));

    }
  }

  function __import__csv($data, $defaultValues=array()){
    $records = array();
    $rows = explode("\n", $data);
    foreach ( $rows as $row ){
      list($season_Name,$season_Show,$season_order) = explode(',', $row);
      $SHOW = df_get_record('api__shows', array('show_Name'=>$season_Show));
      $record = new Dataface_Record('api__seasons', array());
      $record->setValues($defaultValues);

      $record->setValues(
        array(
          'season_Name'=>$season_Name,
          'season_Order'=>$season_order,
          'season_Show_Id'=>$SHOW->val('show_Id')
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
      $season_Show = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $ligne)->getValue();
      $SHOW = df_get_record('api__shows', array('show_Name'=>$season_Show));
      $show_Id = $SHOW->val('show_Id');
      $record = new Dataface_Record('api__seasons', array());
      $record->setValues($defaultValues);
      $record->setValues(
        array(
          'season_Name'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $ligne)->getValue(),
          'season_Order'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $ligne)->getValue(),
          'season_Show_Id '=>$show_Id
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