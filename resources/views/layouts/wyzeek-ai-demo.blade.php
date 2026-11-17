{{-- WYZEEK AI assistant: meeting-only local demonstration. No server endpoints, no DB writes. --}}
<button type="button" id="wyz-ai-launcher" class="wyz-ai-launcher" aria-controls="wyz-ai-dialog" aria-expanded="false" aria-label="Open WYZEEK AI demo">
    <span class="wyz-ai-launcher-pulse" aria-hidden="true"></span>
    <img src="{{ asset('assets/img/wyzeek-icon.png') }}" alt="" aria-hidden="true">
    <span class="wyz-ai-launcher-label">AI Demo <small>Tap to explore</small></span>
</button>
<div class="wyz-ai-shade" id="wyz-ai-shade" hidden></div>
<section id="wyz-ai-dialog" class="wyz-ai-dialog" role="dialog" aria-modal="true" aria-labelledby="wyz-ai-title" aria-describedby="wyz-ai-disclaimer" hidden>
    <header class="wyz-ai-head">
        <div class="wyz-ai-head-icon" aria-hidden="true">✦</div>
        <div class="wyz-ai-head-copy">
            <h2 id="wyz-ai-title">WYZEEK AI Assistant <span class="wyz-ai-live-dot" aria-hidden="true"></span></h2>
            <p>Animated presentation · Concept prototype</p>
        </div>
        <button type="button" class="wyz-ai-close" id="wyz-ai-close" aria-label="Close assistant">×</button>
    </header>
    <p id="wyz-ai-disclaimer" class="wyz-ai-notice">DEMO ONLY — No ChatGPT API, real AI processing, or database updates. Confirmation is simulated.</p>
    <div class="wyz-ai-feed" id="wyz-ai-feed" aria-live="polite" aria-relevant="additions text" aria-label="AI demo conversation">
        <div class="wyz-ai-msg wyz-ai-msg-bot"><span class="wyz-ai-bubble">Hello! 👋 I'm the WYZEEK AI Assistant prototype. Choose a workflow to see how a teacher could enter data by message or voice.</span></div>
    </div>
    <div class="wyz-ai-options" id="wyz-ai-options" aria-label="Choose demonstration workflow">
        <button type="button" data-wyz-demo="result">📊 Update Result</button>
        <button type="button" data-wyz-demo="attendance">📅 Update Attendance</button>
        <button type="button" data-wyz-demo="notice">📣 Prepare Notice</button>
        <button type="button" data-wyz-demo="help">❓ How It Works</button>
    </div>
    <div class="wyz-ai-sample" id="wyz-ai-sample" hidden>
        <span>Example (editable):</span>
        <button type="button" id="wyz-ai-example" title="Fill the text box with the sample input">Use sample</button>
    </div>
    <form class="wyz-ai-compose" id="wyz-ai-form" autocomplete="off">
        <label for="wyz-ai-input" class="wyz-visually-hidden">Enter a demo message</label>
        <textarea id="wyz-ai-input" rows="1" placeholder="Choose a workflow above…" maxlength="600"></textarea>
        <button type="submit" id="wyz-ai-send" aria-label="Send demo message">➤</button>
    </form>
    <div class="wyz-ai-foot">WYZEEK · Paperless Education · Client-side demo</div>
</section>
