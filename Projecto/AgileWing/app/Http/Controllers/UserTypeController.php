<?php

namespace App\Http\Controllers;

use App\UserType;
use Illuminate\Http\Request;
use Exception;

class UserTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.user_types.crud', ['userTypes' => UserType::all()]);
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
        // Procura na BD um nome igual ao inserido, incluindo registros excluídos suavemente
        $existingUserType = UserType::withTrashed()->where('name', $request->input('name'))->first();
    
        if ($existingUserType) {
            if ($existingUserType->trashed()) {
                // Se o registro existir e estiver excluído suavemente, restaure-o
                $existingUserType->restore();
                session()->flash('success', 'Tipo de utilizador restaurado com sucesso.');
            } else {
                // Se o registro existir e não estiver excluído suavemente, exiba uma mensagem de erro
                session()->flash('error', 'O tipo de utilizador já existe.');
            }
        } else {
            // Se não houver um registro existente, continue com a validação dos campos
            $request->validate([
                'name' => 'required|string|max:255|regex:/^[\pL\sÇç]+$/u|unique:user_types,name',
            ], [
                'name.required' => 'O campo nome é obrigatório.',
                'name.regex' => 'O nome só pode conter letras, acentuação e Ç ou ç.',
                'name.unique' => 'O nome já foi escolhido',
            ]);
    
            try {        
                UserType::create($request->all());
                session()->flash('success', 'Tipo de utilizador criado com sucesso.');
            } catch (Exception $e) {
                session()->flash('error', 'Ocorreu um erro ao tentar criar o registro: ' . $e->getMessage());
                return back()->withInput();
            }
        }
    
        return redirect()->route('user-types.index');
    }
    
    
    
    
    

    /**
     * Display the specified resource.
     *
     * @param  \App\UserType  $userType
     * @return \Illuminate\Http\Response
     */
    public function show(UserType $userType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserType  $userType
     * @return \Illuminate\Http\Response
     */
    public function edit(UserType $userType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserType  $userType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255|regex:/^[\pL\sÇç]+$/u',
            ],
            [
                'name.required' => 'O campo obrigatório.',
                'name.regex' => 'O nome só pode conter letras, acentuação e Ç ou ç.',
            ]
        );

        try {        
            $userType = UserType::find($id);
            $userType->name = $request->name;
            $userType->save();
        
            session()->flash('success', 'Tipo de utilizador editado com sucesso.');
            return redirect()->route('user-types.index');
        } catch (Exception $e) {
            
            session()->flash('error', 'Ocorreu um erro a tentar editar o resgisto: ' . $e->getMessage());
            return back()->withInput();
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserType  $userType
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserType $userType)
    {
        try {
            $userType->delete();
    
            return redirect()->route('user-types.index')->with('success', 'Tipo de utilizador apagado com successo.');
        } catch (Exception $e) {            
    
            return redirect()->route('user-types.index')->with('error', 'Houve um erro a apagar o tipo de utilizador.' . $e->getMessage());
        }
    }
}
