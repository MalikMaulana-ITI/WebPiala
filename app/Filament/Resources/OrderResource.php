<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use App\Models\CustomizeTrophy; // Import model CustomizeTrophy
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str; // Untuk uuid atau string unik lainnya jika diperlukan
use Storage; // Untuk menyimpan file gambar jika ada

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'Shop Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pembeli')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('buyer_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone_number')
                            ->tel()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('trophy_id')
                            ->relationship('trophy', 'name')
                            ->searchable()
                            ->preload()
                            ->getOptionLabelFromRecordUsing(fn($record) => $record->name ?? '[Nama Trofi Tidak Tersedia]'),
                        Forms\Components\Select::make('order_status')
                            ->options([
                                'pending' => 'Pending',
                                'processing' => 'Processing',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                                'shipped' => 'Shipped',
                            ])
                            ->default('pending')
                            ->required(),
                    ]),

                Forms\Components\Section::make('Kustomisasi Trofi')
                    ->schema([
                        Forms\Components\Toggle::make('isCustomize')
                            ->label('Apakah Trofi Dikustomisasi?')
                            ->live() // Penting untuk memperbarui field kustomisasi
                            ->default(false),

                        // Group ini akan muncul hanya jika 'isCustomize' true
                        Forms\Components\Group::make([
                            Forms\Components\Textarea::make('customText')
                                ->label('Teks Ukiran (Engraving Text)')
                                ->maxLength(200)
                                ->placeholder('Masukkan teks yang ingin diukir pada trofi Anda...'),

                            Forms\Components\Select::make('textSize')
                                ->label('Ukuran Teks')
                                ->options([
                                    'small' => 'Kecil',
                                    'medium' => 'Sedang',
                                    'large' => 'Besar',
                                ])
                                ->default('medium'),

                            Forms\Components\ColorPicker::make('customColor')
                                ->label('Warna Trofi Kustom')
                                ->default('#000000'),

                            Forms\Components\Select::make('fontStyle')
                                ->label('Gaya Font')
                                ->options([
                                    'serif' => 'Serif (Klasik)',
                                    'sans-serif' => 'Sans-serif (Modern)',
                                    'script' => 'Script (Elegan)',
                                    'monospace' => 'Monospace (Teknis)',
                                ])
                                ->default('sans-serif'),

                            Forms\Components\Textarea::make('uniqueShapeDescription')
                                ->label('Deskripsi Bentuk/Desain Unik')
                                ->maxLength(500)
                                ->placeholder('Contoh: Siluet logo perusahaan, bentuk bola, figur 3D...'),

                            Forms\Components\Grid::make(2)
                                ->schema([
                                    Forms\Components\TextInput::make('customHeight')
                                        ->label('Tinggi Piala (cm)')
                                        ->numeric()
                                        ->minValue(1)
                                        ->maxValue(500),
                                    Forms\Components\TextInput::make('customWidth')
                                        ->label('Lebar Piala (cm)')
                                        ->numeric()
                                        ->minValue(1)
                                        ->maxValue(500),
                                ]),

                            Forms\Components\Textarea::make('additionalComponentsDescription')
                                ->label('Deskripsi Komponen Tambahan')
                                ->maxLength(500)
                                ->placeholder('Contoh: Alas marmer, puncak kristal, bagian tengah akrilik...'),

                            Forms\Components\FileUpload::make('imageFile')
                                ->label('Upload Gambar/Foto')
                                ->disk('public') // Pastikan disk ini dikonfigurasi di config/filesystems.php
                                ->directory('customization_images') // Folder tempat gambar disimpan
                                ->image()
                                ->maxSize(2048), // Maks 2MB

                            Forms\Components\FileUpload::make('logoFile')
                                ->label('Upload Logo')
                                ->disk('public')
                                ->directory('customization_logos')
                                ->image()
                                ->maxSize(2048),

                            Forms\Components\Select::make('surfaceFinishing')
                                ->label('Finishing Permukaan')
                                ->options([
                                    'doff' => 'Doff (Matte)',
                                    'glossy' => 'Glossy (Mengkilap)',
                                    'bertekstur' => 'Bertekstur',
                                ])
                                ->default('doff'),

                            Forms\Components\TextInput::make('ribbonColor')
                                ->label('Warna Pita Custom')
                                ->maxLength(255)
                                ->placeholder('Contoh: Merah, Biru, Emas'),

                            Forms\Components\Toggle::make('premiumBox')
                                ->label('Tambahkan Kotak Premium')
                                ->live(),

                            Forms\Components\Group::make([
                                Forms\Components\Textarea::make('boxTextLogo')
                                    ->label('Teks/Logo pada Kotak')
                                    ->maxLength(200)
                                    ->placeholder('Teks atau deskripsi logo untuk kotak premium...'),
                                Forms\Components\Toggle::make('ledLights')
                                    ->label('Tambahkan Lampu LED'),
                            ])->hidden(fn(Forms\Get $get): bool => ! $get('premiumBox')),

                        ])->hidden(fn(Forms\Get $get): bool => ! $get('isCustomize')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('buyer_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('trophy.name')
                    ->label('Trophy')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\IconColumn::make('isCustomize')
                    ->label('Customized')
                    ->boolean(),
                Tables\Columns\TextColumn::make('shipping_address')
                    ->label('Alamat')
                    ->sortable(),
                Tables\Columns\TextColumn::make('village_name')
                    ->label('Kelurahan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('district_name')
                    ->label('Kecamatan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('regency_name')
                    ->label('Kota/Kab')
                    ->sortable(),
                Tables\Columns\TextColumn::make('province_name')
                    ->label('Provinsi')
                    ->sortable(),
                // Untuk detail kustomisasi, kita perlu mengakses JSON
                Tables\Columns\TextColumn::make('customize.customize.customText') // Akses path JSON
                    ->label('Teks Kustomisasi')
                    ->tooltip(
                        fn($record): string =>
                        'Ukuran: ' . ($record->customize->customize['textSize'] ?? 'N/A') . "\n" .
                            'Warna: ' . ($record->customize->customize['customColor'] ?? 'N/A') . "\n" .
                            'Font: ' . ($record->customize->customize['fontStyle'] ?? 'N/A')
                        // Tambahkan detail lain yang relevan
                    )
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('order_status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'processing' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        'shipped' => 'primary',
                    })
                    ->searchable(),
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
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
