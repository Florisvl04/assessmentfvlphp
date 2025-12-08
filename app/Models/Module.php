<?php

namespace App\Models;

use App\Enums\ModuleCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'category',
        'price',
        'required_time',
        'image_path',
        'specifications',
    ];

    protected function casts(): array
    {
        return [
            'category' => ModuleCategory::class, // Automatically converts string to Enum
            'specifications' => 'array',         // Automatically converts JSON to Array
        ];
    }
}
