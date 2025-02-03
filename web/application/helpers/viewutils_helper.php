<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// --------------------------------------------------------------------


function parseTeamList($html)
{
    if (empty($html)) return 'no team data';

    $result = [];

    // Use DOMDocument to parse the HTML
    $dom = new DOMDocument();
    @$dom->loadHTML($html);

    // Get all <a> tags
    $anchors = $dom->getElementsByTagName('a');

    foreach ($anchors as $anchor) {
        $text = $anchor->nodeValue;

        // Exclude the ones containing "E.A.Taylor"
        if (stripos($text, "E.A.Taylor") === false) {
            $result[] = $text;
        }
    }

    if (empty($result)) return 'just me';

    if (count($result) === 1) {
        return '2 person team'; // maybe say "2 person team"
    }

    $str = '<li class="team_count">Worked with team of ' . count($result) . ' others</li>';
    return $str;
}


function sortDevToolsByFilters($devtools, $filters)
{
    if (empty($filters)) return $filters;

    $filters = explode(',', $filters);

    // Normalize the filters to only alphanumeric characters
    $normalizedFilters = array_map(function ($filter) {
        return preg_replace('/[^a-zA-Z0-9]/', '', $filter);
    }, $filters);

    // Normalize the devtools to only alphanumeric characters
    $normalizedDevtools = array_map(function ($devtool) {
        return preg_replace('/[^a-zA-Z0-9]/', '', $devtool);
    }, $devtools);

    // Filter devtools that match any value in normalized filters
    $matched = array_filter($devtools, function ($devtool) use ($normalizedDevtools, $normalizedFilters) {
        return in_array(preg_replace('/[^a-zA-Z0-9]/', '', $devtool), $normalizedFilters);
    });

    // Filter devtools that do not match any value in normalized filters
    $notMatched = array_filter($devtools, function ($devtool) use ($normalizedDevtools, $normalizedFilters) {
        return !in_array(preg_replace('/[^a-zA-Z0-9]/', '', $devtool), $normalizedFilters);
    });

    // Merge matched and not matched arrays
    return array_merge($matched, $notMatched);
}


function ellipse($str, $num)
{
    if (strlen($str) > $num) {
        if ($num > 0) return substr($str, 0, $num) . "...";
        else return '...' . substr($str, $num);
    }
    return $str;
}

function displayLink($str)
{
    $str = stripos($str, '//') ? substr($str, stripos($str, '//') + 2) : $str;
    if (stripos($str, 'www.') === 0) {
        $str = substr($str, strlen('www.'));
    }
    if ($str[strlen($str) - 1] === '/') {
        $str = substr($str, 0, -1);
    }
    return $str;
}


function ellipseMid($str, $num)
{
    if (strlen($str) > $num) {
        $num = ceil($num / 2);
        $str1 = substr($str, 0, $num);
        $str2 = substr($str, strlen($str) - $num);
        return $str1 . "..." . $str2;
    }
    return $str;
}

function removeqsvar($url, $varname)
{
    return preg_replace('/([?&])' . $varname . '=[^&]+(&|$)/', '$1', $url);
}


function imageSize($c, $dim)
{
    preg_match('/_(\d{1,4})x(\d{1,4})/i', $c, $match); // never should actually happen, but check if any prefix is already in string.
    if (!empty($match)) {
        $img = preg_replace("/" . $match[0] . "/", '_' . $dim, $c); // just add it
        if (file_exists(ROOT_CD . $img)) return $img; // check if exists
    }
    if (strpos($c, "//cdn") === 0) {
        $test = substr($c, strpos($c, ".com/") + 5);
        $ext = preg_replace('/^.*\./', '', $c);
        $img = preg_replace("/\." . $ext . "/", '_' . $dim . "." . $ext, $test);
        if (file_exists(CDN_CD . $img)) {
            return substr($c, 0, strpos($c, ".com/") + 5) . $img;
        }
    } else {
        $ext = preg_replace('/^.*\./', '', $c);
        $img = preg_replace("/\." . $ext . "/", '_' . $dim . "." . $ext, $c);
        if (file_exists(ROOT_CD . $img)) return $img;
    }
    //if (ENVIRONMENT != 'production') {
    //    Modules::run("info/logImgSize", $c, $dim);
    //}
    return $c;
}

function fnum($num, $decimals = 0)
{
    return number_format($num, $decimals, '.', ',');
}

function fDate($date = null, $form = "short")
{
    if (empty($date)) $date = time();
    if ($form == "year") return date("F jS, Y", $date);
    if ($form == "time") return date("F j, Y, g:i a T", $date);
    if ($form == "month") return date("F, Y", $date);
    if ($form == "sortershort") return date("Y-m-d", $date);
    if ($form == "sorter") return date("Y-m-d H:i:s", $date);
    else return date("D, M jS", $date);
}

function dateRange($start, $end, $format = "short")
{
    $parts = [];

    if ($start && $part = strtotime($start)) {
        $parts[] = fDate($part, $format);
    }

    if (empty($end)) {
        $parts[] = 'Present';
    } else if ($part = strtotime($end)) {
        $parts[] = fDate($part, $format);
    }

    if (sizeof($parts) > 0) return implode(' ~ ', $parts);
    return '';
}


function makeAssociative($rows, $keys = "id")
{
    $obj = array();
    if (!is_array($rows) || empty($rows)) return $obj;
    foreach ($rows as $r) {
        $key = "";

        if (is_array($keys)) {
            foreach ($keys as $k) $key .= $r->$k;
        } else $key = $r->$keys;

        $obj[$key] = $r;
    }
    return $obj;
}

function debug($arr = null, $height = "100%")
{
    echo "<div style='height:" . $height . "' class='debugBox'><pre>";
    var_dump($arr);
    echo "</pre></div>";
}

function mergeStringsUniquely(...$strings)
{
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
