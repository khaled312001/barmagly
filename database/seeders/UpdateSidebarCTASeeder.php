<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Frontend;
use Illuminate\Support\Facades\DB;

class UpdateSidebarCTASeeder extends Seeder
{
    /**
     * Update the Sidebar CTA section with Arabic translation and new contact link.
     */
    public function run(): void
    {
        $this->command->info('🚀 Updating Sidebar CTA section...');
        
        // Find the sidebar CTA section
        $sidebarCTA = Frontend::where('data_keys', 'main_demo_sidebar_cta_section.content')->first();
        
        if ($sidebarCTA) {
            // Get the raw value directly from database
            $rawValue = DB::table('frontends')
                ->where('id', $sidebarCTA->id)
                ->value('data_values');
            
            $this->command->info('Raw value type: ' . gettype($rawValue));
            
            // Try to decode - handle multiple levels of encoding
            $dataValues = $rawValue;
            
            // Keep decoding until we get an array
            $maxAttempts = 3;
            $attempts = 0;
            while (is_string($dataValues) && $attempts < $maxAttempts) {
                $decoded = json_decode($dataValues, true);
                if ($decoded !== null) {
                    $dataValues = $decoded;
                } else {
                    break;
                }
                $attempts++;
            }
            
            // If still not an array, create a new one
            if (!is_array($dataValues)) {
                $this->command->warn('Could not decode existing data, creating new structure');
                $dataValues = [];
            }
            
            // Update with Arabic translations and new link
            $dataValues['heading'] = 'لا تتردد في التواصل معنا';
            $dataValues['description'] = 'في برمجلي، نحن ملتزمون بتقديم خدمات استثنائية';
            $dataValues['button_text'] = 'تواصل معنا';
            $dataValues['button_link'] = 'https://www.barmagly.tech/contact-us';
            
            // Update directly in database
            DB::table('frontends')
                ->where('id', $sidebarCTA->id)
                ->update(['data_values' => json_encode($dataValues)]);
            
            $this->command->info('✅ Sidebar CTA section updated successfully!');
            $this->command->info('   Heading: لا تتردد في التواصل معنا');
            $this->command->info('   Button Link: https://www.barmagly.tech/contact-us');
        } else {
            // Create new record if it doesn't exist
            DB::table('frontends')->insert([
                'data_keys' => 'main_demo_sidebar_cta_section.content',
                'data_values' => json_encode([
                    'heading' => 'لا تتردد في التواصل معنا',
                    'description' => 'في برمجلي، نحن ملتزمون بتقديم خدمات استثنائية',
                    'button_text' => 'تواصل معنا',
                    'button_link' => 'https://www.barmagly.tech/contact-us',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            $this->command->info('✅ Sidebar CTA section created successfully!');
        }
    }
}
