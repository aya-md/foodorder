<x-layouts.console title="Business Approvals">
    <div class="page-head">
        <div>
            <div class="eyebrow">Platform Admin</div>
            <h1>Business Approvals</h1>
        </div>
    </div>

    <div class="wrap" style="padding:20px 40px 40px;">
        <div class="panel">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr>
                        <th class="mono" style="text-align:left;font-size:10.5px;letter-spacing:.1em;text-transform:uppercase;color:var(--paper-dim);padding:16px 22px;border-bottom:1px solid var(--line);font-weight:500;">Business</th>
                        <th class="mono" style="text-align:left;font-size:10.5px;letter-spacing:.1em;text-transform:uppercase;color:var(--paper-dim);padding:16px 22px;border-bottom:1px solid var(--line);font-weight:500;">Status</th>
                        <th class="mono" style="text-align:right;font-size:10.5px;letter-spacing:.1em;text-transform:uppercase;color:var(--paper-dim);padding:16px 22px;border-bottom:1px solid var(--line);font-weight:500;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($businesses as $business)
                        <tr>
                            <td style="padding:16px 22px;border-bottom:1px dashed var(--line);font-weight:700;">{{ $business->name }}</td>
                            <td style="padding:16px 22px;border-bottom:1px dashed var(--line);">
                                <span class="status-pill {{ $business->status }} {{ $business->status === 'pending' ? 'pulse' : '' }}">
                                    <span class="dot"></span>{{ ucfirst($business->status) }}
                                </span>
                            </td>
                            <td style="padding:16px 22px;border-bottom:1px dashed var(--line);text-align:right;">
                                @if ($business->status !== 'approved')
                                    <form method="POST" action="{{ route('admin.businesses.approve', $business) }}" class="inline" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="act-btn mint">Approve</button>
                                    </form>
                                @endif
                                @if ($business->status !== 'suspended')
                                    <form method="POST" action="{{ route('admin.businesses.suspend', $business) }}" class="inline ml-2" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="act-btn chili">{{ $business->status === 'pending' ? 'Reject' : 'Suspend' }}</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.console>
