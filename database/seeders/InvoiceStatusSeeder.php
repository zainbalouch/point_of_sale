<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\InvoiceStatus;

class InvoiceStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'name_en' => 'Draft',
                'name_ar' => 'مسودة',
                'color' => '#718096', // Gray
            ],
            [
                'name_en' => 'Sent',
                'name_ar' => 'تم الإرسال',
                'color' => '#4299e1', // Blue
            ],
            [
                'name_en' => 'Paid',
                'name_ar' => 'مدفوع',
                'color' => '#48bb78', // Green
            ],
            [
                'name_en' => 'Overdue',
                'name_ar' => 'متأخر',
                'color' => '#ed8936', // Orange
            ],
            [
                'name_en' => 'Cancelled',
                'name_ar' => 'ملغى',
                'color' => '#e53e3e', // Red
            ],
            [
                'name_en' => 'Refunded',
                'name_ar' => 'مسترجع',
                'color' => '#805ad5', // Purple
            ],
        ];

        foreach ($statuses as $status) {
            InvoiceStatus::firstOrCreate(
                ['name_en' => $status['name_en']],
                $status
            );
        }
    }
} 