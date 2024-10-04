<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instructor;
use App\Models\Student;
use App\Models\User;
use App\Models\StudentClass;
use App\Models\StudentAssgin;
use App\Models\Section;
use App\Tools\Repositories\Crud;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Traits\ImageSaveTrait;
use Spatie\Permission\Models\Role;
use App\Traits\General;



class InstructorController extends Controller
{
    use General;
    protected $instructorModel, $studentModel;
    public function __construct(Instructor $instructor, Student $student)
    {
        $this->instructorModel = new Crud($instructor);
        $this->studentModel = new Crud($student);
    }

    public function index()
    {
        $data['title'] = 'All Instructors';
        $data['instructors'] = $this->instructorModel->getOrderReleationById('DESC', 25);
        $data['instactionParentActiveClass'] = 'active';
        return view('pages.instructor.index', $data);
    }

    // public function view($uuid)
    // {
    //     $data['title'] = 'Instructor Profile';
    //     $data['instructor'] = $this->instructorModel->getRecordByUuid($uuid);
    //     $userCourseIds = Course::whereUserId($data['instructor']->user->id)->pluck('id')->toArray();
    //     if (count($userCourseIds) > 0){
    //         $orderItems = Order_item::whereIn('course_id', $userCourseIds)
    //             ->whereYear("created_at", now()->year)->whereMonth("created_at", now()->month)
    //             ->whereHas('order', function ($q) {
    //                 $q->where('payment_status', 'paid');
    //             });
    //         $data['total_earning'] = $orderItems->sum('owner_balance');
    //     }

    //     return view('admin.instructor.view', $data);
    // }

    public function pending()
    {

        $data['title'] = 'Pending for Review';
        $data['instructors'] = Instructor::pending()->orderBy('id', 'desc')->paginate(25);
        return view('pages.instructor.pending', $data);
    }

    public function approved()
    {

        $data['title'] = 'Approved Instructor';
        $data['instructors'] = Instructor::approved()->orderBy('id', 'desc')->paginate(25);
        return view('pages.instructor.approved', $data);
    }

    public function blocked()
    {

        $data['title'] = 'Blocked Instructor';
        $data['instructors'] = Instructor::blocked()->orderBy('id', 'desc')->paginate(25);
        return view('pages.instructor.blocked', $data);
    }

    public function changeStatus($uuid, $status)
    {
        $instructor = $this->instructorModel->getRecordByUuid($uuid);
        $instructor->status = $status;
        $instructor->save();

        if ($status == 1)
        {
            $user = User::find($instructor->user_id);
            $user->role = 2;
            $user->save();
        }

        $this->showToastrMessage('success', 'Status has been changed');
        return redirect()->back();
    }

    public function create()
    {
        $data['title'] = 'Add Instructor';
        $data['roles'] = Role::all();
        $data['classes'] = StudentClass::orderBy('id','DESC')->get();
        $data['sections'] = Section::orderBy('id','DESC')->get();
        return view('pages.instructor.add', $data);
    }

