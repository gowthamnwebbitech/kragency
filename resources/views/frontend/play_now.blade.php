@extends('frontend.layouts.app')
@section('title', 'Home')

@section('content')
    <section class="results mt-4">
        <div class="lottery-result result-page">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="lottery-times">
                            @foreach ($schedules as $schedule)
                                @php
                                    $scheduleTime = \Carbon\Carbon::parse($schedule->time);
                                    $compareTime = now()->addMinutes($close_time);
                                @endphp

                                @if ($scheduleTime->greaterThan($compareTime))
                                    <div onclick="window.location.href='{{ route('customer.play-now', ['id' => $schedule->betting_providers_id, 'time_id' => $schedule->id]) }}'"
                                        style="cursor:pointer;"
                                        class="lottery-card {{ $scheduleTime->lessThan($compareTime) ? 'closed' : ($schedule->id == $slot_time_id ? 'active' : 'running') }}">
                                    @else
                                        <div
                                            class="lottery-card {{ $scheduleTime->lessThan($compareTime) ? 'closed' : ($schedule->id == $slot_time_id ? 'active' : 'running') }}">
                                @endif
                                {{ date('h:i A', strtotime($schedule->time)) }} <br>
                                <small>{{ $schedule->name }}<br>
                                    {{ $scheduleTime->greaterThan($compareTime) ? 'active' : 'closed' }}
                                </small>
                        </div>
                        @endforeach
                    </div>

                    @if ($show_slot == 1)
                        @foreach ($gameSlots as $group)
                            @php
                                $first = $group->first();
                                $type = $first->digitMaster->type;
                            @endphp

                            <div class="game-box {{ $type == 1 ? 'singleDigit' : '' }}">
                                <div class="header mb-3">
                                    @if ($type == 1)
                                        <div class="title">
                                            Single Digit
                                            <span>Win ₹{{ $first->providerSlot?->winning_amount ?? 0 }}
                                            </span>
                                        </div>
                                    @elseif ($type == 2)
                                        <div class="title">
                                            Double Digit
                                            <span>Win ₹{{ $first->providerSlot?->winning_amount ?? 0 }}
                                            </span>
                                        </div>
                                    @elseif ($type == 3)
                                        <div class="title">
                                            Three Digit
                                            <span>Win ₹{{ $first->providerSlot?->winning_amount ?? 0 }}</span>
                                        </div>
                                    @elseif ($type == 4)
                                        <div class="title">
                                            Four Digit
                                            <span>Win ₹{{ $first->providerSlot?->winning_amount ?? 0 }}</span>
                                        </div>
                                    @endif

                                    <div class="price">₹{{ $first->amount }}</div>
                                </div>
                                @foreach ($group as $game_slot)
                                    <div class="gridWrap" data-type="{{ $type }}"
                                        data-game-label="{{ $game_slot->digitMaster->name }}"
                                        data-game-id="{{ $game_slot->id }}" data-amount="{{ $game_slot->amount }}">

                                        @php
                                            $gameName = $game_slot->digitMaster?->name ?? '';
                                            $gameName = preg_replace('/\s*\(.*?\)\s*/', '', $gameName);
                                        @endphp

                                        <div class="d-flex">
                                            @foreach (str_split($gameName) as $char)
                                                <div class="label" style="margin:0 0 0 2px;padding:0;">{{ $char }}
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="gridChild">
                                            <div class="d-flex">
                                                @for ($i = 1; $i <= $type; $i++)
                                                    <input type="text" class="input-box" maxlength="1"
                                                        name="digit{{ $i }}" inputmode="numeric"
                                                        pattern="[0-9]*" autocomplete="one-time-code">
                                                @endfor
                                            </div>
                                        </div>


                                        {{-- COUNTER --}}
                                        <div class="gridChild">
                                            <div class="counter">
                                                <button type="button" class="minus">-</button>
                                                <span class="count">1</span>
                                                <button type="button" class="plus">+</button>
                                            </div>
                                        </div>

                                        {{-- ADD --}}
                                        <div class="gridChild text-right">
                                            <a class="custom-button2 add-to-cart">ADD</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    @endif

                </div>

                @if ($show_slot == 1)
                    <div class="col-lg-12 text-center d-none ">
                        <a href="{{ route('lottery.view.cart') }}" class="custom-button2" id="pay-now1">Pay Now</a>
                    </div>
                @endif
            </div>
        </div>
        </div>
    </section>

    <!-- Cart Summary Modal "-->
    <div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="cartModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cartModalLabel">Your Selections</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="cart-items">
                        <!-- Cart items will be displayed here -->
                    </div>
                    <div class="total-amount">
                        <strong>Total: ₹<span id="cart-total">0</span></strong>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Continue Playing</button>
                    <button type="button" class="btn btn-primary" id="confirm-payment">Confirm Payment</button>
                </div>
            </div>
        </div>
    </div>
