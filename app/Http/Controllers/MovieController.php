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
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'nullable',
            'release_year' => 'required|integer|between:1900,' .date('Y'),
            'director' => 'required|string|max:255',
            'genre' => 'nullable|string',
            'rating' => 'required|numeric|between:0,10',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $movieData = [
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'release_year' => $request->get('release_year'),
            'director' => $request->get('director'),
            'genre' => $request->get('genre'),
            'rating' => $request->get('rating'),
        ];
        try {
            Movie::create($movieData);

        }catch (\Exception $exception){
            return response()->json([$exception->getMessage()]);
        }

        return response()->json([$movieData]);
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {

        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'release_year' => 'sometimes|required|integer|between:1900,' . date('Y'),
            'director' => 'sometimes|required|string|max:255',
            'genre' => 'nullable|string|max:100',
            'rating' => 'nullable|numeric|between:0,10',
        ]);

        try {
            $movie->update($request->only(['title', 'description', 'release_year', 'director', 'genre', 'rating']));
            return response()->json($movie, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update movie', 'message' => $e->getMessage()], 500);
        }

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
        try {
            $movie->delete();
            return response()->json(['message' => 'Movie deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete movie', 'message' => $e->getMessage()], 500);
        }

    }
}
