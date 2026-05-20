<x-layouts.admin title="Dashboard">

    {{-- Update checker --}}
    @if($versionInfo['upToDate'] === false)
        <div style="background-color:#2d1f07; border:1px solid #f59e0b; border-radius:var(--border-radius-md); padding:14px 18px; margin-bottom:20px; display:flex; align-items:center; justify-content:space-between; gap:12px;">
            <div style="display:flex; align-items:center; gap:10px;">
                <span style="font-size:18px;">⚠</span>
                <div>
                    <span style="color:#fbbf24; font-weight:600; font-size:14px;">{{ __('Update available') }} — v{{ $versionInfo['latestTag'] }}</span>
                    @if(!empty($versionInfo['latest']['name']))
                        <span class="hlx-muted" style="font-size:12px; margin-left:8px;">{{ $versionInfo['latest']['name'] }}</span>
                    @endif
                    <div class="hlx-muted" style="font-size:12px; margin-top:2px;">{{ __('Installed:') }} v{{ $versionInfo['installed'] }}</div>
                </div>
            </div>
            @if(!empty($versionInfo['latest']['html_url']))
                <a href="{{ $versionInfo['latest']['html_url'] }}" target="_blank" rel="noopener"
                   style="background-color:#f59e0b; color:#000; padding:6px 14px; border-radius:var(--border-radius-sm); font-size:13px; font-weight:600; text-decoration:none; white-space:nowrap;">
                    {{ __('Download') }} ↗
                </a>
            @endif
        </div>
    @elseif($versionInfo['upToDate'] === true)
        <div style="background-color:#0d2b1a; border:1px solid #22c55e; border-radius:var(--border-radius-md); padding:10px 18px; margin-bottom:20px; display:flex; align-items:center; gap:10px;">
            <span style="font-size:16px;">✅</span>
            <span style="color:#4ade80; font-size:13px;">{{ __('Up to date') }} — v{{ $versionInfo['installed'] }}</span>
        </div>
    @else
        <div style="background-color:var(--bg-surface-alt); border:1px solid var(--border); border-radius:var(--border-radius-md); padding:10px 18px; margin-bottom:20px; display:flex; align-items:center; gap:10px;">
            <span style="font-size:16px;">ℹ</span>
            <span class="hlx-muted" style="font-size:13px;">{{ __('Version') }} v{{ $versionInfo['installed'] }} — {{ __('Could not check for updates') }}</span>
        </div>
    @endif

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
