<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get(); //
// Route::post(); //
// Route::put(); //edit/update or delete whole data and change
// Route::patch(); //delete some portion of the data and change
// Route::delete(); //delete data
// Route::options(); // allow/control the method url

// Route::match(['get', 'post'], '/', function(){
//     return 'POST and GET is allowed';
// });

// Route::view('/ welcome', 'welcome');
// Route::permanentRedirect('/welcome', '/');


// Route::get('/users', [ UserController::class, 'index']);

// Route::get('/user/{id}', [UserController::class, 'show']);

// Route::get('student/{id}', [StudentController::class , 'show']);

// Route::get('/test', function () {return view('test');});//tailwind

//common routes naming
//index - Show all data or students
//show - Show a single data or students
//create - Show a form to a new user
//edit - Show a for to a data
//update - updtae a data
//destroy - delete a data


// Route::controller(UserController::class)->group(function(){
//     Route::get('/register','register');
//     Route::get('/login','login')->name('login')->middleware('guest');
//     Route::post('/login/process','process');
//     Route::post('/logout','logout');
//     Route::post('/store','store');
// });

// Route::controller(StudentController::class)->group(function(){
//     Route::get('/','index')->middleware('auth');
//     Route::get('/add/student', 'create');
//     Route::post('/add/student', 'store');
//     Route::get('/student/{id}', 'show');
//     Route::put('/student/{student}', 'update');
//     Route::delete('/student/{student}', 'destroy');
// });

Route::controller(UserController::class)->group(function(){
    Route::get('/register', 'register');
    Route::get('/login', 'login')->name('login')->middleware('guest');
    Route::post('/login/process', 'process');   
    Route::post('/logout', 'logout');   
    Route::post('/store', 'store');
});

Route::controller(StudentController::class)->group(function(){
    Route::get('/', 'index')->middleware('auth');
    Route::get('/add/student', 'create');
    Route::post('/add/student', 'store');
    Route::get('/student/{student}', 'show');
    Route::put('/student/{student}', 'update');
    Route::delete('/student/{student}', 'destroy');
});

