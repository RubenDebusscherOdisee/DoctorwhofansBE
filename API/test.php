<?php
$resultset = [
    ["id" => "1", "cityId" => "1", "cityName" => "Bengaluru", "runId" => "2", "distance" => "10k", "status" => "1"],
    ["id" => "2", "cityId" => "1", "cityName" => "Bengaluru", "runId" => "1", "distance" => "5k", "status" => "1"],
    ["id" => "3", "cityId" => "1", "cityName" => "Bengaluru", "runId" => "5", "distance" => "3k", "status" => "0"],
    ["id" => "4", "cityId" => "2", "cityName" => "Chennai", "runId" => "1", "distance" => "5k", "status" => "1"],
    ["id" => "5", "cityId" => "2", "cityName" => "Chennai", "runId" => "2", "distance" => "10k", "status" => "1"],
    ["id" => "6", "cityId" => "2", "cityName" => "Chennai", "runId" => "4", "distance" => "15k", "status" => "1"]
];

foreach ($resultset as $row) {
    if (!isset($result[$row["cityId"]])) {
        $result[$row["cityId"]] = array("cityId" => $row["cityId"], $row["cityName"] => array(array("id" => $row["id"])+array_slice($row,-3)));
    } else {
        $result[$row['cityId']][$row["cityName"]][] = array("id" => $row["id"])+array_slice($row,-3);
    }
}

if (!isset($result)) {   // don't need to check rowCount() at all
    $result = 'Runs not found';
} else {
    $result = array_values($result);
}

$result = array("status" => true, "runsBasedOnCity" => $result);
var_export(json_encode($result, JSON_PRETTY_PRINT));

?>    