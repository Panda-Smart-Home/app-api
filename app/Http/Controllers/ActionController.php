<?php

namespace App\Http\Controllers;

use App\Models\Action;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class ActionController extends Controller
{
    public function create(Request $request)
    {
        $name = $request->get('name');
        $preTodo = $request->get('todo');
        if (empty($name) || empty($preTodo) || !is_array($preTodo)) {
            return response(['msg' => 'error'], 400);
        }
        $todo = [];
        foreach ($preTodo as $item) {
            if (is_null($item['id'])
                || is_null($item['property'])
                || is_null($item['value'])) {
                continue;
            }
            $todo[] = [
                'id' => $item['id'],
                'property' => $item['property'],
                'value' => $item['value'],
            ];
        }
        if (empty($todo)) {
            return response(['msg' => 'error'], 400);
        }

        $action = new Action(['name' => $name, 'todo' => $todo]);
        if ($action->save()) {
            return response(['msg' => 'success']);
        }
        return response(['msg' => 'error'], 500);
    }

    public function get(string $id = null)
    {
        if ($id) {
            return Action::query()->find($id);
        }
        return Action::query()->get();
    }

    public function delete(string $id)
    {
        $action = Action::query()->find($id);
        if (is_null($action)) {
            return response(['msg' => 'action not exist'], 404);
        }
        if ($action->delete()) {
            return response(['msg' => 'success'], 204);
        }
        return response(['msg' => 'error'], 500);
    }
}
