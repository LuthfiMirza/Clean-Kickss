<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Service;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BookingStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', Booking::STATUS_PENDING)->count();
        $completedBookings = Booking::where('status', Booking::STATUS_DELIVERED)->count();
        $totalCustomers = Customer::count();
        $totalServices = Service::where('is_active', true)->count();
        $totalRevenue = Booking::where('payment_status', Booking::PAYMENT_PAID)->sum('total_price');

        return [
            Stat::make('Total Booking', $totalBookings)
                ->description('Total semua booking')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('primary'),
            
            Stat::make('Booking Pending', $pendingBookings)
                ->description('Menunggu konfirmasi')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
            
            Stat::make('Booking Selesai', $completedBookings)
                ->description('Sudah diantar')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            
            Stat::make('Total Pelanggan', $totalCustomers)
                ->description('Pelanggan terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),
            
            Stat::make('Layanan Aktif', $totalServices)
                ->description('Layanan tersedia')
                ->descriptionIcon('heroicon-m-wrench-screwdriver')
                ->color('secondary'),
            
            Stat::make('Total Pendapatan', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('Dari pembayaran lunas')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
        ];
    }
}