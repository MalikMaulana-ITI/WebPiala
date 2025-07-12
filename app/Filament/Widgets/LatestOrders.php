<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Order; // Import model Order
use Illuminate\Database\Eloquent\Builder; 

class LatestOrders extends BaseWidget
{
    protected static ?string $heading = 'Pesanan Terbaru';
    protected static ?int $sort = 2; // Urutan widget di dashboard

    protected function getTableQuery(): Builder
    {
        return Order::latest()->limit(5); // Ambil 5 pesanan terbaru
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('order_id')
                ->label('ID Pesanan')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('buyer_name')
                ->label('Nama Pembeli')
                ->searchable(),
            Tables\Columns\TextColumn::make('invoice.amount')
                ->label('Total Harga')
                ->money('IDR'),
            Tables\Columns\TextColumn::make('order_status')
                ->label('Status Pesanan')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'pending' => 'warning',
                    'processing' => 'info',
                    'shipped' => 'primary',
                    'completed' => 'success',
                    'cancelled' => 'danger',
                    default => 'gray',
                }),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Tanggal Pesanan')
                ->dateTime()
                ->sortable(),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            // Tables\Actions\Action::make('view')
            //     ->label('Lihat')
            //     ->url(fn (Order $record): string => \App\Filament\Resources\OrderResource::getUrl('edit', ['record' => $record])),
        ];
    }
}