<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseStatusCodes;
use App\Models\IncidentType;
use App\Models\Priority;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    //
    public function fetchAllRoles(Request $request): JsonResponse
    {
        $roles = Role::latest()->get();
        // log the activity of the user
        // logAction(auth()->user()->userName, 'List All Roles', "fetched all the roles", $request->ip(), $request->userAgent());
        return successResponse('Successful', $roles);
    }

    //
    public function listRoles(): JsonResponse
    {
        $roles = Role::where('isActive', true)->latest()->get();
        return successResponse('Successful', $roles);
    }

    //
    public function createRole(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:roles',
        ]);

        // failed validation
        if ($validator->fails()) {
            return errorResponse(ResponseStatusCodes::VALIDATOR_ERROR, "Validation Error", $validator->errors()->all(), Response::HTTP_UNAUTHORIZED);
        }

        // create new role
        $create = Role::create([
            'name' => $request->name,
            'isActive' => true
        ]);

        if ($create) {
            // log the activity of the user
            logAction(auth()->user()->userName, 'New Role', "created a new role named: {$request->name}", $request->ip(), $request->userAgent());
            // success response of the action
            return successResponse("You have successfully created a new role", $create);
        }
    }

    //
    public function updateRole(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required|string|unique:roles',
        ]);

        // failed validation
        if ($validator->fails()) {
            return errorResponse(ResponseStatusCodes::VALIDATOR_ERROR, "Validation Error", $validator->errors()->all(), Response::HTTP_UNAUTHORIZED);
        }
        $roles = Role::find($request->id);
        // update new role
        $update = $roles->update(['name' => $request->name]);

        if ($update) {
            // log the activity of the user
            logAction(auth()->user()->userName, 'Update Role', "updated an role", $request->ip(), $request->userAgent());
            // success response of the action
            return successResponse("You have successfully updated an role", $update);
        }
    }

    //
    public function deleteRole(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        // failed validation
        if ($validator->fails()) {
            return errorResponse(ResponseStatusCodes::VALIDATOR_ERROR, "Validation Error", $validator->errors()->all(), Response::HTTP_UNAUTHORIZED);
        }

        //
        $roles = Role::where('id', $request->id)->first();
        // delete new role
        // $delete = $roles->update(['isActive' => false]);
        $delete = $roles->delete();

        if ($delete) {
            // log the activity of the user
            logAction(auth()->user()->userName, 'Deleted a Role', " deleted a role", $request->ip(), $request->userAgent());
            // success response of the action
            return successResponse("You have successfully deleted a role", $delete);
        }
    }

    //
    public function fetchAllPriorities(Request $request): JsonResponse
    {
        $priorities = Priority::latest()->get();
        // log the activity of the user
        logAction(auth()->user()->userName, 'List All Priorities', "fetched all the priorities", $request->ip(), $request->userAgent());
        return successResponse('Successful', $priorities);
    }

    //
    public function listPriorities(): JsonResponse
    {
        $priorities = Priority::where('isActive', true)->latest()->get();
        return successResponse('Successful', $priorities);
    }

    //
    public function createPriority(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:priorities',
        ]);

        // failed validation
        if ($validator->fails()) {
            return errorResponse(ResponseStatusCodes::VALIDATOR_ERROR, "Validation Error", $validator->errors()->all(), Response::HTTP_UNAUTHORIZED);
        }

        // create new Priority
        $create = Priority::create([
            'name' => $request->name,
            'isActive' => true
        ]);

        if ($create) {
            // log the activity of the user
            logAction(auth()->user()->userName, 'New Priority', "created a new priority named: {$request->name}", $request->ip(), $request->userAgent());
            // success response of the action
            return successResponse("You have successfully created a new priority", $create);
        }
    }

    //
    public function updatePriority(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required|string|unique:priorities',
        ]);

        // failed validation
        if ($validator->fails()) {
            return errorResponse(ResponseStatusCodes::VALIDATOR_ERROR, "Validation Error", $validator->errors()->all(), Response::HTTP_UNAUTHORIZED);
        }
        $priorities = Priority::find($request->id);
        // update new Priority
        $update = $priorities->update(['name' => $request->name]);

        if ($update) {
            // log the activity of the user
            logAction(auth()->user()->userName, 'Update Priority', "updated an priority", $request->ip(), $request->userAgent());
            // success response of the action
            return successResponse("You have successfully updated an priority", $update);
        }
    }

    //
    public function deletePriority(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        // failed validation
        if ($validator->fails()) {
            return errorResponse(ResponseStatusCodes::VALIDATOR_ERROR, "Validation Error", $validator->errors()->all(), Response::HTTP_UNAUTHORIZED);
        }

        //
        $priorities = Priority::find($request->id);
        // delete new Priority
        // $delete = $priorities->update(['isActive' => false]);
        $delete = $priorities->delete();
        if ($delete) {
            // log the activity of the user
            logAction(auth()->user()->userName, 'Deactivated Priority', "deactivated an priority", $request->ip(), $request->userAgent());
            // success response of the action
            return successResponse("You have successfully deactivated an priority", $delete);
        }
    }


    //
    public function fetchAllIncidentTypes(Request $request): JsonResponse
    {
        $incident_types = IncidentType::latest()->get();
        // log the activity of the user
        logAction(auth()->user()->userName, 'List All Statu', "fetched all the incident types", $request->ip(), $request->userAgent());
        return successResponse('Successful', $incident_types);
    }

    //
    public function listIncidentTypes(): JsonResponse
    {
        $incident_types = IncidentType::where('isActive', true)->latest()->get();
        return successResponse('Successful', $incident_types);
    }


    //
    public function createIncidentType(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:incident_types',
        ]);

        // failed validation
        if ($validator->fails()) {
            return errorResponse(ResponseStatusCodes::VALIDATOR_ERROR, "Validation Error", $validator->errors()->all(), Response::HTTP_UNAUTHORIZED);
        }

        // create new incident type
        $create = IncidentType::create([
            'name' => $request->name,
            'isActive' => true
        ]);

        if ($create) {
            // log the activity of the user
            logAction(auth()->user()->userName, 'New Incident Type', "created a new incident type named: {$request->name}", $request->ip(), $request->userAgent());
            // success response of the action
            return successResponse("You have successfully created a new incident type", $create);
        }
    }

    //
    public function updateIncidentType(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required|string|unique:incident_types',
        ]);

        // failed validation
        if ($validator->fails()) {
            return errorResponse(ResponseStatusCodes::VALIDATOR_ERROR, "Validation Error", $validator->errors()->all(), Response::HTTP_UNAUTHORIZED);
        }
        $incident_types = IncidentType::find($request->id);
        // update new incident type
        $update = $incident_types->update(['name' => $request->name]);

        if ($update) {
            // log the activity of the user
            logAction(auth()->user()->userName, 'Update Incident Type', "updated an incident type", $request->ip(), $request->userAgent());
            // success response of the action
            return successResponse("You have successfully updated an incident type", $update);
        }
    }

    //
    public function deleteIncidentType(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        // failed validation
        if ($validator->fails()) {
            return errorResponse(ResponseStatusCodes::VALIDATOR_ERROR, "Validation Error", $validator->errors()->all(), Response::HTTP_UNAUTHORIZED);
        }

        //
        $incident_types = IncidentType::find($request->id);
        // delete new incident type
        // $delete = $incident_types->update(['isActive' => false]);
        $delete = $incident_types->delete();

        if ($delete) {
            // log the activity of the user
            logAction(auth()->user()->userName, 'Deactivated Incident Type', "deactivated an incident type", $request->ip(), $request->userAgent());
            // success response of the action
            return successResponse("You have successfully deactivated an incident type", $delete);
        }
    }

    //
    public function fetchAllStatuses(Request $request): JsonResponse
    {
        $statuses = Status::latest()->get();
        // log the activity of the user
        // logAction(auth()->user()->userName, 'List All Statu', "fetched all the incident types", $request->ip(), $request->userAgent());
        return successResponse('Successful', $statuses);
    }

    //
    public function listStatuses(): JsonResponse
    {
        $statuses = Status::where('isActive', true)->latest()->get();
        return successResponse('Successful', $statuses);
    }


    //
    public function createStatus(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:statuses',
        ]);

        // failed validation
        if ($validator->fails()) {
            return errorResponse(ResponseStatusCodes::VALIDATOR_ERROR, "Validation Error", $validator->errors()->all(), Response::HTTP_UNAUTHORIZED);
        }

        // create new incident type
        $create = Status::create([
            'name' => $request->name,
            'isActive' => true
        ]);

        if ($create) {
            // log the activity of the user
            logAction(auth()->user()->userName, 'New Status', "created a new status named: {$request->name}", $request->ip(), $request->userAgent());
            // success response of the action
            return successResponse("You have successfully created a new status", $create);
        }
    }

    //
    public function updateStatus(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required|string|unique:statuses',
        ]);

        // failed validation
        if ($validator->fails()) {
            return errorResponse(ResponseStatusCodes::VALIDATOR_ERROR, "Validation Error", $validator->errors()->all(), Response::HTTP_UNAUTHORIZED);
        }
        $status = Status::find($request->id);
        // update new incident type
        $update = $status->update(['name' => $request->name]);

        if ($update) {
            // log the activity of the user
            logAction(auth()->user()->userName, 'Update Status', "updated a status", $request->ip(), $request->userAgent());
            // success response of the action
            return successResponse("You have successfully updated a status", $update);
        }
    }

    //
    public function deleteStatus(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        // failed validation
        if ($validator->fails()) {
            return errorResponse(ResponseStatusCodes::VALIDATOR_ERROR, "Validation Error", $validator->errors()->all(), Response::HTTP_UNAUTHORIZED);
        }

        //
        $status = Status::find($request->id);
        // delete new incident type
        // $delete = $status->update(['isActive' => false]);
        $delete = $status->delete();

        if ($delete) {
            // log the activity of the user
            logAction(auth()->user()->userName, 'Deactivated Status', "deactivated a status", $request->ip(), $request->userAgent());
            // success response of the action
            return successResponse("You have successfully deactivated a status", $delete);
        }
    }


    //
    public function listUsers(): JsonResponse
    {
        $users = User::latest()->get();
        return successResponse('Successful', $users);
    }

    //
    public function listAdmins(): JsonResponse
    {
        $admins = Status::where('isActive', true)->where('role', 'admin')->latest()->get();
        return successResponse('Successful', $admins);
    }

    //
    public function listClients(): JsonResponse
    {
        $clients = Status::where('role', 'client')->where('isActive', true)->latest()->get();
        return successResponse('Successful', $clients);
    }
}
