<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductUser
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProductUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductUser whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductUser whereUserId($value)
 * @mixin \Eloquent
 */
class ProductUser extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
}
