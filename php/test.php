<?
function makeSQL_search_pattern($search) {
    $search_pattern = false;
    //escape the special regex chars
    $search = str_replace('"', "''", $search);
    $search = str_replace('^', "\\^", $search);
    $search = str_replace('$', "\\$", $search);
    $search = str_replace('.', "\\.", $search);
    $search = str_replace('[', "\\[", $search);
    $search = str_replace(']', "\\]", $search);
    $search = str_replace('|', "\\|", $search);
    $search = str_replace('*', "\\*", $search);
    $search = str_replace('+', "\\+", $search);
    $search = str_replace('{', "\\{", $search);
    $search = str_replace('}', "\\}", $search);
    $search = explode(" ", $search);
    for ($i = 0; $i < count($search); $i++) {
        if ($i > 0 && $i < count($search) ) {
           $search_pattern .= "|";
        }
        $search_pattern .= $search[$i];
    }
    return $search_pattern;
}

echo makeSQL_search_pattern($_GET['search']);


?>