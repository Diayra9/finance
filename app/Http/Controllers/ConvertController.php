<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ConvertController extends Controller
    {
        public function requestForm()
        {
            return view('pages.anyapi.request');
        }

        public function convertCurrency(Request $request)
        {
            $amount = $request->input('amount');
            $apiKey = env('ANYAPI_KEY');
            $base = $request->input('baseCurrency');
            $to = $request->input('targetCurrency');

            $url = "https://anyapi.io/api/v1/exchange/convert?apiKey=$apiKey&base=$base&to=$to&amount=$amount";
            $client = new \GuzzleHttp\Client();

            try {
                $response = $client->request('GET', $url);
                $data = json_decode($response->getBody(), true);
                // dd($data);
                if (isset($data['errors'])) {
                    throw new \Exception($data['errors'][0]);
                }
                $converted = $data['converted'] ?? null;

                return view('pages.anyapi.result-view', compact('amount', 'base', 'to', 'converted'));
            } catch (\Exception $e) {
                return back()->with('error', 'Failed to convert currency: ' . $e->getMessage());
            }
        }
    }
