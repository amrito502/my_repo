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

//         // $employee->department['name'] 

//         $branch_name = StudentAssgin::section(['name' => $branchName]); 

//         // $branch_name = Section::firstOrCreate(['name' => $branchName]); 


//         $class_name = StudentClass::firstOrCreate(['name' => $className]);
//         $shift_name = StudentAssgin::firstOrCreate(['shift' => $shiftName]);


//         $old_assgin = StudentAssgin::where([
//             ['user_id', $user->id],
//             ['section_id', $branch_name->id],
//             ['student_class_id', $class_name->id],
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








==========================


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

        // Create or fetch the user
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => trim($firstName . ' ' . $lastName),
                'address' => $address,
                'phone_number' => $phoneNumber,
                'guardian_phone_number' => $guardianPhoneNumber,
                'gender' => $gender ?? '',
                'password' => Hash::make('123456'), // Default password
                'role' => 3,
                'email_verified_at' => now(),
            ]
        );

        $className = trim($className); 
        $class = StudentClass::firstOrCreate(
            ['name' => $className],
            ['subjects' => json_encode(['21', '20', '19', '18', '15', '14', '13', '12', '11', '10', '9', '8', '7'])] // Populate subjects with data
        );
      
        $normalizedBranchName = strtolower(trim($branchName));
        $section = Section::where('name', 'LIKE', '%' . $normalizedBranchName . '%')
                         ->first();
                if (!$section) {
                $section = Section::create([
                    'name' => $normalizedBranchName, // Use the normalized branch name
                    'status' => 1, 
                    'student_class_id' => $class->id, 
                ]);
            }              
           
        $shift = StudentAssgin::firstOrCreate(
            ['shift' => $shiftName, 'user_id' => $user->id]
        );
        $existingAssignment = StudentAssgin::where([
            ['user_id', $user->id],
            ['section_id', $section->id],  // Use section ID
            ['student_class_id', $class->id], // Set student_class_id
            ['shift', $shift->id],
        ])->exists();

        // If not existing, create a new assignment
        if (!$existingAssignment) {
            $assignment = new StudentAssgin();
            $assignment->user_id = $user->id; // Foreign key
            $assignment->section_id = $section->id; // Set section_id
            $assignment->student_class_id = $class->id; // Set student_class_id
            $assignment->shift = $shiftName; // Use shift name directly
            $assignment->save();
        }
    }

    $this->showToastrMessage('success', 'CSV data uploaded successfully!');
    return redirect()->route('student.index');
}



=======

$old_assgin = StudentAssgin::where([
                ['user_id', $user->id],
                ['section_id', $branch_name->name],
                ['student_class_id', $class_name->name],
                ['shift', $shift_name->shift],
            ])->first();
            if (empty($old_assgin)) {  }