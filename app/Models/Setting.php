<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    // Specify the table if not following Laravel's naming convention
    protected $table = 'settings';

    // Define the fillable attributes
    protected $fillable = [
        'type',
        'key',
        'value',
        'is_enabled',
    ];

    // Define the cast attributes for proper data types
    protected $casts = [
        'is_enabled' => 'boolean', // Automatically cast to boolean
        'value' => 'string', // Ensure value is treated as string
    ];

    /**
     * Get the setting value as an array.
     *
     * @return array
     */
    public function getSettingValue()
    {
        return [
            'type' => $this->type,
            'key' => $this->key,
            'value' => $this->value,
            'is_enabled' => $this->is_enabled,
        ];
    }
}
