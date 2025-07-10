<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Filament\Resources\BookingResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewBooking extends ViewRecord
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            
            // Payment Proof Action
            Actions\Action::make('viewPaymentProof')
                ->label('Lihat Bukti Pembayaran')
                ->icon('heroicon-o-photo')
                ->color('info')
                ->visible(fn () => !empty($this->record->payment_proof))
                ->modalHeading('Bukti Pembayaran - Booking #' . $this->record->id)
                ->modalContent(fn () => view('filament.modals.payment-proof', [
                    'booking' => $this->record,
                    'imageUrl' => $this->record->payment_proof_url
                ]))
                ->modalWidth('3xl')
                ->modalSubmitAction(false)
                ->modalCancelActionLabel('Tutup'),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Informasi Booking')
                    ->schema([
                        Infolists\Components\TextEntry::make('id')
                            ->label('ID Booking')
                            ->badge()
                            ->color('primary'),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Tanggal Dibuat')
                            ->dateTime('d F Y, H:i'),
                        Infolists\Components\TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'pending' => 'warning',
                                'confirmed' => 'info',
                                'picked_up' => 'primary',
                                'in_progress' => 'gray',
                                'ready' => 'success',
                                'delivered' => 'success',
                                'cancelled' => 'danger',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn (string $state): string => $this->record->status_label),
                    ])
                    ->columns(3),

                Infolists\Components\Section::make('Informasi Pelanggan')
                    ->schema([
                        Infolists\Components\TextEntry::make('customer.name')
                            ->label('Nama Pelanggan'),
                        Infolists\Components\TextEntry::make('customer.phone')
                            ->label('Nomor Telepon')
                            ->icon('heroicon-o-phone'),
                        Infolists\Components\TextEntry::make('customer.email')
                            ->label('Email')
                            ->icon('heroicon-o-envelope')
                            ->placeholder('Tidak ada email'),
                        Infolists\Components\TextEntry::make('customer.address')
                            ->label('Alamat')
                            ->icon('heroicon-o-map-pin')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Detail Layanan')
                    ->schema([
                        Infolists\Components\TextEntry::make('service.name')
                            ->label('Layanan'),
                        Infolists\Components\TextEntry::make('service.description')
                            ->label('Deskripsi')
                            ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('service.duration_minutes')
                            ->label('Durasi')
                            ->suffix(' menit'),
                        Infolists\Components\TextEntry::make('total_price')
                            ->label('Harga')
                            ->money('IDR'),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Jadwal')
                    ->schema([
                        Infolists\Components\TextEntry::make('booking_date')
                            ->label('Tanggal Booking')
                            ->date('d F Y'),
                        Infolists\Components\TextEntry::make('pickup_time')
                            ->label('Waktu Pickup')
                            ->dateTime('d F Y, H:i'),
                        Infolists\Components\TextEntry::make('delivery_time')
                            ->label('Waktu Delivery')
                            ->dateTime('d F Y, H:i')
                            ->placeholder('Akan diambil sendiri'),
                    ])
                    ->columns(3),

                Infolists\Components\Section::make('Pembayaran')
                    ->schema([
                        Infolists\Components\TextEntry::make('payment_method')
                            ->label('Metode Pembayaran')
                            ->formatStateUsing(fn (string $state): string => $this->record->payment_method_label),
                        Infolists\Components\TextEntry::make('payment_status')
                            ->label('Status Pembayaran')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'pending' => 'warning',
                                'paid' => 'success',
                                'refunded' => 'danger',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn (string $state): string => $this->record->payment_status_label),
                        Infolists\Components\ImageEntry::make('payment_proof')
                            ->label('Bukti Pembayaran')
                            ->disk('public')
                            ->height(200)
                            ->width(300)
                            ->placeholder('Belum ada bukti pembayaran')
                            ->visible(fn () => !empty($this->record->payment_proof)),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Catatan')
                    ->schema([
                        Infolists\Components\TextEntry::make('notes')
                            ->label('Catatan Khusus')
                            ->placeholder('Tidak ada catatan')
                            ->columnSpanFull(),
                    ])
                    ->visible(fn () => !empty($this->record->notes)),
            ]);
    }
}