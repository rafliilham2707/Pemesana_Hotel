<?php

use Carbon\Carbon;

if (! function_exists('format_rupiah')) {
    /**
     * Format number to Rupiah currency string.
     * Example: format_rupiah(1250000) -> "Rp 1.250.000"
     */
    function format_rupiah(int|float|null $amount): string
    {
        return 'Rp '.number_format((float) ($amount ?? 0), 0, ',', '.');
    }
}

if (! function_exists('format_tanggal')) {
    /**
     * Format date into localized Indonesian date.
     * Example: format_tanggal('2026-11-06') -> "6 Nov 2026"
     */
    function format_tanggal(?string $date, string $format = 'd M Y'): string
    {
        if (! $date) {
            return '-';
        }

        return Carbon::parse($date)->locale('id')->translatedFormat($format);
    }
}
