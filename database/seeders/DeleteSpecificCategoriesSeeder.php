<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Category\Entities\Category;
use Modules\Category\Entities\CategoryTranslation;
use Illuminate\Support\Facades\DB;

class DeleteSpecificCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🗑️  Starting deletion of specific categories...');
        
        // Categories to delete (in Arabic and English)
        $categoriesToDelete = [
            'الأجهزة المنزلية',
            'البرمجة',
            'نمط الأعمال',
            'الإلكترونيات',
            'Home Appliances',
            'Programming',
            'Business Pattern',
            'Electronics',
        ];
        
        // Find all category translations that match these names
        $translationsToDelete = CategoryTranslation::whereIn('name', $categoriesToDelete)->get();
        
        if ($translationsToDelete->isEmpty()) {
            $this->command->warn('⚠️  No categories found with the specified names.');
            return;
        }
        
        // Get unique category IDs
        $categoryIds = $translationsToDelete->pluck('category_id')->unique();
        
        $this->command->info('📋 Found ' . $categoryIds->count() . ' category/categories to delete.');
        
        // Delete category translations first
        $deletedTranslations = CategoryTranslation::whereIn('category_id', $categoryIds)->delete();
        $this->command->info('✅ Deleted ' . $deletedTranslations . ' category translation(s).');
        
        // Delete categories
        $deletedCategories = Category::whereIn('id', $categoryIds)->delete();
        $this->command->info('✅ Deleted ' . $deletedCategories . ' category/categories.');
        
        $this->command->info('✅ Specific categories deletion completed!');
    }
}
