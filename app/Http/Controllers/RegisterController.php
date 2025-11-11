<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        // print_r($request->all());
        // p($request->all());
        // die;
        // echo "<pre>";
        // print_r($request->file('image'));

        // $filename = $request->file('image')->getClientOriginalName();


        // $request->file('image')->store('uploads');


        $employee = new Employee;

        $employee->empid = mt_rand(11111, 99999);
        $employee->fullname = $request['name'];
        $employee->email = $request['email'];
        $employee->address = $request['address'];
        $employee->date = $request['date'];
        // $employee->image = $filename;
        $employee->status = 1;
        $employee->save();

        // return redirect('view');
        return redirect('view')->with('insert_success', true);
    }

    public function fetchdata(Request $request)
    {
        $search = $request->search;
        if ($search) {
            $employee = Employee::where('fullname', 'LIKE', "%$search%")->orWhere('email', 'LIKE', "%$search%")->paginate(5);
        } else {
            $employee = Employee::paginate(5);
        }
        $data = compact('employee');
        return view('fetchdata')->with($data);
    }

    public function updatedata($empid)
    {
        $employee = Employee::find($empid);

        if (!is_null($employee)) {
            $data = compact('employee');
            return view('register')->with($data);
        } else {
            return redirect('view');
        }
    }
    public function updated($empid, Request $request)
    {
        $employee = Employee::find($empid);

        $employee->fullname = $request['name'];
        $employee->email = $request['email'];
        $employee->address = $request['address'];
        $employee->date = $request['date'];
        $employee->save();

        // return redirect('view');
        return redirect('view')->with('update_success', true);
    }

    public function delete($empid)
    {
        $employee = Employee::find($empid);
        if (!is_null($employee)) {
            $employee->delete();
            return redirect()->back();
        } else {
            return redirect('view');
        }
    }
}
