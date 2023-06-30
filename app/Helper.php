<?php

if (!function_exists('cmToFeet')) {
    function cmToFeet(int $cm): string
    {
        $inches = $cm / 2.54;
        $feet = intval($inches / 12);
        $inches = $inches % 12;
        return sprintf('%dft and %d inches', $feet, $inches);
    }
}
