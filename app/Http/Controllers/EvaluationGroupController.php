<?php

namespace App\Http\Controllers;

use App\EvaluationGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class EvaluationGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $evaluationGroups = DB::table('evaluation_groups')->get();

        $fields = [
            'id' => '#',
            'advisor_FK' => 'Orientador',
            'appraiser1_FK' => 'Professor 1',
            'appraiser2_FK' => 'Professor 2',
            'profile_FK' => 'Aluno',
            'status' => 'Status'
        ];

        return view('index', [
            'fields' => $fields, 
            'data' => $evaluationGroups, 
            'controller' => 'evaluationGroups', 
            'title' => 'Bancas'
        ]);
    }

    public function create()
    {
        $fields = [
            'name' => ['name' => 'Nome'],
            'address' => ['name' => 'Endereço'],
            'phone' => ['name' => 'Telefone'],
            'email' => ['name' => 'E-mail', 'type' => 'email'],
            'cnpj' => ['name' => 'CNPJ'],
        ];

        return view('create', [
            'fields' => $fields,
            'controller' => 'evaluationGroups',
            'title' => 'Registrar Banca',
        ]);
    }

    public function store(Request $request)
    {
        $status = Company::create($request->all());

        if ($status) {
            Session::flash('success', 'Empresa alterada com sucesso!');
            return redirect('companies');
        }

        Session::flash('error', 'Ocorreu um erro ao alterar a empresa!');
        return view('companies.create');
    }

    public function show($id)
    {
        $fields = [
            'id' => [ 'name' => '#' ],
            'name' => [ 'name' => 'Nome' ],
            'address' => [ 'name' => 'Endereço' ],
            'phone' => [ 'name' => 'Telefone' ],
            'email' => [ 'name' => 'E-mail', 'type' => 'email' ],
            'cnpj' => [ 'name' => 'CNPJ' ],
        ];

        return view('show', [
            'fields' => $fields, 
            'datum' => Company::findOrFail($id),
            'controller' => 'evaluationGroups', 
            'title' => 'Visualizar Empresa'
        ]);
    }

    public function edit($id)
    {
        $fields = [
            'name' => [ 'name' => 'Nome' ],
            'address' => [ 'name' => 'Endereço' ],
            'phone' => [ 'name' => 'Telefone' ],
            'email' => [ 'name' => 'E-mail', 'type' => 'email' ],
            'cnpj' => [ 'name' => 'CNPJ' ],
        ];

        return view('edit', [
            'fields' => $fields, 
            'datum' => Company::findOrFail($id),
            'controller' => 'evaluationGroups', 
            'title' => 'Editar Empresa'
        ]);
    }

    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $status = $company->update($request->all());

        if ($status) {
            Session::flash('success', 'Empresa alterada com sucesso!');
            return redirect('companies');
        }

        Session::flash('error', 'Ocorreu um erro ao alterar a empresa!');
        return view('companies.edit', ['company' => $company]);
    }

    public function destroy($id)
    {
        Company::destroy($id);
        Session::flash('success', 'Empresa excluída com sucesso!');

        return redirect('companies');
    }
}
