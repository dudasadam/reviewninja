<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Main extends Model
{
    public static function homepage(): array
    {
        return [
            'brand' => 'ReviewNinja',
            'title' => 'Kezeld egy helyen az online értékeléseidet',
            'subtitle' => 'Google, Facebook és egyéb csatornák véleményei egy modern dashboardon.',
            'cta_primary' => 'Kezdjük el',
            'cta_secondary' => 'Demó megtekintése',
            'stats' => [
                ['label' => 'Integráció', 'value' => '12+'],
                ['label' => 'Átlagos válaszidő javulás', 'value' => '42%'],
                ['label' => 'Kezelt review / hó', 'value' => '15k+'],
            ],
        ];
    }
}
