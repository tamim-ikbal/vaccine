<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\EnrollResource;
use App\Models\Enroll;
use App\Services\EnrollService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EnrollController extends Controller
{
    public function status(Request $request)
    {
        $request->validate([
            'nid' => ['required'],
            'dob' => ['required', 'date', 'date_format:Y-m-d'],
        ]);

        $enroll = EnrollService::getEnroll(
            nid: $request->get('nid'),
            dob: $request->get('dob')
        );

        if (!$enroll) {
            return response()->json([
                'message' => __('No data found.'),
                'payload' => null,
            ]);
        }

        return response()->json([
            'message' => __('Enroll Details.'),
            'payload' => EnrollResource::make($enroll),
        ]);
    }
}
