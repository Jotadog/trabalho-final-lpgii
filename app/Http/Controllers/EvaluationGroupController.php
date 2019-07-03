<?php

namespace App\Http\Controllers;

use App\Company;
use App\EvaluationGroup;
use App\Profile;
use App\Internship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class EvaluationGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('finishRegister');
    }

    public function index()
    {
        $role = auth()->user()->profile->role->name; 
        $id = auth()->user()->profile->id;

        if($role == "administrador"){
            $evaluationGroups = EvaluationGroup::all();
            $modify = [ 'create' => true, 'delete' => true, 'edit' => true ];
        }else if($role == "professor"){
            $evaluationGroups = EvaluationGroup::where('advisor_FK', $id)
                ->orWhere('appraiser1_FK', $id)
                ->orWhere('appraiser2_FK', $id)
                ->get();

            $internship = Internship::where(['advisor_FK' => $id])->get();
            if($internship->isEmpty()){
                $modify = [ 'create' => false, 'delete' => false, 'edit' => true ];    
            }else{
                $modify = [ 'create' => true, 'delete' => true, 'edit' => true ];
            }
        }else{
            $evaluationGroups = EvaluationGroup::where('profile_FK', $id)->get();
            $modify = [ 'create' => false, 'delete' => false, 'edit' => false ];
        }

        $fields = [
            'id' => '#',
            'advisor' => 'Orientador',
            'appraiser1' => 'Professor 1',
            'appraiser2' => 'Professor 2',
            'profile' => 'Aluno',
            'status' => 'Status',
        ];

        $newEvaluationGroups = [];
        foreach ($evaluationGroups as $value) {
            array_push($newEvaluationGroups, (object) [
                'id' => $value['id'],
                'advisor' => $value['advisor']['user']['name'],
                'appraiser1' => $value['appraiser1']['user']['name'],
                'appraiser2' => $value['appraiser2']['user']['name'],
                'profile' => $value['profile']['user']['name'],
                'status' => $value['status'],
            ]);
        }

        return view('index', [
            'fields' => $fields,
            'data' => $newEvaluationGroups,
            'controller' => 'evaluationGroups',
            'title' => 'Bancas',
            'modify' => $modify
        ]);
    }

    public function create() 
    {
        $id = auth()->user()->profile->id;
        $role = auth()->user()->profile->role->name; 

        $companies = Company::all();
        $profiles = Profile::where(['role_FK' => 3])->get();
        $profilesStudent = Profile::where(['role_FK' => 2])->get();

        if($role == "administrador"){
            $internship = Internship::all();
        }else{
            $internship = Internship::where(['advisor_FK' => $id])->get();
            
            if($internship->isEmpty()) {
                Session::flash('error', 'Você não tem acesso a essa parte do sistema!');
                return redirect('evaluationGroups');
            }
        }

        $fields = [
            'advisor_FK' => ['name' => 'Orientador', 'select' => 'true'],
            'appraiser1_FK' => ['name' => 'Professor 1', 'select' => 'true'],
            'appraiser2_FK' => ['name' => 'Professor 2', 'select' => 'true'],
            'company_FK' => ['name' => 'Empresa', 'select' => 'true'],
            'profile_FK' => ['name' => 'Aluno', 'select' => 'true'],
            'status' => ['name' => 'Status'],
            'advisor_note' => ['name' => 'Nota Orientador'],
            'defense_date' => ['name' => 'Data de defesa', 'type' => 'date'],
            'report_path' => ['name' => 'Relatório', 'type' => 'file'],
            'appraiser_note1' => ['name' => 'Nota Professor 1'],
            'appraiser_note2' => ['name' => 'Nota Professor 2'],
            'internship_FK' => ['name' => 'ID Estágio', 'select' => 'true'],
        ];

        $newProfiles = [];
        $newCompanies = [];
        $newProfilesStudent = [];
        $newInternship = [];

        foreach ($profiles as $value) 
            array_push($newProfiles, ['name' => $value['user']['name'], 'value' => $value['user_FK']]);

        foreach ($companies as $value) 
            array_push($newCompanies, ['name' => $value['name'], 'value' => $value['id']]);

        foreach ($profilesStudent as $value) 
            array_push($newProfilesStudent, ['name' => $value['user']['name'], 'value' => $value['user_FK']]);

        foreach ($internship as $value) 
            array_push($newInternship, ['name' => $value['id'], 'value' => $value['id']]);

        $datum = [
            'advisor_FK' => $newProfiles,
            'appraiser1_FK' => $newProfiles,
            'appraiser2_FK' => $newProfiles,
            'company_FK' => $newCompanies,
            'profile_FK' => $newProfilesStudent,
            'internship_FK' => $newInternship
        ];

        return view('create', [
            'fields' => $fields,
            'controller' => 'evaluationGroups',
            'datum' => $datum,
            'title' => 'Registrar Banca',
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'appraiser1_FK' => 'required|numeric',
            'appraiser2_FK' => 'required|numeric',
            'advisor_FK' => 'required|numeric',
            'advisor_note' => 'max:191',
            'defense_date' => 'required|max:191',
            'status' => 'required|max:191',
            'report_path' => 'required|max:191',
            'appraiser_note1' => 'max:191',
            'appraiser_note2' => 'max:191',
            'company_FK' => 'required|numeric',
            'profile_FK' => 'required|numeric',
            'internship_FK' => 'required|numeric'
        ]);

        if($validator->fails()) {
            Session::flash('error', 'Ocorreu um erro ao alterar a banca!');
            return redirect('evaluationGroup/create');
        }
        
        $status = EvaluationGroup::create($request->all());

        if ($status) {
            Session::flash('success', 'Banca cadastrada com sucesso!');
            return redirect('evaluationGroup');
        }

        Session::flash('error', 'Ocorreu um erro ao cadastrar a banca!');
        return redirect('evaluationGroup/create');
    }

    public function show($id)
    {
        $evaluationGroup = EvaluationGroup::findOrFail($id);

        $fields = [
            'advisor_FK' => ['name' => 'Orientador', 'select' => 'true'],
            'appraiser1_FK' => ['name' => 'Professor 1', 'select' => 'true'],
            'appraiser2_FK' => ['name' => 'Professor 2', 'select' => 'true'],
            'company_FK' => ['name' => 'Empresa', 'select' => 'true'],
            'profile_FK' => ['name' => 'Aluno', 'select' => 'true'],
            'status' => ['name' => 'Status'],
            'advisor_note' => ['name' => 'Nota Orientador'],
            'defense_date' => ['name' => 'Data de defesa', 'type' => 'date'],
            'report_path' => ['name' => 'Relatório'],
            'appraiser_note1' => ['name' => 'Nota Professor 1'],
            'appraiser_note2' => ['name' => 'Nota Professor 2'],
            'internship_FK' => ['name' => 'ID Estágio', 'select' => 'true'],
        ];

        $datum = (object) [
            'appraiser1_FK' => $evaluationGroup['appraiser1']['user']['name'],
            'appraiser2_FK' => $evaluationGroup['appraiser2']['user']['name'],
            'advisor_FK' => $evaluationGroup['advisor']['user']['name'],
            'advisor_note' => $evaluationGroup['advisor_note'],
            'defense_date' => $evaluationGroup['defense_date'],
            'status' => $evaluationGroup['status'],
            'report_path' => $evaluationGroup['report_path'],
            'appraiser_note1' => $evaluationGroup['appraiser_note1'],
            'appraiser_note2' => $evaluationGroup['appraiser_note2'],
            'company_FK' => $evaluationGroup['company']['name'],
            'profile_FK' => $evaluationGroup['profile']['user']['name'],
            'internship_FK' => $evaluationGroup['internship']['id'],
        ];

        return view('show', [
            'fields' => $fields,
            'datum' => $datum,
            'controller' => 'evaluationGroups',
            'title' => 'Visualizar Banca',
        ]);
    }

    public function edit($id)
    {
        $profileId = auth()->user()->profile->id;
        $role = auth()->user()->profile->role->name; 
        
        $evaluationGroup = EvaluationGroup::findOrFail($id);
        $companies = Company::all();
        $profiles = Profile::where(['role_FK' => 3])->get();
        $profilesStudent = Profile::where(['role_FK' => 2])->get();
        $internship = Internship::all();
        
        $fields = [
            'advisor_FK' => ['name' => 'Orientador', 'select' => 'true'],
            'appraiser1_FK' => ['name' => 'Professor 1', 'select' => 'true'],
            'appraiser2_FK' => ['name' => 'Professor 2', 'select' => 'true'],
            'company_FK' => ['name' => 'Empresa', 'select' => 'true'],
            'profile_FK' => ['name' => 'Aluno', 'select' => 'true'],
            'status' => ['name' => 'Status'],
            'advisor_note' => ['name' => 'Nota Orientador'],
            'defense_date' => ['name' => 'Data de defesa', 'type' => 'date'],
            'report_path' => ['name' => 'Relatório', 'type' => 'file'],
            'internship_FK' => ['name' => 'ID Estágio', 'select' => 'true']
        ];

        $appraiser1 = [];
        $appraiser2 = [];
        $advisor = [];
        $newCompanies = [];
        $newProfilesStudent = [];
        $newInternship = [];

        foreach ($profiles as $key => $value) {
            if ($key == 0) {
                array_push($appraiser1, [
                    'name' => $evaluationGroup['appraiser1']['user']['name'],
                    'value' => $evaluationGroup['appraiser1']['user_FK']
                ]);
                array_push($appraiser2, [
                    'name' => $evaluationGroup['appraiser2']['user']['name'],
                    'value' => $evaluationGroup['appraiser2']['user_FK']
                ]);
                array_push($advisor, [
                    'name' => $evaluationGroup['advisor']['user']['name'],
                    'value' => $evaluationGroup['advisor']['user_FK']
                ]);
            }

            if ($appraiser1[0]['value'] != $value['user_FK']) {
                array_push($appraiser1, ['name' => $value['user']['name'], 'value' => $value['user_FK']]);
            }

            if ($appraiser2[0]['value'] != $value['user_FK']) {
                array_push($appraiser2, ['name' => $value['user']['name'], 'value' => $value['user_FK']]);
            }

            if ($advisor[0]['value'] != $value['user_FK']) {
                array_push($advisor, ['name' => $value['user']['name'], 'value' => $value['user_FK']]);
            }
        }

        foreach ($companies as $key => $value) {
            if ($key == 0) {
                array_push($newCompanies, [
                    'name' => $evaluationGroup['company']['name'],
                    'value' => $evaluationGroup['company_FK']
                ]);
            }

            if ($newCompanies[0]['value'] != $value['id']) {
                array_push($newCompanies, ['name' => $value['name'], 'value' => $value['id']]);
            }
        }

        foreach ($profilesStudent as $key => $value) {
            if ($key == 0) {
                array_push($newProfilesStudent, [
                    'name' => $evaluationGroup['profile']['user']['name'],
                    'value' => $evaluationGroup['profile_FK']
                ]);
            }

            if ($newProfilesStudent[0]['value'] != $value['id']) {
                array_push($newProfilesStudent, ['name' => $value['user']['name'], 'value' => $value['user_FK']]);
            }
        }

        foreach ($internship as $key => $value) {
            if ($key == 0) {
                array_push($newInternship, [
                    'name' => $evaluationGroup['internship_FK'],
                    'value' => $evaluationGroup['internship_FK']
                ]);
            }

            if ($newInternship[0]['value'] != $value['id']) {
                array_push($newInternship, ['name' => $value['id'], 'value' => $value['id']]);
            }
        }

        $datum = [
            'id' => $id,
            'appraiser1_FK' => $appraiser1,
            'appraiser2_FK' => $appraiser2,
            'advisor_FK' => $advisor,
            'advisor_note' => $evaluationGroup['advisor_note'],
            'defense_date' => $evaluationGroup['defense_date'],
            'status' => $evaluationGroup['status'],
            'report_path' => $evaluationGroup['report_path'],
            'company_FK' => $newCompanies,
            'profile_FK' => $newProfilesStudent,
            'internship_FK' => $newInternship
        ];
        
        if($role == "professor"){
            $evaluation = EvaluationGroup::where(['appraiser1_FK' => $profileId, 'id' => $id])->get();
            if(!$evaluation->isEmpty()) {
                $fields = [ 'appraiser_note1' => ['name' => 'Nota Professor 1'] ];
                $datum = [ 'id' => $id, 'appraiser_note1' => $evaluationGroup['appraiser_note1'] ];
            }
            $evaluation = EvaluationGroup::where(['appraiser2_FK' => $profileId, 'id' => $id])->get();
            if(!$evaluation->isEmpty()) {
                $fields = [ 'appraiser_note2' => ['name' => 'Nota Professor 2'] ];
                $datum = [ 'id' => $id, 'appraiser_note2' => $evaluationGroup['appraiser_note2'] ];
            }
        }else if($role == "administrador"){
            array_push($datum, ['appraiser_note1' => $evaluationGroup['appraiser_note1']]);
            array_push($datum, ['appraiser_note2' => $evaluationGroup['appraiser_note2']]);
        }
        
        return view('edit', [
            'fields' => $fields,
            'datum' => (object) $datum,
            'controller' => 'evaluationGroups',
            'title' => 'Editar Banca',
        ]);
    }

    public function update(Request $request, $id)
    {
        $role = auth()->user()->profile->role->name; 
        $profileId = auth()->user()->profile->id;

        $evaluationGroup = EvaluationGroup::findOrFail($id);

        $validations = [
            'appraiser1_FK' => 'required|numeric',
            'appraiser2_FK' => 'required|numeric',
            'advisor_FK' => 'required|numeric',
            'advisor_note' => 'max:191',
            'defense_date' => 'required|max:191',
            'status' => 'required|max:191',
            'company_FK' => 'required|numeric',
            'profile_FK' => 'required|numeric',
            'internship_FK' => 'required|numeric'
        ];
        
        if($role == "professor"){
            $evaluation = EvaluationGroup::where(['appraiser1_FK' => $profileId, 'id' => $id])->get();
            if(!$evaluation->isEmpty()) {
                $validations = [ 'appraiser_note1' => 'max:191' ];
            }

            $evaluation = EvaluationGroup::where(['appraiser2_FK' => $profileId, 'id' => $id])->get();
            if(!$evaluation->isEmpty()) {
                $validations = [ 'appraiser_note2' => 'max:191' ];
            }
        }else if($role == "administrador"){
            array_push($validations, ['appraiser_note1' => 'max:191']);
            array_push($validations, ['appraiser_note2' => 'max:191']);
        }

        $validator = Validator::make($request->all(), $validations);

        if($validator->fails()) {
            Session::flash('error', 'Ocorreu um erro ao alterar a banca!');
            return redirect('evaluationGroups/edit', ['evaluationGroup' => $evaluationGroup]);
        }

        $status = $evaluationGroup->update($request->all());

        if ($status) {
            Session::flash('success', 'Banca alterada com sucesso!');
            return redirect('evaluationGroups');
        }

        Session::flash('error', 'Ocorreu um erro ao alterar a banca!');
        return redirect('evaluationGroups/edit', ['evaluationGroup' => $evaluationGroup]);
    }

    public function destroy($id)// verificar se o usuário é um advisor
    {
        EvaluationGroup::destroy($id);
        Session::flash('success', 'Banca excluída com sucesso!');

        return redirect('evaluationGroups');
    }
}
