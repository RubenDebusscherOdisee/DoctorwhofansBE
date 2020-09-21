<?php
/*
 * Function requested by Ajax
 */
require("cors.php");
    //open connection
	require("connect.php");
    //check if there is any error in the connection, if so --> die
	if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
if(isset($_POST['func']) && !empty($_POST['func'])){
    switch($_POST['func']){
        case 'getCalender':
            getCalender($_POST['year'],$_POST['month']);
            break;
        case 'getEvents':
            getEvents($_POST['date']);
            break;
        default:
            break;
    }
}

/*
 * Get calendar full HTML
 */
function getCalender($year = '',$month = ''){
    $dateYear = ($year != '')?$year:date("Y");
    $dateMonth = ($month != '')?$month:date("m");
    $date = $dateYear.'-'.$dateMonth.'-01';
    $currentMonthFirstDay = date("N",strtotime($date));
    $totalDaysOfMonth = cal_days_in_month(CAL_GREGORIAN,$dateMonth,$dateYear);
    $totalDaysOfMonthDisplay = ($currentMonthFirstDay == 7)?($totalDaysOfMonth):($totalDaysOfMonth + $currentMonthFirstDay);
    $boxDisplay = ($totalDaysOfMonthDisplay <= 35)?35:42;
?>
    <div id="calender_section">
        <h2>
            <a href="javascript:void(0);" onclick="getCalendar('calendar_div','<?php echo date("Y",strtotime($date.' - 1 Month')); ?>','<?php echo date("m",strtotime($date.' - 1 Month')); ?>');">&lt;&lt;</a>&nbsp;
            <select name="month_dropdown" class="month_dropdown dropdown"><?php echo getAllMonths($dateMonth); ?></select>
            <select name="year_dropdown" class="year_dropdown dropdown"><?php echo getYearList($dateYear); ?></select>&nbsp;
            <a href="javascript:void(0);" onclick="getCalendar('calendar_div','<?php echo date("Y"); ?>','<?php echo date("m"); ?>');">Vandaag</a>&nbsp;
            <a href="javascript:void(0);" onclick="getCalendar('calendar_div','<?php echo date("Y",strtotime($date.' + 1 Month')); ?>','<?php echo date("m",strtotime($date.' + 1 Month')); ?>');">&gt;&gt;</a>
        </h2>
        <div id="event_list" class="none"></div>
        <div id="calender_section_top">
            <ul>
                <li>Maandag</li>
                <li>Dinsdag</li>
                <li>Woensdag</li>
                <li>Donderdag</li>
                <li>Vrijdag</li>
                <li>Zaterdag</li>
                <li>Zondag</li>

            </ul>
        </div>
        <div id="calender_section_bot">
            <ul>
            <?php 
                $dayCount = 1; 
                for($cb=2;$cb<=$boxDisplay;$cb++){
                    if(($cb >= $currentMonthFirstDay+1 || $currentMonthFirstDay == 7) && $cb <= ($totalDaysOfMonthDisplay)){
                        //Current date
                        $currentDate = $dateYear.'-'.$dateMonth.'-'.$dayCount;
                        $currentBirthDay = '-'.$dateMonth.'-'.$dayCount;
                        $eventNum = 0;
                        //Include db configuration file
                        include 'dbConfig.php';
                        //Get number of events based on the current date
                        $result = $db->query("SELECT title FROM events WHERE event_date = '".$currentDate."' AND status = 1 union select title from birthdays where birthday_date like '%".$currentBirthDay."' and status=1");
                        $eventNum = $result->num_rows;
                        //Define date cell color
                        if(strtotime($currentDate) == strtotime(date("Y-m-d"))){
                            echo '<li date="'.$currentDate.'" class="Today date_cell">';
                        }elseif($eventNum > 0){
                            echo '<li date="'.$currentDate.'" class="hasEvent date_cell" onclick="getEvents(\''.$currentDate.'\');">';
                        }else{
                            echo '<li date="'.$currentDate.'" class="date_cell">';
                        }
                        //Date cell
                        echo '<span>';
                        echo $dayCount;
                        if($eventNum >0){
                            echo ' ('.$eventNum.')</span>';
                        }else{
                            echo '</span>';
                        }
                        //Hover event popup
                       
                        
                        echo '</li>';
                        $dayCount++;
            ?>
            <?php }else{ ?>
                <li><span>&nbsp;</span></li>
            <?php } } ?>
            </ul>
        </div>
    </div>

    <script type="text/javascript">
        function getCalendar(target_div,year,month){
            $.ajax({
                type:'POST',
                url:'https://www.doctorwhofans.be/php/functions.php',
                data:'func=getCalender&year='+year+'&month='+month,
                success:function(html){
                    $('#'+target_div).html(html);
                }
            });
        }
        
        function getEvents(date){
            $.ajax({
                type:'POST',
                url:'https://www.doctorwhofans.be/php/functions.php',
                data:'func=getEvents&date='+date,
                success:function(html){
                    $('#event_list').html(html);
                    $('#event_list').slideDown('slow');
                }
            });
        }
        
        function addEvent(date){
            $.ajax({
                type:'POST',
                url:'https://www.doctorwhofans.be/php/functions.php',
                data:'func=addEvent&date='+date,
                success:function(html){
                    $('#event_list').html(html);
                    $('#event_list').slideDown('slow');
                }
            });
        }
        
        $(document).ready(function(){
            $('.date_cell').mouseenter(function(){
                date = $(this).attr('date');
                $("#date_popup_"+date).fadeIn();    
            });
            $('.date_cell').mouseleave(function(){
            });
            $('.month_dropdown').on('change',function(){
                getCalendar('calendar_div',$('.year_dropdown').val(),$('.month_dropdown').val());
            });
            $('.year_dropdown').on('change',function(){
                getCalendar('calendar_div',$('.year_dropdown').val(),$('.month_dropdown').val());
            });
            $(document).click(function(){
                $('#event_list').slideUp('slow');
            });
        });
    </script>
<?php
}

