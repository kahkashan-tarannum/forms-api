<?php

namespace App\Models;

use App\Models\Traits\DateFormattingTrait;
use Illuminate\Database\Eloquent\Model;

class FormData extends Model
{
    use DateFormattingTrait;

    protected $table = 'form_data';

    protected $fillable = [
        'form_data_id',
        'form_config_id',
        'data_blob',
        'form_id',
        'created_at',
        'updated_at'
    ];
}