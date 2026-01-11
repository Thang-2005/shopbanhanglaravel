<?php

if (!function_exists('convertNumberToWords')) {
    function convertNumberToWords($number)
    {
        $words = ['không','một','hai','ba','bốn','năm','sáu','bảy','tám','chín'];
        $units = ['', 'nghìn', 'triệu', 'tỷ'];

        if ($number == 0) {
            return 'Không đồng';
        }

        $result = '';
        $unitIndex = 0;

        while ($number > 0) {
            $chunk = $number % 1000;

            if ($chunk > 0) {
                $chunkWords = '';

                $hundreds = intdiv($chunk, 100);
                $tens = intdiv($chunk % 100, 10);
                $ones = $chunk % 10;

                if ($hundreds > 0) {
                    $chunkWords .= $words[$hundreds].' trăm ';
                }
                if ($tens > 1) {
                    $chunkWords .= $words[$tens].' mươi ';
                }
                if ($ones > 0) {
                    $chunkWords .= $words[$ones].' ';
                }

                $result = trim($chunkWords).' '.$units[$unitIndex].' '.$result;
            }

            $number = intdiv($number, 1000);
            $unitIndex++;
        }

        return trim($result).' đồng';
    }
}
