<?php

namespace Companue\Contacts\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = database_path('seeders/contact_categories.json');
        if (file_exists($jsonPath)) {
            $data = json_decode(file_get_contents($jsonPath), true);
            if (!is_array($data)) {
                throw new \Exception("Invalid JSON format in: " . $jsonPath);
            }
        } else {
            // Default categories if JSON file does not exist
            $data = [
                [
                    'slug' => 'legal',
                    'title' => 'Legal',
                ],
                [
                    'slug' => 'real',
                    'title' => 'Real',
                ],
            ];
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
            if (empty($match)) {
                $match['name'] = $item['name'] ?? null;
            }

            DB::table('contact_categories')->updateOrInsert(
                $match,
                $item
            );
        }
    }
}
