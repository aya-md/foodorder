<x-layouts.console title="Table QR Codes">
    <div class="page-head">
        <div>
            <div class="eyebrow">Vendor Console</div>
            <h1>Table QR Codes</h1>
        </div>
    </div>

    <form method="POST" action="{{ route('tables.update') }}" style="margin:20px 40px;display:flex;align-items:flex-end;gap:12px;">
        @csrf
        @method('PATCH')
        <div class="form-field" style="margin:0;">
            <label>Number of Tables</label>
            <input type="number" name="table_count" value="{{ $business->table_count }}" min="1" max="200">
        </div>
        <button type="submit" class="act-btn mint" style="padding:10px 16px;">Update</button>
    </form>

    <div class="dash-grid" style="grid-template-columns:repeat(2, 1fr);">
        @foreach ($tables as $table)
            <div class="panel" style="padding:18px;text-align:center;">
                <p class="mono" style="font-weight:700;font-size:13px;letter-spacing:.04em;text-transform:uppercase;color:var(--amber);margin:0 0 12px;">Table {{ $table['number'] }}</p>
                <img src="{{ $table['qr_image'] }}" alt="QR code for table {{ $table['number'] }}" style="display:block;margin:0 auto;max-width:100%;border-radius:4px;background:#fff;padding:8px;">
                <a href="{{ $table['qr_image'] }}" download="table-{{ $table['number'] }}.png" class="act-btn amber" style="display:inline-block;margin-top:12px;">Download</a>
            </div>
        @endforeach
    </div>
</x-layouts.console>
