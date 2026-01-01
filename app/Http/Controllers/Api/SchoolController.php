<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    /**
     * Get all schools with teacher and student counts.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $schools = School::withCount(['teachers', 'students'])->get();

        return response()->json([
            'status' => 'success',
            'data' => $schools
        ]);
    }
}
