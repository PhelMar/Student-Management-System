<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcomePage');
});

require __DIR__.'/auth.php';
require __DIR__.'/auth-admin.php';
require __DIR__.'/auth-user.php';
require __DIR__.'/auth-guard.php';


