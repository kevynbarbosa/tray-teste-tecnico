<?php

namespace App\Models;

use App\Observers\OfferObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([OfferObserver::class])]
class Offer extends Model
{
    public $incrementing = false;

    protected $fillable = [
        'id',
        'title',
        'description',
        'price',
        'status',
        'stock',
        'workflow_status',
    ];
}
