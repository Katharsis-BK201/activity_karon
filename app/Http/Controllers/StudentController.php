<?php
namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index() {
        $students = Student::all();
        return view('students.index', compact('students'));
    }

    // public function create() {
    //     return view('students.create');
    // }

    // public function store(Request $request) {
    //     $request->validate([
    //         'name' => 'required',
    //         'email' => 'required|email|unique:students',
    //     ]);

    //     Student::create($request->all());
    //     return redirect()->route('students.index')->with('success', 'Student created successfully.');
    // }

    // public function edit($id) {
    //     $student = Student::findOrFail($id);
    //     return view('students.edit', compact('student'));
    // }

    // public function update(Request $request, $id) {
    //     $student = Student::findOrFail($id);
    //     $student->update($request->all());
    //     return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    // }

    // public function destroy($id) {
    //     $student = Student::findOrFail($id);
    //     $student->delete();
    //     return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    // }
}
