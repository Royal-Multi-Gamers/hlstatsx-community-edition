@php
    $theme = app(\App\Services\ThemeService::class)->getActive();
    $logo    = $theme['logo']   ?? [];
    $header  = $theme['header'] ?? [];
    $navBtns = $header['nav-buttons'] ?? [];

    $forumUrl     = \App\Models\Option::get('forum_address', '#');
    $showChat     = \App\Models\Option::get('nav_globalchat', '1') === '1';
    $showCheaters = \App\Models\Option::get('nav_cheaters', '1') === '1';

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

<div x-data="{ open: false }">

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
                    <a href="#" title="Steam" style="color:var(--text-secondary); font-size:12px; text-decoration:none;">{{ __('Steam') }}</a>
                    <a href="#" title="Discord" style="color:var(--text-secondary); font-size:12px; text-decoration:none;">{{ __('Discord') }}</a>
                    <span style="color:var(--border); font-size:12px;">|</span>
                    <a href="{{ route('language.switch', 'en') }}"
                       style="font-size:11px; font-weight:600; text-decoration:none; padding:1px 6px; border-radius:3px;
                              {{ app()->getLocale() === 'en' ? 'background-color:var(--accent-primary); color:#fff;' : 'color:var(--text-secondary);' }}">EN</a>
                    <a href="{{ route('language.switch', 'fr') }}"
                       style="font-size:11px; font-weight:600; text-decoration:none; padding:1px 6px; border-radius:3px;
                              {{ app()->getLocale() === 'fr' ? 'background-color:var(--accent-primary); color:#fff;' : 'color:var(--text-secondary);' }}">FR</a>
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
            <a href="{{ route('language.switch', 'en') }}"
               style="font-size:11px; font-weight:600; padding:2px 10px; border-radius:3px; text-decoration:none;
                      {{ app()->getLocale() === 'en' ? 'background-color:var(--accent-primary); color:#fff;' : 'color:var(--text-secondary); border:1px solid var(--border);' }}">EN</a>
            <a href="{{ route('language.switch', 'fr') }}"
               style="font-size:11px; font-weight:600; padding:2px 10px; border-radius:3px; text-decoration:none;
                      {{ app()->getLocale() === 'fr' ? 'background-color:var(--accent-primary); color:#fff;' : 'color:var(--text-secondary); border:1px solid var(--border);' }}">FR</a>
        </div>
    </div>

</div>
