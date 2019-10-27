<?php
class tables_alles {
    function __import__csv($data, $defaultValues=array()){
        // build an array of Dataface_Record objects that are to be inserted based
        // on the CSV file data.
        $records = array();
        
        // first split the CSV file into an array of rows.
        $rows = explode("\n", $data);
        foreach ( $rows as $row ){
            // We iterate through the rows and parse the name, phone number, and email 
            // addresses to that they can be stored in a Dataface_Record object.
            list($A_Pagina,$A_Pagina_Type,$A_Type,$A_Waarde,$A_Level,$A_Actief,$A_Taal,$A_Klasse,$A_Hoort_Bij) = explode(',', $row);
            $record = new Dataface_Record('alles', array());
            
            // We insert the default values for the record.
            $record->setValues($defaultValues);
            
            // Now we add the values from the CSV file.
            $record->setValues(
                array(
                    'A_Pagina'=>(int)$A_Pagina,
                    'A_Pagina_Type'=>(int)$A_Pagina_Type,
                    'A_Type'=>(int)$A_Type,
                    'A_Waarde'=>$A_Waarde,
                    'A_Level'=>(int)$A_Level,
                    'A_Actief'=>(int)$A_Actief,
                    'A_Taal'=>(int)$A_Taal,
                    'A_Klasse'=>$A_Klasse,
                    'A_Hoort_Bij'=>(int)$A_Hoort_Bij
                     )
                );
            
            // Now add the record to the output array.
            $records[] = $record;
        }
        
        // Now we return the array of records to be imported.
        return $records;
    }
}
?>