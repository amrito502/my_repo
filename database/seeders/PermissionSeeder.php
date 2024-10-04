<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        Permission::create(['name' => 'view_student_assgin']);
        Permission::create(['name' => 'add_student_assgin']);
        Permission::create(['name' => 'edit_student_assgin']);
        Permission::create(['name' => 'delete_student_assgin']);

        Permission::create(['name' => 'view_attendance']);
        Permission::create(['name' => 'add_attendance']);
        Permission::create(['name' => 'edit_attendance']);
        Permission::create(['name' => 'delete_attendance']);

        Permission::create(['name' => 'view_class']);
        Permission::create(['name' => 'add_class']);
        Permission::create(['name' => 'edit_class']);
        Permission::create(['name' => 'delete_class']);

        Permission::create(['name' => 'view_section']);
        Permission::create(['name' => 'add_section']);
        Permission::create(['name' => 'edit_section']);
        Permission::create(['name' => 'delete_section']);
        
        Permission::create(['name' => 'view_subject']);  
        Permission::create(['name' => 'add_subject']);  
        Permission::create(['name' => 'edit_subject']);
        Permission::create(['name' => 'delete_subject']);

        Permission::create(['name' => 'view_exam']);
        Permission::create(['name' => 'add_exam']);    
        Permission::create(['name' => 'edit_exam']);
        Permission::create(['name' => 'delete_exam']);

        Permission::create(['name' => 'view_mark']);  
        Permission::create(['name' => 'add_mark']);  
        Permission::create(['name' => 'edit_mark']);
        Permission::create(['name' => 'delete_mark']);

        Permission::create(['name' => 'view_role']);  
        Permission::create(['name' => 'add_role']);  
        Permission::create(['name' => 'edit_role']);
        Permission::create(['name' => 'delete_role']);

        Permission::create(['name' => 'view_teacher']);  
        Permission::create(['name' => 'add_teacher']);  
        Permission::create(['name' => 'edit_teacher']);
        Permission::create(['name' => 'delete_teacher']);

        Permission::create(['name' => 'view_student']);  
        Permission::create(['name' => 'add_student']);  
        Permission::create(['name' => 'edit_student']);
        Permission::create(['name' => 'delete_student']);

        Permission::create(['name' => 'view_user']);  
        Permission::create(['name' => 'add_user']);  
        Permission::create(['name' => 'edit_user']);
        Permission::create(['name' => 'delete_user']);

        Permission::create(['name' => 'home_setting']);
        Permission::create(['name' => 'user_management']);

        $role = Role::where('name', 'Super Admin')->first();
        if ($role){
            $role->givePermissionTo(Permission::all());
        }
    }
}
