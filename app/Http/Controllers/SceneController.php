<?php

namespace App\Http\Controllers;

use App\Models\Scene;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class SceneController extends Controller
{
    public function create(Request $request)
    {
        $name = $request->get('name');
        $rules = $request->get('rules');
        if (empty($name) || empty($rules) || !is_array($rules)) {
            return response(['msg' => 'error'], 400);
        }
        $requirement = [];
        foreach ($rules as $rule) {
            if (is_null($rule['id'])
                || is_null($rule['property'])
                || is_null($rule['operator'])
                || is_null($rule['value'])) {
                continue;
            }
            $requirement[] = [
                'id' => $rule['id'],
                'property' => $rule['property'],
                'operator' => $rule['operator'],
                'value' => $rule['value'],
            ];
        }
        if (empty($requirement)) {
            return response(['msg' => 'error'], 400);
        }

        $scene = new Scene(['name' => $name, 'requirement' => $requirement]);
        if ($scene->save()) {
            return response(['msg' => 'success']);
        }
        return response(['msg' => 'error'], 500);
    }

    public function get(string $id = null)
    {
        if ($id) {
            return Scene::query()->find($id);
        }
        return Scene::query()->get();
    }

    public function update(Request $request, string $id)
    {
        $scene = Scene::query()->find($id);
        if (is_null($scene)) {
            return response(['msg' => 'scene not exist'], 404);
        }

        $name = $request->get('name');
        if ($name) {
            $scene->name = $name;
        }

        $requirement = $request->get('requirement');
        if ($requirement) {
            // TODO
        }

        if ($scene->save()) {
            return response(['msg' => 'success']);
        }
        return response(['msg' => 'error'], 500);
    }

    public function delete(string $id)
    {
        $scene = Scene::query()->find($id);
        if (is_null($scene)) {
            return response(['msg' => 'scene not exist'], 404);
        }
        if ($scene->delete()) {
            return response(['msg' => 'success'], 204);
        }
        return response(['msg' => 'error'], 500);
    }
}
