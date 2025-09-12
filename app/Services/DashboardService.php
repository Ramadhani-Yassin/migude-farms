<?php

namespace App\Services;

use App\Enums\Expense\ExpenseFieldsEnum;
use App\Enums\Order\OrderFieldsEnum;
use App\Helpers\BaseHelper;
use App\Models\Expense;
use App\Models\Order;
use Carbon\Carbon;

class DashboardService
{
    public function getData(?string $date = null): array
    {
        $date = $date ? Carbon::parse($date) : Carbon::now();

        // Current month
        $selectedMonthOrders = Order::query()
            ->when($date, function ($query, $date) {
                $query->whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year);
            })
            ->get();
        $selectedMonthTotalOrders = $selectedMonthOrders->count();
        $selectedMonthTotalSales = $selectedMonthOrders->sum(OrderFieldsEnum::TOTAL->value);

        // Last month
        $lastMonthDate = (clone $date)->subMonth();
        $lastMonthOrders = Order::query()
            ->whereMonth('created_at', $lastMonthDate->month)
            ->whereYear('created_at', $lastMonthDate->year)
            ->get();
        $lastMonthTotalOrders = $lastMonthOrders->count();
        $lastMonthTotalSales = $lastMonthOrders->sum(OrderFieldsEnum::TOTAL->value);

        // Expenses (by expense_date)
        $selectedMonthTotalExpenses = Expense::query()
            ->when($date, function ($query, $date) {
                $query->whereMonth(ExpenseFieldsEnum::EXPENSE_DATE->value, $date->month)
                    ->whereYear(ExpenseFieldsEnum::EXPENSE_DATE->value, $date->year);
            })
            ->sum(ExpenseFieldsEnum::AMOUNT->value);
        $lastMonthTotalExpenses = Expense::query()
            ->whereMonth(ExpenseFieldsEnum::EXPENSE_DATE->value, $lastMonthDate->month)
            ->whereYear(ExpenseFieldsEnum::EXPENSE_DATE->value, $lastMonthDate->year)
            ->sum(ExpenseFieldsEnum::AMOUNT->value);

        // Profit = Sales - Expenses
        $selectedMonthTotalProfit = (double) $selectedMonthTotalSales - (double) $selectedMonthTotalExpenses;
        $lastMonthTotalProfit = (double) $lastMonthTotalSales - (double) $lastMonthTotalExpenses;

        // Percentage changes
        $orderPercentageChange = ($lastMonthTotalOrders != 0) ? (($selectedMonthTotalOrders - $lastMonthTotalOrders) / $lastMonthTotalOrders) * 100 : 0;
        $salesPercentageChange = ($lastMonthTotalSales != 0) ? (($selectedMonthTotalSales - $lastMonthTotalSales) / $lastMonthTotalSales) * 100 : 0;
        $profitPercentageChange = ($lastMonthTotalProfit != 0) ? (($selectedMonthTotalProfit - $lastMonthTotalProfit) / $lastMonthTotalProfit) * 100 : 0;
        $expensePercentageChange = ($lastMonthTotalExpenses != 0) ? (($selectedMonthTotalExpenses - $lastMonthTotalExpenses) / $lastMonthTotalExpenses) * 100 : 0;

        return [
            "total_orders"      => [
                "selected"          => $selectedMonthTotalOrders,
                "percentage_change" => abs(BaseHelper::numberFormat($orderPercentageChange)),
                "stateArray"        => $orderPercentageChange < 0 ? "down" : "up"
            ],
            "total_profit"      => [
                "selected"          => (double) $selectedMonthTotalProfit,
                "percentage_change" => abs(BaseHelper::numberFormat($profitPercentageChange)),
                "stateArray"        => $profitPercentageChange < 0 ? "down" : "up"
            ],
            "total_sales"       => [
                "selected"          => (double) $selectedMonthTotalSales,
                "percentage_change" => abs(BaseHelper::numberFormat($salesPercentageChange)),
                "stateArray"        => $salesPercentageChange < 0 ? "down" : "up"
            ],
            "total_expense"     => [
                "selected"          => (double) $selectedMonthTotalExpenses,
                "percentage_change" => abs(BaseHelper::numberFormat($expensePercentageChange)),
                "stateArray"        => $expensePercentageChange < 0 ? "down" : "up"
            ],
            "profit_line_chart" => $this->prepareProfitLineChart(),
            "orders_bar_chart"  => $this->prepareOrderBarChart(),
        ];
    }

    private function prepareProfitLineChart(): array
    {
        $currentYearProfit = Order::selectRaw('MONTH(created_at) as month, SUM(total) as total_sales')
            ->where('created_at', '>=', Carbon::now()->subMonths(7))
            ->groupBy('month')
            ->pluck('total_sales', 'month');

        $lastYearProfit = Order::selectRaw('MONTH(created_at) as month, SUM(total) as total_sales')
            ->whereYear('created_at', Carbon::now()->subYear()->year)
            ->where('created_at', '>=', Carbon::now()->subYear()->subMonths(7))
            ->groupBy('month')
            ->pluck('total_sales', 'month');

        // Loop to get the last 7 months
        $months = [];
        $currentYearProfitValues = [];
        $lastYearProfitValues = [];
        for ($i = 6; $i >= 0; $i--) {
            $carbon = Carbon::now()->subMonths($i);
            $months[] = $carbon->format('F');
            $currentYearProfitValues[] = (double) ($currentYearProfit[$carbon->month] ?? 0);
            $lastYearProfitValues[] = (double) ($lastYearProfit[$carbon->month] ?? 0);
        }

        return [
            "months"       => $months,
            "current_year" => $currentYearProfitValues,
            "last_year"    => $lastYearProfitValues,
        ];
    }

    private function prepareOrderBarChart(): array
    {
        $currentYearOrders = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as total_orders')
            ->whereYear('created_at', Carbon::now()->year)
            ->where('created_at', '>=', Carbon::now()->subMonths(7))
            ->groupBy('month')
            ->pluck('total_orders', 'month');

        $lastYearOrders = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as total_orders')
            ->whereYear('created_at', Carbon::now()->subYear()->year)
            ->where('created_at', '>=', Carbon::now()->subYear()->subMonths(7))
            ->groupBy('month')
            ->pluck('total_orders', 'month');

        // Loop to get the last 7 months
        $months = [];
        $currentYearOrdersValues = [];
        $lastYearOrdersValues = [];
        for ($i = 6; $i >= 0; $i--) {
            $carbon = Carbon::now()->subMonths($i);
            $months[] = $carbon->format('F');
            $currentYearOrdersValues[] = (double) ($currentYearOrders[$carbon->month] ?? 0);
            $lastYearOrdersValues[] = (double) ($lastYearOrders[$carbon->month] ?? 0);
        }

        return [
            "months"       => $months,
            "current_year" => $currentYearOrdersValues,
            "last_year"    => $lastYearOrdersValues,
        ];
    }
}
