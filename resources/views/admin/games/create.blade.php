<x-layouts.admin title="Add Game">
    <form method="POST" action="{{ route('admin.games.store') }}" style="max-width:480px;">
        @csrf
        <div style="margin-bottom:14px;">
            <label class="hlx-muted" style="display:block; margin-bottom:4px; font-size:var(--font-size-sm);">Game Code <span style="color:var(--status-offline);">*</span></label>
            <input type="text" name="code" value="{{ old('code') }}" required maxlength="32"
                   placeholder="e.g. css, tf, csgo"
                   style="width:100%; box-sizing:border-box; background-color:var(--bg-body); color:var(--text-primary); border:1px solid var(--border); border-radius:var(--border-radius-sm); padding:6px 10px; font-size:var(--font-size-sm);">
            @error('code') <div style="color:var(--status-offline); font-size:var(--font-size-sm); margin-top:4px;">{{ $message }}</div> @enderror
        </div>
        <div style="margin-bottom:14px;">
            <label class="hlx-muted" style="display:block; margin-bottom:4px; font-size:var(--font-size-sm);">Game Name <span style="color:var(--status-offline);">*</span></label>
            <input type="text" name="name" value="{{ old('name') }}" required maxlength="128"
                   placeholder="e.g. Counter-Strike: Source"
                   style="width:100%; box-sizing:border-box; background-color:var(--bg-body); color:var(--text-primary); border:1px solid var(--border); border-radius:var(--border-radius-sm); padding:6px 10px; font-size:var(--font-size-sm);">
            @error('name') <div style="color:var(--status-offline); font-size:var(--font-size-sm); margin-top:4px;">{{ $message }}</div> @enderror
        </div>
        <div style="margin-bottom:14px;">
            <label class="hlx-muted" style="display:block; margin-bottom:4px; font-size:var(--font-size-sm);">Real Game (for assets)</label>
            <input type="text" name="realgame" value="{{ old('realgame') }}" maxlength="32"
                   placeholder="e.g. css (folder name in hlstatsimg/games/)"
                   style="width:100%; box-sizing:border-box; background-color:var(--bg-body); color:var(--text-primary); border:1px solid var(--border); border-radius:var(--border-radius-sm); padding:6px 10px; font-size:var(--font-size-sm);">
            @error('realgame') <div style="color:var(--status-offline); font-size:var(--font-size-sm); margin-top:4px;">{{ $message }}</div> @enderror
        </div>
        <div style="margin-bottom:16px;">
            <label style="display:flex; align-items:center; gap:8px; color:var(--text-secondary); font-size:var(--font-size-sm); cursor:pointer;">
                <input type="checkbox" name="hidden" value="1" {{ old('hidden') ? 'checked' : '' }}>
                Hide from public
            </label>
        </div>
        <div style="display:flex; gap:8px;">
            <button type="submit" class="hlx-btn-gold">Create Game</button>
            <a href="{{ route('admin.games.index') }}" class="hlx-btn-green">Cancel</a>
        </div>
    </form>
</x-layouts.admin>
