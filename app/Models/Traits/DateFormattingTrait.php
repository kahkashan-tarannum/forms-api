<?php

namespace App\Models\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

trait DateFormattingTrait
{
    
    protected $datetime_format = 'ISO-8601';

    protected function formatter($value)
    {
            $datetime_format = isset($this->datetime_format) ? $this->datetime_format : 'timestamp';

            switch ($datetime_format) {
                case 'ISO-8601':
                    return Carbon::parse($value)->toAtomString();
                case 'Carbon':
                    return new Carbon($value);
                case 'timestamp':
                    return Carbon::parse($value)->timestamp;
                default:
                    return Carbon::parse($value)->format($datetime_format);
            }
    }

    /**
     * Parse date value and add config timezone
     *
     * @param string $value
     * @return null|Carbon
     */
    protected function parseWithTimezone($value)
    {
        if (is_null($value)) {
            return null;
        }

        return Carbon::parse($value)->timezone(Config::get('app.timezone'));
    }

    public function getCreatedAtAttribute($value)
    {
        if (!isset($this->attributes['created_at'])) {
            return null;
        }

        return $this->formatter($value);
    }

    public function getUpdatedAtAttribute($value)
    {
        if (!isset($this->attributes['updated_at'])) {
            return null;
        }

        return $this->formatter($value);
    }

    public function setCreatedAtAttribute($value)
    {
        $this->attributes['created_at'] = $this->parseWithTimezone($value);
    }

    public function setUpdatedAtAttribute($value)
    {
        $this->attributes['updated_at'] = $this->parseWithTimezone($value);
    }
}