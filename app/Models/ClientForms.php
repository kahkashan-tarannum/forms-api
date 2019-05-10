<?php

namespace App\Models;

use App\Models\Traits\DateFormattingTrait;
use Illuminate\Database\Eloquent\Model;

class ClientForms extends Model
{
    use DateFormattingTrait;

    protected $table = 'client_forms';

    protected $fillable = [
        'client_forms_id',
        'client_id',
        'form_id',
        'created_at',
        'updated_at'
    ];
}