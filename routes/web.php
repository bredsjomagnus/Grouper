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
Route::get('/groups/addgroups', 'GroupController@addGroups')->name('addgroups');
Route::post('/addgroupconfirm', 'GroupController@addGroupConfirm')->name('addgroupconfirm');
Route::post('/addgroupprocess', 'GroupController@addGroupProcess')->name('addgroupprocess');
Route::get('/groups/edit/{id}', 'GroupController@editGroup')->name('editgroup');
Route::post('/groups/editnameprocess', 'GroupController@editGroupName')->name('editgroupnameprocess');
Route::get('/groups/delete/{id}', 'GroupController@deleteGroupProcess')->name('deletegroup');

// MemberController
Route::post('/members/edit/{id}', 'MemberController@editMemberProcess');
Route::post('/members/addprocess', 'MemberController@addMemberProcess');
Route::get('/members/delete/{id}', 'MemberController@deleteMember');
Route::get('/members/move', 'MemberController@moveMember');

// ChoiceController
Route::get('/choices/addchoices', 'ChoiceController@addChoices')->name('addchoices');
Route::post('/choices/addchoicesconfirm', 'ChoiceController@addChoicesConfirm')->name('addchoicesconfirm');
Route::post('/choices/addoneprocess', 'ChoiceController@addChoiceProcess')->name('addchoiceprocess');
Route::post('/choices/addprocess', 'ChoiceController@addChoicesProcess')->name('addchoicesprocess');
Route::get('/choices/edit', 'ChoiceController@editChoices')->name('editchoice');
Route::get('/choices/delete/{id}', 'ChoiceController@deleteChoicesProcess')->name('deletechoice');
Route::post('/choices/newname/{id}', 'ChoiceController@editChoicesProcess')->name('editchoiceprocess');

// EventController
Route::get('/events/create', 'EventController@createEvent')->name('createevent');
Route::post('/events/createprocess', 'EventController@createEventProcess')->name('createeventprocess');
Route::get('/events/delete/{id}', 'EventController@deleteEventProcess')->name('deleteeventprocess');
Route::get('/events/edit/{id}', 'EventController@editEvent')->name('editevent');
