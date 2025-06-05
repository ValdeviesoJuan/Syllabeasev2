<?php

namespace App\Http\Controllers\Chairperson;

use App\Http\Controllers\Controller;
use App\Models\Chairperson;
use App\Models\ProgramOutcome;
use App\Models\Department;
use App\Models\POE;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChairPOEController extends Controller
{
    public function index()
    {
        $department_id = Chairperson::where('chairpeople.user_id', '=', Auth::user()->id)
            ->select('chairpeople.department_id')
            ->first()
            ->department_id;
        $today = now()->toDateString();
        $poes = POE::join('departments', 'poes.department_id', '=', 'departments.department_id')
            ->join('chairpeople', 'departments.department_id', '=', 'chairpeople.department_id')
            // ->where('chairpeople.start_validity', '<=', $today)
            // ->where('chairpeople.end_validity', '>=', $today)
            ->where('chairpeople.user_id', Auth::user()->id)
            ->orderBy('poes.poe_code', 'asc')
            ->select('departments.*', 'poes.*')
            ->get();

        $user = Auth::user();
        $notifications = $user->notifications;
        return view('Chairperson.POE.poeList', compact('notifications', 'poes', 'department_id'));
    }
    public function createPoe()
    {
        $user = Auth::user();
        $notifications = $user->notifications;
        return view('Chairperson.POE.poeCreate', compact('notifications'));
    }
    public function storePoe(Request $request)
    {
        $department_id = Chairperson::where('chairpeople.user_id', '=', Auth::user()->id)
            ->select('chairpeople.department_id')
            ->first()
            ->department_id;

        $validatedData = $request->validate([
            'poe_code.*' => 'required',
            'poe_description.*' => 'required',
        ]);
        foreach ($validatedData['poe_code'] as $key => $poe_code) {
            $poe = new POE();
            $poe->department_id = $department_id;
            $poe->poe_code = $poe_code;
            $poe->poe_description = $validatedData['poe_description'][$key];
            $poe->save();
        }

        return redirect()->route('chairperson.poe')->with('success', 'POE created successfully.');
    }
    public function editPoe($poe_id)
    {
        $poes = POE::join('departments', 'poes.department_id', '=', 'departments.department_id')
            ->join('chairpeople', 'departments.department_id', '=', 'chairpeople.department_id')
            ->where('chairpeople.user_id', '=', Auth::user()->id)
            ->select('departments.*', 'poes.*')
            ->get();
        $department_id = Chairperson::where('chairpeople.user_id', '=', Auth::user()->id)
            ->select('chairpeople.department_id')
            ->first()
            ->department_id;
        $user = Auth::user();
        $notifications = $user->notifications;
        return view('Chairperson.POE.poeEdit', compact('notifications', 'poes', 'department_id'));
    }
    public function updatePoe(Request $request, string $department_id)
    {
        $department_id = Chairperson::where('chairpeople.user_id', '=', Auth::user()->id)
            ->select('chairpeople.department_id')
            ->first()
            ->department_id;

        $validatedData = $request->validate([
            'poe_code.*' => 'required',
            'poe_description.*' => 'required',
        ]);
        POE::where('department_id', $department_id)->delete();
        foreach ($validatedData['poe_code'] as $key => $poe_code) {
            $poe = new POE();
            $poe->department_id = $department_id;
            $poe->poe_code = $poe_code;
            $poe->poe_description = $validatedData['poe_description'][$key];
            $poe->save();
        }
        return redirect()->route('chairperson.poe')->with('success', 'POE updated successfully.');
    }
    public function destroyPoe($poe_id)
    {
        $poe = POE::findorfail($poe_id);
        $poe->delete();
        return redirect()->route('chairperson.poe')->with('success', 'POE deleted successfully.');
    }
}
