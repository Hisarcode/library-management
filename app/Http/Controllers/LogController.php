<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use App\Models\Books;
use App\Models\Issue;
use App\Models\Student;
use App\Models\StudentCategories;
use App\Models\BookIssueLog;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;

class LogController extends Controller
{
	public function index()
	{

		$logs = Logs::select('id', 'book_issue_id', 'student_id', 'issued_at')
			->where('return_time', '=', 0)
			->orderBy('issued_at', 'DESC');

		// dd($logs);

		$logs = $logs->get();

		for ($i = 0; $i < count($logs); $i++) {

			$issue_id = $logs[$i]['book_issue_id'];
			$student_id = $logs[$i]['student_id'];

			// to get the name of the book from book issue id
			$issue = Issue::find($issue_id);
			$book_id = $issue->book_id;
			$book = Books::find($book_id);
			$logs[$i]['book_name'] = $book->title;

			// to get the name of the student from student id
			$student = Student::find($student_id);
			$logs[$i]['student_name'] = $student->first_name . ' ' . $student->last_name;

			// change issue date and return date in human readable format
			$logs[$i]['issued_at'] = date('d-M', strtotime($logs[$i]['issued_at']));
			if ($issue->return_time == 0) {
				$logs[$i]['return_time'] =  '<p class="color:red">Pending</p>';
			} else {
				$logs[$i]['return_time'] = date('d-M', strtotime($logs[$i]['return_time']));
			}
		}

		return $logs;
	}

	public function create()
	{
		//
	}

	public function store(Request $request)
	{
		$data = $request->all()['data'];
		$bookID = $data['bookID'];
		$studentID = $data['studentID'];

		$student = Student::find($studentID);

		if ($student == NULL) {
			return "ID murid invalid";
		} else {
			$approved = $student->approved;

			if ($approved == 0) {

				return "Murid masih belum disetujui oleh admin perpustakaan";
				// throw new Exception('');
			} else {
				$books_issued = $student->books_issued;
				$category = $student->category;

				$max_allowed = StudentCategories::where('cat_id', '=', $category)->firstOrFail()->max_allowed;

				if ($books_issued >= $max_allowed) {

					return 'Murid tidak dapat meminjam lebih banyak buku';
				} else {

					$book = Issue::where('book_id', $bookID)->where('available_status', '!=', 0)->first();

					if ($book == NULL) {

						return 'ID peminjaman buku invalid';
					} else {

						$book_availability = $book->available_status;
						// dd($book);
						if ($book_availability != 1) {
							return 'Buku tidak tersedia';
						} else {

							// book is to be issued
							DB::transaction(function () use ($bookID, $studentID) {

								$book = Issue::where('book_id', $bookID)->where('available_status', '!=', 0)->first();
								// changing the availability status
								$book_issue_update = Issue::where('book_id', $bookID)->where('issue_id', $book->issue_id)->first();
								$book_issue_update->available_status = 0;
								$book_issue_update->save();

								// increasing number of books issed by student
								$student = Student::find($studentID);
								$student->books_issued = $student->books_issued + 1;
								$student->save();

								$log = new Logs;

								$log->book_issue_id = $book->issue_id;
								$log->student_id	= $studentID;
								$log->issue_by		= Auth::id();
								$log->issued_at		= date('Y-m-d H:i');
								$log->return_time	= 0;

								$log->save();
							});

							return 'Berhasil dipinjam!';
						}
					}
				}
			}
		}
	}

	public function show($id)
	{
		//
	}

	public function edit($id)
	{
		$issueID = $id;

		$conditions = array(
			// 'book_issue_id'	=> $issueID,
			'id'	=> $issueID,
			'return_time'	=> 0
		);

		$log = Logs::where($conditions);

		if (!$log->count()) {
			return 'ID buku yang dimasukkan invalid atau buku sudah dikembalikan';
		} else {

			$log = Logs::where($conditions)
				->firstOrFail();


			$log_id = $log['id'];
			$student_id = $log['student_id'];
			$issue_id = $log['book_issue_id'];


			DB::transaction(function () use ($log_id, $student_id, $issue_id) {
				// change log status by changing return time
				$log_change = Logs::find($log_id);
				$log_change->return_time = date('Y-m-d H:i');
				$log_change->save();

				// decrease student book issue counter
				$student = Student::find($student_id);
				$student->books_issued = $student->books_issued - 1;
				$student->save();

				// change issue availability status
				$issue = Issue::find($issue_id);
				$issue->available_status = 1;
				$issue->save();
			});

			return 'Berhasil dikembalikan';
		}
	}

	public function update($id)
	{
		//
	}

	public function destroy($id)
	{
		//
	}

	public function renderLogs()
	{
		return view('panel.logs');
	}

	public function renderIssueReturn()
	{
		return view('panel.issue-return');
	}
	public function laporantotal()
	{
		$riwayat = BookIssueLog::get()->all();


		for ($i = 0; $i < count($riwayat); $i++) {

			$issue_id = $riwayat[$i]['book_issue_id'];
			$student_id = $riwayat[$i]['student_id'];

			// to get the name of the book from book issue id
			$issue = Issue::find($issue_id);
			$book_id = $issue->book_id;
			$book = Books::find($book_id);
			$riwayat[$i]['book_name'] = $book->title;

			// to get the name of the student from student id
			$student = Student::find($student_id);
			$riwayat[$i]['student_name'] = $student->first_name . ' ' . $student->last_name;
			$riwayat[$i]['kelas'] = $student->branch;
			$kategori = StudentCategories::find($student->category);
			$riwayat[$i]['kategori'] = $kategori->category;

			// change issue date and return date in human readable format

			$riwayat[$i]['issued_at'] = date('d-M', strtotime($riwayat[$i]['issued_at']));
			if ($riwayat[$i]['return_time'] == 0) {
				$riwayat[$i]['return_time'] =  '<p class="color:red">Pending</p>';
			} else {
				$riwayat[$i]['return_time'] = date('d-M', strtotime($riwayat[$i]['return_time']));
			}
		}

		return view('panel.totalpeminjaman', compact('riwayat'));
	}


public function cetakpdf()
{
	$riwayat = BookIssueLog::get()->all();


	for ($i = 0; $i < count($riwayat); $i++) {

		$issue_id = $riwayat[$i]['book_issue_id'];
		$student_id = $riwayat[$i]['student_id'];

		// to get the name of the book from book issue id
		$issue = Issue::find($issue_id);
		$book_id = $issue->book_id;
		$book = Books::find($book_id);
		$riwayat[$i]['book_name'] = $book->title;

		// to get the name of the student from student id
		$student = Student::find($student_id);
		$riwayat[$i]['student_name'] = $student->first_name . ' ' . $student->last_name;
		$riwayat[$i]['kelas'] = $student->branch;
		$kategori = StudentCategories::find($student->category);
		$riwayat[$i]['kategori'] = $kategori->category;

		// change issue date and return date in human readable format

		$riwayat[$i]['issued_at'] = date('d-M', strtotime($riwayat[$i]['issued_at']));
		if ($riwayat[$i]['return_time'] == 0) {
			$riwayat[$i]['return_time'] =  '<p class="color:red">Pending</p>';
		} else {
			$riwayat[$i]['return_time'] = date('d-M', strtotime($riwayat[$i]['return_time']));
		}
	}

	$pdf = PDF::loadview('panel.cetak_pdf',compact('riwayat'));
    return $pdf->download('nama file');

}


}
