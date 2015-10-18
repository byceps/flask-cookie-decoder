<?php
/**
 * A decoder for signed session cookies created by Flask/itsdangerous,
 * implemented in PHP.
 *
 * Created to connect existing PHP web applications to the BYCEPS LAN
 * party platform, specifically its user and authorization subsystem.
 *
 * Copyright 2014-2015 Jan Ove Korneffel
 * License: MIT, see LICENSE for details.
 */

/**
 * Decode and verify a cookie.
 */
function decode_cookie($cookie, $key, $sep = '.') {
    $tokens = explode($sep, $cookie);
    $signature = array_pop($tokens);
    $timestamp = array_pop($tokens);
    $value = implode($sep, $tokens);

    $is_compressed = false;
    if (verify_signature($key, $value . $sep . $timestamp, $signature)) {
        if ($value[0] == '.') {
            $value = substr($value, 1);
            $is_compressed = true;
        }

        $value = urlsafe_b64decode($value);

        if ($is_compressed) {
            $value = zlib_decode($value);
        }

        return json_decode($value);
    }

    return null;
}

function verify_signature($key, $message, $signature) {
    $salt = 'cookie-session';

    $derived_key = hash_hmac('sha1', $salt, $key, true);
    $mac = hash_hmac('sha1', $message, $derived_key, true);
    $org_mac = urlsafe_b64decode($signature);

    return $org_mac == $mac;
}

function urlsafe_b64decode($string) {
    $data = str_replace(
        array('-', '_'),
        array('+', '/'),
        $string);

    return base64_decode($data);
}

function urlsafe_b64encode($string) {
    $data = base64_encode($string);

    $data = str_replace(
        array('+', '/', '='),
        array('-', '_', ''),
        $data);

    return $data;
}
?>
