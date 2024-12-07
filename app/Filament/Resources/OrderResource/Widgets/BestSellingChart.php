<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class BestSellingChart extends ChartWidget
{
    protected static ?string $heading = 'Top 15 Bestselling Products';
    protected int | string | array $columnSpan = 'full';
    protected function getData(): array
    {
        // Retrieve the top 15 bestselling products by summing the quantity sold from the order_items table
        $bestsellingItems = DB::table('order_items')
            ->select('order_items.product_id', 'products.name', DB::raw('SUM(order_items.quantity) as total_quantity'))
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->groupBy('order_items.product_id', 'products.name')
            ->orderByDesc('total_quantity')
            ->limit(15)
            ->get();

        // Prepare the chart data
        $labels = [];
        $data = [];

        foreach ($bestsellingItems as $item) {
            $labels[] = $item->name; // Product names for the X-axis
            $data[] = $item->total_quantity; // Total quantity sold for the Y-axis
        }

        // Return the chart data with custom Y-axis options for whole numbers
        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Quantity Sold',
                    'data' => $data,
                    'borderColor' => 'rgba(75, 192, 192, 1)', // Color for the line
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)', // Color for the fill
                    'fill' => true,
                ],
            ],
            'options' => [
                'scales' => [
                    'y' => [
                        'beginAtZero' => false, // Prevent starting at zero
                        'min' => 1, // Set the minimum Y value to 1
                        'ticks' => [
                            'stepSize' => 1, // Ensure all ticks are whole numbers (1, 2, 3, etc.)
                            'callback' => function ($value) {
                                // Ensure no decimals are shown in the Y-axis ticks
                                return Number.isInteger($value) ? $value : '';
                            },
                        ],
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        // You can change 'line' to 'bar' or 'pie' for other chart types
        return 'line';
    }
}
