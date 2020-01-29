<?php

class tables_alles {

    function getTitle($record){
		return mb_substr($record->val('A_Waarde'),0,40).'...';
    }

    function css__tableRowClass( $record ){
        if ( $record->val('A_Actief') == 1 ) return 'active-row';
        else return 'dormant-row';
    }
    
    function __import__csv($data, $defaultValues=array()){
        $records = array();
        $rows = explode("\n", $data);
        foreach ( $rows as $row ){
            list($A_Pagina,$A_Pagina_Type,$A_Type,$A_Waarde,$A_Level,$A_Actief,$A_Klasse,$A_Hoort_Bij) = explode(',', $row);
            $record = new Dataface_Record('alles', array());            
            $record->setValues($defaultValues);
            $record->setValues(
                array(
                    'A_Pagina'=>(int)$A_Pagina,
                    'A_Pagina_Type'=>(int)$A_Pagina_Type,
                    'A_Type'=>(int)$A_Type,
                    'A_Waarde'=>$A_Waarde,
                    'A_Level'=>(int)$A_Level,
                    'A_Actief'=>(int)$A_Actief,
                    'A_Klasse'=>$A_Klasse,
                    'A_Hoort_Bij'=>(int)$A_Hoort_Bij
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
			
			$record = new Dataface_Record('alles', array());
			
			// Start out with the default values and build from there.
            $record->setValues($defaultValues);
			
			$record->setValues(
                array(
                    'A_Pagina'=>(int)$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $ligne)->getValue(),
                    'A_Pagina_Type'=>(int)$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $ligne)->getValue(),
                    'A_Type'=>(int)$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $ligne)->getValue(),
                    'A_Waarde'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $ligne)->getValue(),
                    'A_Level'=>(int)$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $ligne)->getValue(),
                    'A_Actief'=>(int)$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $ligne)->getValue(),
                    'A_Klasse'=>$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $ligne)->getValue(),
                    'A_Hoort_Bij'=>(int)$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $ligne)->getValue(),
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