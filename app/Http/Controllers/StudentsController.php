<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instructor;
use App\Models\Student;
use App\Models\User;
use App\Tools\Repositories\Crud;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Traits\ImageSaveTrait;
use Spatie\Permission\Models\Role;
use App\Traits\General;
use App\Models\StudentClass;
use App\Models\StudentAssgin;
use App\Models\StudentAttendance;
use App\Models\Subject;
use App\Models\Section;
use App\Models\Exam;
use App\Models\ExamMark;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentsController extends Controller
{
    use General, ImageSaveTrait;

    protected $studentModel;
    public function __construct(Student $student)
    {
        $this->studentModel = new Crud($student);
    }

    public function index(Request $request)
    {
        $data['title'] = 'All Students';

        $class = $request->input('class_id', 1);
        $section = $request->input('section_id', 1);
        $shift = $request->input('shift', 'Day');
        $gender = $request->input('gender', 'Boy');

        $data['students'] = Student::orderBy('user_id', 'DESC')
            ->whereHas('assign', function ($query) use ($class, $section, $shift, $gender) {
                $query->where('student_class_id', $class)
                    ->where('section_id', $section)
                    ->where('shift', $shift)
                    ->where('gender', $gender);
            })
            ->with('assign')
            ->get();

        $data['subjects'] = Subject::orderBy('id', 'DESC')->get();
        $data['classes'] = StudentClass::orderBy('id', 'DESC')->get();
        $data['sections'] = Section::orderBy('id', 'DESC')->get();

        return view('pages.student.index', $data);
    }

    public function create()
    {
        $data['title'] = 'Add Student';
        $data['classes'] = StudentClass::orderBy('id', 'ASC')->get();
        $data['sections'] = Section::orderBy('id', 'DESC')->get();
        $data['students'] = Student::orderBy('id', 'DESC')->get();
        return view('pages.student.add', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            //'password' => ['required', 'string', 'min:2'],
            'phone_number' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'class_id' => 'required',
            'section_id' => 'required',
            'shift' => 'required',
            'image' => 'image:jpeg,png,jpg|file|dimensions:min_width=300,min_height=300,max_width=300,max_height=300|max:1024'
        ]);

        //dd($request->all());

        $user = new User();
        $user->student_number = $request->student_number;
        $user->name = $request->first_name . ' ' . $request->last_name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->gurdian_phone_number = $request->gurdian_phone_number;
        $user->address = $request->address;
        $user->email_verified_at = now();
        $user->password = Hash::make('123456');
        $user->role = 3;
        $user->image = $request->image ? $this->saveImage('user', $request->image, null, null) : null;
        $user->assignRole('Student');
        $user->save();

        $student_data = [
            'user_id' => $user->id,
            'student_number' => $request->student_number,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'gurdian_phone_number' => $request->gurdian_phone_number,
            'gender' => $request->gender,
            'shift' => $request->shift,
        ];
        $insertStudentData = $this->studentModel->create($student_data);

        $old_assgin = StudentAssgin::where([
            ['user_id', $user->id],
            ['section_id', $request->section_id],
            ['student_class_id', $request->class_id],
            ['shift', $request->shift],
        ])->first();
        if (empty($old_assgin)) {
            $assgin = new StudentAssgin();
            $assgin->user_id = $user->id;
            $assgin->section_id = $request->section_id;
            $assgin->shift = $request->shift;
            $assgin->student_class_id = $request->class_id;
            $assgin->save();
        }
        $this->showToastrMessage('success', 'Student created successfully');
        return redirect()->route('student.index');
    }

    /*public function view($uui, Request $request)
    {
        $data['title'] = 'View Student';

        $month =  date('m');
        $year = date('Y');

        $start_date = date("$year-$month-01");
        $end_date = date("Y-m-t", strtotime($start_date));

        // Retrieve the student ID by uuid
        $student_id = Student::where('uuid', $uuid)->value('id');

        // Fetch student data with attendance for the specified date range using the retrieved student ID
        $data['student'] = Student::with(['assign', 'attendance' => function ($query) use ($student_id) {
            $query->where('student_id', $student_id);
        }])
        ->find($student_id);

        $data['studentAttendance'] = StudentAttendance::where('student_id', $data['student']->user_id)
                                                  ->whereBetween('created_at', [$start_date, $end_date])
                                                  ->get();

        return view('pages.student.view', $data);
    }*/

    public function view($uuid, Request $request)
    {
        $data['title'] = 'View Student';

        // Get month and year parameters from the request
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        $start_date = date("$year-$month-01");
        $end_date = date("Y-m-t", strtotime($start_date));

        // Retrieve the student ID by uuid
        $student_id = Student::where('uuid', $uuid)->value('id');

        // Fetch student data with attendance for the specified date range using the retrieved student ID
        $data['student'] = Student::with([
            'assign',
            'attendance' => function ($query) use ($student_id) {
                $query->where('student_id', $student_id);
            }
        ])
            ->find($student_id);

        $data['studentAttendance'] = StudentAttendance::where('student_id', $data['student']->user_id)
            ->whereBetween('created_at', [$start_date, $end_date])
            ->get();


        return view('pages.student.view', $data);
    }

    public function edit($uuid)
    {
        $data['title'] = 'Edit Student';
        $data['student'] = Student::where('uuid', $uuid)->with('assign')->first();
        $data['user'] = User::findOrfail($data['student']->user_id);
        $data['classes'] = StudentClass::orderBy('id', 'DESC')->get();
        $data['sections'] = Section::orderBy('id', 'DESC')->get();
        $data['students'] = Student::orderBy('id', 'DESC')->get();
        return view('pages.student.edit', $data);
    }

    public function update(Request $request, $uuid)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone_number' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'shift' => 'required',
            'image' => 'mimes:jpeg,png,jpg|file|dimensions:min_width=300,min_height=300,max_width=300,max_height=300|max:1024'
        ]);

        $student = $this->studentModel->getRecordByUuid($uuid);

        $user = User::findOrfail($student->user_id);
        if (User::where('id', '!=', $student->user_id)->where('email', $request->email)->count() > 0) {
            $this->showToastrMessage('warning', 'Email already exist');
            return redirect()->back();
        }

        $user->name = $request->first_name . ' ' . $request->last_name;
        $user->student_number = $request->student_number;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->address = $request->address;
        $user->gurdian_phone_number = $request->gurdian_phone_number;

        if ($request->password) {
            $request->validate([
                'password' => 'required|string|min:6'
            ]);
            $user->password = Hash::make($request->password);
        }
        $user->image = $request->image ? $this->saveImage('user', $request->image, null, null) : $user->image;
        $user->save();

        $student_data = [
            'user_id' => $user->id,
            'student_number' => $request->student_number,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'gurdian_phone_number' => $request->gurdian_phone_number,
            'gender' => $request->gender,
        ];

        $this->studentModel->updateByUuid($student_data, $uuid);

        $old_assgin = StudentAssgin::where([
            ['user_id', $user->id],
        ])->first();
        if (empty($old_assgin)) {
            $assgin = new StudentAssgin();
            $assgin->user_id = $user->id;
            $assgin->section_id = $request->section_id;
            $assgin->student_class_id = $request->class_id;
            $assgin->shift = $request->shift;
            $assgin->save();
        }

        if (!empty($old_assgin)) {
            $old_assgin->user_id = $user->id;
            $old_assgin->section_id = $request->section_id;
            $old_assgin->student_class_id = $request->class_id;
            $old_assgin->shift = $request->shift;
            $old_assgin->save();
        }

        $this->showToastrMessage('success', 'Updated Successfully');
        return redirect()->route('student.index');
    }

    public function delete($uuid)
    {
        $student = $this->studentModel->getRecordByUuid($uuid);
        $instructor = Instructor::whereUserId($student->user_id)->first();
        if ($instructor) {
            $this->showToastrMessage('error', 'You can\'t delete it. Because this user already an instructor. If you want to delete, at first you delete from instructor.');
            return redirect()->back();
        }
        if ($student) {
            $this->deleteFile(@$student->user->image);
        }
        User::find($student->user_id)->delete();
        $this->studentModel->deleteByUuid($uuid);

        $this->showToastrMessage('success', 'Deleted Successfully');
        return redirect()->back();
    }

    public function changeStudentStatus(Request $request)
    {
        $student = Student::findOrFail($request->id);
        $student->status = $request->status;
        $student->save();

        return response()->json([
            'data' => 'success',
        ]);
    }

    public function mark($uid)
    {
        $data['student'] = Student::where('uuid', $uid)->first();
        $data['exam_marks'] = ExamMark::where('student_id', $data['student']->id)->orderBy('id', 'DESC')->with('exam')->get();

        return view('pages.mark.index', $data);
    }

    // =================================
    // ========upload-csv-file==========
    public function student_csv_file_upload()
    {
        return view('pages.student.upload_csv');
    }

    // public function student_csv_file_store(Request $request){

    //     $request->validate([
    //         'csv_file' => 'required|file|mimes:csv,txt',
    //     ]);

    //     $file = $request->file('csv_file');
    //     $path = $file->getRealPath();

    //     $data = array_map('str_getcsv', file($path));

    //     foreach ($data as $row) {

    //         $firstName = $row[0];
    //         $lastName = $row[1];
    //         $email = $row[2];
    //         $address = $row[3];
    //         $phoneNumber = $row[4];
    //         $gurdianPhoneNumber = $row[5];
    //         $studentNumber = $row[6];
    //         $gender = $row[7];
    //         $branchName = $row[8];
    //         $className = $row[9];
    //         $shiftName = $row[10];

    //         $user = new User();
    //         $user->student_number = $studentNumber;
    //         $user->name = $firstName . ' ' . $lastName;
    //         $user->email = $email;
    //         $user->phone_number = $phoneNumber;
    //         $user->gurdian_phone_number = $gurdianPhoneNumber;
    //         $user->address = $address;
    //         $user->email_verified_at = now();
    //         $user->password = Hash::make('123456');
    //         $user->role = 3;
    //         $user->image =  $request->image ? $this->saveImage('user', $request->image, null, null) :   null;
    //         $user->assignRole('Student');
    //         $user->save();

    //         $student_data = [
    //             'user_id' => $user->id,
    //             'student_number' => $studentNumber,
    //             'first_name' => $firstName,
    //             'last_name' => $lastName,
    //             'address' => $address,
    //             'phone_number' => $phoneNumber,
    //             'gurdian_phone_number' => $gurdianPhoneNumber,
    //             'gender' => $gender,
    //             // 'shift' => $row[0],
    //         ];
    //         $insertStudentData = $this->studentModel->create($student_data); 


    //         $branch_name = Section::firstOrCreate(['name' => $branchName]); 
    //         return $branch_name;
    //         $class_name = StudentClass::firstOrCreate(['name' => $className]);
    //         $shift_name = StudentAssgin::firstOrCreate(['shift' => $shiftName]);


    //         $old_assgin = StudentAssgin::where([
    //             ['user_id', $user->id],
    //             ['section_id', $branch_name->name],
    //             ['student_class_id', $class_name->name],
    //             ['shift', $shift_name->id],
    //         ])->first();
    //         if (empty($old_assgin)) {
    //             $assgin = new StudentAssgin();
    //             $assgin->user_id = $user->id;
    //             $assgin->section_id = $branch_name->id;
    //             $assgin->shift = $shift_name->id;
    //             $assgin->student_class_id = $class_name->id;
    //             $assgin->save();
    //         }

    //     }

    //     $this->showToastrMessage('success', 'CSV data uploaded successfully!');
    //     return redirect()->back()->route('student.index');
    // }



    public function student_csv_file_store(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));

        foreach ($data as $row) {
            if (count($row) < 11) {
                continue; // Skip invalid rows
            }

            [$firstName, $lastName, $email, $address, $phoneNumber, $guardianPhoneNumber, $studentNumber, $gender, $branchName, $className, $shiftName] = $row;

            // // Create or fetch the user
            // $user = User::firstOrCreate(
            //     ['email' => $email],
            //     [
            //         'name' => trim($firstName . ' ' . $lastName),
            //         'address' => $address,
            //         'phone_number' => $phoneNumber,
            //         'guardian_phone_number' => $guardianPhoneNumber,
            //         'gender' => $gender ?? '',
            //         'password' => Hash::make('123456'), // Default password
            //         'role' => 3,
            //         'email_verified_at' => now(),
            //     ]
            // );

            $user = new User();
            $user->student_number = $studentNumber;
            $user->name = $firstName . ' ' . $lastName;
            $user->email = $email;
            $user->phone_number = $phoneNumber;
            $user->gurdian_phone_number = $guardianPhoneNumber;
            $user->address = $address;
            $user->email_verified_at = now();
            $user->password = Hash::make('123456');
            $user->role = 3;
            $user->image = $request->image ? $this->saveImage('user', $request->image, null, null) : null;
            $user->assignRole('Student');
            $user->save();


            $student_data = [
                'user_id' => $user->id,
                'student_number' => $studentNumber,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'address' => $address,
                'phone_number' => $phoneNumber,
                'gurdian_phone_number' => $guardianPhoneNumber,
                'gender' => $gender,
                // 'shift' => $row[0],
            ];
            $insertStudentData = $this->studentModel->create($student_data);





            // $className = trim($className);
            // $class = StudentClass::firstOrCreate(
            //     ['name' => $className],
            //     ['subjects' => json_encode(['21', '20', '19', '18', '15', '14', '13', '12', '11', '10', '9', '8', '7'])] // Populate subjects with data
            // );

            // $normalizedBranchName = strtolower(trim($branchName));
            // $section = Section::where('name', 'LIKE', '%' . $normalizedBranchName . '%')
            //     ->first();
            // if (!$section) {
            //     $section = Section::create([
            //         'name' => $normalizedBranchName, // Use the normalized branch name
            //         'status' => 1,
            //         'student_class_id' => $class->id,
            //     ]);
            // }

            // $shift = StudentAssgin::firstOrCreate(
            //     ['shift' => $shiftName, 'user_id' => $user->id]
            // );
            // $existingAssignment = StudentAssgin::where([
            //     ['user_id', $user->id],
            //     ['section_id', $section->id],  // Use section ID
            //     ['student_class_id', $class->id], // Set student_class_id
            //     ['shift', $shift->id],
            // ])->exists();

            // // If not existing, create a new assignment
            // if (!$existingAssignment) {
            //     $assignment = new StudentAssgin();
            //     $assignment->user_id = $user->id; // Foreign key
            //     $assignment->section_id = $section->id; // Set section_id
            //     $assignment->student_class_id = $class->id; // Set student_class_id
            //     $assignment->shift = $shiftName; // Use shift name directly
            //     $assignment->save();
            // }


            $className = trim($className);

            // Ensure the class is created or retrieved correctly
            $class = StudentClass::firstOrCreate(
                ['name' => $className],
                ['subjects' => json_encode(['21', '20', '19', '18', '15', '14', '13', '12', '11', '10', '9', '8', '7'])] // Populate subjects with data
            );

            // Normalize branch name
            $normalizedBranchName = strtolower(trim($branchName));

            // Find or create the section based on normalized name
            $section = Section::where('name', 'LIKE', '%' . $normalizedBranchName . '%')->first();

            if (!$section) {
                $section = Section::create([
                    'name' => $normalizedBranchName, // Use the normalized branch name
                    'status' => 1,
                    'student_class_id' => $class->id,
                ]);
            }

            // Ensure shift is created or retrieved correctly
            $shift = StudentAssgin::firstOrCreate(
                ['shift' => $shiftName, 'user_id' => $user->id]
            );

            // Check for existing assignment before creating a new one
            $existingAssignment = StudentAssgin::where([
                ['user_id', $user->id],
                ['section_id', $section->id], // Use section ID
                ['student_class_id', $class->id], // Set student_class_id
                ['shift', $shift->shift], // Reference the shift name
            ])->exists();

            // If not existing, create a new assignment
            if (!$existingAssignment) {
                $assignment = new StudentAssgin();
                $assignment->user_id = $user->id; // Foreign key
                $assignment->section_id = $section->id; // Set section_id
                $assignment->student_class_id = $class->id; // Set student_class_id
                $assignment->shift = $shift->shift; // Use shift name directly
                $assignment->save();
            }




        }

        $this->showToastrMessage('success', 'CSV data uploaded successfully!');
        return redirect()->route('student.index');
    }


}
