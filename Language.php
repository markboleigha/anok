<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');




class Language {

	

    public $os; 
    public $browser; 
    public $agent; 
    public $lang; 
    private $CI;
    
    public function __construct() { 
        
        $this->CI =& get_instance();
        $this->agent = $_SERVER['HTTP_USER_AGENT']; 
        $this->language();
        $this->language = $this->language();
        
    } 
    
    public function os() { 

        $os_array = array( 
                            '/windows nt 6.2/i' => 'Windows 8', 
                            '/windows nt 6.1/i' => 'Windows 7', 
                            '/windows nt 6.0/i' => 'Windows Vista', 
                            '/windows nt 5.2/i' => 'Windows Server 2003/XP x64', 
                            '/windows nt 5.1/i' => 'Windows XP', 
                            '/windows xp/i' => 'Windows XP', 
                            '/windows nt 5.0/i' => 'Windows 2000', 
                            '/windows me/i' => 'Windows ME', 
                            '/win98/i' => 'Windows 98', 
                            '/win95/i' => 'Windows 95', 
                            '/win16/i' => 'Windows 3.11', 
                            '/macintosh|mac os x/i' => 'Mac OS X', 
                            '/mac_powerpc/i' => 'Mac OS 9', 
                            '/linux/i' => 'Linux', 
                            '/ubuntu/i' => 'Ubuntu', 
                            '/iphone/i' => 'iPhone', 
                            '/ipod/i' => 'iPod', 
                            '/ipad/i' => 'iPad', 
                            '/android/i' => 'Android', 
                            '/blackberry/i' => 'BlackBerry', 
                            '/webos/i' => 'Mobile' 
                        ); 

        foreach ($os_array as $regex => $value) { 

            if (preg_match($regex, $this->agent)) { 
                $this->os = $value; 
            } 

        } 

        return $this->os; 
    } 

    function browser() { 

        $browser_array = array( 
                            '/msie/i' => 'Internet Explorer', 
                            '/Trident/i' => 'Internet Explorer', 
                            '/firefox/i' => 'Firefox', 
                            '/safari/i' => 'Safari', 
                            '/chrome/i' => 'Chrome', 
                            '/opera/i' => 'Opera', 
                            '/OPR/i' => 'Opera', 
                            '/netscape/i' => 'Netscape', 
                            '/maxthon/i' => 'Maxthon', 
                            '/konqueror/i' => 'Konqueror', 
                            '/mobile/i' => 'Handheld Browser' 
                        ); 

        foreach ($browser_array as $regex => $value) { 

            if (preg_match($regex, $this->agent)) { 
                $this->browser = $value; 
            } 
        } 

        return $this->browser; 
    } 

    public function language() { 

        $this->lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2); 
        
        return $this->lang;
    } 

    public function parse($string){
        
        $skin = preg_replace_callback('/{\@lang->(.+?)}/i', create_function('$replace', 'return lang("$replace[1]");'), $skin);
    
        return $skin;
    }

    //get transaltions
    public function lang($var){
        require_once APPPATH."language/".$this->language.".php";
        global $l;
        return $l[$var];
        
    }


}
?>
