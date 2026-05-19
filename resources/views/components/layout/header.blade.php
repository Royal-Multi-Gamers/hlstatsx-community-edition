@php
    $theme = app(\App\Services\ThemeService::class)->getActive();
    $logo   = $theme['logo'] ?? [];
    $header = $theme['header'] ?? [];
    $navBtns = $header['nav-buttons'] ?? [];

    $forumUrl     = \App\Models\Option::get('forum_address', '#');
    $showChat     = \App\Models\Option::get('nav_globalchat', '1') === '1';
    $showCheaters = \App\Models\Option::get('nav_cheaters', '1') === '1';
@endphp

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

    {{-- Right side: nav buttons + social icons --}}
    <div style="display:flex; flex-direction:column; align-items:flex-end; gap:6px;">

        {{-- Nav buttons --}}
        @if(!empty($navBtns))
            <div style="display:flex; gap:6px; flex-wrap:wrap; justify-content:flex-end;">
                @foreach($navBtns as $btn)
                    @php
                        $btnUrl = $btn['url'];
                        if (strtolower($btn['label']) === 'forums') {
                            $btnUrl = !empty($forumUrl) ? $forumUrl : '#';
                        } elseif (strtolower($btn['label']) === 'help') {
                            $btnUrl = route('help');
                        }
                    @endphp
                    <a href="{{ $btnUrl }}"
                       style="background-color:var(--accent-primary); color:#fff; border-radius:var(--border-radius-pill); padding:3px 12px; font-size:var(--font-size-sm); font-weight:600; text-decoration:none; white-space:nowrap;">
                        {{ $btn['label'] }}
                    </a>
                @endforeach

                @if($showChat)
                    <a href="{{ route('chat.index') }}"
                       style="background-color:var(--accent-primary); color:#fff; border-radius:var(--border-radius-pill); padding:3px 12px; font-size:var(--font-size-sm); font-weight:600; text-decoration:none; white-space:nowrap;">
                        {{ __('Chat') }}
                    </a>
                @endif

                @if($showCheaters)
                    <a href="{{ route('bans.index') }}"
                       style="background-color:var(--accent-primary); color:#fff; border-radius:var(--border-radius-pill); padding:3px 12px; font-size:var(--font-size-sm); font-weight:600; text-decoration:none; white-space:nowrap;">
                        {{ __('Banned Players') }}
                    </a>
                @endif

                <a href="{{ route('admin.dashboard') }}"
                   style="background-color:var(--accent-primary); color:#fff; border-radius:var(--border-radius-pill); padding:3px 12px; font-size:var(--font-size-sm); font-weight:600; text-decoration:none; white-space:nowrap;">
                    {{ __('Admin') }}
                </a>
            </div>
        @endif

        {{-- Social icons + language switcher --}}
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
</header>
