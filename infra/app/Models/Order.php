<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends BaseModel
{

    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'user_id',
        'destiny',
        'departure_date',
        'return_date',
        'status_order',
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'departure_date' => 'date:Y-m-d',
        'return_date' => 'date:Y-m-d',
    ];
}
