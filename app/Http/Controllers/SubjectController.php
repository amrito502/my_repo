<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\StudentClass;

class SubjectController extends Controller
{
    public function index()
    {
        return view('pages.subject.subject_assign');
    }

    public function getSubjects(Request $request)
    {
        // Retrieve subjects based on the class ID passed through the request
        $classId = $request->query('class_id');

        //$subjects = Subject::where('class_id', $classId)->get();

        $classInfo = StudentClass::find($classId);

        $decodeSubject = json_decode($classInfo->subjects);

        $subjectsArray = [];

        foreach ($decodeSubject as $value) {
            $subject = Subject::find($value);
            if ($subject) {
                $subjectsArray[] = [
                    'id' => $subject->id,
                    'name' => $subject->name
                ];
            }
        }

        $data['subjects'] = $subjectsArray;

        // $data['subjects'] = [
        //     [
        //         'id' => 1,
        //         'name' => 'Bangla'
        //     ],
        //     [
        //         'id' => 2,
        //         'name' => 'English'
        //     ],
        //     [
        //         'id' => 3,
        //         'name' => 'Math'
        //     ],
        //     [
        //         'id' => 4,
        //         'name' => 'Science'
        //     ],
        //     [
        //         'id' => 5,
        //         'name' => 'Social Science'
        //     ],
        //     [
        //         'id' => 6,
        //         'name' => 'Religion'
        //     ]
        // ];

        return response()->json($data);
    }

    // public function create()
    // {
    //     return view('pages.subject-create');
    // }

    // public function store(Request $request)
    // {
    //     return $request->all();
    // }

    // public function edit()
    // {
    //     return view('pages.subject-edit');
    // }

    // public function update(Request $request)
    // {
    //     return $request->all();
    // }

    // public function delete()
    // {
    //     return view('pages.subject-delete');
    // }
}
