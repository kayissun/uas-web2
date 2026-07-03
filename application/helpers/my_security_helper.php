<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('esc')) {
    function esc($value, $double_encode = TRUE)
    {
        if (is_array($value)) {
            return array_map(function ($item) use ($double_encode) {
                return esc($item, $double_encode);
            }, $value);
        }

        return html_escape($value, $double_encode);
    }
}
