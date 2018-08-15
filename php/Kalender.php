<?php include_once('functions.php'); ?>
<div id="calendar_div">
	<?php echo getCalender(); ?>
</div>
<div>
    <?php
        require("dbConfig.php");
        $query = "SELECT COUNT(*) FROM events WHERE `status` = 1 and `date` >= current_date()";
        $result = mysqli_query($db,$query);
        $rows = mysqli_fetch_row($result);
        
        if($rows ===0){
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
            echo"<h2>Verjaardagen</h2>";
            $sqlBirthday = " SELECT *, extract(month from `date`) as month , extract(day from `date`) as day, (TIMESTAMPDIFF(YEAR, date, CURDATE())+1) AS age FROM `events` WHERE `status` = 1 and verjaardag = 1";
            $sqlBirthday .= " ORDER BY date";
            $resultBirthDay = mysqli_query($db,$sqlBirthday);
            if( ! $resultBirthDay ){ 
            }else{
                while ($rowBirthDay = $resultBirthDay->fetch_assoc()){
                    if (substr($rowBirthDay['age'],-1)==1){
                      ?>
                    <p style="clear:both;min-width:auto; width:100%;"><span><?=$rowBirthDay['day']?> / <?=$rowBirthDay['month']?> : <?=$rowBirthDay['age']?>st <?=$rowBirthDay['title']?></span></p>
                    <?php  
                    }else if(substr($rowBirthDay['age'],-1)==2){
                        ?>
                    <p style="clear:both;min-width:auto; width:100%;"><span><?=$rowBirthDay['day']?> / <?=$rowBirthDay['month']?> : <?=$rowBirthDay['age']?>nd <?=$rowBirthDay['title']?></span></p>
                    <?php 
                    }else if(substr($rowBirthDay['age'],-1)==3){
                        ?>
                    <p style="clear:both;min-width:auto; width:100%;"><span><?=$rowBirthDay['day']?> / <?=$rowBirthDay['month']?> : <?=$rowBirthDay['age']?>rd <?=$rowBirthDay['title']?></span></p>
                    <?php 
                    }else{
                        ?>
                    <p style="clear:both;min-width:auto; width:100%;"><span><?=$rowBirthDay['day']?> / <?=$rowBirthDay['month']?> : <?=$rowBirthDay['age']?>th <?=$rowBirthDay['title']?></span></p>
                    <?php 
                        
                    }
                }
            }
        }

        
        
    ?>
</div>
