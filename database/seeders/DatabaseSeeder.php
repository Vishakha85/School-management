<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
        // Hash all existing user passwords with bcrypt if not already hashed
        {
            /**
             * Seed the application's database.
            */
            public function run(): void
            {
                \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);
                \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'student']);
                \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'teacher']);
        // Assign 'teacher' role to all teachers in teachers table
        $teacherModelClass = '\App\Models\Teacher';
        if (class_exists($teacherModelClass)) {
            $teachers = $teacherModelClass::all();
            foreach ($teachers as $teacher) {
                if (!\Illuminate\Support\Facades\Hash::needsRehash($teacher->password)) {
                    $teacher->password = \Illuminate\Support\Facades\Hash::make($teacher->password);
                    $teacher->save();
                }
                $user = \App\Models\User::where('name', $teacher->name)->first();
                if (!$user) {
                    $user = \App\Models\User::create([
                        'name' => $teacher->name,
                        'email' => isset($teacher->email) ? $teacher->email : $teacher->name . '@gmail.com',
                        'password' => $teacher->password,
                    ]);
                }
                $user->assignRole('teacher');
            }
        }

        $adminUser = User::firstOrCreate(
            ['name' => 'admin'],
            [
                'email' => 'admin@example.com',
                'password' => 'password123', 
            ]
        );
        

        // Assign 'admin' role to the admin user
        if ($adminUser) {
            $adminUser->assignRole('admin');
        }

     
        $studentModelClass = '\App\Models\student';
        if (class_exists($studentModelClass)) {
            $students = $studentModelClass::all();
            foreach ($students as $student) {
                if (!\Illuminate\Support\Facades\Hash::needsRehash($student->password)) {
                    $student->password = \Illuminate\Support\Facades\Hash::make($student->password);
                    $student->save();
                }
                $user = \App\Models\User::where('name', $student->name)->first();
                if (!$user) {
                    $user = \App\Models\User::create([
                        'name' => $student->name,
                        'email' => isset($student->email) ? $student->email : $student->name . '@gmail.com',
                        'password' => $student->password,
                    ]);
                }
                $user->assignRole('student');
            }
        }
    }
}
