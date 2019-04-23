<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Device
 * @package App\Models
 *
 * @property int    $id
 * @property string $name
 * @property string $type
 * @property array  $status
 * @property bool   $online
 * @property string $ip
 */
class Device extends Model
{
    protected $fillable = [
        'id', 'name', 'status', 'online', 'ip'
    ];

    protected $casts = [
        'status' => 'array',
    ];

    public function updateStatus($status)
    {
        $ip = env('CONTROL_CENTER', '127.0.0.1');
        $id = $this->id;
        if ($this->type === 'power' && isset($status['power'])) {
            $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
            $message = $status['power'] ? "control|$id|on" : "control|$id|off";
            socket_sendto($socket, $message, strlen($message), 0, $ip, 9527);
        }
    }
}
