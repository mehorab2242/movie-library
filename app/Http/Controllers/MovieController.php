<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        //
        $movies = response()->json(Movie::all(), 200) ;
        return $movies;

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        //
        return view('movies.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'nullable',
            'release_year' => 'required|integer',
            'director' => 'required|string|max:255',
            'genre' => 'nullable|string',
            'rating' => 'required|numeric|between:0,10',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }
        $movieData = [
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'release_year' => 'required|integer|between:1900,' .date('Y'),
            'director' => $request->get('director'),
            'genre' => $request->get('genre'),
            'rating' => $request->get('rating'),
        ];
        try {
            Movie::create($movieData);

        }catch (\Exception $exception){
            return $exception;
        }

        return $movieData;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        //
        $movie = Movie::find($id);
        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }
        return response()->json($movie, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        //
        $movie = Movie::find($id);
        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'release_year' => 'required|integer|between:1900,' .date('Y'),
            'director' => 'required|max:255',
            'genre' => 'nullable|string|max:100',
            'rating' => 'nullable|numeric|between:0,10',

        ]);
        $movie->update($request->all());
        return response()->json($movie, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id):JsonResponse
    {
        //
        $movie = Movie::find($id);
        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }
        $movie->delete();
        return response()->json(['message' => 'Movie deleted'], 200);
    }
}
