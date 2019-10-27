<?php
class tables_alles {
    function __import__csv($data, $defaultValues=array()){
        $records = array();
        $rows = explode("\n", $data);
        foreach ( $rows as $row ){
            list($A_Pagina,$A_Pagina_Type,$A_Type,$A_Waarde,$A_Level,$A_Actief,$A_Taal,$A_Klasse,$A_Hoort_Bij) = explode(',', $row);
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
                    'A_Taal'=>(int)$A_Taal,
                    'A_Klasse'=>$A_Klasse,
                    'A_Hoort_Bij'=>(int)$A_Hoort_Bij
                     )
                );
            $records[] = $record;
        }
        return $records;
    }
}
?>