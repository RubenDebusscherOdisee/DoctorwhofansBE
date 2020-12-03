<?php
class tables_api__doctors {
  function getTitle($record){
		return $record->val('doctor_id').': '.$record->val('doctor_Incarnation');
    }
  function beforeInsert(Dataface_Record $record){
    $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
    if ( $user and !$record->val('doctor_Owner_Id') ){
        $record->setValue('doctor_Owner_Id', $user->val('user_Id'));
        $record->setValue('doctor_Last_modifier', $user->val('user_Id'));


    }
  }
  function beforeUpdate(Dataface_Record $record){
    $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
    if ( $user){
        $record->setValue('doctor_Last_modifier', $user->val('user_Id'));

    }
  }

  function __import__csv($data, $defaultValues=array()){
    $records = array();
    $rows = explode("\n", $data);
    foreach ( $rows as $row ){
      list($doctor_Incarnation,$doctor_Order,$doctor_Actor_first_name,$doctor_Actor_last_name,$doctor_Page_Id) = explode(',', $row);
      $record = new Dataface_Record('api__doctors', array());
      $record->setValues($defaultValues);
      $record->setValues(
        array(
          'doctor_Incarnation'=>$doctor_Incarnation,
          'doctor_Order'=>$doctor_Order,
          'doctor_Actor_Id'=>df_get_record('api__actors', array('actor_First_name'=>'='.$doctor_Actor_first_name, 'actor_Last_name'=>'='.$doctor_Actor_last_name))->val('actor_Id'),
          //'doctor_Page_Id'=>$doctor_Page_Id
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
      $record = new Dataface_Record('api__doctors', array());
      $record->setValues($defaultValues);
      $current_actor_First_Name = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $ligne)->getValue();
      $current_actor_Last_Name = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $ligne)->getValue();

      $current_actor = df_get_record('api__actors', array('actor_First_name'=>'='.$current_actor_First_Name, 'actor_Last_name'=>'='.$current_actor_Last_Name));
      
      if(!$current_actor){
      }else{
        $current_actor_Id = $current_actor->val('actor_Id');
      }
      $record->setValues(
        array(
          'doctor_Incarnation'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $ligne)->getValue(),
          'doctor_Order'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $ligne)->getValue(),
          'doctor_Actor_Id'=>$current_actor_Id,
          //'doctor_Page_Id'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $ligne)->getValue()
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