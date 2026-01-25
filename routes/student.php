<?php

use App\Http\Controllers\Student\StudentFormController;
use Illuminate\Support\Facades\Route;

Route::resource("/ppq", StudentFormController::class)->names("student")->only("index", "store");
