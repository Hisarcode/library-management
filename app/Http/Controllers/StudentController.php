<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Logs;
use App\Models\Books;
use App\Models\Issue;
use App\Models\Branch;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\StudentCategories;
use App\Http\Controllers\HomeController;
use App\Models\BookIssueLog;
use Illuminate\Support\Facades\Redirect;

class StudentController extends Controller
{
	public function __construct()
	{

		$this->filter_params = array('branch', 'year', 'category');
	}

	public function index()
	{
		$conditions = array(
			'approved'	=> 0,
			'rejected'	=> 0
		);

		$students = Student::join('branches', 'branches.id', '=', 'students.branch')
			->join('student_categories', 'student_categories.cat_id', '=', 'students.category')
			->select('student_id', 'first_name', 'last_name', 'student_categories.category', 'roll_num', 'branches.branch', 'year')
			->where($conditions)
			->orderBy('student_id');

		// $this->filterQuery($students);
		$students = $students->get();
		// dd($students);
		return $students;
	}

	public function StudentByAttribute(Request $request)
	{
		// dd($request->branch );
		$conditions = array(
			'approved'	=> 0,
			'rejected'	=> 0
		);
		if ($request->branch != 0) {

			$students = Student::join('branches', 'branches.id', '=', 'students.branch')
				->join('student_categories', 'student_categories.cat_id', '=', 'students.category')
				->select('student_id', 'first_name', 'last_name', 'student_categories.category', 'roll_num', 'branches.branch', 'year')
				->where($conditions)
				->where('students.branch', $request->branch)
				->orderBy('student_id');
			$students = $students->get();
			return $students;
		} elseif ($request->category != 0) {

			$students = Student::join('branches', 'branches.id', '=', 'students.branch')
				->join('student_categories', 'student_categories.cat_id', '=', 'students.category')
				->select('student_id', 'first_name', 'last_name', 'student_categories.category', 'roll_num', 'branches.branch', 'year')
				->where($conditions)
				->where('students.category', $request->category)
				->orderBy('student_id');
			$students = $students->get();
			return $students;
		} elseif ($request->year != 0) {
			// dd($request->year );
			$students = Student::join('branches', 'branches.id', '=', 'students.branch')
				->join('student_categories', 'student_categories.cat_id', '=', 'students.category')
				->select('student_id', 'first_name', 'last_name', 'student_categories.category', 'roll_num', 'branches.branch', 'year')
				->where($conditions)
				->where('students.year', $request->year)
				->orderBy('student_id');
			$students = $students->get();

			return $students;
		}
		return "Tidak ditemukan";
	}


	public function create()
	{
		$conditions = array(
			'approved'	=> 1,
			'rejected'	=> 0
		);

		$students = Student::join('branches', 'branches.id', '=', 'students.branch')
			->join('student_categories', 'student_categories.cat_id', '=', 'students.category')
			->select('student_id', 'first_name', 'last_name', 'student_categories.category', 'roll_num', 'branches.branch', 'year', 'email_id', 'books_issued')
			->where($conditions)
			->orderBy('student_id');

		// $this->filterQuery($students);
		$students = $students->get();

		return $students;
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$student = Student::find($id);
		if ($student == NULL) {
			throw new Exception('ID murid invalid');
		}

		$student->year = (int)substr($student->year, 2, 4);

		$student_category = StudentCategories::find($student->category);
		$student->category = $student_category->category;

		$student_branch = Branch::find($student->branch);
		$student->branch = $student_branch->branch;


		if ($student->rejected == 1) {
			unset($student->approved);
			unset($student->books_issued);
			$student->rejected = (bool)$student->rejected;

			return $student;
		}

		if ($student->approved == 0) {
			unset($student->rejected);
			unset($student->books_issued);
			$student->approved = (bool)$student->approved;

			return $student;
		}

		unset($student->rejected);
		unset($student->approved);

		$student_issued_books = Logs::select('book_issue_id', 'issued_at')
			->where('student_id', '=', $id)
			->orderBy('created_at', 'desc')
			->take($student->books_issued)
			->get();

		foreach ($student_issued_books as $issued_book) {
			$issue = Issue::find($issued_book->book_issue_id);
			$book = Books::find($issue->book_id);
			$issued_book->name = $book->title;

			$issued_book->issued_at = date('d-M', strtotime($issued_book->issued_at));
		}

		$student->issued_books = $student_issued_books;

		return $student;
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		$flag = (bool)$request->get('flag');

		$student = Student::findOrFail($id);

		if ($flag) {
			// if student is approved
			$student->approved = 1;
		} else {
			// if student is rejected for some reason
			$student->rejected = 1;
		}

		$student->save();

		return "Status penerimaan/penolakan murid berhasil diubah.";
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Request $request, $id)
	{
		// dd($request->all());
		if ($request->category) {

			$student = StudentCategories::find($id);
			$student->delete();
			if (!$student) {
				return "Kategori murid gagal dihapus!.";
			} else {
				return redirect(route('settings'));
			}
		} elseif ($request->branch) {

			$branch = Branch::find($id);
			$branch->delete();
			if (!$branch) {
				return "Kelas gagal dihapus!.";
			} else {
				return redirect(route('settings'));
			}
		}
	}


