<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use App\Models\Wallet;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /*** Fungsi untuk membaca list wallet dari form blade ***/
    public function index(Request $request)
    {
        $query = Transaction::with(['category', 'wallet', 'user'])->orderBy('date', 'asc');

        // If the user is not an admin, filter by the logged-in user's ID
        if (auth()->user()->hasRole('user')) {
            $query->where('user_id', auth()->user()->id);
        }

        if ($request->has('month') && $request->month != '') {
            $query->whereMonth('date', $request->month);
        }

        $transactions = $query->get();
        return view('pages.transaction.view', compact('transactions'));
    }

    /*** Fungsi untuk memanggil wallet dan kategori ***/
    public function create()
    {
        $categories = Category::all();
        $wallets = Wallet::where('status', 1)
            ->orderBy('name')
            ->take(5)
            ->get();

        return view('pages.transaction.add', compact('categories', 'wallets'));
    }

    /*** Fungsi untuk menyimpan transaction dari form blade ***/
    public function store(Request $request)
    {
        $transaction = new Transaction();
        $transaction->user_id = auth()->user()->hasRole('user') ? auth()->user()->id : $request->user_id;
        $transaction->nominal =  $request->nominal;
        $transaction->description =  $request->description;
        $transaction->date =  $request->date;
        $transaction->category_id = $request->category_id;
        $transaction->wallet_id = $request->wallet_id;
        $transaction->status =  $request->status;

        $wallet = Wallet::find($request->wallet_id);
        if (!$wallet) {
            return redirect()->back()->withErrors(['wallet_id' => 'Wallet not found.']);
        }

        $wallet->save();
        $transaction->save();
        return redirect()->route('transactions.index');
    }

    /*** Fungsi untuk menghapus list wallet dari form blade ***/
    public function destroy($id)
    {
        $transaction = Transaction::find($id);
        $wallet = Wallet::find($transaction->wallet_id);

        $wallet->save();
        $transaction->delete();
        return redirect()->route('transactions.index');
    }

    /*** Fungsi untuk mengedit list transaction dari form blade ***/
    public function edit(Request $request, $id)
    {
        $transaction = Transaction::with(['category', 'wallet'])->findOrFail($id);
        $categories = Category::all();
        $wallets = Wallet::where('status', 1)
            ->orderBy('name')
            ->take(5)
            ->get();

        return view('pages.transaction.edit', compact('categories', 'transaction', 'wallets'));
    }

    /*** Fungsi untuk mengupdate transaction dari form blade ***/
    public function update(Request $request, $id)
    {
        $transaction = Transaction::find($id);

        $originalWalletId = $transaction->wallet_id;
        $originalStatus = $transaction->status;

        $transaction->nominal =  $request->nominal;
        $transaction->description =  $request->description;
        $transaction->date =  $request->date;
        $transaction->category_id = $request->category_id;
        $transaction->wallet_id = $request->wallet_id;
        $transaction->status =  $request->status;

        if ($originalWalletId != $request->wallet_id) {
            $newWallet = Wallet::find($request->wallet_id);
            if ($request->status == 0) {
                $newWallet->saldo -= $request->nominal;
            } else {
                $newWallet->saldo += $request->nominal;
            }
            $newWallet->save();
        }

        $transaction->save();

        return redirect()->route('transactions.index');
    }

    // Fungsi untuk membaca nominal wallet dari form blade
    // public function nominalTransaction(Request $request)
    // {
    //     $totalNominal = Transaction::sum('nominal');
    //     return view('nominal-transaction', compact('totalNominal'));
    // } 
}
