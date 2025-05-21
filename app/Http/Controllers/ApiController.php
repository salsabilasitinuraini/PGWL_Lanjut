<?php

namespace App\Http\Controllers;

use App\Models\PointsModel;
use Illuminate\Http\Request;
use App\Models\PolygonsModel;
use App\Models\PolylinesModel;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->points = new PointsModel();
        $this->polylines = new PolylinesModel();
        $this->polygons = new PolygonsModel();
    }

    public function points()
    {
        $points = $this->points->geojson_points();

        return response()->json($points);
    }
    public function point(&$id)
    {
        $points = $this->points->geojson_point($id);

        return response()->json($points);
    }

    public function polylines()
    {
        $polylines = $this->polylines->geojson_polylines();

        return response()->json($polylines);
    }
    public function polyline($id)
    {
        $polylines = $this->polylines->geojson_polyline($id);

        return response()->json($polylines);
    }

    public function polygons()
    {
        $polygons = $this->polygons->geojson_polygons();

        return response()->json($polygons);
    }
    public function polygon($id)
    {
        $polygons = $this->polygons->geojson_polygon($id);

        return response()->json($polygons);
    }
}
