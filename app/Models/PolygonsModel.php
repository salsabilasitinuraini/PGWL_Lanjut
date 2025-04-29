<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PolygonsModel extends Model
{
    protected $table = 'polygons';

    protected $guarded = ['id'];

    public function geojson_polygons()
    {
        // Ambil data dari database
        $polygons = $this
            ->select(DB::raw('st_asgeojson(geom) as geom, name, description, image, st_area(geom, true) as area_m2, st_area(geom, true) / 1000000 as area_km2, st_area(geom, true) / 10000 as area_hektar, created_at, updated_at'))
            ->get();

        // Bangun struktur GeoJSON
        $geojson = [
            'type' => 'FeatureCollection',
            'features' => [],
        ];

        foreach ($polygons as $p) {
            $feature = [
                'type' => 'Feature',
                'geometry' => json_decode($p->geom),
                'properties' => [
                    'name' => $p->name,
                    'description' => $p->description,
                    'image' => $p->image,
                    'area_m2' => $p->area_m2,
                    'area_km2' => $p->area_km2,
                    'area_hektar' => $p->area_hektar,
                    'created_at' => $p->created_at,
                    'updated_at' => $p->updated_at,
                ],
            ];

            $geojson['features'][] = $feature;
        }

        // Kembalikan GeoJSON
        return $geojson;
    }
}
