@extends($activeTemplate . 'layouts.master')
@section('content')
    @php
        $kycInfo = getContent('kyc_info.content', true);
    @endphp
<div class="row g-4 justify-content-center">
    @if (auth()->user()->kv == 0)
                                                                                                                                        @include('components.kyc-alert', [
            'type' => 'info',
            'heading' => __('KYC Verification required'),
            'message' => __($kycInfo->data_values->verification_content ?? ''),
            'link' => route('user.kyc.form'),
            'linkText' => __('Click Here to Verify')
        ])
    @elseif(auth()->user()->kv == 2)
                                                                                                                                        @include('components.kyc-alert', [
            'type' => 'warning',
            'heading' => __('KYC Verification pending'),
            'message' => __($kycInfo->data_values->pending_content ?? ''),
            'link' => route('user.kyc.data'),
            'linkText' => __('See KYC Data')
        ])
    @endif
    <style>
        .wallet-card {
            background: #000;
            color: white;
            border-radius: 15px;
            padding: 20px;
            min-height: 200px;
        }
        
        .balance-label {
            font-size: 0.9rem;
            opacity: 0.8;
            padding-bottom: 1rem;
        }
        
        .balance-amount {
            font-size: 2.5rem;
            font-weight: bold;
            padding-bottom: 1rem;
        }
        
        .verification-status {
            color: #ff4444;
            font-size: 0.8rem;
        }
        
        .verify-btn {
            background: transparent;
            border: 1px solid #333;
            font-size: 0.8rem;
            padding: 2px 8px;
            color: white;
        }
        
        .action-grid {
            margin-top: 30px;
        }
        
        .action-item {
            text-align: center;
            color: white;
            text-decoration: none;
        }
        
        .action-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
        }
        
        .action-text {
            font-size: 0.8rem;
        }
        
        .buy-icon { background: #f8f9fa; }
        .send-icon { background: #ff4b75; }
        .receive-icon { background: #0d6efd; }
        .swap-icon { background: #ffc107; }
        .link-icon { background: #228B22; }
        
        .card-tag {
            position: absolute;
            top: 20px;
            right: 20px;
            border: 1px solid #00ff9d;
            color: #00ff9d;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
        }
    </style>

    <div class="container py-4">
        <div class="wallet-card position-relative">
            
            <div>
                <div class="balance-label">Total Balance</div>
                <div class="balance-amount">${{ number_format($totalDollarValue, 2) }}</div>
            </div>
            
            <div class="action-grid">
                <div class="row g-4">
                <div class="col">
    <a href="#" class="action-item" data-bs-toggle="modal" data-bs-target="#buyCryptoModal">
        <div class="action-icon buy-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2">
                <rect x="3" y="3" width="18" height="18" rx="2" />
                <path d="M7 7h10" />
            </svg>
        </div>
        <div class="action-text">Buy</div>
    </a>
</div>


                    <div class="col">
                        <a href="#" class="action-item">
                            <div class="action-icon receive-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                                    <path d="M19 12H5M12 19l-7-7 7-7" />
                                </svg>
                            </div>
                            <div class="action-text">Withdraw</div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="#" class="action-item">
                            <div class="action-icon swap-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2">
                                    <path d="M4 9h16M4 15h16M8 5l-4 4 4 4M16 19l4-4-4-4" />
                                </svg>
                            </div>
                            <div class="action-text">Swap</div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="#" class="action-item">
                            <div class="action-icon link-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" />
                                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" />
                                </svg>
                            </div>
                            <div class="action-text">Link Wallet</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        @foreach ($cryptoBalances as $crypto => $balance)
                                                                                                                                                                                                                                                                            @include('components.dashboard-item', [
                'icon' => $crypto . '.png',
                'title' => strtoupper($crypto) . ' ' . __('Balance'),
                'value' => $balance,
                'subValue' => 'Dollar Price: $' . number_format($dollarValues[$crypto] ?? 0, 2),
            ])
        @endforeach
    </div>
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
            @include('components.dashboard-item', [
    'iconClass' => 'las la-tasks',
    'title' => __('Referral User'),
    'value' => $widget['referred'],
    'link' => route('user.referral.log'),
    'linkText' => __('View all'),
])
        </div>

        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
            @include('components.dashboard-item', [
    'iconClass' => 'las la-coins',
    'title' => __('Total Transaction'),
    'value' => $widget['transactions'],
    'link' => route('user.transactions.history'),
    'linkText' => __('View all'),
])
        </div>
    </div>

    <div class="referral-area ptb-80">
        <div class="input-group">
            <input type="text" name="key" value="{{ route('home') }}?reference={{ auth()->user()->username }}" class="form-control referralURL" readonly>
            <button type="button" class="btn btn-secondary copytext" id="copyBoard"> <i class="fa fa-copy"></i> </button>
        </div>
    </div>

    <h3 class="text-primary text-center my-5">{{ __('Market Update') }}</h3>
    <script async src="https://static.coinstats.app/widgets/coin-list-widget.js"></script>
    <coin-stats-list-widget 
        locale="en" 
        currency="USD" 
        bg-color="rgba(6,55,176,1)" 
        status-up-color="#74D492" 
        status-down-color="#FE4747" 
        text-color="#FFFFFF" 
        font="Roboto, Arial, Helvetica" 
        border-color="rgba(255,255,255,0.15)" 
        width="100%" 
        coin-ids="bitcoin,ethereum,litecoin,ripple,stellar,tether,binance-coin,tron,solana,shiba-inu,trust-wallet-token,dogecoin,dai,kucoin-shares,iota,binance-usd">
    </coin-stats-list-widget>

    <table class="custom-table">
        <thead>
            <tr>
                <th>{{ __('Time') }}</th>
                <th>{{ __('TRX') }}</th>
                <th>{{ __('Type') }}</th>
                <th>{{ __('Details') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $transaction)
                <tr>
                    <td><span title="{{ $transaction->created_at->diffForHumans() }}">{{ showDateTime($transaction->created_at) }}</span></td>
                    <td class="fw-bold">{{ $transaction->trx }}</td>
                    <td class="fw-bold {{ $transaction->trx_type == '+' ? 'text-success' : 'text-danger' }}">
                        {{ $transaction->trx_type }}{{ showAmount($transaction->amount) }} {{ $transaction->currency->code ?? '' }}
                    </td>
                    <td>{{ $transaction->details }}</td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="4">{{ __($emptyMessage) }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection

<!-- Buy Crypto Modal -->
<div class="modal fade" id="buyCryptoModal" tabindex="-1" aria-labelledby="buyCryptoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="buyCryptoModalLabel">Buy Cryptocurrency</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Hidden inputs for transaction data -->
        <input type="hidden" id="user_id" value="{{ auth()->id() }}">
        <input type="hidden" id="coin_id" name="coin_id">
        <input type="hidden" id="vendor_id" name="vendor_id">
        
        <!-- Form: Step 1 -->
        <div id="step1">
          <form id="buyCryptoForm">
            <div class="mb-3">
              <label for="coin" class="form-label">Select Coin</label>
              <select class="form-select" id="coin" name="coin" required>
                <option value="" disabled selected>Select a coin</option>
                <!-- Options populated dynamically -->
              </select>
            </div>
            <div class="mb-3">
              <label for="amount" class="form-label">Amount</label>
              <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter amount" required>
            </div>
            <div class="mb-3">
              <label for="vendor" class="form-label">Select Vendor</label>
              <select class="form-select" id="vendor" name="vendor" required>
                <option value="" disabled selected>Select a vendor</option>
                <!-- Options populated dynamically -->
              </select>
            </div>
            <button type="button" id="proceedBtn" class="btn btn-primary">Proceed</button>
          </form>
        </div>
        <!-- Form: Step 2 -->
        <div id="step2" style="display: none;">
          <h6>Transaction Summary</h6>
          <ul class="list-group">
            <li class="list-group-item"><strong>Coin:</strong> <span id="summaryCoin"></span></li>
            <li class="list-group-item"><strong>Amount:</strong> <span id="summaryAmount"></span></li>
            <li class="list-group-item"><strong>Vendor:</strong> <span id="summaryVendor"></span></li>
            <li class="list-group-item">
              <strong>Wallet Address:</strong>
              <span id="summaryWallet"></span>
              <button class="btn btn-sm btn-outline-secondary" id="copyWalletBtn">Copy</button>
            </li>
          </ul>
          <button type="button" id="continueBtn" class="btn btn-success mt-3">Continue</button>
        </div>
      </div>
    </div>
  </div>
</div>
@push('style')
    <style>
        .copied::after {
            background-color: #{{ $general->base_color ?? '000' }};
        }
    </style>
@endpush

@push('script')
        <script>
            (function($) {
                "use strict";
                $('#copyBoard').click(function() {
                    var copyText = $('.referralURL').get(0);
                    navigator.clipboard.writeText(copyText.value).then(() => {
                        this.classList.add('copied');
                        setTimeout(() => this.classList.remove('copied'), 1500);
                    });
                });
            })(jQuery);
        </script>
       <script>
        const coins = @json($coins);
        const vendors = @json($vendors);

        // Handle coin selection
        $("#coin").on("change", function () {
            $("#coin_id").val($(this).val());
        });

        // Handle vendor selection
        $("#vendor").on("change", function () {
            $("#vendor_id").val($(this).val());
        });

        document.addEventListener("DOMContentLoaded", function () {
            // Populate Coins Dropdown
            const coinDropdown = $("#coin");
            coinDropdown
                .empty()
                .append('<option value="" disabled selected>Select a coin</option>');
            coins.forEach(function (coin) {
                coinDropdown.append(
                    `<option value="${coin.id}" data-wallet="${coin.wallet_address}">${coin.name} (${coin.symbol})</option>`
                );
            });

            // Populate Vendors Dropdown
            const vendorDropdown = $("#vendor");
            vendorDropdown
                .empty()
                .append('<option value="" disabled selected>Select a vendor</option>');
            vendors.forEach(function (vendor) {
                vendorDropdown.append(
                    `<option value="${vendor.id}" data-url="${vendor.url}">${vendor.name}</option>`
                );
            });

            // Handle Proceed Button
            $("#proceedBtn").on("click", function () {
                const selectedCoin = $("#coin option:selected");
                const amount = $("#amount").val();
                const selectedVendor = $("#vendor option:selected");

                if (!selectedCoin.val() || !amount || !selectedVendor.val()) {
                    alert("Please fill all fields.");
                    return;
                }

                // Populate Summary
                $("#summaryCoin").text(selectedCoin.text());
                $("#summaryAmount").text(amount);
                $("#summaryVendor").text(selectedVendor.text());
                $("#summaryWallet").text(selectedCoin.data("wallet"));

                // Switch to Step 2
                $("#step1").hide();
                $("#step2").show();
            });

            // Copy Wallet Address
            $("#copyWalletBtn").on("click", function () {
                const walletAddress = $("#summaryWallet").text();
                navigator.clipboard.writeText(walletAddress).then(function () {
                    alert("Wallet address copied!");
                });
            });

            // Continue Button
            $("#continueBtn").on("click", function () {
                if ($(this).text() === "Continue") {
                    // Only open new window in Continue state
                    const vendorUrl = $("#vendor option:selected").data("url");
                    window.open(vendorUrl, "_blank");

                    // Change button to Confirm Payment state
                    $(this).text("Confirm Payment").addClass("btn-warning");
                } else {
                    // Handle Confirm Payment click
                    confirmPayment();
                }
            });

            // Confirm Payment
            function confirmPayment() {
                // Get the necessary data from your form or page
                const transactionData = {
                    user_id: $("#user_id").val(),
                    coin_id: $("#coin_id").val(),
                    vendor_id: $("#vendor").val(),
                    amount: $("#amount").val()
                };

                // Make AJAX call to store the transaction
                $.ajax({
                    url: '/payment/crypt-transactions', // Updated URL to match your route prefix
                    method: 'POST',
                    data: transactionData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        alert("Payment confirmed! Admin has been notified.");
                        $("#buyCryptoModal").modal("hide");
                        window.location.reload();
                    },
                    error: function (xhr, status, error) {
                        let errorMessage = "Error confirming payment";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        alert(errorMessage);
                    }
                });
            }
        });
    </script>


@endpush
