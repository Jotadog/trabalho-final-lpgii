<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $companies = DB::table('companies')->get();

        $fields = [
            'id' => '#',
            'name' => 'Nome',
            'cnpj' => 'CNPJ',
            'email' => 'E-mail',
        ];

        return view('index', [
            'fields' => $fields,
            'data' => $companies,
            'controller' => 'companies',
            'title' => 'Empresas',
        ]);
    }

    public function create()
    {
        $fields = [
            'id' => ['name' => '#'],
            'name' => ['name' => 'Nome'],
            'address' => ['name' => 'Endereço'],
            'phone' => ['name' => 'Telefone'],
            'email' => ['name' => 'E-mail', 'type' => 'email'],
            'cnpj' => ['name' => 'CNPJ'],
        ];

        return view('create', [
            'fields' => $fields,
            'data' => $companies,
            'controller' => 'companies',
            'title' => 'Empresas',
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
        return view('create');
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
            'id' => ['name' => '#'],
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

        $status = $company->update($request->all());

        if ($status) {
            Session::flash('success', 'Empresa alterada com sucesso!');
            return redirect('index');
        }

        Session::flash('error', 'Ocorreu um erro ao alterar a empresa!');
        return view('edit', ['company' => $company]);
    }

    public function destroy($id)
    {
        Company::destroy($id);
        Session::flash('success', 'Empresa excluída com sucesso!');

        return redirect('index');
    }
}
