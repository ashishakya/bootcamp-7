<?php
declare(strict_types=1);


use Carbon\Carbon;

if (!function_exists("formatCarbonDate")) {
    function formatCarbonDate(Carbon $carbonDate): array
    {
        return [
            "raw"            => $carbonDate,
            "diff_for_human" => $carbonDate->diffForHumans(),
            "date_string"    => $carbonDate->format("Y-m-d"),
        ];
    }
}


if (!function_exists("sum")) {
    function sum(int $num1, int $num2):int
    {
        return $num1 + $num2;
    }
}

