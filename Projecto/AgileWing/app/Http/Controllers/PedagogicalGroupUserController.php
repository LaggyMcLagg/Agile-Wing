<?php

namespace App\Http\Controllers;

use App\PedagogicalGroup;
use App\PedagogicalGroupUser;
use Illuminate\Http\Request;
use App\User;


class PedagogicalGroupUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pedagogicalGroupUsers = PedagogicalGroupUser::with('pedagogicalGroup', 'user')->get();

        // Pass the data to the view
        return view('pages.pedagogical-group-users.index', compact('pedagogicalGroupUsers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $pedagogicalGroups = PedagogicalGroup::all();


        return view('pages.pedagogical-group-users.create', [
            'users' => $users,
            'pedagogicalGroups' => $pedagogicalGroups,
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

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'pedagogical_group_id' => 'required|exists:pedagogicalGroups,id',
        ]);

        PedagogicalGroupUser::create($request->all());

        return redirect()->route('pedagogical-group-users.index')->with('success', 'Pedagogical Group User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PedagogicalGroupUser  $pedagogicalGroupUser
     * @return \Illuminate\Http\Response
     */
    public function show(PedagogicalGroupUser $pedagogicalGroupUser)
    {
        // Eager load the necessary relationships
        $pedagogicalGroupUser->load('user', 'pedagogicalGroup');

        // Pass the data to the view
        return view('pages.pedagogical-group-users.show', compact('pedagogicalGroupUser'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PedagogicalGroupUser  $pedagogicalGroupUser
     * @return \Illuminate\Http\Response
     */
    public function edit(PedagogicalGroupUser $pedagogicalGroupUser)
    {
        $users = User::all();
        $pedagogicalGroups = PedagogicalGroup::all();
        
        return view('pages.pedagogical-group-users.edit', compact('users', 'pedagogicalGroups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PedagogicalGroupUser  $pedagogicalGroupUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PedagogicalGroupUser $pedagogicalGroupUser)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'pedagogical_group_id' => 'required|exists:pedagogicalGroups,id'
        ]);
    
        $pedagogicalGroupUser->update($request->all());
    
        return redirect()->route('pedagogical-group-users.index')->with('success', 'Teacher availability updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PedagogicalGroupUser  $pedagogicalGroupUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(PedagogicalGroupUser $pedagogicalGroupUser)
    {
        $pedagogicalGroupUser->delete();
    
        return redirect()->route('pedagogical-group-users.index')
                         ->with('success', 'Pedagogical Group User deleted successfully');
    }
}
