<?php

namespace App\Http\Controllers;

use App\User;
use App\PedagogicalGroup;
use App\SpecializationArea;
use App\UserType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str; //para poder gerar pw aleatoria ao criar um user
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log; // apagar, so serviu para testes
use Carbon\Carbon; //para usarmos o gt() e verificação do tempo útil do link de verf de email
use PDF;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //###############################
    //CRUD METHODS
    //###############################

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
        $defaultUserType = UserType::find(2);

        return view('pages.users.create', [
            'userTypes'             => $userTypes, 
            'pedagogicalGroups'     => $pedagogicalGroups,
            'specializationAreas'   => $specializationAreas,
            'defaultUserType'       => $defaultUserType
        ]);
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

        $temporaryPassword = bcrypt(Str::random(20));
        $token = Str::random(32); //aqui nao podemos usar bcrypt porque da erro na url

        $user = User::create([
            'name'              => $request->input('name'),
            'email'             => $request->input('email'),
            'password'          => $temporaryPassword,
            'user_type_id'      => $request->input('user_type_id'),
            'color_1'           => $request->input('color_1'),
            'color_2'           => $request->input('color_2'),
            'token_password'    => $token,
            'token_created_at'  => now()
        ]);

        // Associar grupos pedagógicos, se estiverem presentes no pedido
        if ($request->has('pedagogicalGroups')) {
            $user->pedagogicalGroups()->sync($request->input('pedagogicalGroups'));
        }

        // Associar áreas de especialização, se estiverem presentes no pedido
        if ($request->has('specializationAreas')) {
            $user->specializationAreas()->sync($request->input('specializationAreas'));
        }

        $verificationUrl = route('verify.email', ['token' => $token]);

        Mail::send('pages.emails.verify-email-new-user', ['user' => $user, 'verificationUrl' => $verificationUrl], function ($message) use ($user) 
        {
            $message->to($user->email)->subject('Verificação de utilizador');
        });

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
            // Verificar se o user está associado a este grupo pedagógico
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

    public function edit() 
    {
        //este metodo faz o mesmo que o index() mas para ficheiros diferentes com diferens JS's associados
        //lógica para ir buscar os users que são apenas formadores
        $users = User::whereHas('userType', function ($query) 
        {
            $query->where('name', 'professor');
        })->with('specializationAreas', 'pedagogicalGroups')->get();
    
        foreach ($users as $user) {
            $lastAvailability = $user->teacherAvailabilities()
                ->where('is_locked', 1) // verifica apenas disponibilidades bloqueadas
                ->latest('updated_at')
                ->first();
    
            if ($lastAvailability) 
            {
                $lastUpdated = $lastAvailability->updated_at->format('Y-m-d H:i:s');
                $lastLogin = $user->last_login;
            } else 
            {
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

    //###############################
    //OTHER METHODS
    //###############################
    
    public function updateNotes(Request $request)
    {
               
        $request->validate(
            [
                'notes' => 'string|max:255|regex:/^[\pL\sÇç]+$/u',
            ],
            [
                'name.regex' => 'The notes may only contain letters, accentuation, and Ç or ç.',
            ]
        );        

        try {

            $user = Auth::user();
            $user->notes = $request->notes;
            $user->save();
        
            return redirect()->route('teacher-availabilities.scheduler')->with('success', 'User notes updated successfully');
        } catch (\Exception $e) {
            //This way we resolve gracefully any errors, return the error message and the old form data
            return back()->withInput()->with('error', 'There was an error updating the user: ' . $e->getMessage());        }
    }

    public function changePasswordView()
    {
        return view('pages.users.change-password');
    }

    public function changePasswordLogic(Request $request)
    {
        $request->validate([
            'new_password'      => 'required|string|min:4|confirmed',
        ], 
        [
            'new_password.required'     => 'A nova password é obrigatória.',
        ]);
        
        $user = Auth::user();
        $user->password = bcrypt(($request->new_password));
        $user->token_password = null; //significa que a pw foi alterada
        $user->save();
        return redirect('home')->with('status', 'Password alterada com sucesso.');
    }

    public function verifyEmail($token)
    {
        //procura o user com base no token passado na URL
        $user = User::where('token_password', $token)->first();

        if(!$user)
        {
            abort(403, 'Este link de verificação já foi utilizado.');
        }

        $tokenCreatedAt  = Carbon::parse($user->token_created_at); //necessário para podermos usar o gt()
        if (!$tokenCreatedAt->gt(now()->subDay()))
        {
            abort(403, 'Este link de verificação econtra-se expirado. Por favor, peça novo link.');
        }

        if ($user->email_verified_at == null)
        {
            $user->email_verified_at = now();
            $user->save();
        }

        //user fica com login feito para ser redirecionado para a página de alteração de pw
        auth()->login($user); 

        return redirect()->route('users.passwordForm')->with('success', 'Email verificado com sucesso.');
    }

    public function resetPassword($id)
    {
        //To re-use the logic that we implemented for the verify email method that already
        //forsees the use case of password reset
        $user = User::find($id);

        $temporaryPassword = bcrypt(Str::random(20));
        $token = Str::random(32);

        $user->update([
            'password'          => $temporaryPassword,
            'token_password'    => $token,
            'token_created_at'  => now()
        ]);

        $verificationUrl = route('verify.email', ['token' => $token]);

        Mail::send('pages.emails.verify-email-new-user', ['user' => $user, 'verificationUrl' => $verificationUrl], function ($message) use ($user)
        {
            $message->to($user->email)->subject('Reset palavra-passe');
        });

        return redirect('users')->with('success', 'Reset palavra-passe com sucesso!');
    } 

    public function exportUsersViewPdf()
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

        $pdf = PDF::loadView('components.users.user-list',[
            'users'         => $users,
            'lastUpdated'   => $lastUpdated,
            'lastLogin'     => $lastLogin,
        ]);
        
        return $pdf->download('users-list.pdf');
    }
}
