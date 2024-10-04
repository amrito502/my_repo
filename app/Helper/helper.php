<?php
use Illuminate\Support\Facades\Storage;

function toastrMessage($message_type, $message)
{
    Toastr::$message_type($message, '', ['progressBar' => true, 'closeButton' => true, 'positionClass' => 'toast-top-right']);
}

function get_option($option_key)
{
    $system_settings = config('settings');

    if ($option_key && isset($system_settings[$option_key])) {
        return $system_settings[$option_key];
    } else {
        return '';
    }
}

