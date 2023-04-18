<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::paginate(10);
        return response()->json([
            'data' => $students
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $code = $request->code;
        $existingCode = Student::where('code', $code)->first();

        if ($existingCode) {
            return response()->json(['message' => 'Kode sudah ada'], 422);
        } else {
            $student = Student::create([
                'full_name' => $request->full_name,
                'phone_number' => $request->phone_number,
                'city' => $request->city,
                'code' => $request->code,
            ]);

            return response()->json([
                'data' => $student
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        return response()->json([
            'data' => $student
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    { }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $student->full_name = $request->full_name;
        $student->phone_number = $request->phone_number;
        $student->city = $request->city;
        $student->code = $request->code;
        $student->save();


        return response()->json([
            'data' => $student
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $student->delete();
        return response()->json([
            'message' => 'customer deleted'
        ], 204);
    }
}
