<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index($studentId, Request $request)
    {
        // Implement filtering, sorting, pagination
        $subjects = Subject::where('student_id', $studentId);

        if ($request->has('search')) {
            $subjects->where('name', 'like', '%' . $request->search . '%');
        }

        // Add more filters as required

        return response()->json([
            'metadata' => [
                'count' => $subjects->count(),
                'search' => $request->search,
                // Add more metadata
            ],
            'subjects' => $subjects->get()
        ]);
    }

    public function store($studentId, Request $request)
    {
        $subject = Subject::create(array_merge($request->all(), ['student_id' => $studentId]));
        return response()->json($subject, 201);
    }

    public function show($studentId, $subjectId)
    {
        $subject = Subject::where('student_id', $studentId)->findOrFail($subjectId);
        return response()->json($subject);
    }

    public function update(Request $request, $studentId, $subjectId)
    {
        $subject = Subject::where('student_id', $studentId)->findOrFail($subjectId);
        $subject->update($request->all());
        return response()->json($subject);
    }
}
