<?php

namespace App\Http\Controllers;

use App\Models\HealthCheck;
use App\Models\Temporal;
use Illuminate\Http\Request;

class HealthCheckController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
  /*
        Temporal::create([
            "name" => "testx",
            "test" => "test@gmail.com"
        ]);
*/

        return response()->json(['message' => 'ok']);

        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(HealthCheck $healthCheck)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HealthCheck $healthCheck)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HealthCheck $healthCheck)
    {
        //
    }
}
