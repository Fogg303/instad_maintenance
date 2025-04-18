<?php

if (!function_exists('get_status_color')) {
    function get_status_color(string $status): string
    {
        return match(strtolower($status)) {
            'open'       => 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100',
            'in_progress' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100',
            'resolved'   => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
            'closed'     => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
            default      => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'
        };
    }
}