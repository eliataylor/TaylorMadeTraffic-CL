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


    function imageSize($c, $dim) {
        preg_match('/_(\d{1,4})x(\d{1,4})/i', $c, $match); // never should actually happen, but check if any prefix is already in string.
        if (!empty($match)) {
          $img = preg_replace("/".$match[0]."/", '_' . $dim, $c); // just add it
          if (file_exists(ROOT_CD . $img)) return $img; // check if exists
        }
        if (strpos($c, "//cdn")===0) {
            $test = substr($c, strpos($c, ".com/")+5);
            $ext = preg_replace('/^.*\./', '', $c);
            $img = preg_replace("/\.".$ext."/", '_' . $dim . "." .$ext, $test);
            if (file_exists(CDN_CD . $img)) {
                return substr($c, 0, strpos($c, ".com/")+5) . $img;
            }
        } else {
            $ext = preg_replace('/^.*\./', '', $c);
            $img = preg_replace("/\.".$ext."/", '_' . $dim . "." .$ext, $c);
            if (file_exists(ROOT_CD . $img)) return $img;
        }
        //if (ENVIRONMENT != 'production') {
        //    Modules::run("info/logImgSize", $c, $dim);
        //}
        return $c;
    }

    function fnum($num, $decimals=0) { return number_format($num, $decimals, '.', ','); }

    function fDate($date=null, $form="short") {
        if (empty($date)) $date = time();
        if ($form == "year") return date("F jS, Y", $date);
        if ($form == "time") return date("F j, Y, g:i a T", $date);
        if ($form == "month") return date("F, Y", $date);
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

    function mergeStringsUniquely(...$strings) {
//         if (empty($strings)) return "";
        $uniqueValues = [];

        // Loop through each input string
        foreach ($strings as $string) {

            if (empty($string)) continue;

            $values = explode(',', $string);

            // Trim whitespace from each value and add unique values to the $uniqueValues array
            $uniqueValues = array_merge($uniqueValues, array_unique(array_map('trim', $values)));
        }

        // Remove duplicates from the $uniqueValues array
        $uniqueValues = array_unique($uniqueValues);

        // Combine the unique values into a comma-separated string
        $resultString = implode(', ', $uniqueValues);

        return $resultString;
    }


/* End of file view utils.php */
