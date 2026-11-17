{{-- resources/views/partials/kolom.blade.php --}}
{{-- Include with: @include('partials.kolom') before </body> --}}

<button type="button" id="wyz-ai-launcher" class="wyz-ai-launcher" aria-controls="wyz-ai-dialog" aria-expanded="false">
    <span class="wyz-ai-launcher-avatar" aria-hidden="true">ক<span class="wyz-ai-dot"></span></span>
    <span class="wyz-ai-launcher-copy">
        <b data-bot-name>Kolom</b>
        <small data-bot-tagline>Ask me anything</small>
    </span>
</button>

<div class="wyz-ai-shade" id="wyz-ai-shade" hidden></div>

<section id="wyz-ai-dialog" class="wyz-ai-dialog" role="dialog" aria-modal="true" aria-labelledby="wyz-ai-title"
    hidden>

    <header class="wyz-ai-head">
        <div class="wyz-ai-head-avatar" aria-hidden="true">ক</div>
        <div class="wyz-ai-head-copy">
            <h2 id="wyz-ai-title">
                <span data-bot-name>Kolom</span>
                <span class="wyz-ai-status" title="Online"></span>
            </h2>
            <p>WYZEEK education assistant</p>
        </div>
        <div class="wyz-ai-lang" role="group" aria-label="Language">
            <button type="button" data-lang="en" class="is-on">EN</button>
            <button type="button" data-lang="bn">বাংলা</button>
        </div>
        <button type="button" class="wyz-ai-close" id="wyz-ai-close" aria-label="Close assistant">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" d="M6 6l12 12M18 6L6 18" />
            </svg>
        </button>
    </header>

    <div class="wyz-ai-feed" id="wyz-ai-feed" role="log" aria-live="polite" aria-relevant="additions text"
        aria-label="Conversation with Kolom"></div>

    <div class="wyz-ai-tools">
        <div class="wyz-ai-options" id="wyz-ai-options" aria-label="What would you like to do?">
            <button type="button" data-task="result" aria-pressed="false">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7l2 2 4-4" />
                </svg>
                <span data-label="result">Update results</span>
            </button>

            <button type="button" data-task="attendance" aria-pressed="false">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span data-label="attendance">Update attendance</span>
            </button>

            <button type="button" data-task="notice" aria-pressed="false">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                </svg>
                <span data-label="notice">Draft a notice</span>
            </button>

            <button type="button" data-task="help" aria-pressed="false">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span data-label="help">How it works</span>
            </button>
        </div>

        <div class="wyz-ai-sample" id="wyz-ai-sample" hidden>
            <span data-label="sampleHint">Need an example?</span>
            <button type="button" id="wyz-ai-example" data-label="sampleBtn">Use sample</button>
        </div>

        <form class="wyz-ai-compose" id="wyz-ai-form" autocomplete="off">
            <label for="wyz-ai-input" class="wyz-sr-only">Message Kolom</label>
            <textarea id="wyz-ai-input" rows="1" maxlength="600" placeholder="Type a message…"></textarea>
            <button type="submit" id="wyz-ai-send" aria-label="Send message">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
            </button>
        </form>
    </div>
</section>

