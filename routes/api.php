<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/add_tags_for_post/{post_id}', [\App\Http\Controllers\PostTagsController::class, 'addTagsForPost']);
