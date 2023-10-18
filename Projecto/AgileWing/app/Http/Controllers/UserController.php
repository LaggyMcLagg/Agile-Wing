<?php

namespace App\Http\Controllers;

use App\User;
use App\PedagogicalGroup;
use App\SpecializationArea;
use App\UserType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; //para poder gerar pw aleatoria ao criar um user


use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() //está a ser usado 01/10/2023
    {
        //lógica para ir buscar os users que são apenas formadores
        $users = User::whereHas('userType', function ($query) {
            $query->where('name', 'professor');
        })->with('specializationAreas', 'pedagogicalGroups')->get();
    
        foreach ($users as $user) {
            $lastAvailability = $user->teacherAvailabilities()
                ->where('is_locked', 1) // verifica apenas disponibilidades bloqueadas
                ->latest('updated_at')
                ->first();
    
            if ($lastAvailability) {
                $lastUpdated = $lastAvailability->updated_at->format('Y-m-d H:i:s');
                $lastLogin = $user->last_login;
            } else {
                $lastUpdated = 'N/A';
                $lastLogin = 'N/A';
            }
            $user->lastUpdated = $lastUpdated; // adiciona lastUpdated ao objeto do user
            $user->lastLogin = $lastLogin; // adiciona lastLogin ao objeto do user
        }
    
        return view('pages.users.index', [
            'users'         => $users,
            'lastUpdated'   => $lastUpdated,
            'lastLogin'     => $lastLogin,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userTypes = UserType::all();
        $pedagogicalGroups = PedagogicalGroup::all();
        $specializationAreas = SpecializationArea::all();
        return view('pages.users.create', [
            'userTypes' => $userTypes, 
            'pedagogicalGroups' => $pedagogicalGroups,
            'specializationAreas' => $specializationAreas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'          => 'required',
            'email'         => 'required|email',
            'user_type_id'  => 'required',
            'color_1'       => 'required',
            'color_2'       => 'required',
        ]);

        $temporaryPassword = Hash::make(Str::random(8));

        $user = User::create([
            'name'          => $request->input('name'),
            'email'         => $request->input('email'),
            'password'      => $temporaryPassword,
            'user_type_id'  => $request->input('user_type_id'),
            'color_1'       => $request->input('color_1'),
            'color_2'       => $request->input('color_2'),
        ]);

        // Associar grupos pedagógicos, se estiverem presentes no pedido
        if ($request->has('pedagogicalGroups')) {
            $user->pedagogicalGroups()->sync($request->input('pedagogicalGroups'));
        }

        // Associar áreas de especialização, se estiverem presentes no pedido
        if ($request->has('specializationAreas')) {
            $user->specializationAreas()->sync($request->input('specializationAreas'));
        }

        return redirect('users')->with('success', 'Registo criado com sucesso!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $pedagogicalGroups = PedagogicalGroup::all();
        $pedagogicalGroupUserList = [];
        
        foreach ($pedagogicalGroups as $pedagogicalGroup)
        {
            // Verificar se o usuário está associado a este grupo pedagógico
            $userAssociatedPedagogicalGroup = $user->pedagogicalGroups->contains($pedagogicalGroup->id);
            
            // Adicionar um elemento ao array
            $pedagogicalGroupUserList[$pedagogicalGroup->id] = [
                'isAssociated' => $userAssociatedPedagogicalGroup
            ];
        }
        
        $specializationAreas = SpecializationArea::all();
        $specializationAreaUserList = [];
        
        foreach ($specializationAreas as $specializationArea)
        {
            $userAssociatedSpecializationArea = $user->specializationAreas->contains($specializationArea->id);
            
            // Adicionar um elemento ao array
            $specializationAreaUserList[$specializationArea->id] = [
                'isAssociated' => $userAssociatedSpecializationArea
            ];
        }
        
        return view('pages.users.show', [
            'user' => $user,
            'pedagogicalGroupUserList'      => $pedagogicalGroupUserList,
            'specializationAreaUserList'    => $specializationAreaUserList,
            'pedagogicalGroups'             => $pedagogicalGroups,
            'specializationAreas'           => $specializationAreas
        ]);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */

//este metodo faz o mesmo que o index() mas para ficheiros diferentes com diferens JS's associados
    public function edit() 
    {
        //lógica para ir buscar os users que são apenas formadores
        $users = User::whereHas('userType', function ($query) {
            $query->where('name', 'professor');
        })->with('specializationAreas', 'pedagogicalGroups')->get();
    
        foreach ($users as $user) {
            $lastAvailability = $user->teacherAvailabilities()
                ->where('is_locked', 1) // verifica apenas disponibilidades bloqueadas
                ->latest('updated_at')
                ->first();
    
            if ($lastAvailability) {
                $lastUpdated = $lastAvailability->updated_at->format('Y-m-d H:i:s');
                $lastLogin = $user->last_login;
            } else {
                $lastUpdated = 'N/A';
                $lastLogin = 'N/A';
            }
            $user->lastUpdated = $lastUpdated; // adiciona lastUpdated ao objeto do user
            $user->lastLogin = $lastLogin; // adiciona lastLogin ao objeto do user
        }
    
        return view('pages.users.edit', [
            'users'         => $users,
            'lastUpdated'   => $lastUpdated,
            'lastLogin'     => $lastLogin,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        //The 'unique:users,email,' . $user->id rule ensures that the provided email 
        //address is unique among all users but doesn't flag it as a duplicate if 
        //it's the email of the user you're currently updating.
        //So that when we update we don't ahve to always change the EMail
        $validatedData = $request->validate(
            [
                'name'      => 'required|string|max:255|regex:/^[\pL\sÇç]+$/u',
                'email'     => 'required|email|unique:users,email,' . $user->id,
                'color_1'   => 'required',
                'color_2'   => 'required',
            ],
            [
                'name.required'     => 'The name field is required.',
                'email.required'    => 'The email field is required.',
                'email.email'       => 'Please provide a valid email address.',
                'email.unique'      => 'This email is already in use.',
                'color_1.required'  => 'Color 1 is required.',
                'color_2.required'  => 'Color 2 is required.',
            ]
        );
        

        // Bulk update the user's fields using validated data
        $user->update($validatedData);
        
        // Update user's associations with pedagogical groups and specialization areas
        $user->pedagogicalGroups()->sync($request->input('pedagogicalGroups', []));
        $user->specializationAreas()->sync($request->input('specializationAreas', []));

        
        return redirect()->route('users.edit')->with('success', 'Registo editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.edit')->with('status', 'Registo apagado com sucesso');
    }

    public function changePasswordView()
    {
        return view('pages.users.change-password');
    }

    public function changePasswordLogic(Request $request)
    {
        $request->validate([
            'new_password'      => 'required|string|min:4|confirmed',
        ], [
            'new_password.required'     => 'A nova password é obrigatória.',
        ]);
        
        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();
        return redirect('home')->with('status', 'Password alterada com sucesso.');
    }
}
