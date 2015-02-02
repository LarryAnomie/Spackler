<?php

 /**
  * [hasQuestionMark Go through a string to see if it contains a certain character
  * @param  String  $string
  * @return boolean
  */
function hasQuestionMark($string) {
    $length = strlen($string);

    for($i = 0; $i < $length; $i++) {
        $char = $string[$i];
        if($char == '?') { return true; }
    }
    return false;
}
