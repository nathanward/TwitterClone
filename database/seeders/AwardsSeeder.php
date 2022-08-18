<?php

namespace Database\Seeders;

use DirectoryIterator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use ReflectionClass;
use App\Models\Awards;

class AwardsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $iterator = new DirectoryIterator(app_path('Awards'));

        foreach ($iterator as $file) {
            if ($file->isDot()) {
                continue;
            }

            $file = 'App\\Awards\\' . str_replace('.php', '', $file->getFilename());

            $class = new ReflectionClass($file);

            if ($class->isAbstract()) {
                continue;
            }

            Awards::factory()->create([
                'id' => app($file)->getId(),
                'name' => app($file)->getName(),
                'description' => app($file)->getDescription(),
            ]);
        }
    }
}
