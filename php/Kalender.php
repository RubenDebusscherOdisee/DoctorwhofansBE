<?php include_once('functions.php'); ?>
<div id="calendar_div">
	<?php echo getCalender(); ?>
</div>
<div>
    <?php
        require("dbConfig.php");
        $query = "SELECT COUNT(*) FROM events WHERE `status` = 1 and `event_date` >= current_date()";
        $result = mysqli_query($db,$query);
        $rows = mysqli_fetch_row($result);
        
        if($rows ==0){
            echo"<p style='clear:both;min-width:auto; width:100%;'>Sorry, we konden geen aankomende events vinden, probeer later opnieuw, of kijk in de kalender naar evenementen in het verleden.</p>";
            
        }else{
            $sqlKalender = " SELECT * FROM `events` WHERE `status` = 1 and `date` >= current_date()";
            $sqlKalender .= " ORDER BY date";
            $resultkalender = mysqli_query($db,$sqlKalender);

    
            if( ! $resultkalender ){ 
            }else{
                while ($rowkalender = $resultkalender->fetch_assoc()){
                    ?>
                    <p style="clear:both;min-width:auto; width:100%;"><span><?=$rowkalender['date']?> : <?=$rowkalender['title']?></span></p>
                    <?php
                }
            }
            
            
        }

        
        
    ?>
</div>
