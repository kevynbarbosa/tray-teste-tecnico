<?php

namespace App\Models;

use App\Enum\OfferImportStatus;
use App\Observers\OfferObserver;
use App\States\OfferCompletedState;
use App\States\OfferPendingCreateHubState;
use App\States\OfferPendingDetailsState;
use App\States\OfferPendingImagesState;
use App\States\OfferPendingPriceState;
use App\States\OfferState;
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

    private OfferState $state;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->initState();
    }

    private function initState(): void
    {
        $this->state = match ($this->status) {
            'PENDING_DETAILS'      => new OfferPendingDetailsState($this),
            'ERROR_DETAILS'        => new OfferPendingDetailsState($this),

            'PENDING_IMAGES'       => new OfferPendingImagesState($this),
            'ERROR_IMAGES'         => new OfferPendingImagesState($this),

            'PENDING_PRICE'        => new OfferPendingPriceState($this),
            'ERROR_PRICE'          => new OfferPendingPriceState($this),

            'PENDING_CREATE_HUB'   => new OfferPendingCreateHubState($this),
            'ERROR_CREATE_HUB'     => new OfferPendingCreateHubState($this),

            'COMPLETED'            => new OfferCompletedState($this),

            default             => new OfferPendingDetailsState($this)
        };
    }

    public function setState(OfferState $state): void
    {
        $this->state = $state;
    }

    public function executeState(): bool
    {
        return $this->state->execute();
    }
}
