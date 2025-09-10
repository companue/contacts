<?php

namespace Companue\Contacts\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactTitleSeeder extends Seeder
{
    public function run(): void
    {

        $jsonPath = database_path('seeders/contact_titles.json');
        $packageJsonPath = __DIR__ . '/contact_titles.json';
        if (file_exists($jsonPath)) {
            $data = json_decode(file_get_contents($jsonPath), true);
            if (!is_array($data)) {
                throw new \Exception("Invalid JSON format in: " . $jsonPath);
            }
        } elseif (file_exists($packageJsonPath)) {
            $data = json_decode(file_get_contents($packageJsonPath), true);
            if (!is_array($data)) {
                throw new \Exception("Invalid JSON format in: " . $packageJsonPath);
            }
        } else {
            throw new \Exception("Seed file not found: $jsonPath or $packageJsonPath");
        }

        $now = now();
        foreach ($data as $item) {
            if (!isset($item['created_at'])) $item['created_at'] = $now;
            if (!isset($item['updated_at'])) $item['updated_at'] = $now;

            $match = [];
            if (isset($item['slug'])) {
                $match['slug'] = $item['slug'];
            }
            if (isset($item['title'])) {
                $match['title'] = $item['title'];
            }

            DB::table('contact_titles')->updateOrInsert(
                $match,
                $item
            );
        }
    }
}
