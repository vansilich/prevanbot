<?php

function curl_out_headers($ch){
// Get the out headers, explode into an array, and remove any empty string entries
    $outHeaders = explode("\n", curl_getinfo($ch, CURLINFO_HEADER_OUT));
    $outHeaders = array_filter($outHeaders, function($value) { return $value !== '' && $value !== ' ' && strlen($value) !== 1; });
    print_r($outHeaders);
}