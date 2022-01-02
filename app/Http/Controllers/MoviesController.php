<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MoviesController extends Controller
{
    protected $apiURL;

    public function __construct() {
        $this->apiURL = "http://www.omdbapi.com/?apikey=" . config('app.omdb_api_key') . "&type=movie&";
    }

    public function index() {
        $watchedMovies = Movie::all();
        $movies = [];

        foreach ($watchedMovies as $key => $movie) {
            $apiURL = $this->apiURL . "i=" . $movie->imdb_id;
            $result = (array) json_decode(file_get_contents($apiURL));

            if ( $result['Response'] ) {
                $movies[] = $result;
            }
        }

        return response()->json($movies);
    }

    public function watchedIds() {
        $watchedMovies = Movie::all();
        $movies = [];

        foreach ($watchedMovies as $key => $movie) {
            $movies[] = $movie->imdb_id;
        }

        return response()->json($movies);
    }

    public function store(Request $request) {
        $movie = Movie::create([
            'imdb_id' => $request->imdbID
        ]);

        $data = [
            'data' => $movie,
            'status' => (bool) $movie,
            'message' => $movie ? 'Movie marked as watched' : 'Error marking movie'
        ];

        return response()->json($data);
    }

    public function show($title, $page) {
        $apiURL = $this->apiURL . "s=" . $title . "&page=" . $page;

        $results = file_get_contents($apiURL);
        $resultsArray = (array) json_decode($results);

        return response()->json($resultsArray);
    }

    public function destroy($id) {
        $status = Movie::where('imdb_id', $id)->delete();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Movie removed' : 'Error removing movie'
        ]);
    }
}
