<?php
class modules_g2responsive {

  private $baseURL = null;

  public function getBaseURL(){
    if ( !isset($this->baseURL) ){
      $this->baseURL = Dataface_ModuleTool::getInstance()->getModuleURL(__FILE__);
    }
    return $this->baseURL;
  }

  public function __construct(){
    $s = DIRECTORY_SEPARATOR;
    $app = Dataface_Application::getInstance();

    $jt = Dataface_JavascriptTool::getInstance();
    $jt->ignore('bootstrap/bootstrap.min.js');
    $jt->ignore('jquery.packed.js');
    $app->addHeadContent('<script src="'.htmlspecialchars(DATAFACE_URL.'/js/jquery.packed.js').'"></script>');
    $app->addHeadContent('<script src="'.htmlspecialchars($this->getBaseURL().'/js/bootstrap/bootstrap.min.js').'"></script>');

    $app->addHeadContent('<link rel="stylesheet" type="text/css" href="'.htmlspecialchars($this->getBaseURL().'/css/bootstrap/bootstrap.min.css').'"/>');
    $app->addHeadContent('<link rel="stylesheet" type="text/css" href="'.htmlspecialchars($this->getBaseURL().'/css/g2ResponsiveStyles.css').'"/>');
    
    $jt->addPath(dirname(__FILE__).$s.'js', $this->getBaseURL().'/js');
    $ct = Dataface_CSSTool::getInstance();
    $ct->addPath(dirname(__FILE__).$s.'css', $this->getBaseURL().'/css');

    df_register_skin('g2responsive', dirname(__FILE__).'/templates');
	
    $settings = parse_ini_file("settings.ini");
        
    if ($settings["installed"] == 0){
      $sql[] = "drop table if exists dataface__modules";
      df_q($sql);
    }
  }

  function block__head() {
    //echo "<meta name='viewport' content='width=655, initial-scale=0.6, user-scalable=yes'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=0.9, user-scalable=yes'>";
  }

  function block__before_search(){
    df_display(array(), 'mobile_buttons.html');
  }

  function block__before_fineprint(){
    df_display(array(), 'navbar_bottom.html');
  }
}