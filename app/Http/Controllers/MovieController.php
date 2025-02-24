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
     * Display a listing of the Created Movie.
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        //
        $movies = response()->json(Movie::all(), 200) ;
        return $movies;

    }

    /**
     * Store a newly created movie in storage.
     * @param Request $request
     * @return JsonResponse
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

        try {
            $movieData = [
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'release_year' => $request->get('release_year'),
                'director' => $request->get('director'),
                'genre' => $request->get('genre'),
                'rating' => $request->get('rating'),
            ];
            Movie::create($movieData);
            return response()->json(['message' => 'Movie added successfully'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

    }

    /**
     * Display the specified single movie.
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        //
        $movie = Movie::findOrFail($id);
        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }
        return response()->json($movie, 200);
    }

    /**
     * Update the specified movie in storage.
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {



        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'release_year' => 'sometimes|required|integer|between:1900,' . date('Y'),
            'director' => 'sometimes|required|string|max:255',
            'genre' => 'nullable|string|max:100',
            'rating' => 'nullable|numeric|between:0,10',
        ]);
        $movie = Movie::findOrFail($id);

        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }

        try {
            $movie->update($request->only(['title', 'description', 'release_year', 'director', 'genre', 'rating']));
            return response()->json([
                'message' => 'Movie updated successfully',
                'movie' => $movie], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update movie', 'message' => $e->getMessage()], 500);
        }

    }

    /**
     * Remove the specified movie from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id):JsonResponse
    {
        //
        $movie = Movie::findOrFail($id);
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
