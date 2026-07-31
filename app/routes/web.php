<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {

    try {
        DB::connection()->getPdo();

        $status = "✅ MySQL Connected Successfully";
    } catch (\Exception $e) {

        $status = "❌ Database Connection Failed";
    }

    return view('welcome', compact('status'));
});
