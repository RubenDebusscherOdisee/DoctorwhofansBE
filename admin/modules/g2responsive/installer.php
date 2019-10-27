<?php
class modules_g2responsive_installer {

    function update_1(){
	    $handle = fopen("tmp.txt", 'w');
		fwrite($handle, "start install".PHP_EOL);
		
        $settings = parse_ini_file("settings.ini");
        
        if ($settings["dashboard"] == 1){
		    fwrite($handle, "Adding Dashboard".PHP_EOL);
		
            $sql[] = "create table if not exists dashboard (
                dashboard_id int(11) not null auto_increment primary key
            )";      
			
            df_q($sql);
			
            copy(dirname(__FILE__).'/install/dashboard/actions.ini', dirname(__FILE__).'/actions.ini');
            copy(dirname(__FILE__).'/install/dashboard/settings.ini', dirname(__FILE__).'/settings.ini');
            
            $filename = DATAFACE_SITE_PATH.'/conf/ApplicationDelegate.php';
            $foldername = DATAFACE_SITE_PATH.'/conf';
            
            if (!file_exists($foldername)){
                mkdir($foldername, 0777, true);
            }

            if (!file_exists($filename)){
            copy(dirname(__FILE__).'/install/conf/ApplicationDelegate.php', $filename);
            }
            else{}
        }
        else{
		    fwrite($handle, "Remove Dashboard".PHP_EOL);
            copy(dirname(__FILE__).'/install/nodashboard/actions.ini', dirname(__FILE__).'/actions.ini');
            copy(dirname(__FILE__).'/install/nodashboard/settings.ini', dirname(__FILE__).'/settings.ini');
        }
	fwrite($handle, PHP_EOL ."paths:". PHP_EOL);
	fwrite($handle, PHP_EOL . DATAFACE_SITE_PATH . PHP_EOL);
	
	fwrite($handle, PHP_EOL . dirname(__FILE__).'/install/dashboard/actions.ini' . PHP_EOL);
	fwrite($handle, dirname(__FILE__).'/install/nodashboard/actions.ini' . PHP_EOL);
	fwrite($handle, dirname(__FILE__).'/actions.ini' . PHP_EOL);
	
	fwrite($handle, PHP_EOL . dirname(__FILE__).'/install/dashboard/settings.ini' . PHP_EOL);
	fwrite($handle, dirname(__FILE__).'/install/nodashboard/settings.ini' . PHP_EOL);
	fwrite($handle, dirname(__FILE__).'/settings.ini' . PHP_EOL);
	
	fwrite($handle, PHP_EOL . DATAFACE_SITE_PATH.'/conf' . PHP_EOL);
	fwrite($handle, DATAFACE_SITE_PATH.'/conf/ApplicationDelegate.php' . PHP_EOL);
	fwrite($handle, dirname(__FILE__).'/install/conf/ApplicationDelegate.php' . PHP_EOL);
	
	fclose($handle);
    }
}