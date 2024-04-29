<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseStatusCodes;
use App\Models\Incident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class WorkerController extends Controller
{
    //
    public function fetchIncidents(): JsonResponse
    {
        $incidents = Incident::where('worker', auth()->user()->userName)->latest()->get();
        $totalIncidents = $incidents->count();
        return successResponse('Successful', $incidents, $totalIncidents);
    }

    //
    public function logIncident(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'log' => 'required'
        ]);

        // failed validation
        if ($validator->fails()) {
            return errorResponse(ResponseStatusCodes::VALIDATOR_ERROR, "Validation Error", $validator->errors()->all(), Response::HTTP_UNAUTHORIZED);
        }
        $incident = Incident::where('id', $request->id)->where('worker', auth()->user()->userName)->first();
        if (!$incident || $incident == null) {
            return errorResponse(ResponseStatusCodes::VALIDATOR_ERROR, "Validation Error", 'Invalid incident or Incident not assigned to this user', Response::HTTP_UNAUTHORIZED);
        }

        // update incident
        $update = $incident->update(['log' => $request->log, 'status' => $request->status]);

        if ($update) {
            // log the activity of the user
            logAction(auth()->user()->userName, 'Logged incident', "logged an incident", $request->ip(), $request->userAgent());
            // success response of the action
            return successResponse("You have successfully logged an incident", $update);
        }
    }
}
