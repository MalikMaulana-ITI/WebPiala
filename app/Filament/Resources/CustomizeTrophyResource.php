<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomizeTrophyResource\Pages;
use App\Filament\Resources\CustomizeTrophyResource\RelationManagers;
use App\Models\CustomizeTrophy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use App\Models\TrophyMaterial; 

class CustomizeTrophyResource extends Resource
{
    protected static ?string $model = CustomizeTrophy::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil';
    protected static ?string $navigationGroup = 'Shop Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detail Pesanan Kustomisasi Piala')
                    ->description('Informasi utama mengenai pesanan kustomisasi piala.')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('neworder.buyer_name')
                            ->label('Nama Pembeli')
                            ->disabled(), // Disabled because this form is for viewing
                        Forms\Components\Textarea::make('customize.custom_text')
                            ->label('Teks Ukiran')
                            ->disabled(),
                        Forms\Components\TextInput::make('customize.font_style')
                            ->label('Gaya Font Ukiran')
                            ->disabled(),
                        Forms\Components\Grid::make(2) // Grid for images
                            ->schema([
                                Forms\Components\FileUpload::make('customize.image_path')
                                    ->label('Gambar Utama')
                                    ->disk('public')
                                    ->columnSpan(1),
                                Forms\Components\FileUpload::make('customize.logo_path')
                                    ->label('Logo Kustom')
                                    ->disk('public')
                                    ->columnSpan(1),
                            ]),
                        Forms\Components\Select::make('customize.selected_material_id')
                            ->label('Material Piala')
                            ->options(TrophyMaterial::pluck('material_name', 'id')->toArray())
                            ->disabled(),
                        Forms\Components\Select::make('customize.surface_finishing')
                            ->label('Finishing Permukaan')
                            ->options([
                                'doff' => 'Doff (Matte)',
                                'glossy' => 'Glossy (Mengkilap)',
                                'bertekstur' => 'Bertekstur',
                            ])
                            ->disabled(),
                    ]),

                Forms\Components\Section::make('Detail Tambahan Kustomisasi')
                    ->description('Informasi kustomisasi piala lainnya.')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('customize.text_size')
                            ->label('Ukuran Teks Ukiran')
                            ->options([
                                'small' => 'Kecil',
                                'medium' => 'Sedang',
                                'large' => 'Besar',
                            ])
                            ->disabled(),
                        Forms\Components\TextInput::make('customize.custom_color')
                            ->label('Warna Kustom')
                            ->disabled(),
                        Forms\Components\TextInput::make('customize.custom_width')
                            ->label('Lebar Kustom (cm)')
                            ->suffix('cm')
                            ->disabled(),
                        Forms\Components\TextInput::make('customize.custom_height')
                            ->label('Tinggi Kustom (cm)')
                            ->suffix('cm')
                            ->disabled(),
                        Forms\Components\Textarea::make('customize.unique_shape_description')
                            ->label('Deskripsi Bentuk Unik')
                            ->rows(3)
                            ->disabled(),
                        Forms\Components\Textarea::make('customize.additional_components_description')
                            ->label('Komponen Tambahan')
                            ->rows(3)
                            ->disabled(),
                    ]),

                Forms\Components\Section::make('Detail Kemasan Premium')
                    ->description('Informasi terkait opsi kemasan premium.')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Toggle::make('customize.premium_box')
                            ->label('Kotak Premium?')
                            ->disabled(),
                        Forms\Components\TextInput::make('customize.box_text_logo')
                            ->label('Teks/Logo Kotak')
                            ->disabled(),
                        Forms\Components\Toggle::make('customize.led_lights')
                            ->label('Lampu LED?')
                            ->disabled(),
                        Forms\Components\TextInput::make('customize.ribbon_color')
                            ->label('Warna Pita')
                            ->disabled(),
                    ]),

                Forms\Components\Section::make('Informasi Administratif & Keuangan')
                    ->description('Data terkait harga dan waktu pembuatan.')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('customize.customization_price')
                            ->label('Biaya Kustomisasi')
                            ->prefix('IDR')
                            ->disabled(),
                        Forms\Components\DateTimePicker::make('created_at')
                            ->label('Dibuat Pada')
                            ->disabled(),
                        Forms\Components\DateTimePicker::make('updated_at')
                            ->label('Diperbarui Pada')
                            ->disabled(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // --- Detail Pesanan Kustomisasi Piala (Prioritas Tinggi) ---
                Tables\Columns\TextColumn::make('orders.buyer_name') // DIGANTI: dari 'orders.buyer_name' ke 'orders.buyer_name'
                    ->label('Nama Pembeli')
                    ->searchable()
                    ->sortable(), // Tidak perlu toggleable karena ini prioritas tinggi

                Tables\Columns\TextColumn::make('customize.custom_text')
                    ->label('Teks Ukiran')
                    ->searchable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('customize.font_style')
                    ->label('Gaya Font Ukiran')
                    ->searchable()
                    ->limit(30),

                Tables\Columns\ImageColumn::make('customize.image_path')
                    ->label('Gambar Utama') // Label lebih spesifik
                    ->disk('public')
                    ->square()
                    ->toggleable(),

                Tables\Columns\ImageColumn::make('customize.logo_path')
                    ->label('Logo Kustom') // Label lebih spesifik
                    ->disk('public')
                    ->square()
                    ->toggleable(),

                // Menampilkan nama material berdasarkan ID
                Tables\Columns\TextColumn::make('customize.selected_material_id')
                    ->label('Material Piala')
                    ->formatStateUsing(function (string $state) {
                        $material = TrophyMaterial::find($state);
                        return $material ? $material->material_name : 'N/A';
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        // Custom search untuk material_name
                        return $query->whereHas('orders.trophyMaterial', function ($q) use ($search) {
                            $q->where('material_name', 'like', "%{$search}%");
                        });
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('customize.surface_finishing')
                    ->label('Finishing Permukaan')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'doff' => 'gray',
                        'glossy' => 'info',
                        'bertekstur' => 'primary',
                        default => 'gray',
                    })
                    ->toggleable(),

                // --- Detail Tambahan Kustomisasi (Prioritas Sedang) ---
                Tables\Columns\TextColumn::make('customize.text_size')
                    ->label('Ukuran Teks Ukiran')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'small' => 'gray',
                        'medium' => 'info',
                        'large' => 'primary',
                        default => 'gray',
                    })
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('customize.custom_color') // DIGANTI: dari ColorColumn ke TextColumn
                    ->label('Warna Kustom')
                    ->toggleable(isToggledHiddenByDefault: true), // Sembunyikan default jika kosong

                Tables\Columns\TextColumn::make('customize.custom_width')
                    ->label('Lebar Kustom (cm)') // Label disesuaikan
                    ->formatStateUsing(fn(string $state): string => $state . ' cm') // Tambah 'cm'
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('customize.custom_height')
                    ->label('Tinggi Kustom (cm)') // Label disesuaikan
                    ->formatStateUsing(fn(string $state): string => $state . ' cm') // Tambah 'cm'
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('customize.unique_shape_description') // DIGANTI: dari IconColumn ke TextColumn
                    ->label('Deskripsi Bentuk Unik')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true), // Sembunyikan default

                Tables\Columns\TextColumn::make('customize.additional_components_description')
                    ->label('Komponen Tambahan') // Label disesuaikan
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),

                // --- Detail Kemasan Premium (Prioritas Rendah Hingga Sedang) ---
                Tables\Columns\IconColumn::make('customize.premium_box')
                    ->label('Kotak Premium?') // Label disesuaikan menjadi pertanyaan
                    ->boolean()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('customize.box_text_logo') // DIGANTI: dari IconColumn ke TextColumn
                    ->label('Teks/Logo Kotak')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make('customize.led_lights')
                    ->label('Lampu LED?') // Label disesuaikan
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('customize.ribbon_color') // DIGANTI: dari IconColumn ke TextColumn
                    ->label('Warna Pita') // Label disesuaikan
                    ->limit(20)
                    ->toggleable(isToggledHiddenByDefault: true),

                // --- Informasi Administratif & Keuangan (Prioritas Bervariasi) ---
                Tables\Columns\TextColumn::make('customize.customization_price')
                    ->label('Biaya Kustomisasi')
                    ->money('IDR')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('premium_box')
                    ->nullable()
                    ->attribute('customize->premium_box')
                    ->label('Filter Kotak Premium'),
                Tables\Filters\SelectFilter::make('text_size')
                    ->attribute('customize->text_size')
                    ->options([
                        'small' => 'Kecil',
                        'medium' => 'Sedang',
                        'large' => 'Besar',
                    ])
                    ->label('Filter Ukuran Teks'),
                Tables\Filters\SelectFilter::make('surface_finishing')
                    ->attribute('customize->surface_finishing')
                    ->options([
                        'doff' => 'Doff (Matte)',
                        'glossy' => 'Glossy (Mengkilap)',
                        'bertekstur' => 'Bertekstur',
                    ])
                    ->label('Filter Finishing Permukaan'),
                Tables\Filters\SelectFilter::make('selected_material') // Filter untuk Material
                    ->label('Material Piala')
                    ->options(TrophyMaterial::pluck('material_name', 'id')->toArray()) // Ambil opsi dari model TrophyMaterial
                    ->query(function (Builder $query, array $data): Builder {
                        if (isset($data['value']) && $data['value'] !== null) {
                            $query->where('customize->selected_material_id', $data['value']);
                        }
                        return $query;
                    }),
            ])
            ->actions([
                // Kosongkan array ini untuk tidak menampilkan aksi per baris
            ])
            ->bulkActions([
                // Kosongkan array ini untuk tidak menampilkan aksi bulk
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomizeTrophies::route('/'),
            // 'create' => Pages\CreateCustomizeTrophy::route('/create'),
            'view' => Pages\ViewCustomizeTrophy::route('/{record}/view'), // Pastikan ada halaman 'view'
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['orders']); // And this part
    }
}