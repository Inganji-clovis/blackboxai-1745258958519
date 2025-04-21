<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes for teachers
Route::middleware(['auth:sanctum', 'role:teacher'])->group(function () {
    Route::post('/teacher/courses', [TeacherController::class, 'addCourse']);
    Route::get('/teacher/students', [TeacherController::class, 'listStudents']);
    Route::put('/teacher/students/{id}', [TeacherController::class, 'updateStudent']);
    Route::post('/teacher/assignments', [TeacherController::class, 'createAssignment']);
    Route::post('/teacher/groups', [TeacherController::class, 'createGroup']);
});

// Protected routes for students
Route::middleware(['auth:sanctum', 'role:student'])->group(function () {
    Route::get('/student/teachers', [StudentController::class, 'listTeachers']);
    Route::get('/student/assignments', [StudentController::class, 'listAssignments']);
});
