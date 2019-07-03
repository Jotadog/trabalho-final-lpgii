<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('finishRegister')->except(['edit', 'update']);
        $this->middleware('authorizeEditing')->only('edit');
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
        $profile = Profile::findOrFail($id);

        $fields = [
            'name' => ['name' => 'name'],
            'email' => ['name' => 'email'],
            'father_name' => ['name' => 'father_name'],
            'mother_name' => ['name' => 'mother_name'],
            'date_of_birth' => ['name' => 'date_of_birth', 'type' => 'date'],
            'register' => ['name' => 'register'],
            'address' => ['name' => 'address'],
            'cpf' => ['name' => 'cpf'],
            'rg' => ['name' => 'rg'],
            'contact' => ['name' => 'contact'],
            'role' => ['name' => 'role'],
        ];

        $datum = (object) [
            'name' => $profile->user->name,
            'email' => $profile->user->email,
            'father_name' => $profile->father_name,
            'mother_name' => $profile->mother_name,
            'date_of_birth' => $profile->date_of_birth,
            'register' => $profile->register,
            'address' => $profile->address,
            'cpf' => $profile->cpf,
            'rg' => $profile->rg,
            'contact' => $profile->contact,
            'role' => $profile->role->name,
        ];

        return view('show', [
            'fields' => $fields,
            'datum' => $datum,
            'controller' => 'profiles',
            'title' => 'Visualizar usuário',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $profile = Profile::findOrFail($id);

        return view('profiles.edit', ['profile' => $profile]);
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
        $path = Storage::putFile('photos', $request->file('photo'));

        $profile = Profile::findOrFail($id);

        $values = $request->all();
        $values['photo'] = $path;

        $status = $profile->update($values);

        if ($status) {
            session()->flash('success', 'Perfil alterado com sucesso!');
            return redirect('home');
        }

        session()->flash('error', 'Ocorreu um erro ao alterar o perfil!');
        return view('profiles.edit', ['profile' => $profile]);
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
