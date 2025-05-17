<?php

namespace App\Enum;

enum OfferImportStatus
{
    case PENDING_DETAILS;
    case ERROR_DETAILS;
    case PENDING_IMAGES;
    case ERROR_IMAGES;
    case PENDING_PRICE;
    case ERROR_PRICE;
    case PENDING_CREATE_HUB;
    case ERROR_CREATE_HUB;
    case COMPLETED;

    public function getStatus(): string
    {
        return match ($this) {
            self::PENDING_DETAILS => 'PENDING_DETAILS',
            self::ERROR_DETAILS => 'ERROR_DETAILS',
            self::PENDING_IMAGES => 'PENDING_IMAGES',
            self::ERROR_IMAGES => 'ERROR_IMAGES',
            self::PENDING_PRICE => 'PENDING_PRICE',
            self::ERROR_PRICE => 'ERROR_PRICE',
            self::PENDING_CREATE_HUB => 'PENDING_CREATE_HUB',
            self::ERROR_CREATE_HUB => 'ERROR_CREATE_HUB',
            self::COMPLETED => 'COMPLETED',
        };
    }
}
