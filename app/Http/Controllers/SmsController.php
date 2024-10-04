<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SmsHistory;
use App\Models\StudentClass;
use App\Traits\General;
use App\Models\Student;
use App\Models\StudentAttendance;
use App\Models\ExamMark;


class SmsController extends Controller
{
    use General;

    public function index()
    {
        $data['classes'] = StudentClass::orderBy('id', 'ASC')->get();

        return view('send_sms', $data);
    }

    public function ShowAllsms( Request $request){

        // $data['sms_history'] = SmsHistory::orderBy('id', 'DESC')->get();

        // return view('sms_history', $data);

        $query = SmsHistory::orderBy('id', 'DESC');

        // Apply filters based on request parameters
        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->has('sender')) {
            $query->where('sender', 'like', '%' . $request->input('sender') . '%');
        }
        if ($request->has('date_from') && $request->has('date_to')) {
            $query->whereBetween('created_at', [$request->input('date_from'), $request->input('date_to')]);
        }

        // Paginate the results
        $data['sms_history'] = $query->paginate(15);

        // Return the view with data
        return view('sms_history', $data);
    }

    public function sendStudentSms(Request $request)
    {

        $class = $request->class_id;
        $section = $request->section_id;
        $shift = $request->shift;

        $students = Student::orderBy('user_id', 'DESC')
            ->whereHas('assign', function ($query) use ( $class  , $section, $shift) {
                $query->where('student_class_id', $class)
                    ->where('section_id', $section)
                    ->where('shift', $shift);
            })
            ->with('assign')
            ->get();

        foreach ($students as $student) {
            $to = "88" . $student->phone_number;
            $messageBody = $request->message;
            $studentId = $student->user_id;
            $class_name = $student->assign->studentClass->name;
            $studentName = $student->first_name . ' ' . $student->last_name;

            $this->sendSms($to, $messageBody, $studentId, $class_name, null, $studentName);

        }

        //return response()->json(['marks' => $students]);

        $this->showToastrMessage('success', 'SMS sent successfully');

        return redirect()->back();
    }

    public function sendSms($to, $messageBody, $studentId, $className, $examId = null, $studentName)
    {
        $headers = array(
            "Content-type: application/json",
        );

        $params = array(
            'user' => env('SMS_EMAIL'),
            'password' =>  env('SMS_PASSWORD'),
            'from' => 'UMMUN',
            'to' => $to,
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

        // Log SMS history to database
        SmsHistory::create([
            'to' => $to,
            'student_id' => $studentId,
            'student_name' => $studentName,
            'class_name' => $className,
            'exam_id' => $examId,
            'message' => $messageBody,
            'status_code' => $statusCode,
            'response' => $resultData
        ]);

        return true;

    }

    public function SendAttendaceSms(Request $request){
        // Retrieve parameters
        $class_id = $request->input('classId');
        $section_id = $request->input('SectionId');
        $shift = $request->input('shift');
        $gender = $request->input('gender');

        $date_time = \Carbon\Carbon::now()->format('d-m-Y');

        // $allAbsentStudents = StudentAttendance::where([
        //     ['class_id', $class_id],
        //     ['section_id', $section_id],
        //     ['shift', $shift],
        //     ['date', $date_time],
        // ])->whereHas('students', function ($query) use ($gender) {
        //     $query->where('gender', $gender);
        // })->where('attent', 0)->with('students', 'studentClass')->get();

        $allAbsentStudents = StudentAttendance::where([
            ['class_id', $class_id],
            ['section_id', $section_id],
            ['shift', $shift],
            ['date', $date_time],
            ['attent', 0],
        ])->whereHas('students', function ($query) use ($gender) {
            $query->where('gender', $gender);
        })->with('students', 'studentClass')->get();


        //dd($allAbsentStudents);

        // $smsArray = [];

        foreach ($allAbsentStudents as $allAbsentStudent) {

            $studentId = $allAbsentStudent->students->user_id;
            $to = "88" . $allAbsentStudent->students->phone_number;
            $date = $allAbsentStudent->date;

            $student_name = $allAbsentStudent->students->first_name . ' ' . $allAbsentStudent->students->last_name;

            $class_name = $allAbsentStudent->studentClass->name;

            $messageBody = "সম্মানিত অভিভাবক, $student_name আজ অনুপস্থিত, $date @ উম্মুন ইন্টারন্যাশনাল স্কুল।";

            // $smsArray[] = array(
            //     "to" => "88" . $allAbsentStudent->students->phone_number,
            //     "name" => $allAbsentStudent->students->first_name . ' ' . $allAbsentStudent->students->last_name,
            //     "class" => $allAbsentStudent->studentClass->name,
            //     "date" => $allAbsentStudent->date,
            //     "messagebody" => "Dear Guardian, $student_name is absent today, $date. @ Ummun INT School.",
            // );

            $this->sendSms($to, $messageBody, $studentId, $class_name, null, $student_name);
        }

        // Your logic here
        //return response()->json(['message' => 'SMS Sent Successfully!', 'allAbsentstudents' => $messageBody]);
        $this->showToastrMessage('success', 'SMS sent successfully');

        return redirect()->back();
    }

    public function SendSingleAttendaceSms(Request $request){

        // dd($request->all());

        $class_name = $request->input('classId');
        $studentId = $request->input('student_id');
        $date = $request->input('date');
        $student_name = $request->input('student_name');
        $phone_number = $request->input('phone_number');

        $to = "88" . $phone_number;
        $messageBody = "সম্মানিত অভিভাবক, $student_name আজ অনুপস্থিত, $date @ উম্মুন ইন্টারন্যাশনাল স্কুল।";

        $this->sendSms($to, $messageBody, $studentId, $class_name, null, $student_name);

        //return response()->json(['message' => 'SMS Sent Successfully!', 'allAbsentstudents' => $messageBody]);

        $this->showToastrMessage('success', 'SMS sent successfully');

        return redirect()->back();

    }

    public function sendExamSms(Request $request){

        $Marks = ExamMark::where('exam_id', $request->exam_id)
        ->where('student_id', $request->studentId)
        ->with('student')->get();

        if(count($Marks) == 0){

            $this->showToastrMessage('warning', 'No Marks Found!');

            return redirect()->back();

            //return response()->json(['message' => 'No Marks Found!']);

        }else{
             // dd($Marks);
            $studentName = $Marks[0]->student->first_name . ' ' . $Marks[0]->student->last_name;
            $class_id = $Marks[0]->class_id;
            $studetId = $Marks[0]->student_id;
            $examID = $request->exam_id;

            $to = "88" . $Marks[0]->student->phone_number;

            $AllMarks = [];
            foreach ($Marks as  $key => $value) {

                $subject_name = $value->subject_name;
                $mark = $value->mark;

                $AllMarks[] = array(
                    "subject" => $subject_name,
                    "mark" => $mark
                );
            }

            $marksString = implode(', ', array_map(function ($mark) {
                return $mark['subject'] . ': ' . $mark['mark'];
            }, $AllMarks));

            $messageBody = "সম্মানিত অভিভাবক, আপনার সন্তান {$studentName} উম্মুনের সাপ্তাহিক পরীক্ষায় {$marksString} পেয়েছে।";

            // $class_id = $request->input('classId');
            // $studetId = $request->input('studentId');
            // $studentName = $request->input('studentName');
            // $messageBody = $request->input('messageBody');
            // $to = "88" . $request->input('to');

            $this->sendSms($to, $messageBody, $studetId, $class_id, $examID, $studentName);

            // return response()->json([
            //     'marks' => $AllMarks,
            //     'mobile' => $to,
            //     'Class ID' => $class_id,
            //     'Student ID' => $studetId,
            //     'Exam ID' => $examID,
            //     'studentName' => $studentName,
            //     'message' => $messageBody,
            //     'Get Full Data' => $Marks
            // ]);

            $this->showToastrMessage('success', 'SMS sent successfully');

            return redirect()->back();

        }


        //return response()->json(['message' => 'SMS Sent Successfully!']);

    }
}
