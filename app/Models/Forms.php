<?php

namespace App\Models;

use App\Models\Traits\DateFormattingTrait;
use Illuminate\Database\Eloquent\Model;

class Forms extends Model
{
    use DateFormattingTrait;

    protected $table = 'forms';

    protected $fillable = [
        'form_id',
        'title',
        'device_type',
        'form_type',
        'created_at',
        'updated_at'
    ];

    public function formData()
    {
        return $this->hasOne('App\Models\FormData', 'form_id');
    }

}