<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Idea;
use App\Models\GroupUser;
use App\Models\GroupRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datos['group'] = Group::leftJoin('users', 'groups.id_user','users.id')
        ->select(
            'groups.id_group',
            'groups.name as namegroup',
            'groups.description',
            'groups.icon',
            'users.name'
        )
        ->get();
        return view('group', $datos);
    }

    public function create()
    {
        return view('group_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->hasFile('icon');
        $nombreArchivo = null;
        if ($request->hasFile('icon')) {
            $archivo = $request->file('icon');
            $nombreArchivo = $archivo->getClientOriginalName();
            $archivo->move(public_path('files'), $nombreArchivo);
            // return "in if"; 
        }   
        // return $nombreArchivo;
        // return "out if"; 
        $group = new Group();
        $group->name = $request->input('name');
        $group->description = $request->input('description');
        $group->icon = $nombreArchivo;
        $group->id_user = auth()->id();

        $group->save();


        // Obtener el ID del grupo recién creado
        $groupId = $group->id_group;

        GroupUser::insert([
            'group_id' => $groupId,
            'user_id' => auth()->id(),
        ]);

        // $groupUser = new GroupUser();
        // $groupUser->group_id = $groupId;
        // $groupUser->user_id = auth()->id();

        // $groupUser->save();


        return redirect('group')->with('mensaje', 'El grupo fue creado exitosamente');
    }

    public function ingroup($id)
    {
        $datos['group'] = Group::leftJoin('users', 'groups.id_user','users.id')
        ->select(
            'groups.id_group',
            'groups.name as namegroup',
            'groups.description',
            'groups.icon',
            'users.name'
        )
        ->where('groups.id_group',$id)
        ->get();
        $datos['idea'] = Idea::leftJoin('users', 'idea.id_user','users.id')
        ->leftJoin('comentario', 'idea.id_idea', 'comentario.id_idea')
        ->leftJoin('users as comment_users', 'comentario.user_id', 'comment_users.id')
        ->select(
            'idea.id_idea',
            'idea.id_user',
            'idea.imageField',
            'idea.video_link',
            'idea.text',
            'idea.date',
            'users.name',
            DB::raw('(SELECT COUNT(*) FROM likes WHERE likes.id_idea = idea.id_idea) as likes_count'),
            DB::raw('GROUP_CONCAT(comentario.id) as idcomments'),
            DB::raw('GROUP_CONCAT(comentario.text) as comentarios'), // Concatenar los comentarios
            DB::raw('GROUP_CONCAT(comment_users.name) as comment_users') // Concatenar los nombres de los usuarios de los comentarios
        )
        ->groupBy('idea.id_idea','idea.id_user','idea.text', 'idea.date', 'users.name','idea.video_link','idea.imageField') // Agrupar por todas las columnas no agregadas
        ->where('idea.id_group',$id)
        ->orderBy('idea.date','DESC')
        ->get();
        return view('ingroup', $datos);
    }

    public function storeidea(Request $request)
    {
        $validatedData = $request->validate([
            'text' => 'required',
            'imageField' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_link' => 'nullable|url',
        ]);
        // Obtener la fecha y hora actual en la zona horaria del servidor
        $fechaHoraServidor = now();

        // Convertir la fecha y hora a la zona horaria de Colombia ('America/Bogota')
        $fechaHoraColombia = $fechaHoraServidor->setTimezone('America/Bogota');

        // Obtener la fecha y hora en formato 'Y-m-d H:i:s'
        $fechaHoraFormateada = $fechaHoraColombia->format('Y-m-d H:i:s');
        
        $group = new Idea();
        // $group->text = $request->input('text');
        $group->text = $validatedData['text'];
        $group->date = $fechaHoraFormateada;
        $group->id_group = $request->input('id_group');
        $group->id_user = auth()->id();

        $nombreArchivo = null;
        if ($request->hasFile('imageField')) {
            $archivo = $request->file('imageField');
            $nombreArchivo = $archivo->getClientOriginalName();
            $archivo->move(public_path('files'), $nombreArchivo);
            $group->imageField = $nombreArchivo;
        } 


        $videoLink = $request->input('video_link');

        // Si se proporcionó un enlace de video
        if ($videoLink) {
            // Obtener la URL del video y descomponerla
            $parsedUrl = parse_url($videoLink);

            // Verificar si la URL es válida y si es de YouTube
            if (isset($parsedUrl['host']) && $parsedUrl['host'] === 'www.youtube.com') {
                // Obtener los parámetros de la URL
                parse_str($parsedUrl['query'], $queryParams);

                // Verificar si existe el parámetro "v" (ID del video)
                if (isset($queryParams['v'])) {
                    // Obtener el ID del video
                    $videoId = $queryParams['v'];

                    // Guardar el ID del video en la base de datos
                    $group->video_link = $videoId;
                }
            }
        }

        $group->save();
        return back()->with('success', 'Idea creada exitosamente');
    }

    public function sendRequest(Request $request, $group_id)
    {
        // Obtener el grupo al que se está solicitando unirse
        $group = Group::findOrFail($group_id);

        // Verificar si el usuario ya ha enviado una solicitud para este grupo
        if ($group->hasPendingRequest(auth()->user())) {
            return redirect()->back()->with('error', 'Ya has enviado una solicitud para este grupo.');
        }

        // Crear una nueva solicitud de grupo
        GroupRequest::create([
            'user_id' => auth()->user()->id,
            'group_id' => $group->id_group,
            // Otros campos relevantes para la solicitud, si los tienes
        ]);

        return redirect()->back()->with('success', 'Solicitud enviada exitosamente.');
    }

    // public function acceptRequest(GroupRequest $request)
    // {
    //     $request->group->members()->attach($request->user_id);
    //     $request->delete();

    //     return redirect()->back()->with('success', 'Solicitud aceptada correctamente.');
    // }

    public function acceptRequest($groupId, $requestId)
    {
        $group = Group::findOrFail($groupId);
        $request = GroupRequest::findOrFail($requestId);

        $group->members()->attach($request->user_id);
        $request->delete();

        return redirect()->back()->with('success', 'Solicitud aceptada correctamente.');
    }

    public function rejectRequest($groupId, $requestId)
    {
        $request = GroupRequest::findOrFail($requestId);
        $request->delete();

        return redirect()->back()->with('success', 'Solicitud rechazada correctamente.');
    }


    // public function acceptRequest(GroupRequest $request)
    // {
    //     $request->group->members()->attach($request->user_id);
    //     $request->delete();

    //     return redirect()->back()->with('success', 'Solicitud aceptada correctamente.');
    // }


    // public function rejectRequest(GroupRequest $request)
    // {
    //     $request->delete();

    //     return redirect()->back()->with('success', 'Solicitud rechazada correctamente.');
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        //
    }

    public function destroyIdea($id)
    {
        DB::table('idea')->where('id_idea', $id)->delete();

        return back()->with('success', 'Idea Eliminada Exitosamente');
    }
}
