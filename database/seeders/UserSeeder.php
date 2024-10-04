<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Instructor;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\Section;
use App\Models\StudentAssgin;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            ['id' => 1, 'name' => 'Administration', 'email' => 'admin@gmail.com', 'password' => Hash::make(123456), 'role' => 1, 'phone_number' => '+8801999999999',
                'address' => 'Dhaka, Bangladesh', 'image' => 'uploads_demo/user/admin-avatar.jpg', 'created_at' => now(), 'updated_at' => now()]
        ]);

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user){
            $role = Role::first();
            if ($role){
                $user->assignRole($role);
            }
        }

        User::insert([
            ['id' => 2, 'name' => 'Teacher', 'email' => 'teacher@gmail.com', 'password' => Hash::make(123456), 'role' => 2, 'phone_number' => '+8801999999911',
                'address' => 'Dhaka, Bangladesh', 'image' => 'uploads_demo/user/admin-avatar.jpg', 'created_at' => now(), 'updated_at' => now()]
        ]);

        $teacherUser = User::where('email', 'teacher@gmail.com')->first();
        $instructor_data = [
            'uuid'=>'01cf1768-52b2-4b0e-8421-376e6c412d0f',
            'user_id' => $teacherUser->id,
            'first_name' => 'Teacher',
            'last_name' => '',
            'address' => 'Dhaka, Bangladesh',
            'professional_title' => 'Software engineer',
            'phone_number' => '+8801999999911',
            'status' => 1,
            'gender' => 'male',
        ];
        Instructor::insert($instructor_data);
        if ($teacherUser){
            $role = Role::where('name','Teacher')->first();
            if ($role){
                $teacherUser->assignRole($role);
            }
        }
        User::insert([
            ['id' =>3, 'name' => 'Student', 'email' => 'student@gmail.com', 'password' => Hash::make(123456), 'role' => 3, 'phone_number' => '+8801999999922',
                'address' => 'Dhaka, Bangladesh', 'image' => 'uploads_demo/user/admin-avatar.jpg', 'created_at' => now(), 'updated_at' => now()]
        ]);

        $studentUser = User::where('email', 'student@gmail.com')->first();
        $student_data = [
            'uuid'=>'01cf1768-52b2-4b0e-8421-376e6c412d0f',
            'user_id' => $studentUser->id,
            'first_name' => 'Student',
            'last_name' => '',
            'address' => 'Dhaka, Bangladesh',
            'phone_number' => '+8801999999922',
            'gender' => 'male',
        ];
        $student=Student::insert($student_data);


         StudentClass::insert([
            'id' =>1,
            'uuid'=>'01cf1768-52b2-4b0e-8421-376e6c412d0f',
            'name'=>'Class 1',
            'created_at' => now(), 'updated_at' => now()
         ]);
         StudentClass::insert([
            'id' =>2,
            'uuid'=>'01cf1768-52b2-4b0e-8421-376e6c412d02',
            'name'=>'Class 2',
            'created_at' => now(), 'updated_at' => now()
         ]);
         StudentClass::insert([
            'id' =>3,
            'uuid'=>'01cf1768-52b2-4b0e-8421-376e6c412d03',
            'name'=>'Class 3',
            'created_at' => now(), 'updated_at' => now()
         ]);
         StudentClass::insert([
            'id' =>4,
            'uuid'=>'01cf1768-52b2-4b0e-8421-376e6c412d04',
            'name'=>'Class 4',
            'created_at' => now(), 'updated_at' => now()
         ]);
         StudentClass::insert([
            'id' =>5,
            'uuid'=>'01cf1768-52b2-4b0e-8421-376e6c412d05',
            'name'=>'Class 5',
            'created_at' => now(), 'updated_at' => now()
         ]);
         StudentClass::insert([
            'id' =>6,
            'uuid'=>'01cf1768-52b2-4b0e-8421-376e6c412d06',
            'name'=>'Class 6',
            'created_at' => now(), 'updated_at' => now()
         ]);
         StudentClass::insert([
            'id' =>7,
            'uuid'=>'01cf1768-52b2-4b0e-8421-376e6c412d07',
            'name'=>'Class 7',
            'created_at' => now(), 'updated_at' => now()
         ]);
         StudentClass::insert([
            'id' =>8,
            'uuid'=>'01cf1768-52b2-4b0e-8421-376e6c412d9',
            'name'=>'Class 8',
            'created_at' => now(), 'updated_at' => now()
         ]);



         Section::insert([
            'id' =>1,
            'uuid'=>'01cf1768-52b2-4b0e-8421-376e6c412d0f',
            'name'=>'Section 1',
            'student_classe_id'=>'1',
            'created_at' => now(), 'updated_at' => now()
         ]);
         Section::insert([
            'id' =>2,
            'uuid'=>'01cf1768-52b2-4b0e-8421-376e6c412d02',
            'name'=>'Section 2',
            'student_classe_id'=>'2',
            'created_at' => now(), 'updated_at' => now()
         ]);
         Section::insert([
            'id' =>3,
            'uuid'=>'01cf1768-52b2-4b0e-8421-376e6c412d03',
            'name'=>'Section 3',
            'student_classe_id'=>'2',
            'created_at' => now(), 'updated_at' => now()
         ]);
         Section::insert([
            'id' =>4,
            'uuid'=>'01cf1768-52b2-4b0e-8421-376e6c412d04',
            'name'=>'Section 4',
            'student_classe_id'=>'2',
            'created_at' => now(), 'updated_at' => now()
         ]);
         Section::insert([
            'id' =>5,
            'uuid'=>'01cf1768-52b2-4b0e-8421-376e6c412d05',
            'name'=>'Section 5',
            'student_classe_id'=>'2',
            'created_at' => now(), 'updated_at' => now()
         ]);
         Section::insert([
            'id' =>6,
            'uuid'=>'01cf1768-52b2-4b0e-8421-376e6c412d06',
            'name'=>'Section 6',
            'student_classe_id'=>'2',
            'created_at' => now(), 'updated_at' => now()
         ]);
         Section::insert([
            'id' =>7,
            'uuid'=>'01cf1768-52b2-4b0e-8421-376e6c412d07',
            'name'=>'Section 7',
            'student_classe_id'=>'2',
            'created_at' => now(), 'updated_at' => now()
         ]);
         Section::insert([
            'id' =>8,
            'uuid'=>'01cf1768-52b2-4b0e-8421-376e6c412d9',
            'name'=>'Section 8',
            'student_classe_id'=>'2',
            'created_at' => now(), 'updated_at' => now()
         ]);
        $assgin = new StudentAssgin();
        $assgin->user_id = $studentUser->id;
        $assgin->section_id ='1';
        $assgin->student_class_id = '1';
        $assgin->save();
        if ($studentUser){
            $role = Role::where('name','Student')->first();
            if ($role){
                $studentUser->assignRole($role);
            }
        }
        $assgin = new StudentAssgin();
        $assgin->user_id = $teacherUser->id;
        $assgin->section_id ='1';
        $assgin->student_class_id = '1';
        $assgin->save();
        if ($teacherUser){
            $role = Role::where('name','Teacher')->first();
            if ($role){
                $teacherUser->assignRole($role);
            }
        }
    }
}
