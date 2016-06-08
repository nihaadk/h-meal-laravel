<?php


Route::get('/', 'Auth\AuthController@getLogin');

// App
Route::get('app', 'AdminController@showApp');

//Admin dashboard and controll Users 
Route::get('app/user/list', 'AdminController@showUserList');
Route::post('app/user/add', 'AdminController@addUser');
Route::delete('app/user/delete/{id}', 'AdminController@destroy');
Route::put('app/user/update/{id}', 'AdminController@update');


// Patient
Route::get('app/patient/list', 'PatientController@index');
Route::post('app/patient/add', 'PatientController@store');
Route::delete('app/patient/delete/{id}', 'PatientController@destroy');
Route::put('app/patient/update/{id}', 'PatientController@update');
Route::get('app/patient/table', 'PatientController@tableShow');


// Food
Route::get('app/food/list', 'FoodController@index');
Route::post('app/food/add', 'FoodController@store');
Route::delete('app/food/delete/{id}', 'FoodController@destroy');
Route::put('app/food/update/{id}', 'FoodController@update');
Route::get('app/food/quantity/{id}', 'FoodController@upQuantity');



// Patient details 
Route::get('app/patient/detail/{id}','PatientDetailController@showDetails' );
Route::post('app/patient/store_day_v/{id}', 'PatientDetailController@storeDayVisits');
Route::post('app/patient/store_m_sugar/{id}', 'PatientDetailController@storeMsugar');
Route::post('app/patient/store_visits/{id}', 'PatientDetailController@storeVisits');



// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');




Route::get('/users', function()
{

   $users = new \App\User;

   return $users::all();
});

