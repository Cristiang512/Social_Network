<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use PhpParser\Node\Stmt\Return_;

class PublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publications = Publication::leftJoin('users', 'publication.id_user', 'users.id')
        ->leftJoin('comentario', 'publication.id_publication', 'comentario.id_publication')
        ->leftJoin('users as comment_users', 'comentario.user_id', 'comment_users.id') // Unión con la tabla de usuarios para los comentarios
        ->select(
            'publication.id_publication',
            'publication.text',
            'publication.imageField',
            'publication.video_link',
            'publication.date',
            'publication.id_user',
            'users.name',
            DB::raw('(SELECT COUNT(*) FROM likes WHERE likes.id_publication = publication.id_publication) as likes_count'),
            DB::raw('GROUP_CONCAT(comentario.id) as idcomments'),
            DB::raw('GROUP_CONCAT(comentario.text) as comentarios'), // Concatenar los comentarios
            DB::raw('GROUP_CONCAT(comment_users.name) as comment_users') // Concatenar los nombres de los usuarios de los comentarios
        )
        ->groupBy('publication.id_publication','publication.text', 'publication.imageField', 'publication.video_link', 'publication.date','publication.id_user', 'users.name') // Agrupar por todas las columnas no agregadas
        ->orderBy('publication.date', 'DESC')
        ->get();

        $datos['publications'] = $publications;

        return view('wall', $datos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function store(Request $request)
    {
        // Validar los campos según tus necesidades
        $validatedData = $request->validate([
            'publication' => 'required',
            'imageField' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_link' => 'nullable|url',
        ]);

        // Obtener la fecha y hora actual en la zona horaria del servidor
        $fechaHoraServidor = now();

        // Convertir la fecha y hora a la zona horaria de Colombia ('America/Bogota')
        $fechaHoraColombia = $fechaHoraServidor->setTimezone('America/Bogota');

        // Obtener la fecha y hora en formato 'Y-m-d H:i:s'
        $fechaHoraFormateada = $fechaHoraColombia->format('Y-m-d H:i:s');
        
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            // Crear una nueva instancia de la publicación
            $publication = new Publication();

            // Asignar los valores a los campos de la publicación
            $publication->text = $validatedData['publication'];
            $publication->date = $fechaHoraFormateada;
            $publication->id_user = auth()->id(); // Obtener el ID del usuario logueado

            $nombreArchivo = null;
            if ($request->hasFile('imageField')) {
                $archivo = $request->file('imageField');
                $nombreArchivo = $archivo->getClientOriginalName();
                $archivo->move(public_path('files'), $nombreArchivo);
                $publication->imageField = $nombreArchivo;
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
                        $publication->video_link = $videoId;
                    }
                }
            }
            // Guardar la publicación en la base de datos
            $publication->save();

            // Redireccionar a alguna vista o realizar otra acción después de guardar la publicación
            return back()->with('success', 'Publicación creada exitosamente');
        } else {
            // El usuario no está autenticado, redireccionar a la página de inicio de sesión u otra acción
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para crear una publicación');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function show(Publication $publication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Publication $publication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
{
    DB::table('publication')->where('id_publication', $id)->delete();

    return back()->with('success', 'Publicación Eliminada Exitosamente');
}

}