@endsection



@push('scripts')
    <script>
        $(document).ready(function() {
            let cart = [];

            // Load cart from Laravel session on page load
            $.ajax({
                url: '{{ route('lottery.get-cart') }}',
                method: 'GET',
                success: function(response) {
                    if (response.cart) {
                        cart = response.cart;
                        $('#cartCount').text(cart.length);
                    }
                }
            });

            // Counter functionality
            $('.plus').click(function() {
                let countElement = $(this).siblings('.count');
                let count = parseInt(countElement.text());
                countElement.text(count + 1);
            });

            $('.minus').click(function() {
                let countElement = $(this).siblings('.count');
                let count = parseInt(countElement.text());
                if (count > 1) {
                    countElement.text(count - 1);
                }
            });

            // Box toggle functionality
            $('.box-toggle').click(function() {
                $(this).toggleClass('active');
            });

            // Add to cart functionality
            $('.add-to-cart').click(function() {

                let gameWrapper = $(this).closest('.gridWrap');
                let type = gameWrapper.data('type');
                let gameLabel = gameWrapper.data('game-label');
                let gameId = gameWrapper.data('game-id');
                let amount = Number(gameWrapper.data('amount'));
                let quantity = Number(gameWrapper.find('.count').text());
                let isBox = gameWrapper.find('.box-toggle').hasClass('active');

                // Validate and get digits based on type
                let digits = '';
                let isValid = true;

                if (type == 1) {
                    let digit = gameWrapper.find('input[name="digit"]').val().trim();
                    if (digit === '' || isNaN(digit)) {
                        alert('Please enter a valid digit');
                        isValid = false;
                    } else {
                        digits = digit;
                    }
                } else if (type == 2) {
                    let digit1 = gameWrapper.find('input[name="digit1"]').val().trim();
                    let digit2 = gameWrapper.find('input[name="digit2"]').val().trim();

                    if (digit1 === '' || isNaN(digit1) || digit2 === '' || isNaN(digit2)) {
                        alert('Please enter valid digits');
                        isValid = false;
                    } else {
                        digits = digit1 + digit2;
                    }
                } else if (type == 3) {
                    let digit1 = gameWrapper.find('input[name="digit1"]').val().trim();
                    let digit2 = gameWrapper.find('input[name="digit2"]').val().trim();
                    let digit3 = gameWrapper.find('input[name="digit3"]').val().trim();

                    if (digit1 === '' || isNaN(digit1) || digit2 === '' || isNaN(digit2) || digit3 === '' ||
                        isNaN(digit3)) {
                        alert('Please enter valid digits');
                        isValid = false;
                    } else {
                        digits = digit1 + digit2 + digit3;
                    }
                } else if (type == 4) {
                    let digit1 = gameWrapper.find('input[name="digit1"]').val().trim();
                    let digit2 = gameWrapper.find('input[name="digit2"]').val().trim();
                    let digit3 = gameWrapper.find('input[name="digit3"]').val().trim();
                    let digit4 = gameWrapper.find('input[name="digit4"]').val().trim();

                    if (digit1 === '' || isNaN(digit1) || digit2 === '' || isNaN(digit2) ||
                        digit3 === '' || isNaN(digit3) || digit4 === '' || isNaN(digit4)) {
                        alert('Please enter valid digits');
                        isValid = false;
                    } else {
                        digits = digit1 + digit2 + digit3 + digit4;
                    }
                }

                if (!isValid) return;

                // Prepare the new cart item
                let cartItem = {
                    type: type,
                    game_id: gameId,
                    game_label: gameLabel,
                    digits: digits,
                    quantity: quantity,
                    amount: amount,
                    is_box: isBox,
                    total: Number(amount) * Number(quantity)
                };

                // Calculate the new total if this item is added
                let newTotal = cart.reduce(function(sum, item) {
                    return Number(sum) + Number(item.total || 0);
                }, 0) + Number(cartItem.total);


                // Check if user is logged in before wallet check
                var isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
                if (!isLoggedIn) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Please login to continue!',
                        showConfirmButton: true,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('login') }}";
                        }
                    });


                    return;
                }

                // AJAX wallet check before adding to cart
                $.ajax({
                    url: '{{ route('lottery.cart.check-wallet') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        total: newTotal
                    },
                    success: function(response) {
                        if (response.success) {
                            // Proceed to add to cart
                            $.ajax({
                                url: '{{ route('lottery.add-to-cart') }}',
                                method: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    item: cartItem
                                },
                                success: function(response) {
                                    if (response.success) {
                                        cart = response
                                            .cart; // updated cart from server
                                        $('#cartCount').text(cart.length);
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Added to cart!',
                                            text: 'Your selection has been added to the cart.',
                                            timer: 1500,
                                            showConfirmButton: false
                                        });
                                        gameWrapper.find('input').val('');
                                        gameWrapper.find('.count').text('1');
                                        if (isBox) gameWrapper.find('.box-toggle')
                                            .removeClass('active');
                                    } else {
                                        alert('Failed to add cart.');
                                    }
                                }
                            });
                        } else {
                            // Remove the attempted item from cart if it was pushed (defensive, but in this code, not pushed yet)
                            // Just ensure it is not added
                            alert(response.message ||
                                'Insufficient wallet balance. Item not added to cart.');
                            // Defensive: if you ever push before check, remove last
                            if (cart.length > 0) {
                                let last = cart[cart.length - 1];
                                if (last && last.game_id === cartItem.game_id && last.digits ===
                                    cartItem.digits && last.amount === cartItem.amount && last
                                    .quantity === cartItem.quantity) {
                                    cart.pop();
                                    $('#cartCount').text(cart.length);
                                }
                            }
                        }
                    },
                    error: function() {
                        alert('Error checking wallet balance.');
                    }
                });

                // Clear inputs
                gameWrapper.find('input').val('');
                gameWrapper.find('.count').text('1');
                if (isBox) {
                    gameWrapper.find('.box-toggle').removeClass('active');
                }

                //count cart items and update cart count
                $('#cartCount').text(cart.length);
            });

            // Pay now functionality
            $('#pay-now').click(function() {
                if (cart.length === 0) {
                    alert('Your cart is empty. Please add some selections first.');
                    return;
                }

                // Display cart items in modal
                let cartHtml = '';
                let total = 0;

                cart.forEach(function(item, index) {
                    cartHtml += `
                    <div class="cart-item">
                        <p>Label: ${item.game_label} - Digit: ${item.digits} - Quantity: ${item.quantity} - ₹${item.total}</p>
                    </div>
                `;
                    total += item.total;
                });

                $('#cart-items').html(cartHtml);
                $('#cart-total').text(total);

                // Show modal
                $('#cartModal').modal('show');
            });

            // Confirm payment
            /* $('#confirm-payment').click(function() {
                $.ajax({
                    url: '{{ route('lottery.place-order') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        cart: cart
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Order placed successfully!');
                            // Clear cart
                            cart = [];
                            sessionStorage.removeItem('lotteryCart');
                            $('#cartModal').modal('hide');
                            // Redirect or refresh as needed
                            window.location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred. Please try again.');
                    }
                });
            });*/

            // Load cart from session storage on page load
            let savedCart = sessionStorage.getItem('lotteryCart');
            if (savedCart) {
                cart = JSON.parse(savedCart);
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-focus next input for double, triple, and four digit games
            document.querySelectorAll(
                '.gridWrap[data-type="2"] .input-box, .gridWrap[data-type="3"] .input-box, .gridWrap[data-type="4"] .input-box'
            ).forEach(function(input, idx, arr) {
                input.addEventListener('input', function(e) {
                    if (e.target.value.length === e.target.maxLength) {
                        // Find the next input in the same parent
                        let next = e.target.parentElement.querySelectorAll('.input-box')[Array
                            .prototype.indexOf.call(e.target.parentElement.querySelectorAll(
                                '.input-box'), e.target) + 1];
                        if (!next) {
                            // Try to find next input in the next sibling (for flex layouts)
                            let allInputs = Array.from(e.target.closest(
                                '.d-flex, .d-flex.justifyEnd').querySelectorAll(
                                '.input-box'));
                            let idx = allInputs.indexOf(e.target);
                            if (idx !== -1 && idx + 1 < allInputs.length) {
                                next = allInputs[idx + 1];
                            }
                        }
                        if (next) next.focus();
                    }
                });
            });
        });
    </script>
@endpush
