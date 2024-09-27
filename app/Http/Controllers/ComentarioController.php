<?php

namespace App\Http\Controllers;

use App\Models\Comentario; // Asegúrate de importar el modelo Comentario
use App\Models\User;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function store(Request $request)
    {
        Comentario::insert([
            'id_publication' => $request->input('id_publication'),
            'text' => $request->input('comentario'),
            'user_id' => auth()->id(),
        ]);
    
        // Redirigir de nuevo a la página de la publicación o hacer lo que sea necesario
        return redirect()->back();
    }

    public function storeGroup(Request $request)
    {
        Comentario::insert([
            'id_idea' => $request->input('id_idea'),
            'text' => $request->input('comentario'),
            'user_id' => auth()->id(),
        ]);
    
        // Redirigir de nuevo a la página de la publicación o hacer lo que sea necesario
        return redirect()->back();
    }

    public function storeForum(Request $request)
    {
        Comentario::insert([
            'id_idea_forum' => $request->input('id_idea_forum'),
            'text' => $request->input('comentario'),
            'user_id' => auth()->id(),
        ]);
    
        // Redirigir de nuevo a la página de la publicación o hacer lo que sea necesario
        return redirect()->back();
    }

    public function storeInfo(Request $request)
    {
        Comentario::insert([
            'id_information' => $request->input('id_information'),
            'text' => $request->input('comentario'),
            'user_id' => auth()->id(),
        ]);
    
        // Redirigir de nuevo a la página de la publicación o hacer lo que sea necesario
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        // Obtener el comentario
        $comentario = Comentario::findOrFail($id);

        // Verificar si el usuario actual es el autor del comentario
        if ($comentario->user_id === auth()->user()->id) {
            $comentario->text = $request->input('comentario');
            $comentario->save();
        }

        return redirect()->back();
    }

    public function destroy($id)
    {
        // Obtener el comentario
        $comentario = Comentario::findOrFail($id);

        // Verificar si el usuario actual es el autor del comentario
        if ($comentario->user_id === auth()->user()->id) {
            $comentario->delete();
            return response()->json(['message' => 'Comentario eliminado exitosamente']);
        }

        return response()->json(['error' => 'No tienes permiso para eliminar este comentario'], 403);

    }
}


