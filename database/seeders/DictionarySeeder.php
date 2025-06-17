<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dictionary;
use Illuminate\Support\Facades\File;

class DictionarySeeder extends Seeder
{
    public function run()
    {
        $path = database_path('seeders/data/dictionaries');

        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
            $this->command->info("Created directory: {$path}");
            return;
        }

        $files = File::files($path);

        if (empty($files)) {
            $this->command->warn("No JSON files found in {$path}");
            return;
        }

        foreach ($files as $file) {
            if ($file->getExtension() !== 'json') continue;

            $this->command->info("Processing: {$file->getFilename()}");

            try {
                $data = json_decode(file_get_contents($file->getPathname()), true, 512, JSON_THROW_ON_ERROR);

                foreach ($data as $entry) {
                    // Map JSON keys to database columns
                    $mappedData = [
                        'type' => $entry['Type'] ?? null,
                        'attribute' => $entry['Attribute'] ?? null,
                        'value' => $entry['Value'] ?? null,
                        'format' => $entry['Format'] ?? null,
                        'vendor' => $entry['Vendor'] ?? null,
                        'recommended_OP' => $entry['RecommendedOP'] ?? null,
                        'recommended_table' => $entry['RecommendedTable'] ?? null,
                        'recommended_helper' => $entry['RecommendedHelper'] ?? null,
                        'recommended_tooltip' => $entry['RecommendedTooltip'] ?? null,
                    ];

                    // Use firstOrCreate to avoid duplicates
                    Dictionary::firstOrCreate(
                        [
                            'attribute' => $mappedData['attribute'],
                            'value' => $mappedData['value'],
                            'vendor' => $mappedData['vendor']
                        ],
                        $mappedData
                    );
                }

                $this->command->info("Imported: " . count($data) . " records");
            } catch (\Exception $e) {
                $this->command->error("Error processing {$file->getFilename()}: " . $e->getMessage());
            }
        }
    }
}
