<x-layouts.admin title="Dashboard">

    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(160px, 1fr)); gap:16px; margin-bottom:24px;">
        @foreach([
            ['label' => 'Players', 'value' => number_format($stats['players']), 'link' => route('admin.players.index')],
            ['label' => 'Clans',   'value' => number_format($stats['clans']),   'link' => route('admin.clans.index')],
            ['label' => 'Servers', 'value' => number_format($stats['servers']), 'link' => route('admin.servers.index')],
            ['label' => 'Games',   'value' => number_format($stats['games']),   'link' => route('admin.games.index')],
            ['label' => 'Active Bans', 'value' => number_format($stats['bans']), 'link' => route('admin.bans.index')],
        ] as $card)
            <a href="{{ $card['link'] }}" style="text-decoration:none;">
                <div style="background-color:var(--bg-surface-alt); border:1px solid var(--border); border-radius:var(--border-radius-md); padding:16px; text-align:center;">
                    <div class="hlx-muted" style="font-size:11px; text-transform:uppercase; margin-bottom:4px;">{{ $card['label'] }}</div>
                    <div style="font-size:24px; font-weight:700; color:var(--accent-primary); font-family:var(--font-family-mono);">{{ $card['value'] }}</div>
                </div>
            </a>
        @endforeach
    </div>

    <div style="background-color:var(--bg-surface-alt); border:1px solid var(--border); border-radius:var(--border-radius-md); padding:16px;">
        <h3 style="margin:0 0 12px; color:var(--text-heading); font-size:14px;">{{ __('Global Statistics') }}</h3>
        <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:6px;">
            <li class="hlx-text" style="font-size:var(--font-size-sm);">{{ __('Total kills:') }} <strong>{{ number_format($globalStats['kills'] ?? 0) }}</strong></li>
            <li class="hlx-text" style="font-size:var(--font-size-sm);">{{ __('Total players ranked:') }} <strong>{{ number_format($globalStats['players'] ?? 0) }}</strong></li>
        </ul>
    </div>

</x-layouts.admin>
