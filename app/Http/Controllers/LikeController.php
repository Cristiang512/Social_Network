<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use App\Models\Publication;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function like($publication)
    {
        // return $publication;
        // $publicationId = $request->input('id_publication');
        $userId = auth()->user()->id;

        $like = Like::where('id_user', $userId)
            ->where('id_publication', $publication)
            ->first();

        if ($like) {
            // Si ya existe un "Me gusta" del usuario en esta publicación, lo eliminamos
            $like->delete();
        } else {
            // Si no existe un "Me gusta" del usuario en esta publicación, lo creamos
            Like::create([
                'id_user' => $userId,
                'id_publication' => $publication,
            ]);
        }

        return redirect()->back();
    }

    public function likeIdea($idea)
    {
        // return $idea;
        // $ideaId = $request->input('id_idea');
        $userId = auth()->user()->id;

        $like = Like::where('id_user', $userId)
            ->where('id_idea', $idea)
            ->first();

        if ($like) {
            // Si ya existe un "Me gusta" del usuario en esta publicación, lo eliminamos
            $like->delete();
        } else {
            // Si no existe un "Me gusta" del usuario en esta publicación, lo creamos
            Like::create([
                'id_user' => $userId,
                'id_idea' => $idea,
            ]);
        }

        return redirect()->back();
    }

    public function likeExp($exp)
    {
        // return $idea;
        // $ideaId = $request->input('id_idea');
        $userId = auth()->user()->id;

        $like = Like::where('id_user', $userId)
            ->where('id_idea_forum', $exp)
            ->first();

        if ($like) {
            // Si ya existe un "Me gusta" del usuario en esta publicación, lo eliminamos
            $like->delete();
        } else {
            // Si no existe un "Me gusta" del usuario en esta publicación, lo creamos
            Like::create([
                'id_user' => $userId,
                'id_idea_forum' => $exp,
            ]);
        }

        return redirect()->back();
    }

    public function likeInf($inf)
    {
        // return $idea;
        // $ideaId = $request->input('id_idea');
        $userId = auth()->user()->id;

        $like = Like::where('id_user', $userId)
            ->where('id_information', $inf)
            ->first();

        if ($like) {
            // Si ya existe un "Me gusta" del usuario en esta publicación, lo eliminamos
            $like->delete();
        } else {
            // Si no existe un "Me gusta" del usuario en esta publicación, lo creamos
            Like::create([
                'id_user' => $userId,
                'id_information' => $inf,
            ]);
        }

        return redirect()->back();
    }
}
