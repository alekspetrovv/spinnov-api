<?php

namespace App\Http\Requests;


class SyncSensorDataRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "sensors" => [
                'required',
                'array', // input must be an array
                'max:3'  // there must be three sensors in the array
            ],
            "sensors.*.type" => [
                'in:blood_pressure,oxygen_levels,sleep_duration',
                'required',
            ],
            "sensors.*.readings" => [
                'required',
                'numeric'
            ],
            "sensors.*.readings_time" => [
                'required',
                'string'
            ],
            "sensors.*.device_id" => [
                'required',
                'exists:devices,id',
            ],

//            // validate fields
//            "sensors" => "required|array",
//            "time" => "required",
        ];
    }
}
