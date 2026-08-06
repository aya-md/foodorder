<x-layouts.console title="Staff Accounts">
    <div class="page-head">
        <div>
            <div class="eyebrow">Vendor Console</div>
            <h1>Staff Accounts</h1>
        </div>
        <a href="{{ route('staff.create') }}" class="act-btn mint">+ Add Staff Account</a>
    </div>

    <div class="wrap" style="padding:20px 40px 40px;">
        <div class="panel">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr>
                        <th class="mono" style="text-align:left;font-size:10.5px;letter-spacing:.1em;text-transform:uppercase;color:var(--paper-dim);padding:16px 22px;border-bottom:1px solid var(--line);font-weight:500;">Name</th>
                        <th class="mono" style="text-align:left;font-size:10.5px;letter-spacing:.1em;text-transform:uppercase;color:var(--paper-dim);padding:16px 22px;border-bottom:1px solid var(--line);font-weight:500;">Email</th>
                        <th class="mono" style="text-align:right;font-size:10.5px;letter-spacing:.1em;text-transform:uppercase;color:var(--paper-dim);padding:16px 22px;border-bottom:1px solid var(--line);font-weight:500;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($staff as $member)
                        <tr>
                            <td style="padding:16px 22px;border-bottom:1px dashed var(--line);font-weight:700;">{{ $member->name }}</td>
                            <td class="mono" style="padding:16px 22px;border-bottom:1px dashed var(--line);color:var(--paper-dim);font-size:12.5px;">{{ $member->email }}</td>
                            <td style="padding:16px 22px;border-bottom:1px dashed var(--line);text-align:right;">
                                <form method="POST" action="{{ route('staff.destroy', $member) }}" class="inline" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="act-btn chili" onclick="return confirm('Remove this staff account?')">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="mono" style="padding:20px 22px;color:var(--paper-dim);">No staff accounts yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.console>
