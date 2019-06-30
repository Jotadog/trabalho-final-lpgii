<?php

namespace App\Http\Controllers;
use App\Internship;
use App\Profile;
use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class InternshipController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $internships = Internship::all();
        
        $fields = [
            'id' => '#',
            'student' => 'Estudante',
            'supervisor_name' => 'Supervisor',
            'company' => 'Empresa',
            'start_date' => 'Data Início',
            'end_date' => 'Data Fim'
        ];

        $newInternships = [];
        foreach($internships as $value) 
            array_push($newInternships, (object) [
                'id' => $value['id'],
                'student' => $value['profile']['user']['name'],
                'supervisor_name' => $value['supervisor_name'],
                'company' => $value['company']['name'],
                'start_date' => $value['start_date'],
                'end_date' => $value['end_date']
            ]);
            
        return view('index', [
            'fields' => $fields, 
            'data' => $newInternships, 
            'controller' => 'internships', 
            'title' => 'Estágios'
        ]);
    }

    public function create()
    {
        $companies = Company::all();
        $profiles = Profile::where(['role_FK' => 3])->get();
        $profilesStudent = Profile::where(['role_FK' => 2])->get();

        $fields = [
            'profile_FK' => ['name' => 'Aluno', 'select' => 'true'],
            'supervisor_name' => ['name' => 'Nome Supervisor'],
            'company_FK' => ['name' => 'Empresa', 'select' => 'true'],
            'supervisor_phone' => ['name' => 'Telefone Supervisor'],
            'supervisor_email' => ['name' => 'Email Supervisor'],
            'start_date' => ['name' => 'Data Início', 'type' => 'date'],
            'end_date' => ['name' => 'Data Fim', 'type' => 'date'],
            'advisor_FK' => ['name' => 'Orientador', 'select' => 'true']
        ];

        $newProfiles = [];
        $newCompanies = [];
        $newProfilesStudent = [];

        foreach($profiles as $value)
            array_push($newProfiles, [ 'name' => $value['user']['name'], 'value' => $value['user_FK'] ]);

        foreach($companies as $value)
            array_push($newCompanies, [ 'name' => $value['name'], 'value' => $value['id'] ]);
        
        foreach($profilesStudent as $value)
            array_push($newProfilesStudent, [ 'name' => $value['user']['name'], 'value' => $value['user_FK'] ]);        

        $datum = [
            'advisor_FK' => $newProfiles,
            'company_FK' => $newCompanies,
            'profile_FK' => $newProfilesStudent
        ];
        
        return view('create', [
            'fields' => $fields,
            'controller' => 'internships',
            'datum' => $datum,
            'title' => 'Registrar Estágio',
        ]);
    }

    public function store(Request $request)
    {
        $status = Internship::create($request->all());

        if ($status) {
            Session::flash('success', 'Estágio alterado com sucesso!');
            return redirect('internships');
        }

        Session::flash('error', 'Ocorreu um erro ao alterar o estágio!');
        return view('internships.create');
    }

    public function show($id)
    {
        $internship = Internship::findOrFail($id);
        
        $fields = [
            'profile_FK' => ['name' => 'Aluno', 'select' => 'true'],
            'supervisor_name' => ['name' => 'Nome Supervisor'],
            'company_FK' => ['name' => 'Empresa', 'select' => 'true'],
            'supervisor_phone' => ['name' => 'Telefone Supervisor'],
            'supervisor_email' => ['name' => 'Email Supervisor'],
            'start_date' => ['name' => 'Data Início', 'type' => 'date'],
            'end_date' => ['name' => 'Data Fim', 'type' => 'date'],
            'advisor_FK' => ['name' => 'Orientador', 'select' => 'true']
        ];

        $datum = (object) [
            'profile_FK' => $internship['profile']['user']['name'],
            'supervisor_name' => $internship['supervisor_name'],
            'company_FK' => $internship['company']['name'],
            'supervisor_phone' => $internship['supervisor_phone'],
            'supervisor_email' => $internship['supervisor_email'],
            'start_date' => $internship['start_date'],
            'end_date' => $internship['end_date'],
            'advisor_FK' => $internship['advisor']['user']['name']
        ];

        return view('show', [
            'fields' => $fields, 
            'datum' => $datum,
            'controller' => 'internships', 
            'title' => 'Visualizar Estágio'
        ]);
    }

    public function edit($id)
    {
        $internship = Internship::findOrFail($id);
        $companies = Company::all();
        $profiles = Profile::where(['role_FK' => 3])->get();
        $profilesStudent = Profile::where(['role_FK' => 2])->get();

        $fields = [
            'profile_FK' => ['name' => 'Aluno', 'select' => 'true'],
            'supervisor_name' => ['name' => 'Nome Supervisor'],
            'company_FK' => ['name' => 'Empresa', 'select' => 'true'],
            'supervisor_phone' => ['name' => 'Telefone Supervisor'],
            'supervisor_email' => ['name' => 'Email Supervisor'],
            'start_date' => ['name' => 'Data Início', 'type' => 'date'],
            'end_date' => ['name' => 'Data Fim', 'type' => 'date'],
            'advisor_FK' => ['name' => 'Orientador', 'select' => 'true']
        ];

        $advisor = [];
        $newCompanies = [];
        $newProfilesStudent = [];

        foreach($profiles as $key => $value){
            if($key == 0){
                array_push($advisor, [
                    'name' => $internship['advisor']['user']['name'], 
                    'value' => $internship['advisor']['user_FK'] ]
                );
            }

            if($advisor[0]['value'] != $value['user_FK'])
                array_push($advisor, [ 'name' => $value['user']['name'], 'value' => $value['user_FK'] ]);
        }

        foreach($companies as $key => $value){
            if($key == 0){
                array_push($newCompanies, [
                    'name' => $internship['company']['name'], 
                    'value' => $internship['company_FK'] ]
                );
            }

            if($newCompanies[0]['value'] != $value['id'])
                array_push($newCompanies, [ 'name' => $value['name'], 'value' => $value['id'] ]);
        }

        foreach($profilesStudent as $key => $value){
            if($key == 0){
                array_push($newProfilesStudent, [
                    'name' => $internship['profile']['user']['name'], 
                    'value' => $internship['profile_FK'] ]
                );
            }

            if($newProfilesStudent[0]['value'] != $value['id'])
                array_push($newProfilesStudent, [ 'name' => $value['user']['name'], 'value' => $value['user_FK'] ]);        
        }

        $datum = (object) [
            'id' => $id,
            'profile_FK' => $newProfilesStudent,
            'supervisor_name' => $internship['supervisor_name'],
            'company_FK' => $newCompanies,
            'supervisor_phone' => $internship['supervisor_phone'],
            'supervisor_email' => $internship['supervisor_email'],
            'start_date' => $internship['start_date'],
            'end_date' => $internship['end_date'],
            'advisor_FK' => $advisor
        ];

        return view('edit', [
            'fields' => $fields, 
            'datum' => $datum,
            'controller' => 'internships', 
            'title' => 'Editar Estágio'
        ]);
    }

    public function update(Request $request, $id)
    {
        $internship = Internship::findOrFail($id);

        $status = $internship->update($request->all());

        if ($status) {
            Session::flash('success', 'Estágio alterado com sucesso!');
            return redirect('internships');
        }

        Session::flash('error', 'Ocorreu um erro ao alterar o estágio!');
        return view('internships.edit', ['internship' => $internship]);
    }

    public function destroy($id)
    {
        Internship::destroy($id);
        Session::flash('success', 'Estágio excluído com sucesso!');

        return redirect('internships');
    }
}
