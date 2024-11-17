<?php

namespace App\Http\Controllers;

use App\Models\Baranggay;
use App\Models\Municipality;
use App\Models\Province;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getMunicipalities($provinceId)
    {
        $municipalities = Municipality::where('prov_code', $provinceId)->get();
        return response()->json($municipalities);
    }

    public function getBarangays($municipalityId)
    {
        $barangays = Baranggay::where('citymun_code', $municipalityId)->get();
        return response()->json($barangays);
    }
}
