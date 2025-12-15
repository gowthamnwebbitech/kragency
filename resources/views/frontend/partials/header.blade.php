
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center w-100">
                   <a class="navbar-brand" href="{{ route('customer.dashboard') }}" 
                style="font-size: 28px; font-weight: 700; background: linear-gradient(45deg, #6a11cb, #2575fc); 
                        -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <img src="{{ asset('frontend/images/logo.png') }}" height="50"  class="brand-logo">
                </a>


            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            </div>
            <!-- Brand -->
        
            <!-- Menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto align-items-lg-center">
                    <li class="nav-item active">
                        @if(Auth::check())
                            <a class="nav-link" href="{{ route('customer.dashboard') }}">Home</a>
                        @else
                            <a class="nav-link" href="{{ route('landing-dashboard') }}">Home</a>
                        @endif
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('customer.results') }}">Results</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" href="{{ route('customer.rules') }}">Rules</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ $whatsapp_number ? 'https://wa.me/' . $whatsapp_number : '#' }}" target="_blank">Recharge</a>
                    </li>

                    <!-- User Dropdown -->
                     @if(Auth::check())
                        <!-- Wallet -->
                        <li class="nav-item">
                            <div class="wallet-balance d-flex align-items-center ml-lg-3">
                                <i class="fas fa-wallet wallet-icon mr-1"></i>
                                <span class="balance-amount">
                                    <span id="balanceValue">{{ $user_detail?->wallet?->balance ?? 0 }}</span>
                                </span>
                            </div>
                        </li>
                        <!-- Cart -->
                        <li class="nav-item">
                            <a href="{{ route('lottery.view.cart') }}" class="nav-link position-relative ml-lg-3">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="cart-count badge badge-danger position-absolute"
                                    style="top:-5px; right:-10px;" id="cartCount">
                                    {{ session('lotteryCart') ? count(session('lotteryCart')) : 0 }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item dropdown ml-lg-3">
                            <a href="#" class="nav-link dropdown-toggle" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow-sm" aria-labelledby="userDropdown" style="min-width: 200px;">
                                <div class="user-info px-3 py-2">
                                    <div class="user-name font-weight-bold">{{ $user_detail->name }}</div>
                                    <div class="user-email text-muted small">{{ $user_detail->mobile }}</div>
                                </div>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('customer-order-details') }}"><i class="fas fa-history mr-2"></i> Order History</a>
                                <a class="dropdown-item" href="{{ route('payment.history') }}"><i class="fas fa-wallet mr-2"></i> Payment History</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('customer.withdraw') }}"><i class="fas fa-money-bill-wave mr-2"></i> Withdraw</a>
                                <a class="dropdown-item" href="{{ route('customer.withdraw.history') }}"><i class="fas fa-history mr-2"></i> Withdraw History</a>
                                <a class="dropdown-item" href="{{ route('bank-details.create') }}"><i class="fas fa-university mr-2"></i> Add Bank Details</a>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
                            </div>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link btn btn-primary text-white px-3" href="{{ route('login') }}">Login / Register</a>
                        </li>
                    @endif

                </ul>
            </div>
        </div>
    </nav>
</header>

<style>
     .brand-logo {
        width: 300px;
        height: auto;
    }
    
.navbar-toggler {
    border: none !important;
    padding: 0 !important;
    outline: none !important;
    box-shadow: none !important;
}

.nav-link {
    width: max-content !important;
}


    /* Mobile */
    @media (max-width: 576px) {
        .brand-logo {
            width: 180px; 
        }
    }
</style>
