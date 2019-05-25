<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Action;
use App\Models\Scene;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class JobController extends Controller
{
    public function create(Request $request)
    {
        // 验证请求参数
        $name = $request->get('name');
        $actionId = $request->get('action_id');
        $sceneId = $request->get('scene_id');
        if (empty($name) || empty($actionId) || empty($sceneId)) {
            return response(['msg' => 'error'], 400);
        }
        // 确认行为和场景存在
        $action = Action::query()->find($actionId);
        $scene  = Scene::query()->find($sceneId);
        if (empty($action) || empty($scene)) {
            return response(['msg' => 'error'], 400);
        }
        // 确认对应任务不存在
        $isExistJob = Job::query()
            ->where('action_id', $actionId)
            ->where('scene_id', $sceneId)
            ->first();
        if (!empty($isExistJob)) {
            return response(['msg' => 'error'], 400);
        }
        // 保存任务
        $job = new Job([
            'name' => $name,
            'action_id' => $actionId,
            'scene_id' => $sceneId
        ]);
        if ($job->save()) {
            return response(['msg' => 'success']);
        }
        return response(['msg' => 'error'], 500);
    }

    public function get(string $id = null)
    {
        if (!is_null($id)) {
            return Job::with(['action', 'scene'])->find($id);
        }
        return Job::with(['action', 'scene'])->get();
    }

    public function delete(string $id)
    {
        $job = Job::query()->find($id);
        if (is_null($job)) {
            return response(['msg' => 'job not exist'], 404);
        }
        if ($job->delete()) {
            return response(['msg' => 'success'], 204);
        }
        return response(['msg' => 'error'], 500);
    }
}
