<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Lastest Transaction
        $latestTransaction = Transaction::latest()->first();
        $createdAt = Carbon::parse($latestTransaction->created_at);
        $timeAgo = $createdAt->diffForHumans();

        // Fucntion Grafik Part One
        $reportByWallet = Transaction::select(DB::raw('DAYOFWEEK(date) as day'), 'wallet_id', DB::raw('COUNT(*) as count'))
        ->whereYear('date', date('Y'))
        ->where('user_id', auth()->id())
        ->groupBy('wallet_id', DB::raw('DAYOFWEEK(date)'))
        ->get();

        $wallets = DB::table('tb_wallet')
        ->where('status', 1)
        ->pluck('name', 'id');

        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $labelsByWallet = collect($days);

        $datasetsByWallet = [];
        foreach ($wallets as $id => $wallet) {
            $data = [];
            foreach (range(1, 7) as $day) {
                $data[] = $reportByWallet->where('day', $day)
                ->where('wallet_id', $id)
                    ->value('count') ?? 0;
            }
            $datasetsByWallet[] = [
                'label' => $wallet,
                'data' => $data,
                'tension' => 0.4,
                'borderRadius' => 4,
                'borderSkipped' => false,
                'backgroundColor' => $this->predefinedColor($id, true),
                'borderColor' => $this->predefinedColor($id, false),
                'borderWidth' => 0,
                'maxBarThickness' => 6,
            ];
        }

        // Fucntion Grafik Part Two
        $reportByStatus = Transaction::select(
            DB::raw('DAYOFWEEK(date) as day'), // Menggunakan DAYOFWEEK untuk mendapatkan hari dalam minggu
            DB::raw('SUM(nominal) as total'),
            'status'
        )
        ->whereYear('date', date('Y'))
        ->where('user_id', auth()->id())
        ->groupBy(DB::raw('DAYOFWEEK(date)'), 'status')
        ->get();

        $combinedData = [];
        foreach ($days as $index => $day) {
            $income = $reportByStatus->where('day', $index + 1)->where('status', 1)->sum('total') ?? 0;
            $expense = $reportByStatus->where('day', $index + 1)->where('status', 0)->sum('total') ?? 0;

            // Gabungkan income dan expense, jika income turun, dianggap expense
            $combinedData[] = $income - $expense;
        }

        return view('dashboard.index', compact('timeAgo', 'labelsByWallet', 'datasetsByWallet', 'combinedData'));
    }

    private function predefinedColor($id, $isBackground)
    {
        $colors = [
            1 => ['rgba(255, 255, 255, .8)', 'rgba(255, 255, 255, 1)'], // White
            2 => ['rgba(54, 162, 235, .8)', 'rgba(54, 162, 235, 1)'], // Blue
            3 => ['rgba(153, 102, 255, .8)', 'rgba(153, 102, 255, 1)'], // Purple
            4 => ['rgba(255, 159, 64, .8)', 'rgba(255, 159, 64, 1)'], // Orange
        ];

        $colorKey = ($id - 1) % count($colors) + 1;
        return $isBackground ? $colors[$colorKey][0] : $colors[$colorKey][1];
    }

}
