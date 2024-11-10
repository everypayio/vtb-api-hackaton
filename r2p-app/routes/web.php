<?php

use Illuminate\Support\Facades\Route;

Route::get('/landing', function () {
    return redirect('/');
});
