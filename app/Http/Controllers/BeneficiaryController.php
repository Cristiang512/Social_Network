<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class BeneficiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datos['users']=User::all();

        return view('beneficiary', $datos);
    }

    public function edit($userId)
    {
        $user = User::findOrFail($userId);
      // Busca el usuario por ID

        return view('edit', compact('user')); // Retorna la vista con el usuario a editar
    }

    // public function edit(Request $user)
    // {
    //     $datos['user']=User::where('id',$user);
    //     return view('edit', compact('user'));
    // }

    // public function edit($userId)
    // {
    //     // return $userId;
    //     // $datos['user'] = User::findOrFail($userId);
    //     // return view('edit', compact('user'));

    //     $user = User::findOrFail($userId)->get();
    //     return view('edit', compact('user'));
    // }

    // public function edit($userId)
    // {
    //     $user = User::findOrFail($userId);
    //     return view('edit', compact('user'));
    // }


    public function update(Request $request, User $user)
    {
        $user->update($request->all());

        $datos['users']=User::all();

        return view('beneficiary', $datos)->with('success', 'Usuario actualizado exitosamente.');
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        // return $request;
        // Validar los campos según tus necesidades
        $validatedData = $request->validate([
            'municipio' => 'required',
            'vereda' => 'required',
            'name' => 'required',
            'documento' => 'required|numeric',
            'telefono' => 'required|numeric',
            'predio' => 'required',
            'password' => 'required|min:8', // Mínimo 8 caracteres para la contraseña
        ]);

        $user = new User([
            'municipio' => $validatedData['municipio'],
            'vereda' => $validatedData['vereda'],
            'name' => $validatedData['name'],
            'documento' => $validatedData['documento'],
            'telefono' => $validatedData['telefono'],
            'predio' => $validatedData['predio'],
            'password' => Hash::make($validatedData['password']), // Cifrar la contraseña
        ]);

        // Guardar el usuario en la base de datos
        $user->save();


        $datos['users']=User::all();

        return view('beneficiary', $datos);
    }

    public function updateEmails()
    {
        $users = DB::table('users')
            ->select('id', 'documento')
            ->get();

        foreach ($users as $user) {
            $email = $user->documento . '@AsctiBoyaca.com';

            DB::table('users')
                ->where('id', $user->id)
                ->update(['email' => $email]);
        }

        return redirect()->back()->with('success', 'Correos electrónicos actualizados exitosamente.');
    }

    public function updatePasssword($id)
    {
        $user = User::find($id);
        $lastFourDigits = substr($user->documento, -4);

        // Actualizar la contraseña del usuario
        $user->password = Hash::make($lastFourDigits);
        $user->save();
        return redirect()->back()->with('success', 'Contraseña restablecida correctamente.');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Beneficiary  $beneficiary
     * @return \Illuminate\Http\Response
     */
    // public function show(Beneficiary $beneficiary)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Beneficiary  $beneficiary
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, Beneficiary $beneficiary)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Beneficiary  $beneficiary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Beneficiary $beneficiary)
    {
        //
    }
}
