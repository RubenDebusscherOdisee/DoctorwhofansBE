<?php
class tables_api__episodes {
  function getTitle($record){
		return $record->val('episode_Id').': '.$record->val('episode_Title');
    }
  function beforeInsert(Dataface_Record $record){
    $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
    if ( $user and !$record->val('episode_Owner_Id') ){
        $record->setValue('episode_Owner_Id', $user->val('user_Id'));
        $record->setValue('episode_Last_modifier', $user->val('user_Id'));


    }
  }
  function beforeUpdate(Dataface_Record $record){
    $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
    if ( $user){
        $record->setValue('episode_Last_modifier', $user->val('user_Id'));

    }
  }


  function episode_UK_viewers__display(&$record){
    return number_format($record->val('episode_UK_viewers'),0,',', '.');
  }

  function episode_Runtime_in_seconds__display(&$record){
    $time = $record->val('episode_Runtime_in_seconds'); // time duration in seconds

    $days = floor($time / (60 * 60 * 24));
    $time -= $days * (60 * 60 * 24);

    $hours = floor($time / (60 * 60));
    $time -= $hours * (60 * 60);

    $minutes = floor($time / 60);
    $time -= $minutes * 60;

    $seconds = floor($time);
    $time -= $seconds;

    $formatted_time = "{$days}d {$hours}h {$minutes}m {$seconds}s"; // 1d 6h 50m 31s

    return $record->val('episode_Runtime_in_seconds').'sec. ('.$formatted_time.')';
  }

  

  function __import__csv($data, $defaultValues=array()){
    $records = array();
    $rows = explode("\n", $data);
    foreach ( $rows as $row ){
      list(
        $episode_Title,
        $episode_Serial,
        $episode_Story,
        $episode_Order,
        $episode_Original_airdate,
        $episode_Runtime_in_seconds,
        $episode_UK_viewers,
        $episode_Appreciation_index,
        $episode_Recreated,
        $episode_Synopsis
        ) = explode(',', $row);
      $serial_Id= df_get_record('api__serials', array('serial_Title'=>'='.$episode_Serial))->val('serial_Id');
      $record = new Dataface_Record('api__episodes', array());
      $record->setValues($defaultValues);
      $record->setValues(
        array(
          'episode_Title'=>$episode_Title,
          'episode_Serial_Id'=>$serial_Id,
          'episode_Story'=>$episode_Story,
          'episode_Order'=>$episode_Order,
          'episode_Original_airdate'=>$episode_Original_airdate,
          'episode_Runtime_in_seconds'=>$episode_Runtime_in_seconds,
          'episode_UK_viewers'=>$episode_UK_viewers,
          'episode_Appreciation_index'=>$episode_Appreciation_index,
          'episode_Recreated'=>$episode_Recreated,
          'episode_Synopsis'=>$episode_Synopsis
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

      $record = new Dataface_Record('api__episodes', array());
      $record->setValues($defaultValues);
      $record->setValues(
        array(
          'episode_Title'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $ligne)->getValue(),
          'episode_Serial_Id'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $ligne)->getValue(),
          'episode_Story'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $ligne)->getValue(),
          'episode_Order'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $ligne)->getValue(),
          'episode_Original_airdate'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $ligne)->getValue(),
          'episode_Runtime_in_seconds'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $ligne)->getValue(),
          'episode_UK_viewers'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $ligne)->getValue(),
          'episode_Appreciation_index'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $ligne)->getValue(),
          'episode_Recreated'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(9, $ligne)->getValue(),
          'episode_Synopsis'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(10, $ligne)->getValue()
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