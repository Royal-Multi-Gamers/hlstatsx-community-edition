<x-layouts.admin :title="'Edit Game: ' . $game->name">
    <form method="POST" action="{{ route('admin.games.update', $game->code) }}" style="max-width:480px;">
        @csrf @method('PUT')
        <div style="margin-bottom:14px;">
            <label class="hlx-muted" style="display:block; margin-bottom:4px; font-size:var(--font-size-sm);">Game Name</label>
            <input type="text" name="name" value="{{ old('name', $game->name) }}" required
                   style="width:100%; box-sizing:border-box; background-color:var(--bg-body); color:var(--text-primary); border:1px solid var(--border); border-radius:var(--border-radius-sm); padding:6px 10px; font-size:var(--font-size-sm);">
        </div>
        <div style="margin-bottom:14px;">
            <label class="hlx-muted" style="display:block; margin-bottom:4px; font-size:var(--font-size-sm);">Real Game (for assets)</label>
            <input type="text" name="realgame" value="{{ old('realgame', $game->realgame) }}"
                   style="width:100%; box-sizing:border-box; background-color:var(--bg-body); color:var(--text-primary); border:1px solid var(--border); border-radius:var(--border-radius-sm); padding:6px 10px; font-size:var(--font-size-sm);">
        </div>
        <div style="margin-bottom:16px;">
            <label style="display:flex; align-items:center; gap:8px; color:var(--text-secondary); font-size:var(--font-size-sm); cursor:pointer;">
                <input type="checkbox" name="hidden" value="1" {{ old('hidden', $game->hidden) == '1' ? 'checked' : '' }}>
                Hide from public
            </label>
        </div>
        <div style="display:flex; gap:8px;">
            <button type="submit" class="hlx-btn-gold">Save</button>
            <a href="{{ route('admin.games.index') }}" class="hlx-btn-green">Cancel</a>
        </div>
    </form>
</x-layouts.admin>
