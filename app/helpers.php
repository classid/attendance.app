<?php

if (!function_exists('deviceConnected')) {
    function deviceConnected($host, $port) {
        try {
	    $sc = stream_socket_client($host, $port, $errno, $errStr, 1);
            return $sc ? true : false;
        }
        catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('xml_data')) {
    function xml_data($data, $p1, $p2)
    {
        $data = ' ' . $data;
        $hasil = '';
        $awal = strpos($data, $p1);
        if ($awal != '') {
            $akhir = strpos(strstr($data, $p1), $p2);
            if ($akhir != '') {
                $hasil = substr($data, ($awal + strlen($p1)), ($akhir - strlen($p1)));
            }
        }
        return $hasil;
    }
}
