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
    public function index() 
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
        'email'                 => 'required|email',
        'password'              => 'required|min:4|confirmed',
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
        
        return view('pages.users.edit', [
            'user' => $user,
            'pedagogicalGroupUserList' => $pedagogicalGroupUserList,
            'specializationAreaUserList' => $specializationAreaUserList,
            'pedagogicalGroups' => $pedagogicalGroups,
            'specializationAreas' => $specializationAreas
        ]);
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
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id, 
            'color_1' => 'required',
            'color_2' => 'required',
        ]);        
        // Atualizar os campos do usuário com base nos dados do formulário
        $user->name = $request->name;
        $user->email = $request->email;

        // Atualize outros campos conforme necessário
        
        // Salvar as alterações nos campos básicos do usuário
        $user->save();
    
        // Agora, lide com as associações de grupos pedagógicos e áreas de formação
    
        // Obtenha os IDs dos grupos pedagógicos selecionados no formulário
        $selectedPedagogicalGroups = $request->input('pedagogicalGroups', []);
    
        // Obtenha os IDs das áreas de formação selecionadas no formulário
        $selectedSpecializationAreas = $request->input('specializationAreas', []);
    
        // Atualize as associações do usuário com grupos pedagógicos
        $user->pedagogicalGroups()->sync($selectedPedagogicalGroups);
    
        // Atualize as associações do usuário com áreas de formação
        $user->specializationAreas()->sync($selectedSpecializationAreas);
    
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

    public function changePasswordView()
    {
        return view('pages.users.change-password');
    }

    public function changePasswordLogic(Request $request)
    {

        //'password'          =>  bcrypt('password'),
        //'password'          =>  bcrypt('password'),
        //'password'          =>  bcrypt('password'),
        //'password'          =>  bcrypt('password'),
        //'password'          =>  bcrypt('password'),
        //$passEnc = bcrypt($request->password);
        //$user->password = bcrypt($request->password);


        // Validação dos campos do formulário
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);
    
        // Obtenha o usuário autenticado
        $user = Auth::user();
    
        // Verifique se a senha atual fornecida corresponde à senha atual do usuário
        if (Hash::check($request->current_password, $user->password)) {
            // Atualize a senha do usuário
            $user->password = Hash::make($request->new_password);
            $user->save();
    
            // Redirecione de volta com uma mensagem de sucesso
            return redirect()->route('profile')->with('success', 'Password alterada com sucesso.');
        } else {
            // Senha atual incorreta, retorne com uma mensagem de erro
            return back()->withErrors(['current_password' => 'ERRO: Tente atualizar a password novamente'])->withInput();
        }
    }
    
}
