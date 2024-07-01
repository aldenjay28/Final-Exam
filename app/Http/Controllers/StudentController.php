<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // Implement filtering, sorting, pagination
        $students = Student::query();

        if ($request->has('search')) {
            $students->where('firstname', 'like', '%' . $request->search . '%')
                     ->orWhere('lastname', 'like', '%' . $request->search . '%');
        }

        // Add more filters as required

        return response()->json([
            'metadata' => [
                'count' => $students->count(),
                'search' => $request->search,
                // Add more metadata
            ],
            'students' => $students->get()
        ]);
    }

    public function store(Request $request)
    {
        $student = Student::create($request->all());
        return response()->json($student, 201);
    }

    public function show($id)
    {
        $student = Student::findOrFail($id);
        return response()->json($student);
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $student->update($request->all());
        return response()->json($student);
    }
}
