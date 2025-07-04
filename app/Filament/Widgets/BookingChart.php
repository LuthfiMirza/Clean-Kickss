<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class BookingChart extends ChartWidget
{
    protected static ?string $heading = 'Booking per Bulan';

    protected function getData(): array
    {
        // Get booking data for the last 6 months
        $data = Booking::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', now()->subMonths(6))
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get();

        $labels = [];
        $values = [];
        
        // Generate labels for last 6 months
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthYear = $date->format('M Y');
            $labels[] = $monthYear;
            
            // Find data for this month
            $monthData = $data->where('month', $date->month)
                            ->where('year', $date->year)
                            ->first();
            
            $values[] = $monthData ? $monthData->count : 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Booking',
                    'data' => $values,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'borderWidth' => 2,
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}