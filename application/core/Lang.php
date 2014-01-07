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
	 * @param	string	the language (en, etc.) CHANGE FROM CORE FILE: naming convention is always the language code, not the name
	 * @param	bool	return loaded array of translations
	 * @param 	bool	add suffix to $langfile
	 * @param 	string	alternative path to look for language file
	 * @return	mixed
	 */
	function load($langfile = '', $idiom = '', $return = FALSE, $add_suffix = TRUE, $alt_path = '') {
                        
		$langfile = str_replace('.php', '', $langfile);

		if ($add_suffix == TRUE)
		{
			$langfile = str_replace('_lang.', '', $langfile).'_lang';
		}

		$langfile .= '.php';

		if (in_array($langfile, $this->is_loaded, TRUE)) {
			return;
		}

		$config =& get_config();

		if ($idiom == '')
		{
			$deft_lang = ( ! isset($config['language'])) ? 'en' : $config['language'];
			$idiom = ($deft_lang == '') ? 'en' : $deft_lang;
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


	function line($line, $lang=false) {
                if (is_numeric($line)) return $line;
		$value = (isset($this->language[$line])) ? $this->language[$line] : $line;
		if (!isset($this->language[$line])) {
                        if (ENVIRONMENT != 'production') {
                            $CI = &get_instance();
                            
                            $key = strtolower(preg_replace('/\s+/', '', $line));
                            $test = $CI->LenguaPlus_model->getLanguageByKey($key);
                            if (!$test) {
                                $trace = debug_backtrace();
                                $obj = array();
                                foreach($trace as $t) {
                                    if ($t['function'] == 'line') {
                                        $obj['langtracker_linenum'] = $t['line'];
                                        $obj['langtracker_type'] = 'msg';
                                        $obj['langtracker_file'] = $t['file'];

                                        if ($lang == 'es') {
                                            $obj['langtracker_key'] = $key;
                                            $obj['langtracker_es'] = $line;
                                        } elseif ($lang == 'en') {
                                            $obj['langtracker_key'] = $key;
                                            $obj['langtracker_en'] = $line;
                                        } else {
                                            $obj['langtracker_key'] = $key;
                                        }

                                        $obj['langtracker_added'] = time();
                                        $obj['langtracker_host'] = $_SERVER['HTTP_HOST'];
                                        $obj['langtracker_language'] = (!empty($this->curlanguage)) ? $this->curlanguage : 'en';
                                        $obj['langtracker_url'] = $_SERVER['REQUEST_URI'];
                                        $obj['langtracker_status'] = "debug";

                                        $test = $CI->LenguaPlus_model->hasKeyByUrl($obj);
                                        if ($test === false) {
                                            $CI->LenguaPlus_model->trackLang($obj);
                                        }
                                        break;
                                    }
                                }
                            } else {
                                $cur = (!empty($this->curlanguage)) ? $this->curlanguage : 'en';
                                if ($lang != $cur) {
                                    $column = 'langtracker_'.$cur;
                                    $value = $test->$column;
                                }
                            }
                        }                    
			log_message('error', 'Could not find the language line "'.$line.'"');
		}

		return $value;
	}
        
        function en($line) {
            return $this->line($line, 'en');
	}
        function es($line) {
            return $this->line($line, 'es');
	}
        
	function ugc($line) {
                if (ENVIRONMENT == 'production') $line;
                if (is_numeric($line)) return $line;
                $key = preg_replace('/\s+/', '', $line);
		if (!isset($this->language[$key])) {
                    $CI = &get_instance();
                    $trace = debug_backtrace();
                    foreach($trace as $t) {
                        if ($t['function'] == 'ugc') {
                            $obj['langtracker_linenum'] = $t['line'];
                            $obj['langtracker_type'] = 'ugc';
                            $obj['langtracker_file'] = $t['file'];
                            $obj['langtracker_added'] = time();
                            $obj['langtracker_key'] = $key;
                            if (!empty($this->curlanguage)) {
                                $obj['langtracker_language'] = $this->curlanguage;
                                $obj['langtracker_' . $this->curlanguage] = $line;
                            } else {
                                $obj['langtracker_language'] = 'en';
                                $obj['langtracker_en'] = $line;
                            }
                            $obj['langtracker_host'] = $_SERVER['HTTP_HOST'];
                            $obj['langtracker_url'] = $_SERVER['REQUEST_URI'];
                            $obj['langtracker_status'] = "debug";

                            $test = $CI->LenguaPlus_model->hasKeyByUrl($obj);
                            if ($test === false) $CI->LenguaPlus_model->trackLang($obj);
                            break;
                        }
                    }                    
                    log_message('error', 'Could not find the language line "'.$line.'"');
		} else {
                    $line = $this->language[$key];
                }
		return $line;
	}        
}
// END Language Class
/* End of file Lang.php */
/* Location: ./system/core/Lang.php */