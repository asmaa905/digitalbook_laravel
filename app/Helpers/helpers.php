<?php

if (!function_exists('cutText')) {
    function cutText($text) {
        if (strlen($text) > 25) {
            return substr($text, 0, 25) . "...";
        }
        return $text;
    }
}