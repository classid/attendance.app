<?php

if (!function_exists('deviceConnected')) {
    function deviceConnected($host, $port) {
        try {
            return fsockopen($host, $port, $errno, $errStr, 1);
        }
        catch (Exception $e) {
            return false;
        }
    }
}
