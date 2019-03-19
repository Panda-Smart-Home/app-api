<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Device
 * @package App\Models
 *
 * @property int    $id
 * @property string $name
 * @property array  $status
 * @property bool   $online
 */
class Device extends Model
{
    protected $fillable = [
        'id', 'name', 'status', 'online'
    ];

    protected $casts = [
        'status' => 'array',
    ];
}
