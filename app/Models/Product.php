<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\GenerateUniqueSlugTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;
use stdClass;

class Product extends Model
{
    use HasFactory, Searchable, GenerateUniqueSlugTrait, Filterable;

    protected $table = 'products';
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'sku',
        'description',
        'specification',
        'color',
        'main_img',
        'alt_img',
        'price',
        'stock',
        'discount',
        'rating'
    ];
    protected array $likeFilterFields = [
        'name',
        'sku',
        'description',
        'specification'
    ];
    protected array $betweenFilterFields = [
        'price',
        'stock',
        'discount',
        'rating'
    ];
    protected array $specificBetweenFilterFields = [
        'height',
        'width',
        'length',
        'weight'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'alt_img' => 'array',
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray(): array
    {
        $array = $this->toArray();

        $array2 = [
            'categories' => $this->categories->pluck('name')->toArray(),
        ];

        return array_merge($array, $array2);
    }

    /**
     * The category that belong to the Product
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * The orders that belong to the Product
     *
     * @return BelongsToMany
     */
    public function orders(): BelongsToMany {
        return $this->belongsToMany(Order::class);
    }

    /**
     * Get the maximum and minimum dimensions of all products
     *
     * @return stdClass
     */
    public static function getMaxMinDimensions($category = null): stdClass
    {
        if (is_null($category)) {
            $categories = Category::all();
            $categoryIds = $categories->pluck('id')->toArray();
            return DB::table('products')
                ->whereIn('category_id', $categoryIds)
                ->select(DB::raw('
                MAX(CAST(json_extract(specification, "$.height") AS INTEGER)) as max_height,
                MIN(CAST(json_extract(specification, "$.height") AS INTEGER)) as min_height,
                MAX(CAST(json_extract(specification, "$.width") AS INTEGER)) as max_width,
                MIN(CAST(json_extract(specification, "$.width") AS INTEGER)) as min_width,
                MAX(CAST(json_extract(specification, "$.length") AS INTEGER)) as max_length,
                MIN(CAST(json_extract(specification, "$.length") AS INTEGER)) as min_length
            '))->first();
        }

        if ($category->children->count() > 0) {
            $categoryIds = $category->children->pluck('id')->toArray();
            return DB::table('products')
                ->whereIn('category_id', $categoryIds)
                ->select(DB::raw('
                MAX(CAST(json_extract(specification, "$.height") AS INTEGER)) as max_height,
                MIN(CAST(json_extract(specification, "$.height") AS INTEGER)) as min_height,
                MAX(CAST(json_extract(specification, "$.width") AS INTEGER)) as max_width,
                MIN(CAST(json_extract(specification, "$.width") AS INTEGER)) as min_width,
                MAX(CAST(json_extract(specification, "$.length") AS INTEGER)) as max_length,
                MIN(CAST(json_extract(specification, "$.length") AS INTEGER)) as min_length
            '))->first();
        }

        return DB::table('products')
            ->where('category_id', $category->id)
            ->select(DB::raw('
            MAX(CAST(json_extract(specification, "$.height") AS INTEGER)) as max_height,
            MIN(CAST(json_extract(specification, "$.height") AS INTEGER)) as min_height,
            MAX(CAST(json_extract(specification, "$.width") AS INTEGER)) as max_width,
            MIN(CAST(json_extract(specification, "$.width") AS INTEGER)) as min_width,
            MAX(CAST(json_extract(specification, "$.length") AS INTEGER)) as max_length,
            MIN(CAST(json_extract(specification, "$.length") AS INTEGER)) as min_length
        '))->first();
    }

    /**
     * Get the maximum and minimum price of all products
     *
     * @param $category
     * @return stdClass
     */
    public static function getMaxMinPrice($category = null): stdClass
    {
        if (is_null($category)) {
            $categories = Category::all();
            $categoryIds = $categories->pluck('id')->toArray();
            return DB::table('products')
                ->whereIn('category_id', $categoryIds)
                ->select(DB::raw('
            MIN(CASE 
                WHEN discount > 0 
                THEN price * (1-discount) 
                ELSE price 
            END) as min_price,
            MAX(price) as max_price
        '))->first();
        }

        if ($category->children->count() > 0) {
            $categoryIds = $category->children->pluck('id')->toArray();
            return DB::table('products')
                ->whereIn('category_id', $categoryIds)
                ->select(DB::raw('
            MIN(CASE 
                WHEN discount > 0 
                THEN price * (1-discount) 
                ELSE price 
            END) as min_price,
            MAX(price) as max_price
        '))->first();
        }

        return DB::table('products')
            ->where('category_id', $category->id)
            ->select(DB::raw('
            MIN(CASE 
                WHEN discount > 0 
                THEN price * (1-discount) 
                ELSE price 
            END) as min_price,
            MAX(price) as max_price
        '))->first();
    }

    public static function getColors($category = null): Collection
    {
        if (is_null($category)) {
            $categories = Category::all();
            $categoryIds = $categories->pluck('id')->toArray();
            return DB::table('products')
                ->whereIn('category_id', $categoryIds)
                ->distinct()
                ->pluck('color');
        }

        if ($category->children->count() > 0) {
            $categoryIds = $category->children->pluck('id')->toArray();
            return DB::table('products')
                ->whereIn('category_id', $categoryIds)
                ->distinct()
                ->pluck('color');
        }

        return DB::table('products')
            ->where('category_id', $category->id)
            ->distinct()
            ->pluck('color');
    }

    public function isInCart(): bool {
        $cart = \Cart::session(1);
        if ($cart) {
            if ($cart->get($this->id)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function isInWishlist(): bool {
        $wishlist = \Cart::session(2);
        if ($wishlist) {
            if ($wishlist->get($this->id)) {
                return true;
            } else {
                return false;
            }
        }
    }
}
