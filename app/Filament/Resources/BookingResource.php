<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationLabel = 'Booking';

    protected static ?string $modelLabel = 'Booking';

    protected static ?string $pluralModelLabel = 'Booking';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pelanggan')
                    ->schema([
                        Forms\Components\Select::make('customer_id')
                            ->label('Pelanggan')
                            ->relationship('customer', 'name')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nama')
                                    ->required(),
                                Forms\Components\TextInput::make('phone')
                                    ->label('No. Telepon')
                                    ->tel()
                                    ->required(),
                                Forms\Components\TextInput::make('email')
                                    ->label('Email')
                                    ->email(),
                                Forms\Components\Textarea::make('address')
                                    ->label('Alamat')
                                    ->rows(2),
                            ])
                            ->required(),
                    ]),

                Forms\Components\Section::make('Detail Booking')
                    ->schema([
                        Forms\Components\Select::make('service_id')
                            ->label('Layanan')
                            ->relationship('service', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $service = Service::find($state);
                                    if ($service) {
                                        $set('total_price', $service->price);
                                    }
                                }
                            }),
                        Forms\Components\DatePicker::make('booking_date')
                            ->label('Tanggal Booking')
                            ->required()
                            ->native(false),
                        Forms\Components\DateTimePicker::make('pickup_time')
                            ->label('Waktu Pickup')
                            ->required()
                            ->native(false),
                        Forms\Components\DateTimePicker::make('delivery_time')
                            ->label('Waktu Pengantaran')
                            ->native(false),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Status & Pembayaran')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                Booking::STATUS_PENDING => 'Menunggu Konfirmasi',
                                Booking::STATUS_CONFIRMED => 'Dikonfirmasi',
                                Booking::STATUS_PICKED_UP => 'Sudah Diambil',
                                Booking::STATUS_IN_PROGRESS => 'Sedang Dikerjakan',
                                Booking::STATUS_READY => 'Siap Diantar',
                                Booking::STATUS_DELIVERED => 'Sudah Diantar',
                                Booking::STATUS_CANCELLED => 'Dibatalkan',
                            ])
                            ->default(Booking::STATUS_PENDING)
                            ->required(),
                        Forms\Components\Select::make('payment_status')
                            ->label('Status Pembayaran')
                            ->options([
                                Booking::PAYMENT_PENDING => 'Belum Bayar',
                                Booking::PAYMENT_PAID => 'Sudah Bayar',
                                Booking::PAYMENT_REFUNDED => 'Dikembalikan',
                            ])
                            ->default(Booking::PAYMENT_PENDING)
                            ->required(),
                        Forms\Components\Select::make('payment_method')
                            ->label('Metode Pembayaran')
                            ->options([
                                'cash' => 'Tunai',
                                'transfer' => 'Transfer Bank',
                                'e_wallet' => 'E-Wallet',
                                'credit_card' => 'Kartu Kredit',
                            ]),
                        Forms\Components\TextInput::make('total_price')
                            ->label('Total Harga')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Bukti Pembayaran')
                    ->schema([
                        Forms\Components\FileUpload::make('payment_proof')
                            ->label('Bukti Pembayaran')
                            ->image()
                            ->directory('payment-proofs')
                            ->visibility('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                null,
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif'])
                            ->helperText('Upload bukti pembayaran (JPG, PNG, GIF - Max: 2MB)'),
                    ])
                    ->visible(fn (Forms\Get $get) => $get('payment_method') !== 'cash'),

                Forms\Components\Section::make('Catatan')
                    ->schema([
                        Forms\Components\Textarea::make('notes')
                            ->label('Catatan')
                            ->rows(3)
                            ->maxLength(1000),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Pelanggan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('service.name')
                    ->label('Layanan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('booking_date')
                    ->label('Tanggal')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('pickup_time')
                    ->label('Pickup')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        Booking::STATUS_PENDING => 'warning',
                        Booking::STATUS_CONFIRMED => 'info',
                        Booking::STATUS_PICKED_UP => 'primary',
                        Booking::STATUS_IN_PROGRESS => 'gray',
                        Booking::STATUS_READY => 'success',
                        Booking::STATUS_DELIVERED => 'success',
                        Booking::STATUS_CANCELLED => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        Booking::STATUS_PENDING => 'Menunggu',
                        Booking::STATUS_CONFIRMED => 'Dikonfirmasi',
                        Booking::STATUS_PICKED_UP => 'Diambil',
                        Booking::STATUS_IN_PROGRESS => 'Dikerjakan',
                        Booking::STATUS_READY => 'Siap',
                        Booking::STATUS_DELIVERED => 'Diantar',
                        Booking::STATUS_CANCELLED => 'Dibatalkan',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Pembayaran')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        Booking::PAYMENT_PENDING => 'warning',
                        Booking::PAYMENT_PAID => 'success',
                        Booking::PAYMENT_REFUNDED => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        Booking::PAYMENT_PENDING => 'Belum Bayar',
                        Booking::PAYMENT_PAID => 'Sudah Bayar',
                        Booking::PAYMENT_REFUNDED => 'Dikembalikan',
                        default => $state,
                    }),
                Tables\Columns\IconColumn::make('payment_proof')
                    ->label('Bukti Bayar')
                    ->boolean()
                    ->trueIcon('heroicon-o-photo')
                    ->falseIcon('heroicon-o-x-mark')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->tooltip(fn (Booking $record): string => 
                        $record->payment_proof ? 'Ada bukti pembayaran' : 'Belum ada bukti pembayaran'
                    ),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        Booking::STATUS_PENDING => 'Menunggu Konfirmasi',
                        Booking::STATUS_CONFIRMED => 'Dikonfirmasi',
                        Booking::STATUS_PICKED_UP => 'Sudah Diambil',
                        Booking::STATUS_IN_PROGRESS => 'Sedang Dikerjakan',
                        Booking::STATUS_READY => 'Siap Diantar',
                        Booking::STATUS_DELIVERED => 'Sudah Diantar',
                        Booking::STATUS_CANCELLED => 'Dibatalkan',
                    ]),
                Tables\Filters\SelectFilter::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        Booking::PAYMENT_PENDING => 'Belum Bayar',
                        Booking::PAYMENT_PAID => 'Sudah Bayar',
                        Booking::PAYMENT_REFUNDED => 'Dikembalikan',
                    ]),
                Tables\Filters\TernaryFilter::make('payment_proof')
                    ->label('Bukti Pembayaran')
                    ->placeholder('Semua')
                    ->trueLabel('Ada Bukti')
                    ->falseLabel('Belum Ada Bukti')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('payment_proof'),
                        false: fn (Builder $query) => $query->whereNull('payment_proof'),
                    ),
                Tables\Filters\Filter::make('booking_date')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('booking_date', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('booking_date', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
                ->label('Aksi')
                ->icon('heroicon-m-ellipsis-vertical')
                ->size('sm')
                ->color('gray'),
                
                // Payment Proof View Action
                Tables\Actions\Action::make('viewPaymentProof')
                    ->label('Lihat Bukti')
                    ->icon('heroicon-o-photo')
                    ->color('info')
                    ->size('sm')
                    ->visible(fn (Booking $record) => !empty($record->payment_proof))
                    ->modalHeading(fn (Booking $record) => 'Bukti Pembayaran - Booking #' . $record->id)
                    ->modalContent(fn (Booking $record) => view('filament.modals.payment-proof', [
                        'booking' => $record,
                        'imageUrl' => $record->payment_proof_url
                    ]))
                    ->modalWidth('3xl')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup'),
                
                // Quick Status Update Buttons
                Tables\Actions\Action::make('confirm')
                    ->label('Konfirmasi')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->size('sm')
                    ->visible(fn (Booking $record) => $record->status === Booking::STATUS_PENDING)
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Booking')
                    ->modalDescription('Apakah Anda yakin ingin mengkonfirmasi booking ini?')
                    ->action(function (Booking $record): void {
                        $record->update(['status' => Booking::STATUS_CONFIRMED]);
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Booking berhasil dikonfirmasi')
                            ->success()
                            ->send();
                    }),
                    
                Tables\Actions\Action::make('pickup')
                    ->label('Diambil')
                    ->icon('heroicon-o-truck')
                    ->color('info')
                    ->size('sm')
                    ->visible(fn (Booking $record) => $record->status === Booking::STATUS_CONFIRMED)
                    ->requiresConfirmation()
                    ->modalHeading('Tandai Sudah Diambil')
                    ->modalDescription('Apakah sepatu sudah diambil dari pelanggan?')
                    ->action(function (Booking $record): void {
                        $record->update(['status' => Booking::STATUS_PICKED_UP]);
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Status diperbarui: Sudah Diambil')
                            ->success()
                            ->send();
                    }),
                    
                Tables\Actions\Action::make('process')
                    ->label('Proses')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->color('warning')
                    ->size('sm')
                    ->visible(fn (Booking $record) => $record->status === Booking::STATUS_PICKED_UP)
                    ->requiresConfirmation()
                    ->modalHeading('Mulai Proses Cuci')
                    ->modalDescription('Apakah proses cuci sepatu sudah dimulai?')
                    ->action(function (Booking $record): void {
                        $record->update(['status' => Booking::STATUS_IN_PROGRESS]);
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Status diperbarui: Sedang Dikerjakan')
                            ->success()
                            ->send();
                    }),
                    
                Tables\Actions\Action::make('ready')
                    ->label('Siap')
                    ->icon('heroicon-o-check-badge')
                    ->color('primary')
                    ->size('sm')
                    ->visible(fn (Booking $record) => $record->status === Booking::STATUS_IN_PROGRESS)
                    ->requiresConfirmation()
                    ->modalHeading('Siap Diantar')
                    ->modalDescription('Apakah sepatu sudah selesai dan siap diantar?')
                    ->action(function (Booking $record): void {
                        $record->update(['status' => Booking::STATUS_READY]);
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Status diperbarui: Siap Diantar')
                            ->success()
                            ->send();
                    }),
                    
                Tables\Actions\Action::make('deliver')
                    ->label('Antar')
                    ->icon('heroicon-o-home')
                    ->color('success')
                    ->size('sm')
                    ->visible(fn (Booking $record) => $record->status === Booking::STATUS_READY)
                    ->requiresConfirmation()
                    ->modalHeading('Sudah Diantar')
                    ->modalDescription('Apakah sepatu sudah diantar ke pelanggan?')
                    ->action(function (Booking $record): void {
                        $record->update(['status' => Booking::STATUS_DELIVERED]);
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Status diperbarui: Sudah Diantar')
                            ->success()
                            ->send();
                    }),
                    
                Tables\Actions\Action::make('cancel')
                    ->label('Batal')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->size('sm')
                    ->visible(fn (Booking $record) => !in_array($record->status, [Booking::STATUS_DELIVERED, Booking::STATUS_CANCELLED]))
                    ->requiresConfirmation()
                    ->modalHeading('Batalkan Booking')
                    ->modalDescription('Apakah Anda yakin ingin membatalkan booking ini?')
                    ->action(function (Booking $record): void {
                        $record->update(['status' => Booking::STATUS_CANCELLED]);
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Booking dibatalkan')
                            ->warning()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    
                    // Bulk Status Update Actions
                    Tables\Actions\BulkAction::make('bulkConfirm')
                        ->label('Konfirmasi Terpilih')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Konfirmasi Multiple Booking')
                        ->modalDescription('Apakah Anda yakin ingin mengkonfirmasi semua booking yang dipilih?')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records): void {
                            $records->each(function (Booking $record) {
                                if ($record->status === Booking::STATUS_PENDING) {
                                    $record->update(['status' => Booking::STATUS_CONFIRMED]);
                                }
                            });
                            
                            \Filament\Notifications\Notification::make()
                                ->title('Booking terpilih berhasil dikonfirmasi')
                                ->success()
                                ->send();
                        }),
                        
                    Tables\Actions\BulkAction::make('bulkPickup')
                        ->label('Tandai Diambil')
                        ->icon('heroicon-o-truck')
                        ->color('info')
                        ->requiresConfirmation()
                        ->modalHeading('Tandai Sudah Diambil')
                        ->modalDescription('Apakah semua sepatu yang dipilih sudah diambil?')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records): void {
                            $records->each(function (Booking $record) {
                                if ($record->status === Booking::STATUS_CONFIRMED) {
                                    $record->update(['status' => Booking::STATUS_PICKED_UP]);
                                }
                            });
                            
                            \Filament\Notifications\Notification::make()
                                ->title('Status diperbarui: Sudah Diambil')
                                ->success()
                                ->send();
                        }),
                        
                    Tables\Actions\BulkAction::make('bulkProcess')
                        ->label('Mulai Proses')
                        ->icon('heroicon-o-cog-6-tooth')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->modalHeading('Mulai Proses Cuci')
                        ->modalDescription('Apakah proses cuci untuk semua sepatu yang dipilih sudah dimulai?')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records): void {
                            $records->each(function (Booking $record) {
                                if ($record->status === Booking::STATUS_PICKED_UP) {
                                    $record->update(['status' => Booking::STATUS_IN_PROGRESS]);
                                }
                            });
                            
                            \Filament\Notifications\Notification::make()
                                ->title('Status diperbarui: Sedang Dikerjakan')
                                ->success()
                                ->send();
                        }),
                        
                    Tables\Actions\BulkAction::make('bulkReady')
                        ->label('Tandai Siap')
                        ->icon('heroicon-o-check-badge')
                        ->color('primary')
                        ->requiresConfirmation()
                        ->modalHeading('Siap Diantar')
                        ->modalDescription('Apakah semua sepatu yang dipilih sudah selesai dan siap diantar?')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records): void {
                            $records->each(function (Booking $record) {
                                if ($record->status === Booking::STATUS_IN_PROGRESS) {
                                    $record->update(['status' => Booking::STATUS_READY]);
                                }
                            });
                            
                            \Filament\Notifications\Notification::make()
                                ->title('Status diperbarui: Siap Diantar')
                                ->success()
                                ->send();
                        }),
                        
                    Tables\Actions\BulkAction::make('bulkDeliver')
                        ->label('Tandai Diantar')
                        ->icon('heroicon-o-home')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Sudah Diantar')
                        ->modalDescription('Apakah semua sepatu yang dipilih sudah diantar ke pelanggan?')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records): void {
                            $records->each(function (Booking $record) {
                                if ($record->status === Booking::STATUS_READY) {
                                    $record->update(['status' => Booking::STATUS_DELIVERED]);
                                }
                            });
                            
                            \Filament\Notifications\Notification::make()
                                ->title('Status diperbarui: Sudah Diantar')
                                ->success()
                                ->send();
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'view' => Pages\ViewBooking::route('/{record}'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}