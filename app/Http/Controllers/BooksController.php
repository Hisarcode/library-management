<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use App\Models\Books;
use App\Models\Issue;
use App\Models\Branch;
use App\Models\Student;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Models\BookCategories;
use App\Models\StudentCategories;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use Exception;

class BooksController extends Controller
{
	public function __construct()
	{

		$this->filter_params = array('category_id');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$book_list = Books::select('book_id', 'title', 'author', 'description', 'book_categories.category')
			->join('book_categories', 'book_categories.id', '=', 'books.category_id')
			->orderBy('book_id')->get();
		// dd($book_list);
		// $this->filterQuery($book_list);

		// $book_list = $book_list->get();

		for ($i = 0; $i < count($book_list); $i++) {

			$id = $book_list[$i]['book_id'];
			$conditions = array(
				'book_id'			=> $id,
				'available_status'	=> 1
			);

			$book_list[$i]['total_books'] = Issue::select()
				->where('book_id', '=', $id)
				->count();

			$book_list[$i]['avaliable'] = Issue::select()
				->where($conditions)
				->count();
		}

		return $book_list;
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$books = $request->all();

		// DB::transaction( function() use($books) {
		// dd($books);
		$db_flag = false;
		$user_id = Auth::id();
		$book_title = Books::create([
			'title'			=> $books['title'],
			'author'		=> $books['author'],
			'description' 	=> $books['description'],
			'category_id'	=> $books['category_id'],
			'added_by'		=> $user_id
		]);
		// dd($book_title);
		$newId = $book_title->book_id;
		// dd($newId);
		if (!$book_title) {
			$db_flag = true;
		} else {
			$number_of_issues = $books['number'];

			for ($i = 0; $i < $number_of_issues; $i++) {

				$issues = Issue::create([
					'book_id'	=> $newId,
					'added_by'	=> $user_id
				]);

				if (!$issues) {
					$db_flag = true;
				}
			}
		}

		if ($db_flag)
			return 'Terdapat kesalahan data';

		// });

		return "Buku berhasil ditambahkan ke database";
	}


	public function BookCategoryStore(Request $request)
	{
		$bookcategory = BookCategories::create($request->all());

		if (!$bookcategory) {

			return 'Kategori buku gagal disimpan!';
		} else {

			return "Kategori buku berhasil ditambah ke database";
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($string)
	{
		$book_list = Books::select('book_id', 'title', 'author', 'description', 'book_categories.category')
			->join('book_categories', 'book_categories.id', '=', 'books.category_id')
			->where('title', 'like', '%' . $string . '%')
			->orWhere('author', 'like', '%' . $string . '%')
			->orderBy('book_id');

		$book_list = $book_list->get();

		foreach ($book_list as $book) {
			$conditions = array(
				'book_id'			=> $book->book_id,
				'available_status'	=> 1
			);

			$count = Issue::where($conditions)
				->count();

			$book->avaliability = ($count > 0) ? true : false;
		}

		return $book_list;
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$issue = Issue::find($id);
		if ($issue == NULL) {
			return 'ID buku invalid';
		}

		$book = Books::find($issue->book_id);

		$issue->book_name = $book->title;
		$issue->author = $book->author;

		$issue->category = Categories::find($book->category_id)
			->category;

		$issue->available_status = (bool)$issue->available_status;
		if ($issue->available_status == 1) {
			return $issue;
		}

		$conditions = array(
			'return_time'	=> 0,
			'book_issue_id'	=> $id,
		);
		$book_issue_log = Logs::where($conditions)
			->take(1)
			->get();

		foreach ($book_issue_log as $log) {
			$student_id = $log->student_id;
		}

		$student_data = Student::find($student_id);

		unset($student_data->email_id);
		unset($student_data->books_issued);
		unset($student_data->approved);
		unset($student_data->rejected);

		$student_branch = Branch::find($student_data->branch)
			->branch;
		$roll_num = $student_data->roll_num . '/' . $student_branch . '/' . substr($student_data->year, 2, 4);

		unset($student_data->roll_num);
		unset($student_data->branch);
		unset($student_data->year);

		$student_data->roll_num = $roll_num;

		$student_data->category = StudentCategories::find($student_data->category)
			->category;
		$issue->student = $student_data;


		return $issue;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function renderAddBookCategory(Type $var = null)
	{
		$categories = BookCategories::all();
		return view('panel.addbookcategory', compact('categories'));
	}

	public function editCategory($id){
		$category = BookCategories::find($id);
		return view('panel.editbookcategory', compact('category'));
	}

	public function updateCategory($id, Request $request){
		$category = BookCategories::find($id);		
		$category->update([
			'category' => $request->category,
		]);

		return redirect()->route('add-book-category');
	}


	public function deleteCategory($id){
		$category = BookCategories::find($id);		
		$category->delete();
		return redirect()->route('add-book-category');
	}

	public function renderAddBooks()
	{
		$db_control = new HomeController();

		return view('panel.addbook')
			->with('categories_list', $db_control->categories_list);
	}

	public function renderAllBooks()
	{
		$books = Books::all();
		$x=0;
		foreach($books as $book){
			$kategori = Categories::find($book['category_id']);
			$jml_buku = DB::table('book_issues')->where('book_id', $book['book_id'])->get();
			$jml_pinjam = DB::table('book_issues')->where('book_id', $book['book_id'])->where('available_status', 1)->get();
			$books[$x]['category'] = $kategori;
			$books[$x]['total'] = count($jml_buku);
			$books[$x]['dipinjam'] = count($jml_pinjam);
			
			$x++;
		}
		// dd($books);

		return view('panel.allbook', compact('books'));
	}

	public function editBook($id){
		$book = Books::find($id);
		
		
		$kategori = Categories::find($book['category_id']);
		$jml_buku = DB::table('book_issues')->where('book_id', $id)->get();
		$jml_pinjam = DB::table('book_issues')->where('book_id', $id)->where('available_status', 1)->get();
		$book['category'] = $kategori;
		$book['total'] = count($jml_buku);
		$book['dipinjam'] = count($jml_pinjam);

		$categories = Categories::all();		
		
		return view('panel.editBook', compact('book', 'categories'));				
	}

	public function updateBook(Books $book, Request $request){
		$book->update([
			'title' => $request->title,
			'author' => $request->author,
			'description' => $request->description,
			'category_id' => $request->category,			

		]);

		return redirect()->route('all-books');
	}

	public function deleteBook(Books $book){
		$book->delete();
		return redirect()->route('all-books');
	}

	public function BookByCategory($cat_id)
	{
		$book_list = Books::select('book_id', 'title', 'author', 'description', 'book_categories.category')
			->join('book_categories', 'book_categories.id', '=', 'books.category_id')
			->where('category_id', $cat_id)->orderBy('book_id');

		$book_list = $book_list->get();

		for ($i = 0; $i < count($book_list); $i++) {

			$id = $book_list[$i]['book_id'];
			$conditions = array(
				'book_id'			=> $id,
				'available_status'	=> 1
			);

			$book_list[$i]['total_books'] = Issue::select()
				->where('book_id', '=', $id)
				->count();

			$book_list[$i]['avaliable'] = Issue::select()
				->where($conditions)
				->count();
		}

		return $book_list;
	}

	public function searchBook()
	{
		$db_control = new HomeController();

		return view('public.book-search')
			->with('categories_list', $db_control->categories_list);
	}
}
