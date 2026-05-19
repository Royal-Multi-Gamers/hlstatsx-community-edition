<x-layouts.admin title="Tools">
    @if(session('success'))<div style="background-color:rgba(63,185,80,0.1); border:1px solid var(--status-online); border-radius:var(--border-radius-sm); padding:8px 12px; margin-bottom:20px; color:var(--status-online); font-size:var(--font-size-sm);">{{ session('success') }}</div>@endif
    @if(session('error'))<div style="background-color:rgba(248,81,73,0.1); border:1px solid var(--status-offline); border-radius:var(--border-radius-sm); padding:8px 12px; margin-bottom:20px; color:var(--status-offline); font-size:var(--font-size-sm);">{{ session('error') }}</div>@endif

    <div style="display:flex; flex-direction:column; gap:20px;">

        {{-- Optimize Database --}}
        <div style="border:1px solid var(--border); border-radius:var(--border-radius-md); padding:20px; background-color:var(--bg-surface);">
            <h3 style="color:var(--text-heading); margin:0 0 8px 0; font-size:15px;">{{ __('Optimize Database') }}</h3>
            <p class="hlx-muted" style="margin:0 0 14px 0; font-size:var(--font-size-sm);">Runs OPTIMIZE TABLE on all major HLStatsX tables to reclaim space and improve performance.</p>
            <form method="POST" action="{{ route('admin.tools.optimize-db') }}" onsubmit="return confirm('Optimize all tables? This may take a moment on large databases.')">
                @csrf
                <button type="submit" class="hlx-btn-gold">{{ __('Optimize Database') }}</button>
            </form>
        </div>

        {{-- Reset Game Stats --}}
        <div style="border:1px solid var(--border); border-radius:var(--border-radius-md); padding:20px; background-color:var(--bg-surface);">
            <h3 style="color:var(--text-heading); margin:0 0 8px 0; font-size:15px;">{{ __('Reset Game Statistics') }}</h3>
            <p class="hlx-muted" style="margin:0 0 14px 0; font-size:var(--font-size-sm);">Resets all player statistics and deletes all event records for the selected game. <strong style="color:var(--status-offline);">This is irreversible.</strong></p>
            <form method="POST" action="{{ route('admin.tools.reset-game') }}">
                @csrf
                <div style="display:flex; flex-wrap:wrap; gap:8px; align-items:flex-end;">
                    <div>
                        <label class="hlx-muted" style="display:block; margin-bottom:4px; font-size:var(--font-size-sm);">Game</label>
                        <select name="game" style="background-color:var(--bg-body); color:var(--text-primary); border:1px solid var(--border); border-radius:var(--border-radius-sm); padding:6px 10px; font-size:var(--font-size-sm);">
                            @foreach($games as $g)
                                <option value="{{ $g->code }}">{{ $g->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="hlx-muted" style="display:block; margin-bottom:4px; font-size:var(--font-size-sm);">Type <span style="color:var(--status-offline);">RESET</span> to confirm</label>
                        <input type="text" name="confirm" required placeholder="RESET"
                               style="background-color:var(--bg-body); color:var(--text-primary); border:1px solid var(--border); border-radius:var(--border-radius-sm); padding:6px 10px; font-size:var(--font-size-sm); width:120px;">
                    </div>
                    <button type="submit" style="padding:6px 14px; border:none; border-radius:var(--border-radius-sm); background:var(--status-offline); color:#fff; cursor:pointer; font-size:var(--font-size-sm); font-weight:600;">Reset Game</button>
                </div>
            </form>
        </div>

        {{-- Delete Zero-stat Players --}}
        <div style="border:1px solid var(--border); border-radius:var(--border-radius-md); padding:20px; background-color:var(--bg-surface);">
            <h3 style="color:var(--text-heading); margin:0 0 8px 0; font-size:15px;">{{ __('Delete Inactive Players') }}</h3>
            <p class="hlx-muted" style="margin:0 0 14px 0; font-size:var(--font-size-sm);">Removes players with 0 kills and 0 deaths from the selected game. <strong style="color:var(--status-offline);">This is irreversible.</strong></p>
            <form method="POST" action="{{ route('admin.tools.delete-players') }}">
                @csrf
                <div style="display:flex; flex-wrap:wrap; gap:8px; align-items:flex-end;">
                    <div>
                        <label class="hlx-muted" style="display:block; margin-bottom:4px; font-size:var(--font-size-sm);">Game</label>
                        <select name="game" style="background-color:var(--bg-body); color:var(--text-primary); border:1px solid var(--border); border-radius:var(--border-radius-sm); padding:6px 10px; font-size:var(--font-size-sm);">
                            @foreach($games as $g)
                                <option value="{{ $g->code }}">{{ $g->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="hlx-muted" style="display:block; margin-bottom:4px; font-size:var(--font-size-sm);">Type <span style="color:var(--status-offline);">DELETE</span> to confirm</label>
                        <input type="text" name="confirm" required placeholder="DELETE"
                               style="background-color:var(--bg-body); color:var(--text-primary); border:1px solid var(--border); border-radius:var(--border-radius-sm); padding:6px 10px; font-size:var(--font-size-sm); width:120px;">
                    </div>
                    <button type="submit" style="padding:6px 14px; border:none; border-radius:var(--border-radius-sm); background:var(--status-offline); color:#fff; cursor:pointer; font-size:var(--font-size-sm); font-weight:600;">Delete Players</button>
                </div>
            </form>
        </div>

    </div>
</x-layouts.admin>
