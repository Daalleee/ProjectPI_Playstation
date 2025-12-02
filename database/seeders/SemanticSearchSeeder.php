<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;
use App\Models\UnitPS;
use App\Models\Accessory;

class SemanticSearchSeeder extends Seeder
{
    public function run(): void
    {
        // Games Keywords
        $gameKeywords = [
            'FIFA' => 'bola, soccer, football, olahraga, sport, messi, ronaldo, lapangan',
            'God of War' => 'kratos, action, adventure, petualangan, dewa, mitologi, perang',
            'The Last of Us' => 'zombie, survival, adventure, ellie, joel, post apocalyptic, seram',
            'Spider-Man' => 'hero, superhero, marvel, action, laba-laba, peter parker, miles morales',
            'Uncharted' => 'adventure, petualangan, nathan drake, harta karun, treasure',
            'Horizon' => 'aloy, robot, dinosaurus, open world, adventure, panah',
            'Gran Turismo' => 'mobil, balap, racing, car, sirkuit, driving',
            'Resident Evil' => 'horror, zombie, seram, hantu, survival, umbrella',
            'Ghost of Tsushima' => 'samurai, jepang, pedang, action, ninja, katana',
            'Ratchet' => 'kartun, adventure, action, robot, space, luar angkasa',
            'Call of Duty' => 'tembak, shooter, fps, perang, war, tentara, gun',
            'Assassins Creed' => 'viking, sejarah, action, stealth, pedang, valhalla',
        ];

        foreach ($gameKeywords as $key => $keywords) {
            Game::where('judul', 'like', '%' . $key . '%')
                ->update(['keywords' => $keywords]);
        }

        // Unit PS Keywords
        $unitKeywords = [
            'PS3' => 'playstation 3, console, konsol, game, murah, lama, old',
            'PS4' => 'playstation 4, console, konsol, game, sony, dualshock',
            'PS5' => 'playstation 5, console, konsol, game, sony, dualsense, next gen, baru, canggih',
        ];

        foreach ($unitKeywords as $key => $keywords) {
            UnitPS::where('model', 'like', '%' . $key . '%')
                ->orWhere('nama', 'like', '%' . $key . '%')
                ->update(['keywords' => $keywords]);
        }

        // Accessory Keywords
        $accessoryKeywords = [
            'DualSense' => 'stik, stick, controller, gamepad, ps5, wireless, getar',
            'DualShock' => 'stik, stick, controller, gamepad, ps4, wireless, getar',
            'Headset' => 'audio, suara, headphone, mic, gaming, telinga, dengar',
            'Charging' => 'cas, charger, baterai, isi ulang, dock, station',
            'VR' => 'virtual reality, kacamata, 3d, game nyata, headset vr',
            'Camera' => 'kamera, video, stream, rekam, foto',
            'Remote' => 'remot, kontrol, media, tv, netflix, youtube',
            'Wheel' => 'setir, stir, mobil, balap, racing, pedal',
            'Move' => 'motion, gerak, stik vr, tongkat',
        ];

        foreach ($accessoryKeywords as $key => $keywords) {
            Accessory::where('nama', 'like', '%' . $key . '%')
                ->update(['keywords' => $keywords]);
        }
    }
}
