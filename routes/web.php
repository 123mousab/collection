<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/pricing_lamps_and_wallet', [\App\Collection\RefactoringCollection::class, 'pricingLampsAndWallet']);
Route::get('/csv_surgery_101', [\App\Collection\RefactoringCollection::class, 'csvSurgery101']);
Route::get('/binary_to_decimal', [\App\Collection\RefactoringCollection::class, 'binaryToDecimal']);
Route::get('/github_score', [\App\Collection\GithubScore::class, 'score']);
Route::get('/build_comment', [\App\Collection\RefactoringCollection::class, 'buildComment']);
Route::get('/compare_revenue', [\App\Collection\RefactoringCollection::class, 'compareRevenue']);
Route::get('/hamming_distance', [\App\Collection\RefactoringCollection::class, 'hamming_distance']);
Route::get('/lookup_table', [\App\Collection\RefactoringCollection::class, 'lookupTable']);
Route::get('/ranking_competition', [\App\Collection\RefactoringCollection::class, 'rankingCompetition']);
