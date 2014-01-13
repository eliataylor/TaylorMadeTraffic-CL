<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/** CREATE TABLE IF NOT EXISTS `langtracker` (
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
        /* override*/ 
        function set_item($name, $val) {
             $this->curlanguage = $val;
        } 
        
        function setLanguaPlus($val) {
           $this->curlanguage = $val;
        }
         
        function line($line, $lang=false) { return $this->msg($line, $lang);}  // for portability from native Lang.php
        function key($line, $lang=false) { return $this->msg($line, $lang); }
        function en($line) { return $this->msg($line, 'en'); }
        function es($line) { return $this->msg($line, 'es'); }

	function msg($value, $lang=false) {
                if (is_numeric($value)) return $value;
                $key = strtolower($value);
		$value = (isset($this->language[$key])) ? $this->language[$key] : $value;
		if (!isset($this->language[$key])) { // generally consider in production this should always happen anyway. (for ugc() the opposite)
                        $CI = &get_instance();
                        $lData = NULL; // false is the query was already made
                        
                        if ($CI->config->item('use_msg_database') === TRUE) {
                            $lData = $CI->LenguaPlus_model->getLanguageByKey($key, $CI->config->item('lang_status')); // only status == 'edited' or 'live' rows
                            $langCol = 'langtracker_';
                            $langCol .= (!empty($this->curlanguage)) ? $this->curlanguage : $CI->config->item('language'); // todo this should be handled better by load
                            if ($lData && !empty($lData->$langCol)) {
                                $this->language[$key] =  $lData->$langCol; // CACHED for request life!
                                // consider updating example URL list: $updated = $CI->LenguaPlus_model->updateLangById($lData, $lData['langtracker_id']);                                
                                return $lData->$langCol;
                            } // nothing is in the database either
                        }
                        if ($CI->config->item('track_msg_production') === true || $CI->config->item('environment') != 'production') {
                            
                            if (empty($lData)) { 
                                $lData = $CI->LenguaPlus_model->getLanguageByKey($key); // any status!
                                if (!empty($lData)) {
                                    // consider updating example URL list: $updated = $CI->LenguaPlus_model->updateLangById($lData, $lData['langtracker_id']);                                
                                }
                            }
                            if (empty($lData)) {
                                $trace = debug_backtrace();
                                foreach($trace as $t) {
                                    if ($t['file'] != __FILE__) { // one file up in the trace
                                        $lData['langtracker_linenum'] = $t['line'];
                                        $lData['langtracker_type'] = 'msg';
                                        $lData['langtracker_file'] = $t['file'];

                                        if ($lang == 'es') {
                                            $lData['langtracker_key'] = $key;
                                            $lData['langtracker_es'] = $key;
                                        } elseif ($lang == 'en') {
                                            $lData['langtracker_key'] = $key;
                                            $lData['langtracker_en'] = $key;
                                        } else {
                                            $lData['langtracker_key'] = $key;
                                        }

                                        $lData['langtracker_added'] = time();
                                        $lData['langtracker_host'] = $_SERVER['HTTP_HOST'];
                                        $lData['langtracker_language'] = (!empty($this->curlanguage)) ? $this->curlanguage : $CI->config->item('language');
                                        $lData['langtracker_url'] = $_SERVER['REQUEST_URI'];
                                        $lData['langtracker_status'] = "debug";
                                        $CI->LenguaPlus_model->trackLang($lData);
                                        break;
                                    }
                                }
                            }
                            log_message('error', 'Could not find the language line "'.$key.'"');
                        }
		}

		return $value;
	}

	function ugc($line, $user_id=NULL) {
                $CI = &get_instance();
                if ($CI->config->item('environment') === 'production' && $CI->config->item('track_ugc_production') === false) 
                    return $line;                
                if (is_numeric($line)) 
                    return $line;
                
                $key = preg_replace("/[^a-z0-9 ]/", '', strtolower($line)); // key is only alphanumeric to avoid redundant entries, WARN can lead to conflicts
		if (isset($this->language[$key])) {
                    $filename = $this->language[$key]; // WARN: even storing ALL ugc filenames in one file could be too large memorywise.
                    $line = file_get_contents($filename);
                } else {
                    $lData = NULL; // false is the query was already made

                    if ($CI->config->item('use_ugc_database') === TRUE) {
                        $lData = $CI->LenguaPlus_model->getLanguageByKey($key, $CI->config->item('lang_status')); // only status == 'edited' or 'live' rows
                        $langCol = 'langtracker_';
                        $langCol .= (!empty($this->curlanguage)) ? $this->curlanguage : $CI->config->item('language'); // todo this should be handled better by load
                        if ($lData && !empty($lData->$langCol)) {
                            //$this->language[$key] =  $lData->$langCol; // CACHED for request life!
                            // consider updating example URL list: $updated = $CI->LenguaPlus_model->updateLangById($lData, $lData['langtracker_id']);                                
                            return $lData->$langCol;
                        } // nothing is in the database either
                    }
                    if ($CI->config->item('track_ugc_production') === true || $CI->config->item('environment') != 'production') {
                        
                        if (empty($lData)) { 
                            $lData = $CI->LenguaPlus_model->getLanguageByKey($key); // any status!
                            if (!empty($lData)) {
                                // consider updating example URL list: $updated = $CI->LenguaPlus_model->updateLangById($lData, $lData['langtracker_id']);                                
                            }
                        }
                        if (empty($lData)) {
                            $trace = debug_backtrace();
                            foreach($trace as $t) {
                                if ($t['file'] != __FILE__) {
                                    $obj['langtracker_linenum'] = $t['line'];
                                    $obj['langtracker_type'] = 'ugc';
                                    $obj['langtracker_file'] = $t['file'];
                                    $obj['langtracker_added'] = time();
                                    $obj['langtracker_key'] = $key;
                                    $obj['langtracker_oauthor_id'] = $user_id;
                                    if (!empty($this->curlanguage)) { // you can never really know this unless it's track by the session of the user when originally entered
                                        $obj['langtracker_language'] = $this->curlanguage;
                                        $obj['langtracker_' . $this->curlanguage] = $line;
                                    } else {
                                        $obj['langtracker_language'] = $CI->config->item('language');
                                        $obj['langtracker_en'] = $line;
                                    }
                                    $obj['langtracker_host'] = $_SERVER['HTTP_HOST'];
                                    $obj['langtracker_url'] = $_SERVER['REQUEST_URI'];
                                    $obj['langtracker_status'] = "debug";
                                    $CI->LenguaPlus_model->trackLang($obj);
                                    break;
                                }
                            }
                        }                    
                        log_message('error', 'Could not find the language line "'.$line.'"');
                    }
		}
		return $line;
	}        
}
// END Language Class
/* End of file Lang.php */
/* Location: ./system/core/Lang.php */