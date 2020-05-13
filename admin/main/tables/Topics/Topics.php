<?

class tables_Topics{

	function getTitle(&$record){
		return $record->val('link').' : '.$record->val('topic');
	}

    function getChildren(&$record){
        return df_get_records('Topics', array('parent_id'=>'='.$record->val('id')));
    }
    function afterSave(&$record){

        //if(count(getChildren($record))<=0){
          // return df_q("UPDATE Topics SET Uitklapbaar=0 WHERE id='".$record->val('parent_id')."'");
        //}else if(count(getChildren($record))>0){
            return df_q("UPDATE Topics SET Uitklapbaar=1 WHERE id='".$record->val('parent_id')."'");
        //}else{
            //return PEAR::raiseError("Errors occurred while updating parent.  Parent could not be updated", DATAFACE_E_NOTICE);
      //  }
    }

    

    
    
	function __import__csv($data, $defaultValues=array()){
        $records = array();
        $rows = explode("\n", $data);
        foreach ( $rows as $row ){
            list($Topic,$Parent_id,$Link,$MagEditeren,$Uitklapbaar,$Actief,$Episode_Order) = explode(',', $row);
            $record = new Dataface_Record('Topics', array());            
            $record->setValues($defaultValues);
            $record->setValues(
                array(
                    'topic'=>$Topic,
                    'parent_id'=>(int)$Parent_id,
                    'link'=>$$Link,
                    'MagEditeren'=>$MagEditeren,
                    'Uitklapbaar'=>(int)$Uitklapbaar,
                    'Actief'=>(int)$Actief,
                    'Episode_Order'=>$Episode_Order
                     )
                );
            $records[] = $record;
        }
        return $records;
	}
    function __import__excel_spreadsheet($data, $defaultValues=array()){
        import(DATAFACE_SITE_PATH."/include/PHPExcel/Classes/PHPExcel.php");
        $records = array();  // the array that will hold the records to be imported.
            
        // First let's import the excel parser and parse the data into a 
        // data structure so we can work with it.
        $tempdir = DATAFACE_SITE_PATH.'/templates_c';
        $tmpnam = tempnam($tempdir, 'import_excel');
        $handle = fopen($tmpnam,'w');
        fwrite($handle,$data);
        fclose($handle);

        //PHPexcel parser		
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($tmpnam);
        $objWorksheet = $objPHPExcel->getActiveSheet();
          
        $app = Dataface_Application::getInstance();

		$ligne=2; // starting line for reading cells
		while ($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $ligne)!=""){
			
			$record = new Dataface_Record('Topics', array());
			
			// Start out with the default values and build from there.
            $record->setValues($defaultValues);
			
			$record->setValues(
                array(
                    'topic'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $ligne)->getValue(),
                    'parent_id'=>(int)$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $ligne)->getValue(),
                    'link'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $ligne)->getValue(),
                    'MagEditeren'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $ligne)->getValue(),
                    'Uitklapbaar'=>(int)$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $ligne)->getValue(),
                    'Actief'=>(int)$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $ligne)->getValue(),
                    'Episode_Order'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $ligne)->getValue()
                        )
                );
                $records[] =$record;
                
                //unset($record);  // necessary to prevent PHP from writing over the last record
				
				$ligne++;
        } 
		 
       // Return our array of records and let Xataface handle the rest.
        return $records;
        
    }
}

?>