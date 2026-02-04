<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Frontend;

class UpdateSidebarCTASeeder extends Seeder
{
    /**
     * Update the Sidebar CTA section with Arabic translation and new contact link.
     * 
     * This updates the "Don't hesitate to contact" section to Arabic
     * and changes the button link to https://www.barmagly.tech/contact-us
     */
    public function run(): void
    {
        $this->command->info('🚀 Updating Sidebar CTA section...');
        
        // Find the sidebar CTA section
        $sidebarCTA = Frontend::where('data_keys', 'main_demo_sidebar_cta_section.content')->first();
        
        if ($sidebarCTA) {
            // Get the raw data_values and decode if it's a string
            $dataValues = $sidebarCTA->getAttributes()['data_values'] ?? '{}';
            if (is_string($dataValues)) {
                $dataValues = json_decode($dataValues, true) ?? [];
            }
            
            // Update with Arabic translations and new link
            $dataValues['heading'] = 'لا تتردد في التواصل معنا';
            $dataValues['description'] = 'في برمجلي، نحن ملتزمون بتقديم خدمات استثنائية';
            $dataValues['button_text'] = 'تواصل معنا';
            $dataValues['button_link'] = 'https://www.barmagly.tech/contact-us';
            
            // Save the updated values
            $sidebarCTA->data_values = json_encode($dataValues);
            $sidebarCTA->save();
            
            $this->command->info('✅ Sidebar CTA section updated successfully!');
            $this->command->info('   Heading: لا تتردد في التواصل معنا');
            $this->command->info('   Description: في برمجلي، نحن ملتزمون بتقديم خدمات استثنائية');
            $this->command->info('   Button Text: تواصل معنا');
            $this->command->info('   Button Link: https://www.barmagly.tech/contact-us');
        } else {
            // Create new record if it doesn't exist
            $newSidebarCTA = new Frontend();
            $newSidebarCTA->data_keys = 'main_demo_sidebar_cta_section.content';
            $newSidebarCTA->data_values = json_encode([
                'heading' => 'لا تتردد في التواصل معنا',
                'description' => 'في برمجلي، نحن ملتزمون بتقديم خدمات استثنائية',
                'button_text' => 'تواصل معنا',
                'button_link' => 'https://www.barmagly.tech/contact-us',
            ]);
            $newSidebarCTA->save();
            
            $this->command->info('✅ Sidebar CTA section created successfully!');
        }
    }
}
