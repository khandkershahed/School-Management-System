{{-- Mobile-only navigation --}}
<div class="wyz-mobile-overlay" id="wyz-mobile-overlay" aria-hidden="true" hidden></div>

<nav class="wyz-mobile-nav" id="wyz-mobile-nav" aria-label="Mobile application navigation">

    <a class="wyz-mobile-tab" href="{{ route('master') }}" data-wyz-tab="home">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
            <polyline points="9 22 9 12 15 12 15 22"></polyline>
        </svg>
        <small>Home</small>
    </a>

    <a class="wyz-mobile-tab" href="#" data-wyz-tab="primary" hidden>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round">
            <rect x="3" y="3" width="7" height="7"></rect>
            <rect x="14" y="3" width="7" height="7"></rect>
            <rect x="14" y="14" width="7" height="7"></rect>
            <rect x="3" y="14" width="7" height="7"></rect>
        </svg>
        <small>Admissions</small>
    </a>

    {{-- AI Button (Floating Action Button) --}}
    <button class="wyz-mobile-tab wyz-tab-ai" type="button" data-wyz-tab="ai" hidden aria-label="Open WYZEEK AI">
        <div class="wyz-ai-fab">
            <svg viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
            </svg>
        </div>
        <small>AI Assistant</small>
    </button>

    <a class="wyz-mobile-tab" href="#" data-wyz-tab="attendance" hidden>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round">
            <path d="M8 2v4"></path>
            <path d="M16 2v4"></path>
            <rect width="18" height="18" x="3" y="4" rx="2"></rect>
            <path d="M3 10h18"></path>
        </svg>
        <small>Attendance</small>
    </a>

    <a class="wyz-mobile-tab" href="#" data-wyz-tab="fees" hidden>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round">
            <line x1="12" y1="1" x2="12" y2="23"></line>
            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
        </svg>
        <small>Fees</small>
    </a>



    <button class="wyz-mobile-tab" type="button" id="wyz-mobile-more" aria-controls="aside" aria-expanded="false">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
            stroke-linejoin="round">
            <line x1="4" y1="12" x2="20" y2="12"></line>
            <line x1="4" y1="6" x2="20" y2="6"></line>
            <line x1="4" y1="18" x2="20" y2="18"></line>
        </svg>
        <small>Menu</small>
    </button>
</nav>
