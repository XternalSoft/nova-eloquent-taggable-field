<?php

use Illuminate\Support\Facades\Route;
use XternalSoft\NovaEloquentTaggableField\Http\Controllers\TagFieldController;

Route::get('/', [TagFieldController::class, 'index']);
