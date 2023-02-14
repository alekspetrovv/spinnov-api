<?php

namespace App\Http\Controllers;

use App\Http\Requests\SyncSensorDataRequest;
use App\Models\Sensor;
use App\Models\Device;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class SensorController extends Controller
{

    public function index()
    {
        // retrieve sensors for authorized user
        return Sensor::whereHas('device', function (Builder $query) {
            $query->where('user_id', '=', Auth::id());
        })->get();
    }

    public function syncSensorData(SyncSensorDataRequest $request): JsonResponse
    {
        $data = $request->validated();
        foreach ($data["sensors"] as $sensor_data) {

            $authorized_device = Device::where('id', '=', $sensor_data["device_id"])
                ->where('user_id', '=', Auth::id())
                ->first();

            // skip iteration if unauthorized
            if (empty($authorized_device)) {
                continue;
            }

            $sensor = new Sensor($sensor_data);
            $sensor->save();
        }
        return response()->json(["message" => "Sensor data synced!"], 200);
    }
}
