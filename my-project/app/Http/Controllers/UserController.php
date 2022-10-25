<?php

namespace App\Http\Controllers;

#use App\Http\Requests\StoreUserRequest;
#use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\TipoUsuarioController;
use App\Http\Controllers\SedeController;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $datos['users']=User::paginate(10);
        return view('administracion.indice_usuario',$datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $usuarioController = new TipoUsuarioController();
        $sedeController = new SedeController();
        $tipos_usuario = $usuarioController->obtener_todo();
        $sedes = $sedeController->obtener_todo();

        return view('administracion.crear_usuario', compact('tipos_usuario','sedes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    #public function store(StoreUserRequest $request)
    public function store(Request $request)
    {
        //
        #$datos_usuario = request()->all();
        // campos a validar
        $campos = [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'type_user' => 'required|string|max:255',
            'sede' => 'required|string|max:255',
            'password' => 'required|string|max:255' 
        ];

        $mensaje_e = [
            'required' => ':attribute es requerido'
        ];

        $this->validate($request, $campos, $mensaje_e);

        $datos_usuario = request()->except('_token');
        $datos_usuario['password'] = Hash::make($datos_usuario['password']);
        #$pwd = $datos_usuario['']
        User::insert($datos_usuario); 
        
        /*User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);*/

        #return response()->json($datos_usuario);
        return redirect('administracion')->with('mensaje_exitoso','Usuario agregado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    #public function edit(User $user)
    public function edit($id)
    {
        //
        $usuarioController = new TipoUsuarioController();
        $sedeController = new SedeController();
        $tipos_usuario = $usuarioController->obtener_todo();
        $sedes = $sedeController->obtener_todo();

        $user = User::findOrFail($id);
        return view("administracion.editar_usuario", compact('user','tipos_usuario','sedes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    #public function update(UpdateUserRequest $request, User $user)
    #public function update(Request $request, User $user)
    public function update(Request $request, $id)
    {
        //
        $campos = [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'type_user' => 'required|string|max:255',
            'sede' => 'required|string|max:255',
            'password' => 'required|string|max:255' 
        ];

        $mensaje_e = [
            'required' => ':attribute es requerido'
        ];

        $this->validate($request, $campos, $mensaje_e);

        $datos_usuario = request()->except(['_token','_method']);
        User::where('id','=',$id)->update($datos_usuario);

        $user = User::findOrFail($id);
        #return view("administracion.editar_usuario", compact('user'));
        return redirect("administracion")->with('mensaje_exitoso','Usuario actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    #public function destroy(User $user)
    public function destroy($id)
    {
        //
        User::destroy($id);
        return redirect("administracion")->with('mensaje_exitoso','Usuario eliminado con éxito');
    }
}
