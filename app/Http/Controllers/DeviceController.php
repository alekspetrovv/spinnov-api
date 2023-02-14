<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeviceDataRequest;
use App\Models\Device;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use function Symfony\Component\String\u;

class DeviceController extends Controller
{
    public function index()
    {
        return Device::where('user_id', '=', Auth::id())
            ->first();
    }


    public function store(DeviceDataRequest $request)
    {
        // validate device fields
        $device_data = $request->validated();

        // create new device
        $new_device = new Device($device_data);
        // assign authenticated user_id
        $new_device->user_id = Auth::id();
        $new_device->save();

        // return message
        return $this->handleMessage($new_device, "created");
    }


    public function show($id)
    {
        // retrieve device
        $device = $this->handleException($id);

        // retrieve sensors
        $device->load("sensors");

        // return message
        return $this->handleMessage($device, "retrieved");
    }


    public function update(DeviceDataRequest $request, $id)
    {
        // retrieve device
        $device = $this->handleException($id);
        // validate fields
        $values = $request->validated();
        // set fields
        $device->fill($values);
        // save to database
        $device->save();
        // return message
        return $this->handleMessage($device, "updated");
    }


    public function destroy($id)
    {
        $this->handlePermissions();
        // check if device exist
        $device = $this->handleException($id);
        // delete device
        $device->delete();
        // return correct message
        return $this->handleMessage($id, "deleted");
    }

    public function handleException($id)
    {
        // search for device
        $device = Device::where('id', '=', $id)->where('user_id', '=', Auth::id())->first();

        // look for any exceptions
        if (empty($device)) {
            throw new HttpResponseException(response()->json(['errors' => "Device unauthorized"], JsonResponse::HTTP_UNAUTHORIZED));
        }
        return $device;
    }

    public function handlePermissions()
    {
        if (!Auth::user()->hasRole('Admin')) {
            throw new HttpResponseException(response()->json(JsonResponse::HTTP_UNAUTHORIZED));
        };
    }

    public function handleMessage($device, $message): JsonResponse
    {
        return response()->json(['device' => $device, "message" => "Device has been {$message} successfully"], 200);
    }

}
