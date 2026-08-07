<x-layouts.ticket title="Checkout">
    <div class="header-band torn-bottom">
        <h1>Checkout</h1>
        <p class="sub">{{ $business->name }}</p>
    </div>

    <div class="receipt-card">
        <a href="{{ route('cart.show') }}" class="link">← Back to Cart</a>

        @if ($errors->any())
            <div class="flash" style="background:#F5DEDB;color:var(--stamp-dim);margin-top:14px;">
                <ul style="margin:0;padding-left:18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('checkout.store') }}" style="margin-top:18px;"
              x-data="{ orderType: '{{ old('type', $tableNumber ? 'dine_in' : 'take_away') }}' }">
            @csrf

            <div class="form-field">
                <label>Your Name</label>
                <input type="text" name="customer_name" value="{{ old('customer_name') }}" required>
            </div>

            <div class="form-field">
                <label>Phone (optional)</label>
                <input type="text" name="phone" value="{{ old('phone') }}">
            </div>

            <div class="form-field">
                <label>Order Type</label>
                <select name="type" id="type" x-model="orderType" required>
                    <option value="take_away">Takeaway</option>
                    <option value="dine_in">Dine-in</option>
                </select>
            </div>

            <div class="form-field" id="table-field" x-show="orderType === 'dine_in'">
                <label>Table Number</label>
                <select name="table_number">
                    <option value="">Select a table</option>
                    @for ($i = 1; $i <= $business->table_count; $i++)
                        <option value="{{ $i }}" @selected(old('table_number', $tableNumber) == $i)>Table {{ $i }}</option>
                    @endfor
                </select>
            </div>

            <button type="submit" class="btn-primary" style="margin-top:20px;">Place Order</button>
        </form>
    </div>
</x-layouts.ticket>
