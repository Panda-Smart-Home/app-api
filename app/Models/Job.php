<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Job
 * @package App\Models
 *
 * @property int    $id
 * @property string $name
 * @property int  $action_id
 * @property int  $scene_id
 */
class Job extends Model
{
    protected $fillable = [
        'id', 'name', 'action_id', 'scene_id'
    ];

    public function action()
    {
        return $this->belongsTo(Action::class);
    }

    public function scene()
    {
        return $this->belongsTo(Scene::class);
    }
}
