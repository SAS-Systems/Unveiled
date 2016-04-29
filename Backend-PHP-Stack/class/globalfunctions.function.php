<?php

/**
 * @param boolean $bool
 * @return int
 */
function boolToInt($bool)
{

    if ($bool) {
        return 1;
    } else {
        return 0;
    }
}


/**
 * @param int $int
 * @return bool
 */
function intToBool($int)
{

    if ($int == 0) {
        return true;
    } else if ($int == 1) {
        return true;
    } else {
        return false;
    }
}

/**
 * @param $str
 * @return bool
 */
function strToBool($str) {

    if($str == "true") {

        return true;
    }

    return false;
}

function boolToStr($str) {

    if($str == true) {

        return "true";
    }

    return "false";
}


/**
 * send SSE message without id
 * @param $content
 * @param $event
 * @param $retry
 */
function sendSSEMessage($content, $event, $retry)
{

    echo "event: " . $event . "\n";
    echo "retry: " . $retry . "\n";
    echo "data:" . $content . "\n\n";
    flush();
}


/**
 * send SSE message with id
 * @param $content
 * @param $event
 * @param $retry
 * @param $id
 */
function sendSSEMessageId($content, $event, $retry, $id)
{

    echo "id: " . $id . "\n";
    echo "event: " . $event . "\n";
    echo "retry: " . $retry . "\n";
    echo "data:" . $content . "\n\n";
    flush();
}

/**
 * detects JSON Parsing erros
 * @return Message or null
 */
function JSONerrorCatch() {

    switch(json_last_error()) {
        case JSON_ERROR_DEPTH:
            return Message::newFromCode("P001", SYSTEM_LANGUAGE);
        case JSON_ERROR_CTRL_CHAR:
            return Message::newFromCode("P002", SYSTEM_LANGUAGE);
        case JSON_ERROR_SYNTAX:
            return Message::newFromCode("P003", SYSTEM_LANGUAGE);
        case JSON_ERROR_NONE:
            return null;
    }
}

/**
 * @param $time
 * @return bool|string
 */
function timestampToString($time) {

    $time = (int)$time;

    return date("H:i:s d.m.Y", $time);
}