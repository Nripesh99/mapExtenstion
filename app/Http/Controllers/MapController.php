<?php

namespace App\Http\Controllers;

use App\Models\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapController extends Controller
{
    public function index(){
        $points =Point::all();

        return view('map', compact('points'));
    }
    public function findShortestPath(Request $request)
    {
   
            $startId = $request->input('start');
            $endId = $request->input('end');
    
            $graph = $this->buildGraph();
            $path = $this->bfs($graph, $startId, $endId);
    
            return response()->json($path);
    }
    private function buildGraph()
    {
        // $points = DB::table('points')->get();
        $points =Point::all();
        $graph = [];

        foreach ($points as $point) {
            $graph[$point->id] = [];
            foreach ($points as $neighbor) {
                if ($point->id !== $neighbor->id) {
                    $distance = $this->calculateDistance($point->latitude, $point->longitude, $neighbor->latitude, $neighbor->longitude);
                    $graph[$point->id][$neighbor->id] = $distance;
                }
            }
        }

        return $graph;
    }
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        return ($miles * 1.609344);
    }
    private function bfs($graph, $start, $end)
    {
        $queue = [[$start]];
        $visited = [$start];

        while (!empty($queue)) {
            $path = array_shift($queue);
            $node = end($path);

            if ($node == $end) {
                return $path;
            }

            foreach ($graph[$node] as $neighbor => $distance) {
                if (!in_array($neighbor, $visited)) {
                    $visited[] = $neighbor;
                    $newPath = $path;
                    $newPath[] = $neighbor;
                    $queue[] = $newPath;
                }
            }
        }

        return [];
    }

}
