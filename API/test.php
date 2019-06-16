<?php
include 'core/connect.php';
    $result = mysqli_query("SELECT * FROM serials",$conn); 
    $json_response = array(); //Create an array
    while ($row = mysql_fetch_array($result))
    {
        $row_array = array();
        $row_array['id'] = $row['id'];        
        $row_array['Title'] = $row['title'];
        $row_array['Doctors'] = array();
        $Serial_id = $row['id'];  

        $option_qry = mysqli_query("SELECT * FROM serials_doctors WHERE serial_id=$Serial_id",$conn);
        while ($opt_fet = mysql_fetch_array($option_qry))
        {
            $row_array['Doctors'][] = array(
                'Doctors' => $opt_fet['Doctor_id'],
            );

        }
        array_push($json_response, $row_array); //push the values in the array
    }
    echo json_encode($json_response);

?>    