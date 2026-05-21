@php
    $theme = app(\App\Services\ThemeService::class)->getActive();
    $logo    = $theme['logo']   ?? [];
    $header  = $theme['header'] ?? [];
    $navBtns = $header['nav-buttons'] ?? [];

    $forumUrl     = \App\Models\Option::get('forum_address', '#');
    $showChat     = \App\Models\Option::get('nav_globalchat', '1') === '1';
    $showCheaters = \App\Models\Option::get('nav_cheaters', '1') === '1';
    $steamUrl     = \App\Models\Option::get('steam_url', '');
    $discordUrl   = \App\Models\Option::get('discord_url', '');
    $showSteam    = \App\Models\Option::get('nav_steam', '1') === '1' && !empty($steamUrl);
    $showDiscord  = \App\Models\Option::get('nav_discord', '1') === '1' && !empty($discordUrl);
    $showLang     = \App\Models\Option::get('nav_lang_switcher', '1') === '1';

    // Detect available locales from lang/*.json files
    $availableLocales = collect(glob(lang_path('*.json')))
        ->map(fn($f) => pathinfo($f, PATHINFO_FILENAME))
        ->sort()
        ->values();

    // Map locale code → country flag code
    $flagMap = [
        'en' => 'gb', 'fr' => 'fr', 'de' => 'de', 'es' => 'es',
        'it' => 'it', 'pt' => 'pt', 'nl' => 'nl', 'ru' => 'ru',
        'zh' => 'cn', 'ja' => 'jp', 'ko' => 'kr', 'ar' => 'sa',
        'pl' => 'pl', 'cs' => 'cz', 'tr' => 'tr', 'sv' => 'se',
        'da' => 'dk', 'fi' => 'fi', 'no' => 'no', 'hr' => 'hr',
        'hu' => 'hu', 'ro' => 'ro', 'bg' => 'bg', 'uk' => 'ua',
        'sk' => 'sk', 'sl' => 'si', 'el' => 'gr', 'lt' => 'lt',
        'lv' => 'lv', 'et' => 'ee',
    ];
    $currentFlag = $flagMap[app()->getLocale()] ?? app()->getLocale();

    // Build nav links once — reused in desktop nav and mobile drawer
    $allNavLinks = collect($navBtns)->map(function ($btn) use ($forumUrl) {
        $url = $btn['url'];
        if (strtolower($btn['label']) === 'forums') $url = !empty($forumUrl) ? $forumUrl : '#';
        elseif (strtolower($btn['label']) === 'help') $url = route('help');
        return ['label' => $btn['label'], 'url' => $url];
    });
    if ($showChat)     $allNavLinks->push(['label' => __('Chat'),           'url' => route('chat.index')]);
    if ($showCheaters) $allNavLinks->push(['label' => __('Banned Players'), 'url' => route('bans.index')]);
    $allNavLinks->push(['label' => __('Admin'), 'url' => route('admin.dashboard')]);
@endphp

