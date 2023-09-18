<?php

namespace App\Http\Controllers;

use App\User;
use App\PedagogicalGroup;
use App\SpecializationArea;
use App\UserType;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() // NAO ESTOU A CONSEGUIR MOSTRAR O LAST AVAILABILTY E LASTLOGIN
    {

        // ####### -> CONTENT TABLE <- #######

        // $useCheckbox = false;
        // $columns = ['Nome do formador', 'Área de formação', 'Grupo pedagógico', 'Último login', 'Data última gravação'];
        // $rows = [];
        // $objectIds = [];
        // //lógica para ir buscar os users que são apenas formadores
        // $users = User::whereHas('userType', function ($query)
        // {
        //     $query->where('name', 'professor');
        // })->with('specializationAreas', 'pedagogicalGroups')->get();
        
        // foreach ($users as $user)
        // {
        //     $specializationList = [];
        //     foreach ($user->specializationAreas as $specializationArea)
        //     {
        //         $specializationList[] = $specializationArea->name;
        //     }
        
        //     $pedagogicalGroupList = [];
        //     foreach ($user->pedagogicalGroups as $pedagogicalGroup)
        //     {
        //         $pedagogicalGroupList[] = $pedagogicalGroup->name;
        //     }

        //     $lastAvailability = $user->teacherAvailabilities()->latest('updated_at')->first();
        //     $lastUpdated = $lastAvailability ? $lastAvailability->updated_at->format('Y-m-d H:i:s') : 'N/A';

        //     $row = 
        //     [
        //         $user->name,
        //         $specializationList,
        //         $pedagogicalGroupList,
        //         $user->last_login,
        //         $lastUpdated
        //     ];

        //     array_push($rows, $row);

        //     // como só precisas de um array unidimensional(vetor) tem de ficar assim e
        //     // resulta com aquilo do index que te tinha dito antes em vez de ficar como
        //     // matriz bidimensional. Mais leve ;) 
        //     array_push($objectIds, $user->id);
        // }
    
        // return view('pages.users.index', compact(
        //     'columns', 
        //     'rows', 
        //     'objectIds', 
        //     'useCheckbox'));

        // ####### -> CONTENT TABLE <- #######

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
            'users' => $users,
            'lastUpdated' => $lastUpdated,
            'lastLogin' => $lastLogin,
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
        'name'                  => 'required',
        'email'                 => 'required',
        'password'              => 'required',
        'user_type_id'          => 'required',
        'color_1'               => 'required',
        'color_2'               => 'required',
    ]);

    $user = User::create([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'password' => bcrypt($request->input('password')),
        'user_type_id' => $request->input('user_type_id'),
        'color_1' => $request->input('color_1'),
        'color_2' => $request->input('color_2'),
    ]);

    // Associar grupos pedagógicos, se estiverem presentes no pedido
    if ($request->has('pedagogicalGroups')) {
        $user->pedagogicalGroups()->sync($request->input('pedagogicalGroups'));
    }

    // Associar áreas de especialização, se estiverem presentes no pedido
    if ($request->has('specializationAreas')) {
        $user->specializationAreas()->sync($request->input('specializationAreas'));
    }

    return redirect('users')->with('status', 'Registo criado com sucesso!');
}


    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
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
            $userAssociatedSpecializationArea = $user->specializationAreas->contains($specializationArea->number);
            
            // Adicionar um elemento ao array
            $specializationAreaUserList[$specializationArea->number] = [
                'isAssociated' => $userAssociatedSpecializationArea
            ];
        }
        
        return view('pages.users.show', [
            'user' => $user,
            'pedagogicalGroupUserList' => $pedagogicalGroupUserList,
            'specializationAreaUserList' => $specializationAreaUserList,
            'pedagogicalGroups' => $pedagogicalGroups,
            'specializationAreas' => $specializationAreas
        ]);
    }
    
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('pages.users.edit', ['user' => $user]);

        // ####### -> CONTENT TABLE <- #######
        // ####### -> CONTENT TABLE <- #######
        // $useCheckbox = true;
        // $columnsPedagogicalGroup = ['Grupo Pedagógico', 'Associado ou Não'];
        // $rowsPedagogicalGroup = [];

        // $pedagogicalGroups = PedagogicalGroup::all();
        // foreach ($pedagogicalGroups as $pedagogicalGroup)
        // {
        //     //containts() devolve true or false
        //     $userAssociatedPedagogicalGroup = $user->pedagogicalGroups->contains($pedagogicalGroup->id);
        //     $rowPedagogicalGroup = [
        //         'itemName'     => $pedagogicalGroup->name,
        //         'isAssociated' => $userAssociatedPedagogicalGroup
        //     ];
            
        //     $rowsPedagogicalGroup[] = $rowPedagogicalGroup;
        // }


        // $columnsSpecializationArea = ['Área de Formação', 'Associado ou Não'];
        // $rowsSpecializationArea = [];

        // $specializationAreas = SpecializationArea::all();
        // foreach ($specializationAreas as $specializationArea)
        // {
        //     $userAssociatedSpecializationArea = $user->specializationAreas->contains($specializationArea->number);
        //     $rowSpecializationArea = [
        //         'itemName'      => $specializationArea->name,
        //         'isAssociated'  =>$userAssociatedSpecializationArea   
        //     ];

        //     $rowsSpecializationArea[] = $rowSpecializationArea;
        // }
        
        // return view ('pages.users.show', compact(
        //     'useCheckbox',
        //     'user',
        //     'columnsPedagogicalGroup',
        //     'columnsSpecializationArea',
        //     'rowsSpecializationArea',
        //     'rowsPedagogicalGroup'
        // ));
        // ####### -> CONTENT TABLE <- #######
        // ####### -> CONTENT TABLE <- #######
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user = User::find($user->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->notes = $request->notes;
        $user->save();

        return redirect('users')->with('status', 'Registo editado com sucesso!');
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
        return redirect('users')->with('status', 'Registo apagado com sucesso');
    }
}
