<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    //public function __construct()
    //{
        //$this->middleware('auth');
    //} isto pode ser eliminado, com o contrutor colocado na web.php grupo de rotas feitas

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userType = auth()->user()->user_type_id;
    
        if ($userType == 1) 
        {
            return view('home-admin');
        } 
        elseif ($userType == 2) 
        {
            return view('home-teacher');
        }
    
        abort(403, 'Unauthorized');
    }
    

}
