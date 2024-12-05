<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="tables"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Include your custom stylesheet here -->
        <link rel="stylesheet" href="{{ asset('styles.css') }}" />
        
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Tables"></x-navbars.navs.auth>
        <div class="currency-converter">
            <h2>Currency Converter</h2>
            <form action="{{ url('/currency/convert') }}" method="POST">
                @csrf

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="form-group">
                    <label for="amount">Amount :</label>
                    <input type="number" id="amount" name="amount" placeholder="Enter amount" required>
                </div>

                <div class="form-group">
                    <label for="baseCurrency">Base Currency :</label>
                    <input type="text" id="baseCurrency" name="baseCurrency" placeholder="Type here" required>
                </div>
                    
                <div class="form-group">
                    <label for="targetCurrency">To Currency :</label>
                    <input type="text" id="targetCurrency" name="targetCurrency" placeholder="Type here" required>
                </div>


                <button type="submit" class="btn">Convert</button>
            </form>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>