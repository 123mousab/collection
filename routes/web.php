<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/pricing_lamps_and_wallet', [\App\Collection\RefactoringCollection::class, 'pricingLampsAndWallet']);
Route::get('/csv_surgery_101', [\App\Collection\RefactoringCollection::class, 'csvSurgery101']);
Route::get('/binary_to_decimal', [\App\Collection\RefactoringCollection::class, 'binaryToDecimal']);
Route::get('/github_score', [\App\Collection\RefactoringCollection::class, 'githubScore']);