<div x-data="{ open: false, langOpen: false }">

    <header class="hlx-header" style="display:flex; align-items:center; padding:0 16px; justify-content:space-between;">

        {{-- Logo --}}
        <a href="{{ route('home') }}" style="display:flex; align-items:center; gap:10px; text-decoration:none;">
            @if($logo['show-icon'] ?? true)
                <span style="
                    display:inline-flex; align-items:center; justify-content:center;
                    width:36px; height:36px; border-radius:6px;
                    background-color:{{ $logo['icon-bg'] ?? 'var(--accent-primary)' }};
                    font-size:14px; font-weight:700; color:#fff;
                ">H</span>
            @endif
            <span style="font-size:17px; font-weight:700; color:{{ $logo['color'] ?? 'var(--accent-secondary)' }}; letter-spacing:0.04em; font-family:var(--font-family-base);">
                {{ $logo['text'] ?? 'HLSTATSX: CE' }}
            </span>
        </a>

        {{-- Desktop: nav buttons + social icons (hidden on mobile via CSS) --}}
        <div class="hlx-header-desktop" style="display:flex; flex-direction:column; align-items:flex-end; gap:6px;">

            <div style="display:flex; gap:6px; flex-wrap:wrap; justify-content:flex-end;">
                @foreach($allNavLinks as $link)
                    <a href="{{ $link['url'] }}"
                       style="background-color:var(--accent-primary); color:#fff; border-radius:var(--border-radius-pill); padding:3px 12px; font-size:var(--font-size-sm); font-weight:600; text-decoration:none; white-space:nowrap;">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>

            @if($header['show-social-icons'] ?? true)
                <div style="display:flex; gap:8px; align-items:center;">
                    @if($showSteam)
                        <a href="{{ $steamUrl }}" title="Steam" target="_blank" rel="noopener" style="color:var(--text-secondary); font-size:12px; text-decoration:none;">{{ __('Steam') }}</a>
                    @endif
                    @if($showDiscord)
                        <a href="{{ $discordUrl }}" title="Discord" target="_blank" rel="noopener" style="color:var(--text-secondary); font-size:12px; text-decoration:none;">{{ __('Discord') }}</a>
                    @endif
                    @if(($showSteam || $showDiscord) && $showLang)
                        <span style="color:var(--border); font-size:12px;">|</span>
                    @endif
                    @if($showLang && $availableLocales->count() > 1)
                        <div style="position:relative;" @click.outside="langOpen = false">
                            <button @click="langOpen = !langOpen"
                                    style="display:flex; align-items:center; gap:4px; background:none; border:1px solid var(--border); border-radius:4px; cursor:pointer; padding:2px 7px; font-size:11px; font-weight:600; color:var(--text-secondary);">
                                <img src="/hlstatsimg/flags/{{ $currentFlag }}.gif" alt="{{ app()->getLocale() }}" style="width:16px; height:11px; object-fit:cover;">
                                {{ strtoupper(app()->getLocale()) }}
                                <span style="font-size:8px; line-height:1;">&#9660;</span>
                            </button>
                            <div x-show="langOpen" x-transition
                                 style="position:absolute; right:0; top:calc(100% + 4px); background:var(--bg-surface); border:1px solid var(--border); border-radius:4px; min-width:90px; z-index:200; box-shadow:0 4px 12px rgba(0,0,0,0.2); overflow:hidden;">
                                @foreach($availableLocales as $loc)
                                    @php $fc = $flagMap[$loc] ?? $loc; @endphp
                                    <form method="POST" action="{{ route('language.switch', $loc) }}" style="margin:0;">
                                        @csrf
                                        <button type="submit"
                                                style="display:flex; align-items:center; gap:7px; width:100%; padding:6px 10px; background:{{ app()->getLocale() === $loc ? 'var(--accent-primary)' : 'none' }}; color:{{ app()->getLocale() === $loc ? '#fff' : 'var(--text-primary)' }}; border:none; cursor:pointer; font-size:12px; font-weight:500; text-align:left; white-space:nowrap;">
                                            <img src="/hlstatsimg/flags/{{ $fc }}.gif" alt="{{ $loc }}" style="width:16px; height:11px; object-fit:cover;">
                                            {{ strtoupper($loc) }}
                                        </button>
                                    </form>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endif

        </div>

        {{-- Mobile: hamburger button (hidden on desktop via CSS) --}}
        <button class="hlx-hamburger" @click="open = !open" :aria-expanded="open.toString()" aria-label="Toggle navigation">
            <span x-show="!open" aria-hidden="true">&#9776;</span>
            <span x-show="open"  aria-hidden="true">&#x2715;</span>
        </button>

    </header>

    {{-- Mobile nav drawer --}}
    <div x-show="open" x-transition class="hlx-mobile-nav">
        @foreach($allNavLinks as $link)
            <a href="{{ $link['url'] }}" @click="open = false">{{ $link['label'] }}</a>
        @endforeach
        <div class="hlx-mobile-lang">
            @if($showLang && $availableLocales->count() > 1)
                @foreach($availableLocales as $loc)
                    @php $fc = $flagMap[$loc] ?? $loc; @endphp
                    <form method="POST" action="{{ route('language.switch', $loc) }}" style="display:inline;">
                        @csrf
                        <button type="submit"
                                style="display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:600; border:none; cursor:pointer; padding:4px 10px; border-radius:4px; background:{{ app()->getLocale() === $loc ? 'var(--accent-primary)' : 'transparent' }}; color:{{ app()->getLocale() === $loc ? '#fff' : 'var(--text-secondary)' }}; {{ app()->getLocale() !== $loc ? 'border:1px solid var(--border);' : '' }}">
                            <img src="/hlstatsimg/flags/{{ $fc }}.gif" alt="{{ $loc }}" style="width:16px; height:11px; object-fit:cover;">
                            {{ strtoupper($loc) }}
                        </button>
                    </form>
                @endforeach
            @endif
        </div>
    </div>

</div>
