<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class DeviceController extends Controller
{
    public function get(string $id = null)
    {
        if (!is_null($id)) {
            return Device::query()->find($id);
        }
        return Device::query()->get();
    }

    public function update(Request $request, string $id)
    {
        $device = Device::query()->find($id);
        if (is_null($device)) {
            return response(['msg' => 'device not exist'], 404);
        }

        $name = $request->get('name');
        if ($name) {
            $device->name = $name;
        }

        $status = $request->get('status');
        if ($status) {
            /**
             * @var Device $device
             */
            $device->updateStatus($status);
        }

        if ($device->save()) {
            return response(['msg' => 'success']);
        }
        return response(['msg' => 'error'], 500);
    }
}
