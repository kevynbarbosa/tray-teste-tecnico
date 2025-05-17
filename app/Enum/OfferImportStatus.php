<?php

namespace App\Enum;

enum OfferImportStatus
{
    case PENDING_DETAILS;
    case PENDING_IMAGES;
    case PENDING_PRICE;
    case PENDING_CREATE_HUB;
    case COMPLETED;

    public function getStatus(): string
    {
        return match ($this) {
            self::PENDING_DETAILS => 'PENDING DETAILS',
            self::PENDING_IMAGES => 'PENDING_IMAGES',
            self::PENDING_PRICE => 'PENDING_PRICE',
            self::PENDING_CREATE_HUB => 'PENDING_CREATE_HUB',
            self::COMPLETED => 'COMPLETED',
        };
    }
}
