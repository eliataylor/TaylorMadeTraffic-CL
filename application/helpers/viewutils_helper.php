<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// --------------------------------------------------------------------

    function ellipse($str, $num){
        if (strlen($str) > $num) {
            if ($num > 0) return substr($str, 0, $num) . "...";
            else return '...' . substr($str, $num);
        }
        return $str;
    }
    
    function ellipseMid($str, $num){
        if (strlen($str) > $num) {
            $num = ceil($num/2);
            $str1 = substr($str, 0, $num);
            $str2 = substr($str, strlen($str)-$num);
            return $str1  . "..." . $str2;
        }
        return $str;
    }
    
    function removeqsvar($url, $varname) {
        return preg_replace('/([?&])'.$varname.'=[^&]+(&|$)/','$1',$url);
    }

    function noSSL($url) {
        if (strpos($url, "http:") === 0) return $url;
        if (strpos($url, "https:") === 0) return "http:" . substr($url, 6);
        if (strpos($url, "//") === 0) return "http:".$url;
        if (strpos($url, "/") === 0) $url = substr($url, 1); // standardize rest to no leading /        
        $http = (strpos(TMT_HTTP, "http:") === 0) ? TMT_HTTP : "http:" . substr(TMT_HTTP, 6);
        return $http . $url;
    }
    
    function makeSSL($url) {
        //if (ENVIRONMENT != 'production') return noSSL($url);
        if (strpos($url, "https:") === 0) return $url;
        if (strpos($url, "https") === 0) return "https:" . substr($url, 5);
        if (strpos($url, "//") === 0) return "https:".$url;
        if (strpos($url, "/") === 0) $url = substr($url, 1); // standardize rest to no leading /        
        $http = (strpos(TMT_HTTP, "https:") === 0) ? TMT_HTTP : "https:" . substr(TMT_HTTP, 5);
        return $http . $url;
    }
    
    function fnum($num, $decimals=0) { return number_format($num, $decimals, '.', ','); }
    
    function fDate($date=null, $form="short") {
        if (empty($date)) $date = time();
        if ($form == "year") return date("F jS, Y", $date);   
        if ($form == "time") return date("F j, Y, g:i a T", $date);
        if ($form == "sortershort") return date("Y-m-d", $date);
        if ($form == "sorter") return date("Y-m-d H:i:s", $date);
        else return date("D, M jS", $date);
    }
    
    function makeAssociative($rows, $keys="id") {
        $obj = array();
        if (!is_array($rows) || empty($rows)) return $obj;
        foreach($rows as $r) {
            $key = "";
            
            if (is_array($keys)) {
                foreach($keys as $k) $key .= $r->$k;
            }
            else $key = $r->$keys;
            
            $obj[$key] = $r;
        }
        return $obj;
    }
    
    function debug($arr=null, $height="100%"){
        echo "<div style='height:".$height."' class='debugBox'><pre>";
        var_dump($arr);
        echo "</pre></div>";
    }
    

/* End of file view utils.php */