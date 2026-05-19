<?php

namespace App\Services;

use Stevebauman\Location\Facades\Location;

class GeoIPService
{

    private function resolve(string $ip): ?\Stevebauman\Location\Position
    {
        try {
            return Location::get($ip) ?: null;
        } catch (\Exception) {
            return null;
        }
    }

    public function getCountryCode(string $ip): ?string
    {
        return $this->resolve($ip)?->countryCode;
    }

    public function getCountryName(string $ip): ?string
    {
        return $this->resolve($ip)?->countryName;
    }

    public function getCoordinates(string $ip): ?array
    {
        $position = $this->resolve($ip);

        if (!$position || $position->latitude === null || $position->longitude === null) {
            return null;
        }

        return ['lat' => $position->latitude, 'lng' => $position->longitude];
    }

    public function getFlagImagePath(string $countryCode): string
    {
        return '/hlstatsimg/flags/' . strtolower($countryCode) . '.gif';
    }
}
