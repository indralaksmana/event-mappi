<?php

function jsonRawParser($rawJson) {
    return json_decode($rawJson, true);
}

function getAccessToken($headers) {
    if (!empty($headers)) {
        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
            return $matches[1];
        }
    }
    return null;
}

function getIndonesianDate($date) {
    $oldFormat = explode('-', $date);
    $newFormat = join('-', [$oldFormat[2], $oldFormat[1], $oldFormat[0]]);
    return $newFormat;
}

function getShortTime($time) {
    return substr($time, 0, 5);
}
?>