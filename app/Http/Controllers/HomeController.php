<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Expense;
use Lava;
use Carbon\Carbon;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = Lava::DataTable();

        $data->addNumberColumn('Month')
             ->addNumberColumn('Expense');

        // Random Data For Example
        for ($a = 0; $a < 6; $a++) {
            $m = date('m') - $a;
            $expense = Expense::whereMonth('created_at', $m)->sum('total');

            $rowData = [
              "$m", $expense
            ];

            $data->addRow($rowData);
        }
        Lava::LineChart('Expenses', $data, 'expense_div');

        $expenses = Expense::where('user', Auth::user()->id)->paginate(10); //where('created_at', '=', Carbon::today())->get();

        return view('home',['expenses' => $expenses]);
    }

    public function expense(Request $request)
    {
        $request->validate([
            'description' => 'required|max:255',
            'total' => 'required',
            'date' => 'required',
        ]);

        Expense::create([
            'description' => $request->description,
            'total' => $request->total,
            'date' => $request->date,
            'user' => Auth::user()->id
        ]);

        return redirect('home');
    }

    public function delete($id)
    {
        Expense::where('id',$id)->delete();
        return redirect('home');
    }




}
