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

Route::get('/' , 'HomeController@index');
Route::get('home' , 'HomeController@index');

//User Register
Route::get('/register','Auth\RegisterController@getRegisterForm')->name('register');

Route::post('/register','Auth\RegisterController@register')->name('register');

//User Login
Route::post('/login','Auth\LoginController@login')->name('login');
Route::get('/login','Auth\LoginController@showLoginForm')->name('login');
Route::post('/logout','Auth\LoginController@logout')->name('logout');

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
   Route::get('/edit-quiz/{quiz_unique}', 'ProfileController@editQuiz');
   Route::post('/update-quiz', 'ProfileController@updateQuiz');
   Route::get('/add-question/{quiz_unique}', 'QuestionController@addQuestion');
   Route::post('/save-question', 'QuestionController@saveQuestion');
   Route::get('/edit-question/{quiz_unique}/{question_unique}', 'QuestionController@editQuestion');
   Route::post('/update-question', 'QuestionController@updateQuestion');
   Route::get('/quizzes', 'ProfileController@showCreatedQuiz');
   Route::get('/played-quiz', 'ProfileController@showPlayedQuiz');
   
});

//Play Quiz
Route::get('quiz/{quiz_slug}' , 'QuizController@home');
Route::post('quiz/play/{quiz_slug}' , 'QuizController@playQuiz');

//Show Quiz Results
Route::get('result/quiz/{quiz_slug}/play/{play_unique}' , 'QuizController@showResult');