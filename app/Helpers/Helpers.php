<?php // Code within app\Helpers\Helper.php


if (!function_exists('get_label_activo')) {
    /**
     * Returns a human readable file size
     *
     * @param integer $bytes
     * Bytes contains the size of the bytes to convert
     *
     * @param integer $decimals
     * Number of decimal places to be returned
     *
     * @return string a string in human readable format
     *
     * */
    function get_label_activo($activo)
    {
        return $activo ? '<span class="label label-success">Activo</span>' : '<span class="label label-danger">Inactivo</span>';
    }
}


