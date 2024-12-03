<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <x-navbars.sidebar activePage="user-profile"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage='Edit Transaction'></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-300 border-radius-xl mt-4"
                style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
                <span class="mask  bg-gradient-primary  opacity-6"></span>
            </div>
            <div class="card card-body mx-3 mx-md-4 mt-n6">
                <div class="card card-plain h-100">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-md-8 d-flex align-items-center">
                                <h6 class="mb-3">Edit The Data For Transaction</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <form action="{{ url('transactions/' . $transaction->id) }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            @method('PUT')
                            <div class="row"> 
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Nominal</label>
                                    <input type="number" name="nominal" class="form-control border border-2 p-2" value="{{ $transaction->nominal }}">
                                </div>      
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Date</label>
                                    <input type="date" name="date" class="form-control border border-2 p-2" value="{{ $transaction->date }}">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Category</label>
                                    <div>
                                        <select name="category_id" class="form-control border border-2 p-2" required>
                                            <option value="" disabled selected>Click and Select One</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" @if($transaction->category_id == $category->id) selected @endif>{{ $category->category }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>     
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Wallet</label>
                                    <div>
                                        <select name="wallet_id" class="form-control border border-2 p-2" required>
                                            <option value="" disabled selected>Click and Select One</option>
                                            @foreach($wallets as $wallet)
                                                <option value="{{ $wallet->id }}" @if($transaction->wallet_id == $wallet->id) selected @endif>{{ $wallet->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('wallet_id')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>                                             
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Status</label>
                                    <div>
                                        <select name="status" class="form-control border border-2 p-2" required>
                                            <option value="" disabled selected>Click and Select One</option>
                                            <option value="1" @if($transaction->status == 1) selected @endif>Income Transaction</option>
                                            <option value="0" @if($transaction->status != 1) selected @endif>Expense Transaction</option>
                                        </select>
                                    </div>
                                </div>                         
                                <div class="mb-3 col-md-12">
                                    <label for="floatingTextarea2">Description</label>
                                    <textarea class="form-control border border-2 p-2" id="floatingTextarea2" name="description" rows="4" cols="20">{{ $transaction->description }}</textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn bg-gradient-dark">Submit</button>
                            <button type="reset" onclick="window.location.href='{{ url('transactions') }}'" class="btn bg-gradient-dark">Cancel</button>
                        </form>

                    </div>
                </div>
            </div>

        </div>
        <x-footers.auth></x-footers.auth>
    </div>
    <x-plugins></x-plugins>

</x-layout>
