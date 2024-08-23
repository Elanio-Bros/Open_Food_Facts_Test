<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $collection = 'products';

    const CREATED_AT = null;
    const UPDATED_AT = 'imported_t';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "code",
        "status",
        "imported_t",
        "url",
        "creator",
        "created_t",
        "last_modified_t",
        "product_name",
        "quantity",
        "brands",
        "categories",
        "labels",
        "cities",
        "purchase_places",
        "ingredients_text",
        "traces",
        "serving_size",
        "serving_quantity",
        "nutriscore_score",
        "nutriscore_grade",
        "main_category",
        "image_url",
    ];

    /**
     * The attributes that are hiden.
     *
     * @var array<int, string>
     */
    protected $hidden = ['_id'];
}
