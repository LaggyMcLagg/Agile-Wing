<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DatabaseExport;
use App\User;
use PDF;

class ImportExportController extends Controller
{
    //está a exportar com botões também, por isso, o melhor será criar ficheiros separados com o conteúdo a exportar
    public function exportUsersPDF() //a lógica é a mesma que o index() do UserController porque é essa view que quero exportar
    {
        $users = User::whereHas('userType', function ($query) {
            $query->where('name', 'professor');
        })->with('specializationAreas', 'pedagogicalGroups')->get();
    
        foreach ($users as $user) 
        {
            $lastAvailability = $user->teacherAvailabilities()
                ->where('is_locked', 1)
                ->latest('updated_at')
                ->first();
    
            if ($lastAvailability) 
            {
                $lastUpdated = $lastAvailability->updated_at->format('Y-m-d H:i:s');
                $lastLogin = $user->last_login;
            } 
            else 
            {
                $lastUpdated = 'N/A';
                $lastLogin = 'N/A';
            }
            $user->lastUpdated = $lastUpdated;
            $user->lastLogin = $lastLogin;
        }
    
        $pdf = PDF::loadView('components.users.user-list', [
            'users' => $users,
            'lastUpdated' => $lastUpdated,
            'lastLogin' => $lastLogin,
        ])->setPaper('a4', 'landscape');
    
        return $pdf->download('users.pdf');
    }

    public function exportDatabase()
    {
        return Excel::download(new DatabaseExport, 'database.xlsx');
    }
}
