<?php

// class HomeController extends BaseController {
namespace App\Http\Controllers;

use App\Models\BookIssueLog;
use Illuminate\Http\Request;
use App\Models\StudentCategories;

use App\Models\Branch;

use App\Models\Categories;
use App\Models\Student;
use Exception;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public $categories_list = array();
    public $branch_list = array();
    public $student_categories_list = array();

    public function __construct()
    {
        $this->categories_list = Categories::select()->orderBy('category')->get();
        $this->branch_list = Branch::select()->orderBy('id')->get();
        $this->student_categories_list = StudentCategories::select()->orderBy('cat_id')->get();
    }

    public function home()
    {
        $buku_tersedia = DB::table('books')->sum('qty');
        $buku_dipinjam = BookIssueLog::orderBy('id', 'DESC')->count();
        $total_murid = Student::orderBy('student_id', 'DESC')->count();

        return view('panel.index')
            ->with('buku_tersedia', $buku_tersedia)
            ->with('buku_dipinjam', $buku_dipinjam)
            ->with('total_murid', $total_murid)
            ->with('categories_list', $this->categories_list)
            ->with('branch_list', $this->branch_list)
            ->with('student_categories_list', $this->student_categories_list);
    }
}
