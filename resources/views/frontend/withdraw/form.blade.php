@extends('frontend.layouts.app')

@section('title', 'Withdraw')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">Withdraw Request</div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger" style="font-size: 13px">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li class="text-sm">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <span class="text-sm text-danger">
                        @endif
                        <form method="POST" action="{{ route('customer.withdraw.submit') }}">
                            @csrf
                            {{-- <small class="text-muted">
                                Maximum withdraw ₹500. Only one request allowed per 24 hours.
                            </small> --}}
                            <div class="form-group">
                                <label for="amount">Withdraw Amount</label>

                                <input type="number" name="amount" min="1" max="500" class="form-control"
                                    required>

                            </div>
                            <div class="form-group">
                                <label>Wallet Balance: <strong>{{ $wallet->balance ?? 0 }}</strong></label>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Request</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
