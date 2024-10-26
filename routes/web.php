<?php
use BblStudio\BblStudio\Controllers\VEditerMediaController;
use BblStudio\BblStudio\Controllers\VEditerController;
use BblStudio\BblStudio\Controllers\VEditerUploadController;
use Illuminate\Support\Facades\Route;

Route::get(config('bblstudio.VEDITOR_URL'),[VEditerController::class,'index'])->name(config('bblstudio.VEDITOR_ROUTE_NAME'))->middleware(config('bblstudio.VEDITOR_MIDDLEWARE_ALIAS'));
Route::get('/'.config('bblstudio.VEDITOR_URL').'/{page}',[VEditerController::class,'openPageInVEditor'] )->name('veditor.page');
Route::get('/vediter-scan-media', [VEditerMediaController::class, 'scanMedia']);
Route::post('/vediter-delete-media', [VEditerMediaController::class, 'deleteMedia']);
Route::post('/vediter-rename-media', [VEditerMediaController::class, 'renameMedia']);
Route::post('/vediter-upload-media', [VEditerUploadController::class, 'uploadFile']);
Route::post('/vediter-save-page', [VEditerController::class, 'savePage']);
