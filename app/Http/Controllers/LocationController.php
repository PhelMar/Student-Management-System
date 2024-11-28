<?php

namespace App\Http\Controllers;

use App\Models\Baranggay;
use App\Models\Municipality;

class LocationController extends Controller
{
    public function getMunicipalities($provinceId)
    {
        $municipalities = Municipality::where('prov_code', $provinceId)
        ->orderBy('citymun_desc', 'asc')
        ->get(['citymun_code', 'citymun_desc']);
        return response()->json($municipalities);
    }

    public function getBarangays($municipalityId)
    {
        $barangays = Baranggay::where('citymun_code', $municipalityId)
        ->orderBy('brgy_desc', 'asc')
        ->get(['brgy_code', 'brgy_desc']);
        return response()->json($barangays);
    }
}
