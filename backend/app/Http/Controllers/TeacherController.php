<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Assignment;
use App\Models\Group;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function addCourse(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $course = Course::create([
            'name' => $request->name,
            'teacher_id' => $request->user()->id,
        ]);

        return response()->json(['message' => 'Course added successfully', 'course' => $course], 201);
    }

    public function listStudents(Request $request)
    {
        $students = User::where('role', User::ROLE_STUDENT)->get();

        return response()->json(['students' => $students]);
    }

    public function updateStudent(Request $request, $id)
    {
        $student = User::where('role', User::ROLE_STUDENT)->findOrFail($id);

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $student->id,
        ]);

        if ($request->has('name')) {
            $student->name = $request->name;
        }
        if ($request->has('email')) {
            $student->email = $request->email;
        }

        $student->save();

        return response()->json(['message' => 'Student updated successfully', 'student' => $student]);
    }

    public function createAssignment(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        $assignment = Assignment::create([
            'title' => $request->title,
            'course_id' => $request->course_id,
            'description' => $request->description,
            'due_date' => $request->due_date,
        ]);

        return response()->json(['message' => 'Assignment created successfully', 'assignment' => $assignment], 201);
    }

    public function createGroup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:users,id',
        ]);

        $group = Group::create([
            'name' => $request->name,
            'teacher_id' => $request->user()->id,
        ]);

        $group->students()->sync($request->student_ids);

        return response()->json(['message' => 'Group created successfully', 'group' => $group], 201);
    }
}
