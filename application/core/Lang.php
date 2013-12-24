<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**		
 * 
 * CREATE TABLE IF NOT EXISTS `langtracker` (
  `langtracker_id` int(11) NOT NULL AUTO_INCREMENT,
  `langtracker_key` varchar(400) COLLATE utf8_unicode_ci NOT NULL,
  `langtracker_file` varchar(400) COLLATE utf8_unicode_ci NOT NULL,
  `langtracker_linenum` int(4) NOT NULL,
  `langtracker_url` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `langtracker_host` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `langtracker_es` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `langtracker_en` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `langtracker_language` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `langtracker_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'debug',
  `langtracker_added` int(11) DEFAULT NULL,
  `langtracker_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`langtracker_id`),
  KEY `langtracker_language` (`langtracker_language`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;
 * 
 * 
 */
class CI_Lang {

	private $language	= array();
        private $curlanguage    = NULL;
	private $is_loaded	= array();

	function __construct() {
            log_message('debug', "Language Class Initialized");
	}

	// --------------------------------------------------------------------

	/**
	 * Load a language file
	 *
	 * @access	public
	 * @param	mixed	the name of the language file to be loaded. Can be an array
	 * @param	string	the language (english, etc.)
	 * @param	bool	return loaded array of translations
	 * @param 	bool	add suffix to $langfile
	 * @param 	string	alternative path to look for language file
	 * @return	mixed
	 */
	function load($langfile = '', $idiom = '', $return = FALSE, $add_suffix = TRUE, $alt_path = '')
	{
		$langfile = str_replace('.php', '', $langfile);

		if ($add_suffix == TRUE)
		{
			$langfile = str_replace('_lang.', '', $langfile).'_lang';
		}

                if (ENVIRONMENT != 'production') {
                    $CI = &get_instance();
                    $CI->load->model('Language_model', 'langtracker');
                }
                
		$langfile .= '.php';

		if (in_array($langfile, $this->is_loaded, TRUE))
		{
			return;
		}

		$config =& get_config();

		if ($idiom == '')
		{
			$deft_lang = ( ! isset($config['language'])) ? 'english' : $config['language'];
			$idiom = ($deft_lang == '') ? 'english' : $deft_lang;
		}
                $this->curlanguage = $idiom;

		// Determine where the language file is and load it
		if ($alt_path != '' && file_exists($alt_path.'language/'.$idiom.'/'.$langfile))
		{
			include($alt_path.'language/'.$idiom.'/'.$langfile);
		}
		else
		{
			$found = FALSE;

			foreach (get_instance()->load->get_package_paths(TRUE) as $package_path)
			{
				if (file_exists($package_path.'language/'.$idiom.'/'.$langfile))
				{
					include($package_path.'language/'.$idiom.'/'.$langfile);
					$found = TRUE;
					break;
				}
			}

			if ($found !== TRUE)
			{
				show_error('Unable to load the requested language file: language/'.$idiom.'/'.$langfile);
			}
		}


		if ( ! isset($lang))
		{
			log_message('error', 'Language file contains no data: language/'.$idiom.'/'.$langfile);
			return;
		}

		if ($return == TRUE)
		{
			return $lang;
		}

		$this->is_loaded[] = $langfile;
		$this->language = array_merge($this->language, $lang);
		unset($lang);

		log_message('debug', 'Language file loaded: language/'.$idiom.'/'.$langfile);
		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Fetch a single line of text from the language array
	 *
	 * @access	public
	 * @param	string	$line	the language line
	 * @return	string
	 */
	function line($line = '') {
		$value = (isset($this->language[$line])) ? $this->language[$line] : $line;

		if (!isset($this->language[$line])) {
                        if (ENVIRONMENT != 'production') {
                            $CI = &get_instance();
                            $trace = debug_backtrace();
                            $obj = array();
                            foreach($trace as $t) {
                                if ($t['function'] == 'line') {
                                    $obj['langtracker_linenum'] = $t['line'];
                                    $obj['langtracker_file'] = $t['file'];
                                    $obj['langtracker_key'] = $line;
                                    $obj['langtracker_added'] = time();
                                    $obj['langtracker_host'] = $_SERVER['HTTP_HOST'];
                                    $obj['langtracker_language'] = $this->curlanguage;
                                    $obj['langtracker_url'] = $_SERVER['REQUEST_URI'];
                                    $obj['langtracker_status'] = "debug";
                                    
                                    //$test = $CI->langtracker->hasKeyByFileLine($obj);
                                    //if ($test === false) $CI->langtracker->trackLang($obj);                        
                                    break;
                                }
                            }
                        }                    
			log_message('error', 'Could not find the language line "'.$line.'"');
		}

		return $value;
	}

}
// END Language Class

/* End of file Lang.php */
/* Location: ./system/core/Lang.php */