	public function renderStudents()
	{
		$db_control = new HomeController;
		return view('panel.students')
			->with('branch_list', $db_control->branch_list)
			->with('student_categories_list', $db_control->student_categories_list);
	}

	public function semuaMurid()
	{
		$students = Student::get()->all();
		$x = 0;
		foreach ($students as $student) {
			$students[$x]['buku_dipinjam']  = 	count(BookIssueLog::where('student_id', '=', $student['student_id'])->get());
			$x++;
		}
		// dd($students);
		// BookIssueLog::
		return view('panel.students', compact('students'));
	}

	public function editMurid($id)
	{
		$student = Student::find($id);
		// dd($student);
		return view('panel.studentEdit', compact('student'));
	}

	public function updateMurid(Request $request, $id)
	{
		$student = Student::find($id);
		$student->update([
			'first_name' => $request->first_name,
			'last_name' => $request->last_name,
			'email_id' => $request->email_id,
			'year' => $request->year,
			'roll_num' => $request->roll_num,
		]);

		return redirect()->route('registered-students');
	}
	public function deleteMurid($id)
	{
		$student = Student::find($id);
		$student->delete();
		return redirect()->route('registered-students');
	}

	public function renderApprovalStudents()
	{
		$db_control = new HomeController;
		return view('panel.approval')
			->with('branch_list', $db_control->branch_list)
			->with('student_categories_list', $db_control->student_categories_list);
	}

	public function getRegistration()
	{
		$db_control = new HomeController;
		return view('public.registration')
			->with('branch_list', $db_control->branch_list)
			->with('student_categories_list', $db_control->student_categories_list);
	}

	public function postRegistration(Request $request)
	{

		$validator = $request->validate([

			'first'			=> 'required|alpha',
			'last'			=> 'required|alpha',

			'year'			=> 'required|integer',
			'email'			=> 'required|email',
			'category'		=> 'required|between:0,5'

		]);

		if (!$validator) {
			return Redirect::route('student-registration')
				->withErrors($validator)
				->withInput();   // fills the field with the old inputs what were correct

		} else {
			$student = Student::create(array(
				'first_name'	=> $request->get('first'),
				'last_name'		=> $request->get('last'),
				'category'		=> $request->get('category'),
				'roll_num'		=> $request->get('rollnumber'),
				'branch'		=> $request->get('branch'),
				'year'			=> $request->get('year'),
				'email_id'		=> $request->get('email'),
			));

			if ($student) {
				return Redirect::route('student-registration')
					->with('successalert', 'Permintaan berhasil diterima!');
			}
		}
	}

	public function Setting()
	{
		$branches = Branch::all();
		$student_category = StudentCategories::all();

		return view('panel.addsettings')
			->with('branches', $branches)
			->with('student_category', $student_category);
	}

	public function editClass($id)
	{
		$branch = Branch::find($id);
		return view('panel.editclass', compact('branch'));
	}

	public function updateClass($id, Request $request)
	{
		$branch = Branch::find($id);
		$branch->update([
			'branch' => $request->branch,
		]);

		return redirect()->route('settings');
	}

	// public function deleteClass($id){
	// 	$branch = Branch::find($id);		
	// 	$branch->delete();
	// 	return redirect()->route('settings');
	// }

	public function editStudentClass($id)
	{
		$studentClass = StudentCategories::find($id);
		return view('panel.editstudentclass', compact('studentClass'));
	}

	public function updateStudentClass($id, Request $request)
	{
		$studentClass = StudentCategories::find($id);
		$studentClass->update([
			'category' => $request->category,
			'max_allowed' => $request->max_allowed,
		]);

		return redirect()->route('settings');
	}



	public function StoreSetting(Request $request)
	{
		// dd($request->all());
		if ($request->category) {

			$student = StudentCategories::create($request->all());

			if (!$student) {
				return "Kategori murid gagal disimpan!.";
			} else {
				return "Kategori murid berhasil disimpan!.";
				// return back();
			}
		} elseif ($request->branch) {

			$branch = Branch::create($request->all());

			if (!$branch) {
				return "Kelas gagal disimpan!.";
			} else {
				return "Kelas berhasil disimpan!.";
				// return back();
			}
		}
	}
}
