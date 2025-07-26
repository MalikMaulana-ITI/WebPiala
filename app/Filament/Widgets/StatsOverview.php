<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Trophy;
use App\Models\CustomizeTrophy; // Tambahkan import untuk CustomizeTrophy

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1; // Urutan widget di dashboard

    protected function getStats(): array
    {
        $totalOrders = Order::count();
        $pendingOrders = Order::where('order_status', 'pending')->count();
        $paidOrders = Order::where('order_status', 'paid')->count();
        $totalRevenue = Invoice::where('payment_status', 'paid')->sum('amount');
        $totalTrophies = Trophy::count();
        $totalCustomizations = CustomizeTrophy::count(); // Tambahkan ini

        return [
            Stat::make('Total Pesanan', $totalOrders)
                ->description('Jumlah seluruh pesanan')
                ->descriptionIcon('heroicon-o-shopping-bag')
                ->color('info'),
            Stat::make('Pesanan Pending', $pendingOrders)
                ->description('Pesanan menunggu konfirmasi')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),
            Stat::make('Pesanan Selesai (Dibayar)', $paidOrders)
                ->description('Pesanan yang telah dibayar')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),
            Stat::make('Total Pendapatan (Paid Invoices)', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('Dari invoice yang telah dibayar')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('success'),
            Stat::make('Total Produk Piala', $totalTrophies)
                ->description('Jumlah varian piala yang tersedia')
                ->descriptionIcon('heroicon-o-trophy')
                ->color('primary'),
            Stat::make('Total Kustomisasi', $totalCustomizations)
                ->description('Jumlah data kustomisasi yang dibuat')
                ->descriptionIcon('heroicon-o-pencil')
                ->color('secondary'),
        ];
    }
}