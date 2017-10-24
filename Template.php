<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template {
  
  //Load Codeigniter Core
	private $CI;
	//public $tpl = array();
  
  /*
  * Initialize the function
  */
	public function __construct(){

		$this->CI =& get_instance();
        $this->CI->config->item('base_url');

	}

  //Render File to view
	public function render($filename, $lang, $data = null){
    //initialize our template container
		global $tmpl;
    
    //Html template to load
		$file = sprintf(APPPATH."views/%s.html", $filename);
		if(!file_exists($file)){
			return "Unable to load file : {$file}";
		}
		$skin = file_get_contents($file);
		//$skin = eval("$file_handle");
		if($data != null){

			foreach ($data as $key => $value) {
				$tmpl[$key] = $value;
			}
      
      //unset data to avoid possible glitches
			unset($data);
		}

		return $this->parse($skin, $lang);
	}

  /*
  * Parse The template and replace with markup and translations
  * $lang: Language file
  * $skin: template file
  */
	private function parse($skin, $lang){
		global $tmpl;
		require_once(APPPATH.'language/'.$lang.'.php');
		$skin = preg_replace_callback('/{\@lang->(.+?)}/i', create_function('$replace', 'return lang("$replace[1]");'), $skin);
		$skin = preg_replace_callback('/{\@([a-zA-Z0-9_]+)}/', create_function('$replace', 'global $tmpl; return (isset($tpl[$replace[1]])?$tpl[$replace[1]]:"");'), $skin);

		return $skin;
	}


	


}
?>
