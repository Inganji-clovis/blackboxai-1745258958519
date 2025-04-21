<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Assignment;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function listTeachers()
    {
        $teachers = User::where('role', User::ROLE_TEACHER)->get();

        return response()->json(['teachers' => $teachers]);
    }

    public function listAssignments(Request $request)
    {
        $student = $request->user();

        // For simplicity, list all assignments for courses taught by teachers
        // In a real app, assignments would be linked to student groups or enrollments

        $assignments = Assignment::all();

        return response()->json(['assignments' => $assignments]);
    }
}
