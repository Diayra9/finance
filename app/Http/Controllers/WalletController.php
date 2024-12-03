<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    /*** Fungsi untuk membaca list wallet dari form blade ***/
    public function index(Request $request)
    {
        $wallets = Wallet::get();
        return view('pages.wallet.view', compact('wallets'));
    }

    public function create()
    {
        return view('pages.wallet.add');
    }

    /*** Fungsi untuk menyimpan wallet dari form blade ***/
    public function store(Request $request)
    {
        $input = $request->input();
        $wallet = new Wallet();
        $wallet->name =  $request->name;
        $wallet->description =  $request->description;
        $wallet->status =  $request->status;
        $wallet->save();

        return redirect()->route('wallets.index');
    }

    /*** Fungsi untuk menghapus list wallet dari form blade ***/
    public function destroy($id)
    {
        $wallet = Wallet::find($id);
        $wallet->delete();

        return redirect()->route('wallets.index');
    }

    /*** Fungsi untuk mengedit list wallet dari form blade ***/
    public function edit(Request $request, $id)
    {
        $wallet = Wallet::find($id);
        return view('pages.wallet.edit', compact('wallet'));
    }

    /*** Fungsi untuk mengupdate wallet dari form blade ***/
    public function update(Request $request, $id)
    {
        $input = $request->input();

        $wallet = Wallet::find($id);
        $wallet->name =  $request->name;
        $wallet->description =  $request->description;
        $wallet->status =  $request->status;
        $wallet->save();

        return redirect()->route('wallets.index');
    }
}
