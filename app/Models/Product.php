<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_name',
        'product_added_by',
        'status'
    ];

     /**
     * Generate UUID.
     *
     * @return uuid
     */
    public static function boot()
    {
        parent::boot();
        static::creating(
            function ($model) {
                $model->uuid = (string) Str::uuid();
                $model->product_added_by = auth()->user()->id;
            }
        );

        static::deleting(function ($model) {
            $model->categories()->detach();
        });
        
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'product_added_by');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
    }
    
}
