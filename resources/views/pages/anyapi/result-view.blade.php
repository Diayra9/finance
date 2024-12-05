<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="tables"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Include your custom stylesheet here -->
        <link rel="stylesheet" href="{{ asset('styles.css') }}" />
        
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Tables"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="currency-converter">
            <h2>Currency Converter</h2>
            <form id="currencyForm" action="{{ url('/currency/convert') }}">
                @csrf

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="form-group">
                    <label for="baseCurrency">Base Currency :</label>
                    <input type="text" id="baseCurrency" value="{{ $amount }}" readonly>
                </div>

                <div class="form-group">
                    <label for="converted">Result :</label>
                    <input type="text" id="converted" name="converted" value="{{ $converted ?? 'Tidak ada data' }}" readonly>
                </div>
                <br>

                <a href="{{ url('/currency/request') }}" class="btn">Convert Again</a>
            </form>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>