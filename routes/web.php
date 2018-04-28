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
Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
// GroupController
Route::get('/groups', 'GroupController@groupsDashboard')->name('groupsdashboard');
Route::get('/addgroups', 'GroupController@addGroup')->name('addgroup');
Route::post('/addgroupconfirm', 'GroupController@addGroupConfirm')->name('addgroupconfirm');
Route::post('/addgroupprocess', 'GroupController@addGroupProcess')->name('addgroupprocess');
Route::get('/groups/edit/{id}', 'GroupController@editGroup')->name('editgroup');

// MemberController
Route::post('/members/edit/{id}', 'MemberController@editMemberProcess');
Route::post('/members/addprocess', 'MemberController@addMemberProcess');
