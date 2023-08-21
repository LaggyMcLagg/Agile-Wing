<?php

namespace App\Http\Controllers;

use App\User;
use App\PedagogicalGroup;
use App\SpecializationArea;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $useCheckbox = false;
        $columns = ['Nome do formador', 'Área de formação', 'Grupo pedagógico', 'Último login', 'Data última gravação'];
        $rows = [];
        $objectIds = [];

        //lógica para ir buscar os users que são apenas formadores
        $users = User::whereHas('userType', function ($query)
        {
            $query->where('name', 'professor');
        })->with('specializationAreas', 'pedagogicalGroups')->get();
        
        foreach ($users as $user)
        {
            $specializationList = [];
            foreach ($user->specializationAreas as $specializationArea)
            {
                $specializationList[] = $specializationArea->name;
            }
        
            $pedagogicalGroupList = [];
            foreach ($user->pedagogicalGroups as $pedagogicalGroup)
            {
                $pedagogicalGroupList[] = $pedagogicalGroup->name;
            }

            $lastAvailability = $user->teacherAvailabilities()->latest('updated_at')->first();
            $lastUpdated = $lastAvailability ? $lastAvailability->updated_at->format('Y-m-d H:i:s') : 'N/A';
        
            $row = 
            [
                $user->name,
                $specializationList,
                $pedagogicalGroupList,
                $user->last_login,
                $lastUpdated
            ];

            array_push($rows, $row);

            //como só precisas de um array unidimensional(vetor) tem de ficar assim e
            //resulta com aquilo do index que te tinha dito antes em vez de ficar como
            //matriz bidimensional. Mais leve ;) 
            array_push($objectIds, $user->id);
        }
    
        return view('pages.users.index', compact(
            'columns', 
            'rows', 
            'objectIds', 
            'useCheckbox'));
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
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
//      ###PASSAR O CONTEUDO DO EDIT PARA AQUI E ALTERAR A ROTA###
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $useCheckbox = true;
        $pedagogicalGroups = PedagogicalGroup::all();
        $pedagogicalGroupUser = [];

        foreach ($pedagogicalGroups as $pedagogicalGroup)
        {
            $userAssociated= $user->pedagogicalGroups->contains($pedagogicalGroup->id);
            $pedagogicalGroupUser[$pedagogicalGroup->name] = $userAssociated;
        }

        return view ('pages.users.show', compact(
            'useCheckbox',
            'user',
            'pedagogicalGroupUser',
            'pedagogicalGroups',
            'userAssociated'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
