{{-- Mobile-only navigation. Original authorized sidebar links remain the source of truth. --}}
<div class="wyz-mobile-overlay" id="wyz-mobile-overlay" aria-hidden="true" hidden></div>
<nav class="wyz-mobile-nav" id="wyz-mobile-nav" aria-label="Mobile application navigation">
    <a class="wyz-mobile-tab" href="{{ route('master') }}" data-wyz-tab="home"><span aria-hidden="true">⌂</span><small>Home</small></a>
    <a class="wyz-mobile-tab" href="#" data-wyz-tab="primary" hidden><span aria-hidden="true">▦</span><small>Modules</small></a>
    <a class="wyz-mobile-tab" href="#" data-wyz-tab="attendance" hidden><span aria-hidden="true">◷</span><small>Attendance</small></a>
    <a class="wyz-mobile-tab" href="#" data-wyz-tab="fees" hidden><span aria-hidden="true">৳</span><small>Fees</small></a>
    <button class="wyz-mobile-tab" type="button" data-wyz-tab="ai" hidden aria-label="Open WYZEEK AI demo"><span aria-hidden="true">✦</span><small>AI Demo</small></button>
    <button class="wyz-mobile-tab" type="button" id="wyz-mobile-more" aria-controls="aside" aria-expanded="false"><span aria-hidden="true">☰</span><small>More</small></button>
</nav>
