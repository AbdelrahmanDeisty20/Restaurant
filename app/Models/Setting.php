<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
    ];
    public function getValueAttribute($value)
    {
        if ($this->type == 'image') {
            return asset('storage/settings/' . $value);
        }
        return $value;
    }
    public function setValueAttribute($value)
    {
        if ($this->type == 'image') {
            $this->attributes['value'] = $value;
        } else {
            $this->attributes['value'] = $value;
        }
    }
}
