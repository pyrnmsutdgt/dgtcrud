<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnrollmentController;

Route::resource('enrollments', EnrollmentController::class);
Route::get('/', [EnrollmentController::class, 'index']); // ให้หน้าแรกวิ่งเข้า Controller นี้เลย
Route::post('/students', [EnrollmentController::class, 'storeStudent'])->name('students.store');
Route::get('/students/{id}/details', [EnrollmentController::class, 'showStudent'])->name('students.show');
Route::get('/report', [EnrollmentController::class, 'report'])->name('report.index');