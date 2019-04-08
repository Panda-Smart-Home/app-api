<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Action
 * @package App\Models
 *
 * @property int    $id
 * @property string $name
 * @property array  $todo
 * @property array  $devices
 */
class Action extends Model
{
    protected $attributes = [];

    protected $fillable = [
        'id', 'name', 'todo'
    ];

    protected $casts = [
        'todo' => 'array',
    ];

    protected $appends = ['devices'];

    public function getDevicesAttribute()
    {
        $todo = $this->todo;
        if (!is_array($todo) || empty($todo)) {
            return null;
        }

        $ids = array_unique(array_column($todo, 'id'));
        if (!is_array($ids) || empty($ids)) {
            return null;
        }

        $devices = Device::query()
            ->select('name')
            ->whereIn('id', $ids)
            ->get()
            ->pluck('name')
            ->toArray();

        return $devices;
    }
}
