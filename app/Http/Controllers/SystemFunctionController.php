<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\EditUserRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\StudentClass;
use App\Models\StudentAssgin;
use App\Models\StudentAttendance;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Section;
use App\Models\Exam;
use App\Models\ExamMark;
use App\Traits\General;
use App\Models\Instructor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SystemFunctionController extends Controller
{
    use General;

    public function classIndex()
    {

        $data['classes'] = StudentClass::orderBy('id', 'DESC')->get();
        $data['leftClassParentActiveClass'] = 'active';
        return view('pages.class.index', $data);
    }

    public function classCreate()
    {

        $data['leftClassParentActiveClass'] = 'active';
        $subjects = Subject::orderBy('id', 'DESC')->get();
        $data['subjects'] = $subjects;
        return view('pages.class.create', $data);
    }


    public function classStore(Request $request)
    {

        //dd($request->all());

        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'subjects' => ['required'],
        ]);

        $class = new StudentClass();
        $class->name = $request->name;
        $class->subjects = json_encode($request->subjects);
        $class->save();
        $this->showToastrMessage('success', 'Class created successfully');
        return $this->controlRedirection($request, 'class', 'Class');
    }

    public function classEdit(  $id)
    {
        $data['leftClassParentActiveClass'] = 'active';
        $data['class'] = StudentClass::find($id);
        $subjects = Subject::orderBy('id', 'DESC')->get();
        $data['subjects'] = $subjects;
        return view('pages.class.edit', $data);
    }

    public function classUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'subjects' => ['required'],
        ]);

        $class = StudentClass::find($id);

        $class->name = $request->name;

        $class->subjects = json_encode($request->subjects);

        $class->save();

        $this->showToastrMessage('success', 'Updated successfully');

        return $this->controlRedirection($request, 'class', 'Class');
    }

    public function classDelete($id)
    {

        StudentClass::whereId($id)->delete();
        $this->showToastrMessage('success', 'Class has been deleted');
        return redirect()->back();
    }

    public function getSectionsByClass($class_id)
    {
        $sections = Section::where('student_classe_id', $class_id)->pluck('name', 'id');

        return response()->json($sections);
    }

    public function sectionIndex()
    {

        $data['section'] = Section::orderBy('id', 'ASC')->with('studentClassData')->get();
        $data['leftSectionParentActiveClass'] = 'active';
        return view('pages.sections.index', $data);
    }

    public function sectionCreate()
    {

        $data['leftSectionParentActiveClass'] = 'active';
        $data['class'] = StudentClass::orderBy('id', 'DESC')->get();
        return view('pages.sections.create', $data);
    }


    public function sectionStore(Request $request)
    {

        $section = new Section();
        $section->name = $request->name;
        $section->student_classe_id = $request->student_classe_id;
        $section->save();
        $this->showToastrMessage('success', 'Section created successfully');
        return $this->controlRedirection($request, 'section', 'Section');
    }

    public function sectionEdit($id)
    {

        $data['leftSectionParentActiveClass'] = 'active';
        $data['class'] = StudentClass::orderBy('id', 'DESC')->get();
        $data['section'] = Section::where('id', $id)->with('studentClassData')->first();
        return view('pages.sections.edit', $data);
    }

    public function sectionUpdate(Request $request, $id)
    {

        $section = Section::find($id);
        $section->name = $request->name;
        $section->student_classe_id = $request->student_classe_id;
        $section->save();
        $this->showToastrMessage('success', 'Updated successfully');
        return $this->controlRedirection($request, 'section', 'Section');
    }


    public function sectionDelete($id)
    {

        Section::whereId($id)->delete();
        $this->showToastrMessage('error', 'Section has been deleted');
        return redirect()->back();
    }



    public function subjectIndex()
    {

        $data['subject'] = Subject::orderBy('id', 'DESC')->get();
        $data['leftSubjectParentActiveClass'] = 'active';
        return view('pages.subject.index', $data);
    }

    public function subjectCreate()
    {

        $data['leftSubjectParentActiveClass'] = 'active';
        $data['class'] = StudentClass::orderBy('id', 'DESC')->get();
        return view('pages.subject.create', $data);
    }


    public function subjectStore(Request $request)
    {

        $subject = new Subject();
        $subject->name = $request->name;
        $subject->save();
        $this->showToastrMessage('success', 'subject created successfully');
        return $this->controlRedirection($request, 'subject', 'Subject');
    }

    public function subjectEdit($id)
    {

        $data['leftSubjectParentActiveClass'] = 'active';
        $data['subject'] = Subject::where('id', $id)->first();
        return view('pages.subject.edit', $data);
    }

    public function subjectUpdate(Request $request, $id)
    {

        $subject = Subject::find($id);
        $subject->name = $request->name;
        $subject->save();
        $this->showToastrMessage('success', 'Updated successfully');
        return $this->controlRedirection($request, 'subject', 'Subject');
    }


    public function subjectDelete($id)
    {

        Subject::whereId($id)->delete();
        $this->showToastrMessage('error', 'Subject has been deleted');
        return redirect()->back();
    }


    public function subjectAssign()
    {
        $subjects = Subject::orderBy('id', 'DESC')->get();
        $classes = StudentClass::orderBy('id', 'DESC')->get();
        // dd($subjects);

        return view('pages.subject.assign', ['subjects' => $subjects, 'classes' => $classes]);
    }

    public function examIndex()
    {
        $data['exams'] = Exam::orderBy('id', 'DESC')->with('teacher', 'subjects')->get();

        return view('pages.exam.index', $data);

    }
    public function examCreate()
    {
        $data['leftExamParentActiveClass'] = 'active';
        $data['classes'] = StudentClass::orderBy('id', 'ASC')->get();
        $data['subjects'] = Subject::orderBy('id', 'ASC')->get();
        $data['teachers'] = Instructor::orderBy('id', 'ASC')->get();

        return view('pages.exam.create', $data);
    }
    public function examStore(Request $request)
    {
        $exam = new Exam();
        $exam->name = $request->name;
        $exam->start_date_time = $request->start_date_time;
        $exam->teacher_id = $request->teacher_id;
        $exam->class_id = $request->class_id;
        $exam->max_marks = $request->max_marks;
        $exam->subjects = json_encode($request->subjects);

        $exam->save();

        $this->showToastrMessage('success', 'exam created successfully');

        return $this->controlRedirection($request, 'exam', 'Exam');
    }

    public function examEdit($id)
    {
        $data['exams'] = Exam::where('uuid', $id)->with('subjects')->first();
        $data['classes'] = StudentClass::orderBy('id', 'ASC')->get();
        $data['subjects'] = Subject::orderBy('id', 'DESC')->get();
        $data['teachers'] = Instructor::orderBy('id', 'ASC')->get();
        return view('pages.exam.edit', $data);
    }

    public function mark($id)
    {
        $data['exams'] = Exam::where('uuid', $id)->with('exam_mark')->first();

        $data['marks'] = ExamMark::where('exam_id', $data['exams']->id)->with('student')->get();

        // $data['students'] = Student::join('student_assgins as a', 'students.user_id', '=', 'a.user_id')
        //             ->where('a.student_class_id', $data['exams']->class_id)
        //             ->get();

        $data['students'] = Student::join('student_assgins as a', 'students.user_id', '=', 'a.user_id')
                    ->where('a.student_class_id', $data['exams']->class_id)
                    ->select('students.*', 'a.section_id', 'a.shift', 'a.shift') // Include fields from both tables
                    ->get();

        if ($data['students']->count() > 0) {
            $section_id = $data['students'][0]->section_id ?? 0;
            $data['sectionName'] = Section::where('id', $section_id)->value('name');
            $data['error'] = "";
        } else {
            $data['error'] = "No students found in this class";
        }

        return view('pages.exam.mark', $data);
    }

    public function viewEdit($id)
    {

        $data['exams'] = Exam::where('uuid', $id)->with('exam_mark')->first();

        $data['marks'] = ExamMark::where('exam_id', $data['exams']->id)->with('student')->get();

        // $data['students'] = Student::join('student_assgins as a', 'students.user_id', '=', 'a.user_id')
        //             ->where('a.student_class_id', $data['exams']->class_id)
        //             ->get();

        $data['students'] = Student::join('student_assgins as a', 'students.user_id', '=', 'a.user_id')
                    ->where('a.student_class_id', $data['exams']->class_id)
                    ->select('students.*', 'a.section_id', 'a.shift', 'a.shift') // Include fields from both tables
                    ->get();

        if ($data['students']->count() > 0) {
            $section_id = $data['students'][0]->section_id ?? 0;
            $data['sectionName'] = Section::where('id', $section_id)->value('name');
            $data['error'] = "";
        } else {
            $data['error'] = "No students found in this class";
        }

        return view('pages.exam.view', $data);
    }



    /*public function studentSssign(Request $request)
    {

        $student_assigns = StudentAssgin::where([
            ['section_id', $request->section_id],
            ['student_class_id', $request->class_id]
        ])->with('students')->get();

        if ($student_assigns->count() > 0) {
            foreach ($student_assigns as $key => $student_assign) {
                if (empty($assigned) && !empty($student_assign->students)) {
                    $assigned = ExamMark::where([
                        ['exam_id', $request->exam_id],
                        ['student_id', $student_assign->students->id]
                    ])->first();
                    $examassign = new ExamMark();
                    $examassign->exam_id = $request->exam_id;
                    $examassign->student_id = $student_assign->students->id;
                    $examassign->save();
                    $this->showToastrMessage('success', 'Student found ');
                }
            }
        } else {
            $this->showToastrMessage('error', 'Student not found !!');
        }

        return  redirect(route('exam.view', [$request->olduuid]));
    }*/

    public function studentGivenMark(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'subject_id' => 'required',
            'subject_name' => 'required',
            'mark' => 'required',
            'max_mark' => 'required',
        ]);

        if($request->max_mark < $request->mark){
            $this->showToastrMessage('error', 'Mark cannot be greater than Full mark');
            return redirect(route('exam.mark', [$request->olduuid]));
        }

        // Attempt to find an existing record with the same student_id and subject_id
        $existingMark = ExamMark::where('student_id', $request->student_id)
                                ->where('subject_id', $request->subject_id)
                                ->where('exam_id', $request->exam_id)
                                ->first();

        // If an existing record is found, update it; otherwise, create a new one
        if ($existingMark) {
            $existingMark->update([
                'mark' => $request->mark,
                'max_mark' => $request->max_mark,
            ]);
            $message = 'Mark has been updated';
        } else {
            $ExamMark = new ExamMark();
            $ExamMark->exam_id = $request->exam_id;
            $ExamMark->class_id = $request->class_id;
            $ExamMark->student_id = $request->student_id;
            $ExamMark->subject_id = $request->subject_id;
            $ExamMark->subject_name = $request->subject_name;
            $ExamMark->mark = $request->mark;
            $ExamMark->max_mark = $request->max_mark;

            $ExamMark->save();

            $message = 'Mark has been saved';
        }

        $response = [
            'status' => 'success',
            'message' => $message,
            'data' => $ExamMark ?? $existingMark,
        ];

        return response()->json($response);

        // $this->showToastrMessage('success', $message);

        // return redirect(route('exam.mark', [$request->olduuid]));

        //return redirect(route('exam.view', [$request->olduuid]));
    }

    public function examUpdate(Request $request, $id)
    {
        $exam = Exam::find($id);
        $exam->name = $request->name;
        $exam->start_date_time = $request->start_date_time;
        $exam->teacher_id = $request->teacher_id;
        $exam->class_id = $request->class_id;
        $exam->max_marks = $request->max_marks;
        $exam->subjects = json_encode($request->subjects);

        $exam->save();

        $this->showToastrMessage('success', 'Updated successfully');

        return $this->controlRedirection($request, 'exam', 'Exam');
    }

    public function examDelete($id)
    {

        Exam::where('uuid', $id)->delete();
        $this->showToastrMessage('success', 'Exam has been deleted');
        return redirect()->back();
    }

    public function assignDelete($id, $eid)
    {

        ExamMark::where('uuid', $id)->delete();
        $this->showToastrMessage('success', 'Student has been removed from exam mark');
        return  redirect(route('exam.view', [$eid]));
    }

    public function attendanceIndex()
    {

        // if (Auth::user()->instructor != null && Auth::user()->student == null) {
        //     $date_time = \Carbon\Carbon::now()->format('d-m-Y');
        //     $data['attendances'] = StudentAssgin::where([
        //         ['student_class_id', Auth::user()->assign->studentClass->id],
        //         ['section_id', Auth::user()->assign->section->id],
        //         ['user_id', '!=', Auth::user()->id],
        //     ])->orderBy('id', 'ASC')->with('students', 'studentClass', 'section')->get();
        //     $data['date'] =  $date_time;
        //     return view('pages.attendance.give_attendance', $data);
        // } else
        if (Auth::user()->student == null) {
            $data['subjects'] = Subject::orderBy('id', 'ASC')->get();
            $data['classes'] = StudentClass::orderBy('id', 'ASC')->get();
            $data['sections'] = Section::orderBy('id', 'ASC')->get();
            $data['leftAttendanceParentActiveClass'] = 'active';
            return view('pages.attendance.index', $data);
        } else {
            $this->showToastrMessage('error', 'Something went wrong !');
            return redirect()->back();
        }
    }

    public function attendanceCreate()
    {

        $data['leftAttendanceParentActiveClass'] = 'active';

        return view('pages.attendance.create', $data);
    }


    public function attendanceStore(Request $request)
    {
        $ifexist = StudentAttendance::where([
            ['class_id', $request->class_id],
            ['section_id', $request->section_id],
            ['shift', $request->shift],
            ['date', $request->date],
        ])->exists();

        if($ifexist){
            $this->showToastrMessage('error', 'Already Exist');
            return redirect()->back();
        }

        $data['attendances'] = StudentAssgin::where([
            ['student_class_id', $request->class_id],
            ['section_id', $request->section_id],
            ['shift', $request->shift],
        ])->orderBy('id', 'ASC')->with('students', 'studentClass', 'section')->get();

        $data['date'] = $request->date;

        return view('pages.attendance.give_attendance', $data);

    }

    public function attendanceUpdate(Request $request, $id)
    {
        //dd($request->all());

        $attents = $request->input('attendence', []);  // Get the array of 'attendence' checkboxes
        $absents = $request->input('attendence_absent', []);  // Get the array of 'attendence_absent' checkboxes
        $delays = $request->input('attendence_delay', []);

        // Process 'attendence' checkboxes
        foreach ($attents as $attent) {

            $assign = StudentAssgin::where('user_id', $attent)->first();

            $give_attent = StudentAttendance::where([
                ['class_id', $assign->student_class_id],
                ['student_id', $assign->user_id],
                ['section_id', $assign->section_id],
                ['shift', $assign->shift],
                ['date', $request->date]
            ])->first();

            if (!empty($give_attent)) {
                $give_attent->attent = "1";  // Assuming "1" represents 'Present'
                $give_attent->save();
            }
            if (empty($give_attent)) {
                $give_new_attent = new StudentAttendance();
                $give_new_attent->class_id = $assign->student_class_id;
                $give_new_attent->section_id = $assign->section_id;
                $give_new_attent->teacher_id = Auth::user()->id;
                $give_new_attent->student_id = $assign->user_id;
                $give_new_attent->shift = $assign->shift;
                $give_new_attent->date = $request->date;
                $give_new_attent->attent = "1";  // Assuming "1" represents 'Present'
                $give_new_attent->save();
            }
        }

        foreach ($absents as $absent) {
            $assign = StudentAssgin::where('user_id', $absent)->first();
            $give_attent = StudentAttendance::where([
                ['class_id', $assign->student_class_id],
                ['student_id', $assign->user_id],
                ['section_id', $assign->section_id],
                ['shift', $assign->shift],
                ['date', $request->date]
            ])->first();

            if (!empty($give_attent)) {
                $give_attent->attent = "0";  // Assuming "1" represents 'Present'
                $give_attent->save();
            }
            if (empty($give_attent)) {
                $give_new_attent = new StudentAttendance();
                $give_new_attent->class_id = $assign->student_class_id;
                $give_new_attent->section_id = $assign->section_id;
                $give_new_attent->teacher_id = Auth::user()->id;
                $give_new_attent->student_id = $assign->user_id;
                $give_new_attent->shift = $assign->shift;
                $give_new_attent->date = $request->date;
                $give_new_attent->attent = "0";  // Assuming "1" represents 'Present'
                $give_new_attent->save();
            }
        }

        foreach ($delays as $delay) {
            $assign = StudentAssgin::where('user_id', $delay)->first();
            $give_attent = StudentAttendance::where([
                ['class_id', $assign->student_class_id],
                ['student_id', $assign->user_id],
                ['section_id', $assign->section_id],
                ['shift', $assign->shift],
                ['date', $request->date]
            ])->first();

            if (!empty($give_attent)) {
                $give_attent->attent = "2";  // Assuming "1" represents 'Present'
                $give_attent->save();
            }
            if (empty($give_attent)) {
                $give_new_attent = new StudentAttendance();
                $give_new_attent->class_id = $assign->student_class_id;
                $give_new_attent->section_id = $assign->section_id;
                $give_new_attent->teacher_id = Auth::user()->id;
                $give_new_attent->student_id = $assign->user_id;
                $give_new_attent->shift = $assign->shift;
                $give_new_attent->date = $request->date;
                $give_new_attent->attent = "2";  // Assuming "1" represents 'Present'
                $give_new_attent->save();
            }
        }

        $this->showToastrMessage('success', 'Attendance given successfully');
        //return redirect(route('attendance.show'));
        return redirect()->route('attendance.show', [
            'date' => $request->date,
            'class_id' => $assign->student_class_id,
            'section_id' => $assign->section_id,
            'shift' => $assign->shift
        ]);

    }

    public function attendanceEdit($id)
    {
        $studnet_attendenc = StudentAttendance::where('uuid', $id)->first();

        $date_time = \Carbon\Carbon::now()->format('d-m-Y');

        // if (Auth::user()->instructor != null && Auth::user()->student == null) {
        //     $data['attendances'] = StudentAttendance::where([
        //         ['teacher_id', Auth::user()->id],
        //         ['class_id', $studnet_attendenc->class_id],
        //         ['section_id', $studnet_attendenc->section_id],
        //         ['shift', $studnet_attendenc->shift],
        //         ['date', $date_time],
        //     ])->orderBy(
        //         'id',
        //         'ASC'
        //     )->with('students', 'studentClass', 'teachers')->get();

        //     return view('pages.attendance.edit', $data);

        // } else
        if (Auth::user()->student == null) {
            $data['attendances'] = StudentAttendance::where([
                ['class_id', $studnet_attendenc->class_id],
                ['section_id', $studnet_attendenc->section_id],
                ['shift', $studnet_attendenc->shift],
                ['date', $date_time],
            ])->orderBy('student_id', 'ASC')->with('students', 'studentClass', 'teachers')->get();

            // dd($data['attendences']);
            return view('pages.attendance.edit', $data);
        } else {
            $this->showToastrMessage('error', 'Something went wrong');
            return redirect()->back();
        }

        // if (Auth::user()->instructor != null) {
        //     $data['leftAttendanceParentActiveClass'] = 'active';
        //     $data['exams'] = Exam::where('uuid', $id)->with('subjects')->first();
        //     $data['subjects'] = Subject::orderBy('id', 'DESC')->get();
        //     return view('pages.attendance.edit', $data);
        // } else {
        //     $this->showToastrMessage('error', 'Your are not teacher you can not take attendence');
        //     return redirect()->back();
        // }
    }


    /*public function attendanceEditUpdate(Request $request, $id)
    {
        $attents = $request->input('attendence', []);  // Get the array of 'attendence' checkboxes
        $absents = $request->input('attendence_absent', []);
        $delays = $request->input('attendence_delay', []);

        foreach ($attents as $attent) {
            $give_attent = StudentAttendance::where([
                ['class_id', $request->class_id],
                ['section_id', $request->section_id],
                ['shift', $request->shift],
                ['date', $request->date]
            ])->first();

            if (!empty($give_attent)) {
                $give_attent->attent = "1";  // Assuming "1" represents 'Present'
                $give_attent->save();
            }
        }

        foreach ($absents as $absent) {

            $give_attent = StudentAttendance::where([
                ['class_id', $request->class_id],
                ['section_id', $request->section_id],
                ['shift', $request->shift],
                ['date', $request->date]
            ])->first();

            if (!empty($give_attent)) {
                $give_attent->attent = "0";  // Assuming "1" represents 'Present'
                $give_attent->save();
            }
        }

        foreach ($delays as $delay) {
            $assign = StudentAssgin::where('user_id', $delay)->first();
            $give_attent = StudentAttendance::where([
                ['class_id', $assign->class_id],
                ['student_id', $assign->user_id],
                ['section_id', $request->section_id],
                ['shift', $request->shift],
                ['date', $request->date]
            ])->first();
            if (!empty($give_attent)) {
                $give_attent->attent = "0";  // Assuming "1" represents 'Present'
                $give_attent->save();
            }
        }

        $this->showToastrMessage('success', 'Attendance update successfully');
        //return redirect(route('attendance.show?date=' . $request->date . '&class_id=' . $request->class_id . '&section_id=' . $request->section_id . '&shift=' . $request->shift));

        return redirect()->route('attendance.show', [
            'date' => $request->date,
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
            'shift' => $request->shift
        ]);
    }*/

    public function attendanceEditUpdate(Request $request, $id)
    {
        dd($request->all());

        // Fetch input data
        $attents = $request->input('attendence', []);
        $absents = $request->input('attendence_absent', []);
        $delays = $request->input('attendence_delay', []);

        // Update attendance for 'attendence' checkboxes
        if(!empty($attents)){
            foreach ($attents as $studentId) {
                $this->updateAttendance($request, $studentId, 1);
            }
        }

        // Update attendance for 'attendence_absent' checkboxes
        foreach ($absents as $studentId) {
            $this->updateAttendance($request, $studentId, 0);
        }

        // Update attendance for 'attendence_delay' checkboxes
        foreach ($delays as $studentId) {

            $this->updateAttendance($request, $studentId, 2); // Assuming delays are treated as absences
        }

        $this->showToastrMessage('success', 'Attendance updated successfully');

        // Redirect back to attendance page
        return redirect()->route('attendance.show', [
            'date' => $request->date,
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
            'shift' => $request->shift
        ]);
    }

    // Function to update attendance
    public function updateAttendance($request, $studentId, $status)
    {
        dd($request->all());

        $attendance = StudentAttendance::where([
            ['class_id', $request->class_id],
            ['student_id', $studentId],
            ['section_id', $request->section_id],
            ['shift', $request->shift],
            ['date', $request->date]
        ])->first();

        //dd($attendance);

        if(!empty($attendance)){
            $attendance->attent = $status; // Assuming "1" represents 'Present' and "0" represents 'Absent' and "3" represents 'Delay'
            $attendance->save();
        }
    }

   /* public function attendanceShow()
    {


        if (Auth::user()->instructor != null && Auth::user()->student == null) {
            $data['leftAttendanceParentActiveClass'] = 'active';
            $data['attendences'] = StudentAttendance::where([
                ['teacher_id', Auth::user()->id],
                ['date',  \Carbon\Carbon::now()->format('d-m-Y')]
                ])->orderBy('id', 'DESC')->with('students', 'studentClass', 'teachers')->get();

            $data['attendences'] = StudentAttendance::where('teacher_id', Auth::user()->id)->orderBy('id', 'DESC')->with('students', 'studentClass', 'teachers')->get();


        } elseif (Auth::user()->instructor == null && Auth::user()->student == null) {
            $data['leftAttendanceParentActiveClass'] = 'active';
            // $data['attendences'] = StudentAttendance::where('date',\Carbon\Carbon::now()->format('d-m-Y'))->orderBy('id', 'DESC')->with('students', 'studentClass', 'teachers')->get();
            $data['attendences'] = StudentAttendance::orderBy('student_id', 'ASC')->with('students', 'studentClass', 'teachers')->get();

        } else {
            $this->showToastrMessage('error', 'Something went wrong');
            return redirect()->back();
        }


        // $data['class'] = StudentClass::orderBy('id', 'DESC')->get();
        // $data['section'] = Section::orderBy('id', 'DESC')->get();



        return view('pages.attendance.show', $data);
    }*/

    public function attendanceShow(Request $request)
    {


        $data['classes'] = StudentClass::orderBy('id', 'ASC')->get();

        $data['sections'] = Section::orderBy('id', 'ASC')->get();

        // Default filter to current date if no filter data provided
        $filterDate = $request->input('date', \Carbon\Carbon::now()->format('d-m-Y'));
        $class = $request->input('class_id', 1);
        $section = $request->input('section_id', 1);
        $shift = $request->input('shift', 'Day');
        $gender = $request->input('gender', 'Boy');

        // if (Auth::user()->instructor != null && Auth::user()->student == null) {
        //     $data['leftAttendanceParentActiveClass'] = 'active';
        //     $data['attendences'] = StudentAttendance::where([
        //         ['teacher_id', Auth::user()->id],
        //         ['date', $filterDate]
        //     ])->orderBy('id', 'DESC')->with('students', 'studentClass', 'teachers')->get();

        // } else
        if (Auth::user()->student == null) {
            $data['leftAttendanceParentActiveClass'] = 'active';
            $data['attendences'] = StudentAttendance::where('date', $filterDate)
                ->where('class_id', $class)
                ->where('section_id', $section)
                ->where('shift', $shift)
                ->whereHas('students', function ($query) use ($gender) {
                    $query->where('gender', $gender);
                })
                ->orderBy('student_id', 'ASC')
                ->with('students', 'studentClass', 'teachers')
                ->get();
        } else {
            $this->showToastrMessage('error', 'Something went wrong');
            return redirect()->back();
        }

        return view('pages.attendance.show', $data);
    }

    public function attendanceDelete($id)
    {
        $this->showToastrMessage('success', 'Exam has been deleted');
        return redirect()->back();
    }

    public function sendMarkSMS(Request $request, $id){

        // dd($request->all() , $id);

        $Marks = ExamMark::where('exam_id', $request->exam_id)
        ->where('student_id', $request->studentId)
        ->with('student')->get();

        // dd($Marks);
        $studentName = $Marks[0]->student->first_name . ' ' . $Marks[0]->student->last_name;
        $mobile = $Marks[0]->student->phone_number;

        // foreach ($Marks as $key => $value) {

        //     //dump($value); // Dump, shows a detailed breakdown but continues execution

        // }


        // $data['exams'] = Exam::where('uuid', $id)->with('exam_mark')->first();

        return response()->json(['marks' => $Marks, 'mobile' => $mobile, 'studentName' => $studentName]);

        $this->showToastrMessage('success', 'Message has been sent successfully');

        return redirect()->back();

       // dd($data['exams']);
    }

    // public function sendMarkSMS(Request $request, $uuid) {
    //     // Retrieve the data sent from JavaScript
    //     $studentId = $request->input('studentId');
    //     $examResults = $request->input('examResults');

    //     // Process the data as needed
    //     // For example, you can save it to the database, send SMS, etc.

    //     // Return a response if necessary
    //     return response()->json(['message' => 'Data received successfully', 'studentId' => $studentId, 'examResults' => $examResults]);
    // }

    public function sendSMS($id)
    {

        $attend_send_sms = StudentAttendance::where('uuid', $id)->with('students', 'studentClass')->first();

        $phone = $attend_send_sms->students->phone_number;
        $student_name = $attend_send_sms->students->first_name . ' ' . $attend_send_sms->students->last_name;
        $class_name = $attend_send_sms->studentClass->name;
        $date = $attend_send_sms->date;

        $headers = array(
            "Content-type: application/json",
        );

        // $messagebody = "Dear guardian, Ummun international school notifies that $student_name did not attend class  $class_name on $attend_send_sms->date.";

        $messageBody = "প্রিয় অভিভাবক, $student_name আজ অনুপস্থিত, $date @ উম্মুন ইন্টারন্যাশনাল স্কুল।";

        $params = array(
            'user' => env('SMS_EMAIL'),
            'password' => env('SMS_PASSWORD'),
            'from' => 'UMMUN',
            'to' => "88$phone",
            'text' => $messageBody
        );

        $queryString = http_build_query($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://panel.smsbangladesh.com/api?$queryString");
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $resultData = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $resultDecode = json_decode($resultData);
        if ($statusCode == 409) {
            $result = $resultDecode;
            $status = false;
            $message = "Request already exist !!";

            return response()->json(compact('status', 'message', 'result'))->setStatusCode(409);
        }
        $this->showToastrMessage('success', 'Message has been sent successfully');
        return redirect()->back();
    }

    public function sendAllSMS($id)
    {
        $date_time = \Carbon\Carbon::now()->format('d-m-Y');

        // Retrieve attendances where students are absent
        $attend_send_smsss = StudentAttendance::where([
            ['class_id', $id],
            ['date', $date_time],
        ])->where('attent', 0)->with('students', 'studentClass')->get();

        dd($attend_send_smsss);

        // Loop to send SMS
        foreach ($attend_send_smsss as $attend_send_sms) {
            $phone = $attend_send_sms->students->phone_number;
            $student_name = $attend_send_sms->students->first_name . ' ' . $attend_send_sms->students->last_name;
            $class_name = $attend_send_sms->studentClass->name;
            $date = $attend_send_sms->date;

            $messagebody = "Dear guardian, Ummun international school notifies that $student_name did not attend class $class_name on $date.";

            // Send SMS
            $this->sendSMSCurl($phone, $messagebody);
        }

        $this->showToastrMessage('success', 'Message has been sent successfully');

        return redirect()->back();
    }

    private function sendSMSCurl($phone, $messagebody)
    {

        return true;
        // $headers = array("Content-type: application/json");
        // $params = array(
        //     'user' => 'ummunintschool@gmail.com',
        //     'password' => 'msr46096',
        //     'from' => 'UMMUN',
        //     'to' => "88$phone",
        //     'text' => $messagebody
        // );
        // $queryString = http_build_query($params);
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, "https://panel.smsbangladesh.com/api?$queryString");
        // curl_setopt($ch, CURLOPT_HTTPGET, 1);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $resultData = curl_exec($ch);
        // $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // curl_close($ch);
    }

    public function assginIndex()
    {

        $data['exams'] = StudentAssgin::orderBy('id', 'DESC')->with('students', 'studentClass', 'section', 'subject')->get();
        $data['leftAssginParentActiveClass'] = 'active';

        return view('pages.assgin.index', $data);
    }

    public function assginCreate()
    {

        $data['leftAssginParentActiveClass'] = 'active';
        $data['subjects'] = Subject::orderBy('id', 'DESC')->get();
        $data['classes'] = StudentClass::orderBy('id', 'DESC')->get();
        $data['sections'] = Section::orderBy('id', 'DESC')->get();
        $data['students'] = Student::orderBy('id', 'DESC')->get();

        return view('pages.assgin.create', $data);
    }

    public function assginStore(Request $request)
    {


        $old_assgin = StudentAssgin::where([
            ['user_id', $request->student_id],
            ['section_id', $request->section_id],
            ['student_class_id', $request->class_id],
            ['subject_id', $request->subject_id],
        ])->first();
        if (empty($old_assgin)) {
            $assgin = new StudentAssgin();
            $assgin->user_id = $request->student_id;
            $assgin->section_id = $request->section_id;
            $assgin->student_class_id = $request->class_id;
            $assgin->subject_id = $request->subject_id;
            $assgin->save();
            $this->showToastrMessage('success', 'Assgin has been successfully');
            return redirect()->back();
        } else {
            $this->showToastrMessage('error', 'This student already assgin');
            return redirect()->back();
        }
    }

    /*public function assignStore(Request $request)
{


    $existing_assignment = StudentAssign::where([
        ['user_id', $request->student_id],
        ['section_id', $request->section_id],
        ['student_class_id', $request->class_id],
        ['subject_id', $request->subject_id],
        ['date', $request->attendance_date],
    ])->first();

    if (empty($existing_assignment)) {
        // Check for existing attendance record for the same date, class, and section
        $existing_attendance = Attendance::where([
            ['attendance_date', $request->attendance_date],
            ['section_id', $request->section_id],
            ['student_class_id', $request->class_id],
        ])->exists();

        if ($existing_attendance) {
            $this->showToastrMessage('error', 'Attendance already exists for the same date, class, and section');
            return redirect()->back();
        }

        $assignment = new StudentAssign();
        $assignment->user_id = $request->student_id;
        $assignment->section_id = $request->section_id;
        $assignment->student_class_id = $request->class_id;
        $assignment->subject_id = $request->subject_id;
        $assignment->save();
        $this->showToastrMessage('success', 'Assignment has been successfully saved');
        return redirect()->back();
    } else {
        $this->showToastrMessage('error', 'This student already has an assignment');
        return redirect()->back();
    }
} */

    public function assginEdit($id)
    {

        $data['leftAssginParentActiveClass'] = 'active';
        $data['exams'] = StudentAssgin::where('uuid', $id)->with('subjects')->first();
        $data['subjects'] = Subject::orderBy('id', 'DESC')->get();
        return view('pages.assgin.edit', $data);
    }

    public function assginUpdate(Request $request, $id)
    {

        $exam = StudentAssgin::find($id);
        $exam->name = $request->name;
        $exam->subjects_id = $request->subject_id;
        $exam->start_date_time = $request->start_date_time;
        $exam->save();
        $this->showToastrMessage('success', 'Updated successfully');
        return $this->controlRedirection($request, 'exam', 'Exam');
    }

    public function assginDelete($id)
    {

        StudentAssgin::where('uuid', $id)->delete();
        $this->showToastrMessage('success', 'Assign has been removed');
        return redirect()->back();
    }
}
