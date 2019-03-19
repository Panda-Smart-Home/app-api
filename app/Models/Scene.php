<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Device
 * @package App\Models
 *
 * @property int    $id
 * @property string $name
 * @property array  $requirement
 */
class Scene extends Model
{
    protected $attributes = [];

    protected $fillable = [
        'id', 'name', 'requirement'
    ];

    protected $casts = [
        'requirement' => 'array',
    ];

    protected $appends = ['devices'];

    public function getDevicesAttribute()
    {
        $requirement = $this->requirement;
        if (!is_array($requirement) || empty($requirement)) {
            return null;
        }

        $ids = array_unique(array_column($requirement, 'id'));
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
