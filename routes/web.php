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

// Unauthenticated group 
Route::group(array('before' => 'guest'), function () {

	// CSRF protection 
	Route::group(array('before' => 'csrf'), function () {

		// Create an account (POST) 
		Route::post('/create', array(
			'as' => 'account-create-post',
			'uses' => 'AccountController@postCreate'
		));

		// Sign in (POST) 
		Route::post('/sign-in', array(
			'as' => 'account-sign-in-post',
			'uses' => 'AccountController@postSignIn'
		));

		// Sign in (POST) 
		Route::post('/student-registration', array(
			'as' => 'student-registration-post',
			'uses' => 'StudentController@postRegistration'
		));
	});

	// Sign in (GET) 
	Route::get('/', array(
		'as' 	=> 'account-sign-in',
		'uses'	=> 'AccountController@getSignIn'
	));

	// Create an account (GET) 
	Route::get('/create', array(
		'as' 	=> 'account-create',
		'uses' 	=> 'AccountController@getCreate'
	));

	// Student Registeration form 
	Route::get('/student-registration', array(
		'as' 	=> 'student-registration',
		'uses' 	=> 'StudentController@getRegistration'
	));

	// Render search books panel
	Route::get('/book', array(
		'as' => 'search-book',
		'uses' => 'BooksController@searchBook'
	));
});

// Main books Controlller left public so that it could be used without logging in too
Route::resource('/books', 'BooksController');

// Authenticated group 
// Route::group(array('before' => 'auth'), function() {
Route::group(['middleware' => ['auth']], function () {

	// Home Page of Control Panel
	Route::get('/home', array(
		'as' 	=> 'home',
		'uses'	=> 'HomeController@home'
	));

	// Render Add Books panel
	Route::get('/add-books', array(
		'as' => 'add-books',
		'uses' => 'BooksController@renderAddBooks'
	));

	Route::get('/add-book-category', array(
		'as' => 'add-book-category',
		'uses' => 'BooksController@renderAddBookCategory'
	));

	Route::get('/categories/edit/{id}', 'BooksController@editCategory')->name('category.edit');
	Route::put('/categories/{id}', 'BooksController@updateCategory')->name('category.update');
	Route::delete('/categories/{id}', 'BooksController@deleteCategory')->name('category.delete');

	Route::post('/bookcategory', 'BooksController@BookCategoryStore')->name('bookcategory.store');


	// Render All Books panel
	Route::get('/all-books', array(
		'as' => 'all-books',
		'uses' => 'BooksController@renderAllBooks'
	));

	// Render All Books panel
	Route::get('/books/edit/{id}', 'BooksController@editBook')->name('book.edit');
	Route::put('/books/{book}', 'BooksController@updateBook')->name('book.update');
	Route::delete('/books/{book}', 'BooksController@deleteBook')->name('book.delete');

	Route::get('/bookBycategory/{cat_id}', array(
		'as' => 'bookBycategory',
		'uses' => 'BooksController@BookByCategory'
	));

	// Students
	Route::get('/registered-students', array(
		'as' => 'registered-students',
		'uses' => 'StudentController@semuaMurid'
	));
	Route::get('/murid/edit/{id}', 'StudentController@editMurid')->name('murid.edit');
	Route::put('/murid/{id}', 'StudentController@updateMurid')->name('murid.update');
	Route::delete('/murid/{id}', 'StudentController@deleteMurid')->name('murid.delete');

	// Render students approval panel
	Route::get('/students-for-approval', array(
		'as' => 'students-for-approval',
		'uses' => 'StudentController@renderApprovalStudents'
	));

	// Render students approval panel
	Route::get('/settings', array(
		'as' => 'settings',
		'uses' => 'StudentController@Setting'
	));

	Route::get('/class/edit/{id}', 'StudentController@editClass')->name('class.edit');
	Route::put('/class/{id}', 'StudentController@updateClass')->name('class.update');
	// Route::delete('/class/{id}', 'StudentController@deleteClass')->name('class.delete');

	Route::get('/student/class/edit/{id}', 'StudentController@editStudentClass')->name('student.category.edit');
	Route::put('/student/class/{id}', 'StudentController@updateStudentClass')->name('student.category.update');
	// Route::delete('/student/class/{id}', 'StudentController@deleteStudentClass')->name('student.category.delete');


	// Render students approval panel
	Route::post('/setting', array(
		'as' => 'settings.store',
		'uses' => 'StudentController@StoreSetting'
	));

	// Main students Controlller resource
	Route::resource('/student', 'StudentController');

	Route::post('/studentByattribute', array(
		'as' => 'studentByattribute',
		'uses' => 'StudentController@StudentByAttribute'
	));

	// Issue Logs
	Route::get('/issue-return', array(
		'as' => 'issue-return',
		'uses' => 'LogController@renderIssueReturn'
	));

	Route::post('/book-issue', 'LogController@pinjamBuku')->name('pinjam.buku');
	Route::post('/return-book', 'LogController@kembalikanBuku')->name('kembalikan.buku');

	Route::post('/add-book', 'BooksController@store')->name('store.book');
	// Render logs panel
	Route::get('/currently-issued', array(
		'as' => 'currently-issued',
		'uses' => 'LogController@renderLogs'
	));

	// Untuk Laporan total
	Route::get('/laporan-total', array(
		'as' => 'laporan-total',
		'uses' => 'LogController@laporantotal'
	));


	// Untuk Laporan total
	Route::get('/laporan/pdf', array(
		'as' => 'cetak_pdf',
		'uses' => 'LogController@cetakpdf'
	));

	// Main Logs Controlller resource
	Route::resource('/issue-log', 'LogController');

	// Sign out (GET) 
	Route::get('/sign-out', array(
		'as' => 'account-sign-out',
		'uses' => 'AccountController@getSignOut'
	));
});