@verbatim
    <style>
        :root {
            --kolom-ink: #0c1a2b;
            --kolom-ink-2: #16283d;
            --kolom-line: #e6eaf0;
            --kolom-line-2: #eef1f5;
            --kolom-soft: #f6f8fa;
            --kolom-text: #334155;
            --kolom-muted: #6b7c90;
            --kolom-accent: #0f9d6e;
            --kolom-font: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto,
                "Hind Siliguri", "Noto Sans Bengali", sans-serif;
        }

        .wyz-ai-launcher {
            position: fixed;
            right: 20px;
            bottom: 20px;
            z-index: 2147483000;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 6px 18px 6px 6px;
            border: 1px solid var(--kolom-line);
            border-radius: 999px;
            background: #fff;
            cursor: pointer;
            font-family: var(--kolom-font);
            box-shadow: 0 14px 38px -18px rgba(12, 26, 43, .5);
            transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
        }

        .wyz-ai-launcher:hover {
            transform: translateY(-1px);
            border-color: #d6dde6;
            box-shadow: 0 18px 44px -18px rgba(12, 26, 43, .55);
        }

        .wyz-ai-launcher-avatar {
            position: relative;
            display: grid;
            place-items: center;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(145deg, var(--kolom-ink-2), var(--kolom-ink));
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            line-height: 1;
        }

        .wyz-ai-dot {
            position: absolute;
            right: -1px;
            bottom: -1px;
            width: 11px;
            height: 11px;
            border-radius: 50%;
            background: var(--kolom-accent);
            border: 2px solid #fff;
            animation: kolom-pulse 2.6s infinite;
        }

        .wyz-ai-launcher-copy {
            display: flex;
            flex-direction: column;
            line-height: 1.25;
            text-align: left;
        }

        .wyz-ai-launcher-copy b {
            font-size: 13px;
            font-weight: 700;
            color: var(--kolom-ink);
        }

        .wyz-ai-launcher-copy small {
            font-size: 11px;
            color: var(--kolom-muted);
        }

        .wyz-ai-shade {
            position: fixed;
            inset: 0;
            z-index: 2147483000;
            background: rgba(12, 26, 43, .34);
            backdrop-filter: blur(2px);
            animation: kolom-fade .2s ease both;
        }

        .wyz-ai-dialog {
            position: fixed;
            right: 20px;
            bottom: 88px;
            z-index: 2147483001;
            display: flex;
            flex-direction: column;
            width: 396px;
            height: min(620px, calc(100dvh - 120px));
            overflow: hidden;
            border: 1px solid var(--kolom-line);
            border-radius: 20px;
            background: #fff;
            font-family: var(--kolom-font);
            box-shadow: 0 40px 90px -40px rgba(12, 26, 43, .55);
            animation: kolom-pop .26s cubic-bezier(.22, 1, .36, 1) both;
        }

        .wyz-ai-dialog[hidden],
        .wyz-ai-shade[hidden],
        .wyz-ai-sample[hidden] {
            display: none !important;
        }

        .wyz-ai-head {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 12px 12px 14px;
            border-bottom: 1px solid var(--kolom-line-2);
            background: #fff;
        }

        .wyz-ai-head-avatar {
            display: grid;
            place-items: center;
            width: 36px;
            height: 36px;
            flex: 0 0 36px;
            border-radius: 12px;
            background: linear-gradient(145deg, var(--kolom-ink-2), var(--kolom-ink));
            color: #fff;
            font-size: 15px;
            font-weight: 700;
        }

        .wyz-ai-head-copy {
            min-width: 0;
            flex: 1;
        }

        .wyz-ai-head-copy h2 {
            display: flex;
            align-items: center;
            gap: 6px;
            margin: 0;
            font-size: 14.5px;
            font-weight: 700;
            letter-spacing: -.01em;
            color: var(--kolom-ink);
        }

        .wyz-ai-status {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--kolom-accent);
        }

        .wyz-ai-head-copy p {
            margin: 1px 0 0;
            font-size: 11.5px;
            color: var(--kolom-muted);
        }

        .wyz-ai-lang {
            display: flex;
            gap: 2px;
            padding: 2px;
            border-radius: 9px;
            background: var(--kolom-soft);
            border: 1px solid var(--kolom-line-2);
        }

        .wyz-ai-lang button {
            padding: 4px 8px;
            border: 0;
            border-radius: 7px;
            background: transparent;
            font: inherit;
            font-size: 11px;
            font-weight: 700;
            color: var(--kolom-muted);
            cursor: pointer;
            transition: background .15s, color .15s;
        }

        .wyz-ai-lang button.is-on {
            background: #fff;
            color: var(--kolom-ink);
            box-shadow: 0 1px 2px rgba(12, 26, 43, .1);
        }

        .wyz-ai-close {
            display: grid;
            place-items: center;
            width: 32px;
            height: 32px;
            flex: 0 0 32px;
            border: 0;
            border-radius: 50%;
            background: transparent;
            color: #8798ab;
            cursor: pointer;
            transition: background .15s, color .15s;
        }

        .wyz-ai-close svg {
            width: 16px;
            height: 16px;
        }

        .wyz-ai-close:hover {
            background: var(--kolom-soft);
            color: var(--kolom-ink);
        }

        .wyz-ai-feed {
            flex: 1;
            min-height: 0;
            display: flex;
            flex-direction: column;
            gap: 9px;
            padding: 16px 14px;
            overflow-y: auto;
            overscroll-behavior: contain;
            background: #f8fafc;
            scrollbar-width: thin;
            scrollbar-color: #cfd8e3 transparent;
        }

        .wyz-ai-feed::-webkit-scrollbar {
            width: 6px;
        }

        .wyz-ai-feed::-webkit-scrollbar-thumb {
            background: #cfd8e3;
            border-radius: 99px;
        }

        .wyz-ai-msg {
            display: flex;
            animation: kolom-msg .3s cubic-bezier(.22, 1, .36, 1) both;
        }

        .wyz-ai-msg-user {
            justify-content: flex-end;
        }

        .wyz-ai-bubble {
            max-width: 86%;
            padding: 9px 13px;
            border-radius: 14px;
            font-size: 13.5px;
            line-height: 1.55;
            white-space: pre-line;
            word-break: break-word;
        }

        .wyz-ai-msg-bot .wyz-ai-bubble {
            border: 1px solid var(--kolom-line);
            border-bottom-left-radius: 5px;
            background: #fff;
            color: #2a3a4e;
            box-shadow: 0 1px 2px rgba(12, 26, 43, .04);
        }

        .wyz-ai-msg-user .wyz-ai-bubble {
            border-bottom-right-radius: 5px;
            background: var(--kolom-ink);
            color: #fff;
        }

        .wyz-ai-typing {
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 13px 14px;
        }

        .wyz-ai-typing span {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #b6c2d1;
            animation: kolom-blink 1.2s infinite;
        }

        .wyz-ai-typing span:nth-child(2) {
            animation-delay: .15s;
        }

        .wyz-ai-typing span:nth-child(3) {
            animation-delay: .3s;
        }

        .wyz-ai-tools {
            flex: 0 0 auto;
            border-top: 1px solid var(--kolom-line-2);
            background: #fff;
            padding-bottom: env(safe-area-inset-bottom, 0);
        }

        .wyz-ai-options {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 7px;
            padding: 11px 14px 0;
        }

        .wyz-ai-options button {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 9px 11px;
            border: 1px solid var(--kolom-line);
            border-radius: 11px;
            background: #fff;
            color: var(--kolom-text);
            font: inherit;
            font-size: 12.5px;
            font-weight: 600;
            text-align: left;
            cursor: pointer;
            transition: border-color .15s, background .15s, color .15s;
        }

        .wyz-ai-options button svg {
            width: 15px;
            height: 15px;
            flex: 0 0 15px;
            color: #8798ab;
            transition: color .15s;
        }

        .wyz-ai-options button:hover {
            border-color: #d3dce6;
            background: #fbfcfd;
        }

        .wyz-ai-options button.is-on {
            border-color: #c5d1de;
            background: #f2f6f9;
            color: var(--kolom-ink);
        }

        .wyz-ai-options button.is-on svg {
            color: var(--kolom-ink);
        }

        .wyz-ai-sample {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 10px 14px 0;
            font-size: 11.5px;
            color: var(--kolom-muted);
        }

        .wyz-ai-sample button {
            padding: 0;
            border: 0;
            background: none;
            font: inherit;
            font-size: 11.5px;
            font-weight: 700;
            color: var(--kolom-ink);
            text-decoration: underline;
            text-underline-offset: 2px;
            cursor: pointer;
        }

        .wyz-ai-compose {
            display: flex;
            align-items: flex-end;
            gap: 8px;
            padding: 11px 14px 14px;
        }

        .wyz-ai-compose textarea {
            flex: 1;
            min-height: 42px;
            max-height: 120px;
            padding: 11px 14px;
            border: 1px solid var(--kolom-line);
            border-radius: 14px;
            background: var(--kolom-soft);
            color: var(--kolom-text);
            font: inherit;
            font-size: 13.5px;
            line-height: 1.45;
            resize: none;
            outline: none;
            transition: border-color .15s, background .15s, box-shadow .15s;
        }

        .wyz-ai-compose textarea::placeholder {
            color: #9aa8b8;
        }

        .wyz-ai-compose textarea:focus {
            border-color: #c3ccd8;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(12, 26, 43, .05);
        }

        .wyz-ai-compose button[type="submit"] {
            display: grid;
            place-items: center;
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            border: 0;
            border-radius: 50%;
            background: var(--kolom-ink);
            color: #fff;
            cursor: pointer;
            transition: background .15s, transform .12s;
        }

        .wyz-ai-compose button[type="submit"] svg {
            width: 17px;
            height: 17px;
        }

        .wyz-ai-compose button[type="submit"]:hover {
            background: #132a42;
        }

        .wyz-ai-compose button[type="submit"]:active {
            transform: scale(.94);
        }

        .wyz-ai-card {
            overflow: hidden;
            border: 1px solid var(--kolom-line);
            border-radius: 14px;
            background: #fff;
            animation: kolom-msg .3s cubic-bezier(.22, 1, .36, 1) both;
        }

        .wyz-ai-card.is-saved {
            border-color: #cfe9dd;
        }

        .wyz-ai-card-head {
            padding: 10px 14px;
            border-bottom: 1px solid var(--kolom-line-2);
        }

        .wyz-ai-card-head h3 {
            margin: 0;
            font-size: 13px;
            font-weight: 700;
            color: var(--kolom-ink);
        }

        .wyz-ai-card-head p {
            margin: 2px 0 0;
            font-size: 11.5px;
            color: var(--kolom-muted);
        }

        .wyz-ai-card-body {
            max-height: 214px;
            overflow: auto;
        }

        .wyz-ai-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
        }

        .wyz-ai-table th {
            padding: 7px 14px;
            border-bottom: 1px solid var(--kolom-line-2);
            background: #fafbfc;
            text-align: left;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: #93a2b4;
        }

        .wyz-ai-table td {
            padding: 7px 14px;
            border-bottom: 1px solid #f2f5f8;
            color: var(--kolom-text);
            vertical-align: middle;
        }

        .wyz-ai-table tr:last-child td {
            border-bottom: 0;
        }

        .wyz-ai-table td:first-child {
            font-weight: 600;
            color: #43536a;
            white-space: nowrap;
        }

        .wyz-ai-field {
            width: 100%;
            padding: 6px 9px;
            border: 1px solid var(--kolom-line);
            border-radius: 8px;
            background: #fbfcfd;
            color: var(--kolom-ink);
            font: inherit;
            font-size: 12.5px;
            outline: none;
            transition: border-color .15s, background .15s;
        }

        .wyz-ai-field:focus {
            border-color: #c3ccd8;
            background: #fff;
        }

        .wyz-ai-field.is-invalid {
            border-color: #e0a0a0;
            background: #fff7f7;
        }

        .wyz-ai-field:disabled {
            background: #f4f7fa;
            color: #7b8a9c;
        }

        textarea.wyz-ai-field {
            min-height: 62px;
            line-height: 1.5;
            resize: none;
        }

        .wyz-ai-card-foot {
            display: flex;
            gap: 8px;
            padding: 10px 14px;
            border-top: 1px solid var(--kolom-line-2);
            background: #fbfcfd;
        }

        .wyz-ai-btn {
            flex: 1;
            padding: 9px 12px;
            border: 1px solid transparent;
            border-radius: 10px;
            font: inherit;
            font-size: 12.5px;
            font-weight: 700;
            cursor: pointer;
            transition: background .15s, border-color .15s, color .15s;
        }

        .wyz-ai-btn-ghost {
            border-color: var(--kolom-line);
            background: #fff;
            color: #5b6b80;
        }

        .wyz-ai-btn-ghost:hover {
            background: #f3f6f9;
        }

        .wyz-ai-btn-primary {
            background: var(--kolom-ink);
            color: #fff;
        }

        .wyz-ai-btn-primary:hover {
            background: #132a42;
        }

        .wyz-ai-btn.is-done {
            border-color: #cfe9dd;
            background: #eef8f3;
            color: #0b7a56;
            cursor: default;
        }

        .wyz-sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        @keyframes kolom-pop {
            from {
                opacity: 0;
                transform: translateY(14px) scale(.985);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        @keyframes kolom-msg {
            from {
                opacity: 0;
                transform: translateY(6px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        @keyframes kolom-fade {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes kolom-blink {

            0%,
            80%,
            100% {
                opacity: .25;
            }

            40% {
                opacity: 1;
                transform: translateY(-2px);
            }
        }

        @keyframes kolom-pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(15, 157, 110, .45);
            }

            70% {
                box-shadow: 0 0 0 7px rgba(15, 157, 110, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(15, 157, 110, 0);
            }
        }

        @media (max-width: 640px) {
            .wyz-ai-launcher {
                display: none;
                right: 14px;
                bottom: 80px;
            }

            .wyz-ai-dialog {
                left: 0;
                right: 0;
                bottom: 0;
                width: 100%;
                height: 88vh;
                height: min(88dvh, 760px);
                border-radius: 20px 20px 0 0;
                border-bottom: 0;
                animation: kolom-sheet .28s cubic-bezier(.22, 1, .36, 1) both;
            }

            .wyz-ai-feed {
                padding: 14px 12px;
            }

            .wyz-ai-bubble {
                max-width: 90%;
            }
        }

        @media (min-width: 641px) {
            .wyz-ai-shade {
                display: none;
            }
        }

        @keyframes kolom-sheet {
            from {
                opacity: 0;
                transform: translateY(26px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .wyz-ai-dialog,
            .wyz-ai-msg,
            .wyz-ai-card,
            .wyz-ai-dot,
            .wyz-ai-typing span {
                animation: none !important;
            }
        }
    </style>
@endverbatim
