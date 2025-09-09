<?php

namespace Companue\Contacts\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = database_path('seeders/contact_types.json');
        if (!file_exists($jsonPath)) {
            throw new \Exception("Seed file not found: " . $jsonPath);
        }

        $data = json_decode(file_get_contents($jsonPath), true);
        if (!is_array($data)) {
            throw new \Exception("Invalid JSON format in: " . $jsonPath);
        }

        // Add timestamps if not present and avoid duplicates
        $now = now();
        foreach ($data as $item) {
            if (!isset($item['created_at'])) $item['created_at'] = $now;
            if (!isset($item['updated_at'])) $item['updated_at'] = $now;

            // Build the match array for updateOrInsert
            $match = [];
            if (isset($item['slug'])) {
                $match['slug'] = $item['slug'];
            }
            if (isset($item['title'])) {
                $match['title'] = $item['title'];
            }
            if (empty($match)) {
                // Fallback to name if neither slug nor title exists
                $match['name'] = $item['name'] ?? null;
            }

            DB::table('contact_types')->updateOrInsert(
                $match,
                $item
            );
        }
    }
}
