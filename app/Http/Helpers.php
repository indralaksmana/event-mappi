<?php

function jsonRawParser($rawJson) {
    return json_decode($rawJson, true);
}

?>