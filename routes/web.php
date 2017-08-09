<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//User Register
Route::get('/register','Auth\RegisterController@getRegisterForm')->name('register');

Route::post('/register','Auth\RegisterController@register')->name('register');

//User Login
Route::post('/login','Auth\LoginController@login')->name('login');
Route::get('/login','Auth\LoginController@showLoginForm')->name('login');
Route::get('/logout','Auth\LoginController@logout')->name('logout');

//Facebook Auth
Route::get('login/facebook', 'Auth\SocialAuthController@loginWithFacebook');
Route::get('login/facebook/callback','Auth\SocialAuthController@callbackFacebook');

//Google Auth
Route::get('login/google', 'Auth\SocialAuthController@loginWithGoogle');
Route::get('login/google/callback','Auth\SocialAuthController@callbackGoogle');

Route::group(["prefix" => "profile","middleware"=>"userrole"],function() {

   Route::get('/', 'ProfileController@home');
   Route::get('/add-quiz', 'ProfileController@addQuiz');
   Route::post('/save-quiz', 'ProfileController@saveQuiz');
   Route::get('/add-question/{quiz_unique}', 'QuestionController@addQuestion');
   Route::post('/save-question', 'QuestionController@saveQuestion');
});