    public function store(Request $request)
    {


        $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            //'password' => ['required', 'string', 'min:6'],
            'professional_title' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'image' => 'mimes:jpeg,png,jpg|file|dimensions:min_width=300,min_height=300,max_width=300,max_height=300|max:1024'
        ]);

        $user = new User();
        $user->name = $request->first_name . ' '. $request->last_name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->gurdian_phone_number = '';
        $user->address = $request->address;
        $user->email_verified_at = now();
        $user->password = Hash::make('123456');
        $user->role = 2;
        $user->image =  $request->image ? $this->saveImage('user', $request->image, null, null) :   null;
        $user->assignRole("Teacher");
        $user->save();

        $student_data = [
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'gurdian_phone_number' => $request->gurdian_phone_number,
            'gender' => $request->gender,
        ];

        // $this->studentModel->create($student_data);

        if (Instructor::where('slug', Str::slug($user->name))->count() > 0)
        {
            $slug = Str::slug($user->name) . '-'. rand(100000, 999999);
        } else {
            $slug = Str::slug($user->name);
        }
        $instructor_data = [
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'professional_title' => $request->professional_title,
            'phone_number' => $request->phone_number,
            'gurdian_phone_number' => $request->gurdian_phone_number,
            'slug' => $slug,
            'status' => 1,
            'gender' => $request->gender,
        ];

            $this->instructorModel->create($instructor_data);

            $old_assgin= StudentAssgin::where([
            ['user_id',$user->id],
            ['section_id',$request->section_id],
            ['student_class_id',$request->class_id],
            ['shift', ''],
            ])->first();

            if($old_assgin == null){
                $assgin = new StudentAssgin();
                $assgin->user_id = $user->id;
                $assgin->section_id = $request->section_id;
                $assgin->student_class_id = $request->class_id;
                $assgin->shift =  '';
                $assgin->save();
            }

        $this->showToastrMessage('success', 'Instructor created successfully');
        return redirect()->route('instructor.index');
    }

    public function edit($uuid)
    {

        $data['title'] = 'Edit Instructor';
        $data['instructor'] = $this->instructorModel->getRecordByUuid($uuid);
        $data['user'] = User::where('id',$data['instructor']->user_id)->with('assign')->first();

        $data['roles'] = Role::all();
        $data['classes'] = StudentClass::orderBy('id','DESC')->get();
        $data['sections'] = Section::orderBy('id','DESC')->get();
        return view('pages.instructor.edit', $data);
    }

    public function update(Request $request, $uuid)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'professional_title' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'image' => 'mimes:jpeg,png,jpg|file|dimensions:min_width=300,min_height=300,max_width=300,max_height=300|max:1024'
        ]);

        $instructor = $this->instructorModel->getRecordByUuid($uuid);
        $user = User::findOrfail($instructor->user_id);
        if (User::where('id', '!=', $instructor->user_id)->where('email', $request->email)->count() > 0) {
            $this->showToastrMessage('warning', 'Email already exist');
            return redirect()->back();
        }

        $user->name = $request->first_name . ' '. $request->last_name;
        $user->email = $request->email;
        if ($request->password){
            $request->validate([
                'password' => 'required|string|min:6'
            ]);
            $user->password = Hash::make($request->password);
        }
        $user->image =  $request->image ? $this->saveImage('user', $request->image, null, null) :   $user->image;
        $user->save();

        if (Instructor::where('slug', Str::slug($user->name))->count() > 0)
        {
            $slug = Str::slug($user->name) . '-'. rand(100000, 999999);
        } else {
            $slug = Str::slug($user->name);
        }

        $instructor_data = [
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'professional_title' => $request->professional_title,
            'phone_number' => $request->phone_number,
            'gurdian_phone_number' => $request->gurdian_phone_number,
            'slug' => $slug,
            'gender' => $request->gender,
        ];

        $this->instructorModel->updateByUuid($instructor_data, $uuid);
            $old_assgin= StudentAssgin::where([
            ['user_id',$user->id],
            ])->first();
            if(empty($old_assgin)){
            $assgin = new StudentAssgin();
            $assgin->user_id = $user->id;
            $assgin->section_id = $request->section_id;
            $assgin->student_class_id = $request->class_id;
            $assgin->shift =  '';
            $assgin->save();
            }

            if(!empty($old_assgin)){
            $old_assgin->user_id = $user->id;
            $old_assgin->section_id = $request->section_id;
            $old_assgin->student_class_id = $request->class_id;
            $old_assgin->shift =  '';
            $old_assgin->save();
            }
        $this->showToastrMessage('success', 'Updated Successfully');
        return redirect()->route('instructor.index');
    }

    public function delete($uuid)
    {
        $instructor = $this->instructorModel->getRecordByUuid($uuid);
        $user = User::where('id',$instructor->user_id)->first();
        $user->delete();
        $this->instructorModel->deleteByUuid($uuid);
        $this->showToastrMessage('success', 'Instructor Deleted Successfully');
        return redirect()->back();
    }


    public function changeInstructorStatus(Request $request)
    {
        $instructor = Instructor::findOrFail($request->id);
        $instructor->status = $request->status;
        $instructor->save();
        return response()->json([
            'data' => 'success',
        ]);
    }
}
