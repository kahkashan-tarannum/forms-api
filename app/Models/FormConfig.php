<?php

namespace App\Models;

use App\Models\Traits\DateFormattingTrait;
use Illuminate\Database\Eloquent\Model;

class FormConfig extends Model
{
    use DateFormattingTrait;

    protected $table = 'form_config';

    protected $fillable = [
        'form_config_id',
        'version',
        'config',
        'is_active',
        'form_id',
        'created_at',
        'updated_at'
    ];
}