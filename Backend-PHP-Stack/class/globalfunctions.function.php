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

?>