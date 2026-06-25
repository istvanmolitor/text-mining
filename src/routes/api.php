<?php

use Illuminate\Support\Facades\Route;
use Molitor\TextMining\Http\Controllers\Api\CorpusTextApiController;

Route::prefix('admin/text-mining')
    ->middleware(['api', 'auth:sanctum', 'permission:text-mining'])
    ->name('text-mining.')
    ->group(function () {
        Route::resource('corpus-texts', CorpusTextApiController::class);
    });
