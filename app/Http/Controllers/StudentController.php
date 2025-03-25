<?php
namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{
    public function index() {
        $students = Student::all();
        return view('students.index', compact('students'));
    }

    public function create() {
        return view('students.create');
    }

    

public function store(Request $request) {
    try {
        $request->validate([
            'first_name' => 'required|regex:/^[a-zA-Z\s]+$/',
            'last_name' => 'required|regex:/^[a-zA-Z\s]+$/',
            'address' => 'required',
        ]);

        // Save student data
        Student::create($request->all());

        return redirect()->route('students.index')->with('success', 'Student created successfully.');

    } catch (ValidationException $e) {
        return redirect()->route('students.create')
            ->withErrors($e->errors())
            ->withInput();
    } catch (\Exception $e) {
        return redirect()->route('students.create')->with('error', 'An unexpected error occurred.');
    }
}

    public function edit($encryptedId) {
        try{
            $id = Crypt::decrypt($encryptedId);
            $student = Student::findOrFail($id);
             return view('students.edit', compact('student'));
        } catch (\Exception $e) {
            return redirect()->route('students.index')->with('error', 'Invalid student ID.');
        }
        
    }

    public function update(Request $request, $encryptedId) {
        try{
            $id = Crypt::decrypt($encryptedId);
            $student = Student::findOrFail($id);
            $request->validate([
                'first_name' => 'required|regex:/^[a-zA-Z\s]+$/',
                'last_name' => 'required|regex:/^[a-zA-Z\s]+$/',
                'address' => 'required',
            ]);
            $student->update($request->all());
            return redirect()->route('students.index')->with('success', 'Student updated successfully.');
        $student->update($request->all());
        } catch (\Exception $e) {
            return redirect()->route('students.index')->with('error', 'Invalid student ID.');
        }
        
        
    }

    public function destroy($encryptedId) {
        try{
            $id = Crypt::decrypt($encryptedId);
            $student = Student::findOrFail($id);
            $student->delete();
            return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
        }catch (\Exception $e) {
            return redirect()->route('students.index')->with('error', 'Invalid student ID.');
        }
    }
}
