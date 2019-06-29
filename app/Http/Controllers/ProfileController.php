<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profiles = Profile::all();

        return view('profiles.index', ['profiles' => $profiles]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fields = [
            'name' => ['name' => 'Nome'],
            'email' => ['name' => 'E-mail', 'type' => 'email'],
            'father_name' => ['name' => 'Nome do pai'],
            'mother_name' => ['name' => 'Nome da mãe'],
            'date_of_birth' => ['name' => 'Data de nascimento', 'type' => 'date'],
            'register' => ['name' => 'Matrícula'],
            'address' => ['name' => 'Endereço'],
            'cpf' => ['name' => 'CPF'],
            'rg' => ['name' => 'RG'],
            'contact' => ['name' => 'Contato'],
            'photo' => ['name' => 'Foto'],
            'role_FK' => ['name' => 'Papel'],
        ];

        $profile = Profile::findOrFail($id);

        return view('edit', ['profile' => $profile]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function approveProfile(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $profile->status = 'Aprovado';
        $status = $profile->save();

        if ($status) {
            session()->flash('success', 'Perfil aprovado com sucesso!');
        } else {
            session()->flash('error', 'Falha ao aprovar perfil!');
        }

        return redirect('profiles');
    }
}
