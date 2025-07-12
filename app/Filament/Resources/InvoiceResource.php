<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Filament\Resources\InvoiceResource\RelationManagers;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text'; // Icon untuk Invoice
    protected static ?string $navigationGroup = 'Shop Management'; // Kelompokkan di bawah Shop Management

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detail Invoice')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('order_id')
                            ->relationship('order', 'buyer_name') // Relasi ke Order, tampilkan buyer_name
                            ->required()
                            ->searchable()
                            ->preload()
                            ->unique(ignoreRecord: true) // Pastikan order_id unik untuk setiap invoice
                            ->getOptionLabelFromRecordUsing(fn($record) => "Order #{$record->order_id} - {$record->buyer_name}"), // Label lebih informatif

                        Forms\Components\TextInput::make('invoice_number')
                            ->required()
                            ->unique(ignoreRecord: true) // Pastikan invoice_number unik
                            ->maxLength(255)
                            ->readOnlyOn('edit') // Biasanya nomor invoice tidak bisa diubah setelah dibuat
                            ->placeholder('Otomatis jika tidak diisi'), // Akan kita tangani di mutateFormDataBeforeCreate

                        Forms\Components\TextInput::make('amount')
                            ->numeric()
                            ->required()
                            ->prefix('Rp')
                            ->inputMode('decimal')
                            ->step(0.01) // Untuk dua digit desimal
                            ->minValue(0),

                        Forms\Components\Select::make('payment_status')
                            ->options([
                                'pending' => 'Pending',
                                'paid' => 'Paid',
                                'failed' => 'Failed',
                                'expired' => 'Expired',
                                'refunded' => 'Refunded', // Contoh status tambahan
                            ])
                            ->default('pending')
                            ->required(),

                        Forms\Components\TextInput::make('midtrans_transaction_id')
                            ->label('Midtrans Transaction ID')
                            ->nullable()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('midtrans_snap_token')
                            ->label('Midtrans Snap Token')
                            ->nullable()
                            ->maxLength(255),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order.buyer_name') // Tampilkan nama pembeli dari relasi Order
                    ->label('Buyer Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->money('IDR') // Format sebagai mata uang Rupiah
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_status')
                    ->badge() // Tampilkan sebagai badge
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'failed' => 'danger',
                        'expired' => 'info',
                        'refunded' => 'gray',
                        default => 'gray',
                    })
                    ->searchable(),

                Tables\Columns\TextColumn::make('midtrans_transaction_id')
                    ->label('Midtrans ID')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('midtrans_snap_token')
                    ->label('Snap Token')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Order Time')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('payment_status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                        'expired' => 'Expired',
                        'refunded' => 'Refunded',
                    ])
                    ->label('Status Pembayaran'),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Jika Anda ingin menampilkan Order terkait sebagai Relation Manager di halaman Invoice, tambahkan di sini
            // RelationManagers\OrderRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvoices::route('/'),
            // 'create' => Pages\CreateInvoice::route('/create'),
            // 'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}
