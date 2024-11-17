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
        $municipalities = Municipality::where('prov_code', $provinceId)->get(['citymun_code', 'citymun_desc']);
        return response()->json($municipalities);
    }

    public function getBarangays($municipalityId)
    {
        $barangays = Baranggay::where('citymun_code', $municipalityId)->get(['brgy_code', 'brgy_desc']);
        return response()->json($barangays);
    }
}