/*
 * Get months options list.
 */
function getAllMonths($selected = ''){
    $options = '';
    for($i=1;$i<=12;$i++)
    {
        $value = ($i < 10)?'0'.$i:$i;
        $selectedOpt = ($value == $selected)?'selected':'';
        $options .= '<option value="'.$value.'" '.$selectedOpt.' >'.date("F", mktime(0, 0, 0, $i+1, 0, 0)).'</option>';
    }
    return $options;
}

/*
 * Get years options list.
 */
function getYearList($selected = ''){
    $options = '';
    for($i=1963;$i<=2055;$i++)
    {
        $selectedOpt = ($i == $selected)?'selected':'';
        $options .= '<option value="'.$i.'" '.$selectedOpt.' >'.$i.'</option>';
    }
    return $options;
}

/*
 * Get events by date
 */
function getEvents($date = ''){
    //Include db configuration file
    include 'dbConfig.php';
    $eventListHTML = '';
    $date = $date?$date:date("Y-m-d");
    $birthDay = $date?$date:date("m-d");
    $birthDay= substr($birthDay, 4);
    //Get events based on the current date
    $result = $db->query("SELECT title FROM events WHERE event_date = '".$date."' AND status = 1 union select  concat(title,' (',TIMESTAMPDIFF(year,birthday_date , curdate()),' - ',extract(year from birthday_date),')')  as title from birthdays where birthday_date like '%".$birthDay."' and status=1");
    if($result->num_rows > 0){
        $eventListHTML = '<h2 style="background-color:white;">Events on '.date("l, d M Y",strtotime($date)).'</h2>';
        $eventListHTML .= '<ul>';
        while($row = $result->fetch_assoc()){ 
            $eventListHTML .= '<li>'.$row['title'].'</li>';
        }
        $eventListHTML .= '</ul>';
    }
    echo $eventListHTML;
}


function fetchCategoryTree($parent = 0, $spacing = '', $user_tree_array = '') {
    //open connection
	require("connect.php");
    //check if there is any error in the connection, if so --> die
	if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
  if (!is_array($user_tree_array))
    $user_tree_array = array();

  $sql = "SELECT `id`, `topic`, `parent_id` FROM `Topics` WHERE `parent_id` = $parent ORDER BY id ASC";
  $query = mysqli_query($conn,$sql);
  if (is_bool(mysqli_num_rows($query)) === false) {
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_object($query)) {
          $user_tree_array[] = array("id" => $row->id, "name" => $spacing .$row->id.": ". $row->topic);
          $user_tree_array = fetchCategoryTree($row->id, $spacing . '&nbsp;&nbsp;', $user_tree_array);
        }
    }
}
  return $user_tree_array;
}

function fetchCategoryTreeList($parent = 0, $user_tree_array = '') {

    //open connection
	require("connect.php");
    //check if there is any error in the connection, if so --> die
	if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if (!is_array($user_tree_array))
    $user_tree_array = array();

  $sql = "SELECT `id`, `topic`, `parent_id`,`link`,`Uitklapbaar` FROM `Topics` WHERE `parent_id` = $parent and Actief=1 ORDER BY Uitklapbaar desc,Episode_Order asc,topic asc,id ASC";
  $query = mysqli_query($conn,$sql);
  if (mysqli_num_rows($query) > 0) {
     $user_tree_array[] = "<ul class='itemsSitemap'>";
    while ($row = mysqli_fetch_object($query)) {
        if($row->Uitklapbaar ==1){
           $user_tree_array[] = "<li class='item parent'><button class='SitemapButton'>+</button><a href ='/".$row->link."/' class='link'>". $row->topic."</a></li>"; 
        }else{
            if($row->topic =="Forum"){
                $user_tree_array[] = "<li><a href ='https://forum.doctorwhofans.be' class='link' style='margin-left:2.3em;'>". $row->topic."</a></li>";
            }else{
                $user_tree_array[] = "<li><a href ='../".$row->link."/' class='link'style='margin-left:2.3em;'>". $row->topic."</a></li>";
            }
        }
	  
      $user_tree_array = fetchCategoryTreeList($row->id, $user_tree_array);
    }
	$user_tree_array[] = "</ul>";
  }
  return $user_tree_array;
}







function fetchCategoryTreeListForum($parent = 20, $user_tree_array = '') {

    if (!is_array($user_tree_array))
    $user_tree_array = array();

  $sql = "SELECT `id`, `topic`, `parent_id` FROM `Topics` WHERE 1 AND `parent_id` = $parent ORDER BY id ASC";
  $query = mysqli_query($conn,$sql);
  if (mysqli_num_rows($query) > 0) {
     $user_tree_array[] = "<ul>";
    while ($row = mysqli_fetch_object($query)) {
	  $user_tree_array[] = "<li>". $row->topic."</li>";
      $user_tree_array = fetchCategoryTreeList($row->id, $user_tree_array);
    }
	$user_tree_array[] = "</ul>";
  }
  return $user_tree_array;
}

?>