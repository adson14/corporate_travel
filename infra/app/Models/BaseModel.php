<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BaseModel extends Model
{

    public $incrementing = false;

    protected $keyType = 'string';

    protected $perPage = 10;

    public static function itemsPerPage() : int
    {
        $model = new BaseModel();
        return $model->perPage;
    }
    protected static function boot()
    {
        parent::boot();
        if(!\Illuminate\Support\Facades\App::runningInConsole()){
            static::addGlobalScope('user', function (Builder $builder) {
                if(empty(Auth::user())){
                    throw  new \Exception('User not authenticated'. $builder->getModel()::class);
                }
                if(in_array('user_id', $builder->getModel()->fillable) && !Auth::user()->isAdmin()) {
                    $builder->where($builder->getModel()->getTable() . '.user_id', Auth::user()->id);
                }
            });
        }

//        static::creating(function ($model) {
//
//        });
    }
}
