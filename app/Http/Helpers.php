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

?>