<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'id' => 1,
                'name' => 'administrador'
            ],
            [
                'id' => 2,
                'name' => 'estudante'
            ],
            [
                'id' => 3,
                'name' => 'orientador'
            ],
            [
                'id' => 5,
                'name' => 'professor'
            ],
            [
                'id' => 4,
                'name' => 'pendente'
            ]
        ]);

        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => '$2y$10$9MvMytEHCCfsIf/gc5PrWug6AF1AzTBxb6x2XTb9nH4vbMceOd7iy'
            ],
            [
                'id' => 2,
                'name' => 'Aluno',
                'email' => 'aluno@aluno.com',
                'password' => '$2y$10$9MvMytEHCCfsIf/gc5PrWug6AF1AzTBxb6x2XTb9nH4vbMceOd7iy'
            ],
            [
                'id' => 3,
                'name' => 'Orientador',
                'email' => 'orientador@orientador.com',
                'password' => '$2y$10$9MvMytEHCCfsIf/gc5PrWug6AF1AzTBxb6x2XTb9nH4vbMceOd7iy'
            ],
            [
                'id' => 4,
                'name' => 'Professor 1',
                'email' => 'professor1@professor1.com',
                'password' => '$2y$10$9MvMytEHCCfsIf/gc5PrWug6AF1AzTBxb6x2XTb9nH4vbMceOd7iy'
            ],
            [
                'id' => 5,
                'name' => 'Professor 2',
                'email' => 'professor2@professor2.com',
                'password' => '$2y$10$9MvMytEHCCfsIf/gc5PrWug6AF1AzTBxb6x2XTb9nH4vbMceOd7iy'
            ]
        ]);

        DB::table('profiles')->insert([
            [
                'id' => 1,
                'user_FK' => 1,
                'father_name' => 'Pai',
                'mother_name' => 'Mãe',
                'date_of_birth' => '1999-06-20',
                'register' => 9879381221,
                'address' => 'Rua dos Bobos',
                'cpf' => '12345678911',
                'rg' => '123456789',
                'contact' => '35370509',
                'photo' => 'admin.png',
                'status' => 'Aprovado',
                'role_FK' => 1
            ],
            [
                'id' => 2,
                'user_FK' => 2,
                'father_name' => 'Pai',
                'mother_name' => 'Mãe',
                'date_of_birth' => '1999-06-29',
                'register' => 123123123,
                'address' => 'Rua dos Ovos',
                'cpf' => '12345678912',
                'rg' => '123456782',
                'contact' => '35370503',
                'photo' => 'aluno.png',
                'status' => 'Aprovado',
                'role_FK' => 2
            ],
            [
                'id' => 3,
                'user_FK' => 3,
                'father_name' => 'Pai',
                'mother_name' => 'Mãe',
                'date_of_birth' => '1999-05-29',
                'register' => 123123123,
                'address' => 'Rua dos Lobos',
                'cpf' => '12345678913',
                'rg' => '123456783',
                'contact' => '35370504',
                'photo' => 'orientador.png',
                'status' => 'Aprovado',
                'role_FK' => 3
            ],
            [
                'id' => 4,
                'user_FK' => 4,
                'father_name' => 'Pai',
                'mother_name' => 'Mãe',
                'date_of_birth' => '2000-06-29',
                'register' => 123123123,
                'address' => 'Rua dos Locos',
                'cpf' => '12345678914',
                'rg' => '123456784',
                'contact' => '35370505',
                'photo' => 'professor1.png',
                'status' => 'Aprovado',
                'role_FK' => 5
            ],
            [
                'id' => 5,
                'user_FK' => 5,
                'father_name' => 'Pai',
                'mother_name' => 'Mãe',
                'date_of_birth' => '1997-06-29',
                'register' => 123123123,
                'address' => 'Rua dos Cocos',
                'cpf' => '12345678915',
                'rg' => '123456785',
                'contact' => '35370506',
                'photo' => 'professor2.png',
                'status' => 'Aprovado',
                'role_FK' => 5
            ]
        ]);

        DB::table('companies')->insert([
            [
                'id' => 1,
                'name' => 'Google',
                'address' => 'Rua dos Cotocos',
                'phone' => '35371213',
                'email' => 'google@google.com',
                'cnpj' => 123123123,
            ],
            [
                'id' => 2,
                'name' => 'Facebook',
                'address' => 'Rua dos Nobres',
                'phone' => '35371214',
                'email' => 'facebook@facebook.com',
                'cnpj' => 123123124,
            ]
        ]);

        DB::table('evaluation_groups')->insert([
            [
                'id' => 1,
                'appraiser1_FK' => 4,
                'advisor_FK' => 2,
                'appraiser2_FK' => 5,
                'advisor_note' => 10,
                'defense_date' => '2019-06-29',
                'status' => 'Aprovado',
                'report_path' => 'report.pdf',
                'appraiser_note1' => 9,
                'appraiser_note2' => 8,
                'company_FK' => 1,
                'user_FK' => 2
            ]
        ]);

        DB::table('internships')->insert([
            [
                'id' => 1,
                'profile_FK' => 2,
                'supervisor_name' => 'Supervisor',
                'company_FK' => 1,
                'supervisor_phone' => 35370809,
                'supervisor_email' => 'supervisor@supervisor.com',
                'start_date' => '2019-07-20',
                'end_date' => '2019-12-25',
                'advisor_FK' => 2
            ]
        ]);

    }
}
