<?php

class tables_items_talen {

    
    
    function __import__csv($data, $defaultValues=array()){
        $records = array();
        $rows = explode("\n", $data);
        foreach ( $rows as $row ){
            list($Item_id,$Taal_id) = explode(',', $row);
            $record = new Dataface_Record('items_talen', array());            
            $record->setValues($defaultValues);
            $record->setValues(
                array(
                    'item_id'=>(int)$Item_id,
                    'taal_id'=>(int)$Taal_id
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
			
			$record = new Dataface_Record('items_talen', array());
			
			// Start out with the default values and build from there.
            $record->setValues($defaultValues);
			
			$record->setValues(
                array(
                    'item_id'=>(int)$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $ligne)->getValue(),
                    'taal_id'=>(int)$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $ligne)->getValue(),
                    
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