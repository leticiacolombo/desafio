<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Http;

class Mock {

    public function authorization() {
        $response = Http::get(config('constants.MOCK_AUTHORIZATION'));

        if ($response->status()==200) {
            $authorization = $response->json();
            if (isset($authorization['message'])) {
                return strtolower($authorization['message'])=='autorizado';
            }
        }

        return false;
    }

    public function notify() {
        $response = Http::get(config('constants.MOCK_NOTIFY'));

        if ($response->status()==200) {
            if (isset($authorization['message'])) {
                return strtolower($authorization['message'])=='success';
            }
        }

        return false;
    }
}