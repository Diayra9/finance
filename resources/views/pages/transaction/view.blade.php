<x-layout bodyClass="g-sidenav-show  bg-gray-200">

    <x-navbars.sidebar activePage="user-management"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="List Transaction"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible text-white" role="alert">
                                <span class="text-sm">{{ session('success') }}</span>
                                <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class=" me-3 my-3 text-end">
                            <a class="btn bg-gradient-dark mb-0" href="{{ url('/transactions/create') }}"><i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add New Transaction</a>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                NO</th>
                                            @if(auth()->user()->hasRole('admin'))
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    USER</th>
                                                @endif
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                NOMINAL</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                DESCRIPTION</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                DATE</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                CATEGORY</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                WALLET</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                STATUS</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transactions as $transaction)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <p class="mb-0 text-sm">{{ ($transactions->currentPage() - 1) * $transactions->perPage() + $loop->iteration }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            @if(auth()->user()->hasRole('admin'))
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $transaction->user->name }}</h6>
                                                    </div>
                                                </td>
                                            @endif
                                            <td>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">Rp. {{ number_format($transaction->nominal, 2, ',', '.') }}</h6>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $transaction->description }}</h6>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $transaction->date }}</h6>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $transaction->category?->category ?? 'No Category' }}</h6>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $transaction->wallet?->name ?? 'No Wallet' }}</h6>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">
                                                        @if ($transaction->status == 1)
                                                            <span class="badge badge-sm bg-gradient-success">
                                                                Income Transaction
                                                            </span>
                                                        @else
                                                            <span class="badge badge-sm bg-gradient-secondary">
                                                                Expense Transaction
                                                            </span>
                                                        @endif
                                                    </h6>
                                                </div>
                                            </td>
                                            @can('dashboard')
                                            <td class="align-middle">
                                                <a rel="tooltip" class="btn btn-success btn-link" href="{{ url('transactions/'.$transaction->id.'/edit') }}" data-original-title="" title="">
                                                    <i class="material-icons">edit</i>
                                                    <div class="ripple-container"></div>
                                                </a>
                                                <form action="{{ url('transactions/'.$transaction->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-link">
                                                        <i class="material-icons">close</i>
                                                        <div class="ripple-container"></div>
                                                    </button>
                                                </form>
                                            </td>
                                            @endcan
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                {{ $transactions->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>

</x-layout>
