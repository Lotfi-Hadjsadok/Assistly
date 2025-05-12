<?php

function normalizeHex($hex)
{
    $hex = ltrim($hex, '#');
    return strlen($hex) === 3
        ? '#' . $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2]
        : '#' . $hex;
}
