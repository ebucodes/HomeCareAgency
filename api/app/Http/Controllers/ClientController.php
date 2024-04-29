<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseStatusCodes;
use App\Models\Incident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends Controller
{
    //
    public function fetchMyIncidents(Request $request): JsonResponse
    {
        $incidents = Incident::where('client', auth()->user()->userName)->latest()->get();
        $totalIncidents = $incidents->count();
        return successResponse('Successful', $incidents, $totalIncidents);
    }

    //
    public function viewSingleIncident(Request $request): JsonResponse
    {
        $incident = Incident::where('id', $request->id)->first();
        return successResponse('Successful', $incident);
    }

    //
    public function reportIncident(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'client' => 'required',
            'type' => 'required',
            'desc' => 'required',
            'priority' => 'required'
        ]);

        // failed validation
        if ($validator->fails()) {
            return errorResponse(ResponseStatusCodes::VALIDATOR_ERROR, "Validation Error", $validator->errors()->all(), Response::HTTP_UNAUTHORIZED);
        }

        // create new incident
        $create = Incident::create([
            'client' => auth()->user()->userName,
            'date' => now(),
            'type' => $request->type,
            'desc' => $request->desc,
            'priority' => $request->priority,
            "worker" => auth()->user()->worker,
            'status' => 'pending'
        ]);

        if ($create) {
            // log the activity of the user
            logAction(auth()->user()->userName, 'Report New Incident', "reported a new incident", $request->ip(), $request->userAgent());
            // success response of the action
            return successResponse("You have successfully reported a new incident", $create);
        }
    }
}
