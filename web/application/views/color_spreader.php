<?php
// Check if variables are set
if (isset($word) && isset($color)) {

    $opacityStep = 1 / strlen($word); // Opacity increment per character

    for ($i = 0; $i < strlen($word); $i++) {
        $currentOpacity = mt_rand(20, 80) / 100;
        $char = $word[$i];
        $style = "color: rgba(" . str_replace("rgb", "", $color) . ", $currentOpacity);";
        echo "<span class='char' style='$style'>$char</span>";
        // $currentOpacity += $opacityStep;
    }
}
?>
