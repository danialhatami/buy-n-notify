<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Transaction
 *
 * @property int $id
 * @property string $amount
 * @property string $model_type
 * @property int $model_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\TransactionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
 * @property int $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUserId($value)
 * @property-read \App\Models\User $User
 * @property-read Model|\Eloquent $model
 * @mixin \Eloquent
 */
class Transaction extends Model
{
    use HasFactory;

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
