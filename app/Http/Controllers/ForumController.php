<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use App\Models\IdeaForum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datos['forums'] = Forum::leftJoin('users', 'forum.id_user', 'users.id')
        ->select(
            'forum.id_forum',
            'forum.description',
            'forum.opening_date',
            'forum.closing_date',
            'users.name',
        )
        ->orderBy('forum.opening_date', 'DESC')
        ->get();
        
        return view('forum', $datos);
    }


    public function create()
    {
        return view('forum_create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $forum = new Forum();
        $forum->description = $request->input('description');
        $forum->opening_date = $request->input('opening');
        $forum->closing_date = $request->input('closing');
        $forum->id_user = auth()->id();

        $forum->save();
        return redirect('forum')->with('mensaje', 'El Foro fue creado exitosamente');
    }

    public function inforum($id)
    {
        $datos['forums'] = Forum::leftJoin('users', 'forum.id_user','users.id')
        ->select(
            'forum.id_forum',
            'forum.description',
            'forum.closing_date',
            'users.name'
        )
        ->where('forum.id_forum',$id)
        ->get();

        $datos['ideaForum'] = IdeaForum::leftJoin('users', 'idea_forum.id_user','users.id')
        ->leftJoin('comentario', 'idea_forum.id_idea_forum', 'comentario.id_idea_forum')
        ->leftJoin('users as comment_users', 'comentario.user_id', 'comment_users.id')
        ->select(
            'idea_forum.id_idea_forum',
            'idea_forum.text',
            'idea_forum.date',
            'idea_forum.id_user',
            'users.name',
            DB::raw('(SELECT COUNT(*) FROM likes WHERE likes.id_idea_forum = idea_forum.id_idea_forum) as likes_count'),
            DB::raw('GROUP_CONCAT(comentario.id) as idcomments'),
            DB::raw('GROUP_CONCAT(comentario.text) as comentarios'), // Concatenar los comentarios
            DB::raw('GROUP_CONCAT(comment_users.name) as comment_users') // Concatenar los nombres de los usuarios de los comentarios
        )
        ->groupBy('idea_forum.id_idea_forum','idea_forum.text','idea_forum.date','idea_forum.id_user', 'users.name') // Agrupar por todas las columnas no agregadas
        ->where('idea_forum.id_forum',$id)
        // ->orderBy('idea_forum.date', 'DESC')
        ->get();
        return view('inforum', $datos);
    }

    public function storeideaForum(Request $request)
    {

        // return $request;
        // Obtener la fecha y hora actual en la zona horaria del servidor
        $fechaHoraServidor = now();

        // Convertir la fecha y hora a la zona horaria de Colombia ('America/Bogota')
        $fechaHoraColombia = $fechaHoraServidor->setTimezone('America/Bogota');

        // Obtener la fecha y hora en formato 'Y-m-d H:i:s'
        $fechaHoraFormateada = $fechaHoraColombia->format('Y-m-d H:i:s');
        
        $group = new IdeaForum();
        $group->text = $request->input('text');
        $group->date = $fechaHoraFormateada;
        $group->id_forum = $request->input('id_forum');
        $group->id_user = auth()->id();

        $group->save();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function show(Forum $forum)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Forum $forum)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function destroy(Forum $forum)
    {
        //
    }

    public function destroyExp($id)
    {
        DB::table('idea_forum')->where('id_idea_forum', $id)->delete();

        return back()->with('success', 'Experiencia Eliminada Exitosamente');
    }
}
