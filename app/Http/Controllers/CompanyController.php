<?php

namespace App\Http\Controllers;

use App\Company;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('finishRegister');
    }

    public function index()
    {
        $result = DB::table('companies')
            ->select('companies.*', DB::raw('count(users.id) as quantity'))
            ->leftJoin('internships', 'companies.id', '=', 'internships.company_FK')
            ->leftJoin('profiles', 'internships.profile_FK', '=', 'profiles.id')
            ->leftJoin('users', 'profiles.user_FK', '=', 'users.id')
            ->groupBy('companies.id')
            ->get();

        $fields = [
            'id' => '#',
            'name' => 'Nome',
            'cnpj' => 'CNPJ',
            'email' => 'E-mail',
            'quantity' => 'Qtd. Alunos',
        ];

        return view('index', [
            'fields' => $fields,
            'data' => $result,
            'controller' => 'companies',
            'title' => 'Empresas',
        ]);
    }

    public function create()
    {
        $fields = [
            'name' => ['name' => 'Nome'],
            'address' => ['name' => 'Endereço'],
            'phone' => ['name' => 'Telefone'],
            'email' => ['name' => 'E-mail', 'type' => 'email'],
            'cnpj' => ['name' => 'CNPJ']
        ];

        return view('create', [
            'fields' => $fields,
            'controller' => 'companies',
            'title' => 'Registrar Empresa',
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
            'address' => 'required|max:191',
            'phone' => 'required|max:191',
            'email' => 'required|max:191',
            'cnpj' => 'required|max:191' 
        ]);

        if($validator->fails()) {
            Session::flash('error', 'Ocorreu um erro ao alterar a empresa!');
            return redirect('companies/create');
        }

        $status = Company::create($request->all());

        if ($status) {
            Session::flash('success', 'Empresa alterada com sucesso!');
            return redirect('companies');
        }

        Session::flash('error', 'Ocorreu um erro ao alterar a empresa!');
        return redirect('companies/create');
    }

    public function show($id)
    {
        $fields = [
            'id' => ['name' => '#'],
            'name' => ['name' => 'Nome'],
            'address' => ['name' => 'Endereço'],
            'phone' => ['name' => 'Telefone'],
            'email' => ['name' => 'E-mail', 'type' => 'email'],
            'cnpj' => ['name' => 'CNPJ'],
        ];

        return view('show', [
            'fields' => $fields,
            'datum' => Company::findOrFail($id),
            'controller' => 'companies',
            'title' => 'Visualizar Empresa',
        ]);
    }

    public function edit($id)
    {
        $fields = [
            'name' => ['name' => 'Nome'],
            'address' => ['name' => 'Endereço'],
            'phone' => ['name' => 'Telefone'],
            'email' => ['name' => 'E-mail', 'type' => 'email'],
            'cnpj' => ['name' => 'CNPJ'],
        ];

        return view('edit', [
            'fields' => $fields,
            'datum' => Company::findOrFail($id),
            'controller' => 'companies',
            'title' => 'Editar Empresa',
        ]);
    }

    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
            'address' => 'required|max:191',
            'phone' => 'required|max:191',
            'email' => 'required|max:191',
            'cnpj' => 'required|max:191'
        ]);

        if($validator->fails()) {
            Session::flash('error', 'Ocorreu um erro ao alterar a empresa!');
            return redirect('companies/edit');
        }

        $status = $company->update($request->all());

        if ($status) {
            Session::flash('success', 'Empresa alterada com sucesso!');
            return redirect('companies');
        }

        Session::flash('error', 'Ocorreu um erro ao alterar a empresa!');
        return redirect('companies/edit', ['company' => $company]);
    }

    public function destroy($id)
    {
        Company::destroy($id);
        Session::flash('success', 'Empresa excluída com sucesso!');

        return redirect('companies');
    }
}
