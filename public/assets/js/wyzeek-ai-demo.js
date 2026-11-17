/* public/js/kolom.js */
/* Kolom — WYZEEK assistant. 100% client-side. No network, no backend. */
(function () {
    'use strict';

    var BN_DIGITS = '\u09E6\u09E7\u09E8\u09E9\u09EA\u09EB\u09EC\u09ED\u09EE\u09EF';
    var MONTHS = ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'];

    function ascii(text) {
        return String(text).replace(/[০-৯]/g, function (c) {
            return BN_DIGITS.indexOf(c);
        });
    }

    var COPY = {
        en: {
            greet: "Hi — I'm Kolom, the WYZEEK assistant. I can record exam marks, mark attendance and draft notices. Pick a task below or just type.",
            pick: "Choose a task above and I'll take it from there.",
            review: "Here's what I've put together. Check each value, edit anything that's off, then confirm.",
            result: "Send the student ID with marks for Bengali, English and Mathematics — for example: Student 1201 Bengali 100 English 50 Mathematics 50.",
            attendance: "Tell me the class and who is present, absent or late — for example: Class 8 Present 1201, 1202 Absent 1203.",
            notice: "Describe the notice — subject, date and time — and I'll draft it for you.",
            help: "Kolom works in three steps: choose a task, type or speak naturally in Bangla or English, then review the table I build. Nothing is saved until you confirm.",
            errId: "Please include a student ID, for example: Student 1201.",
            errMarks: "I couldn't find subject marks. Try: Student 1201 Bengali 100 English 50 Mathematics 50.",
            errRange: "Marks must be between 0 and 100.",
            errClass: "Please include the class, for example: Class 8 Present 1201, 1202.",
            errStudents: "Add at least one student ID with a status.",
            errConflict: function (ids) {
                return "A student can't be both present and absent: " + ids + ".";
            },
            errNotice: "Write a line or two describing the notice.",
            errFill: "Some fields still need a value.",
            savedResult: function (id) {
                return "Saved. Student " + id + "'s marks are now in the class register.";
            },
            savedAttendance: function (cls) {
                return "Saved. Attendance for Class " + cls + " is recorded.";
            },
            savedNotice: "Published. The notice is now on the institution notice board.",
            discard: "Okay, I've discarded that. Tell me what you'd like to change.",
            titleResult: function (id) {
                return "Results — Student " + id;
            },
            detailResult: "Check each mark before saving",
            headSubject: "Subject",
            headMarks: "Marks",
            headStudent: "Student",
            headDate: "Date",
            headStatus: "Status",
            headField: "Field",
            headValue: "Value",
            titleAttendance: function (cls) {
                return "Attendance — Class " + cls;
            },
            detailAttendance: "Review each status before saving",
            titleNotice: "Notice draft",
            detailNotice: "Edit the wording before publishing",
            labelTitle: "Title",
            labelDate: "Date",
            labelTime: "Time",
            labelMessage: "Message",
            confirm: "Confirm & save",
            discardBtn: "Discard",
            savedBtn: "Saved"
        },
        bn: {
            greet: "আসসালামু আলাইকুম — আমি কলম, WYZEEK-এর সহকারী। পরীক্ষার নম্বর, হাজিরা আর নোটিশ — সব লিখে রাখতে পারি। নিচের যেকোনো একটি বেছে নিন, অথবা সরাসরি লিখুন।",
            pick: "উপরের যেকোনো একটি কাজ বেছে নিন — তারপর আমি এগিয়ে নেব।",
            review: "তথ্যগুলো সাজিয়ে দিয়েছি। প্রতিটি মান দেখে নিন, দরকার হলে বদলান — তারপর নিশ্চিত করুন।",
            result: "শিক্ষার্থীর আইডি ও বাংলা, ইংরেজি, গণিতের নম্বর পাঠান — যেমন: শিক্ষার্থী 1201 বাংলা 100 ইংরেজি 50 গণিত 50।",
            attendance: "শ্রেণি এবং কে উপস্থিত, অনুপস্থিত বা বিলম্বে — জানান। যেমন: শ্রেণি 8 উপস্থিত 1201, 1202 অনুপস্থিত 1203।",
            notice: "নোটিশটি কী নিয়ে, তারিখ ও সময়সহ লিখুন — আমি খসড়া তৈরি করব।",
            help: "কলম তিন ধাপে কাজ করে: কাজ বেছে নিন, বাংলা বা ইংরেজিতে স্বাভাবিকভাবে লিখুন, তারপর আমি যে টেবিল তৈরি করি তা দেখে নিন। আপনি নিশ্চিত না করলে কিছুই সংরক্ষিত হয় না।",
            errId: "শিক্ষার্থীর আইডি দিন — যেমন: শিক্ষার্থী 1201।",
            errMarks: "নম্বর খুঁজে পাইনি। লিখুন: শিক্ষার্থী 1201 বাংলা 100 ইংরেজি 50 গণিত 50।",
            errRange: "নম্বর ০ থেকে ১০০-এর মধ্যে হতে হবে।",
            errClass: "শ্রেণি লিখুন — যেমন: শ্রেণি 8 উপস্থিত 1201, 1202।",
            errStudents: "অন্তত একটি শিক্ষার্থীর আইডি ও অবস্থা দিন।",
            errConflict: function (ids) {
                return "একই শিক্ষার্থী উপস্থিত ও অনুপস্থিত দুটোই হতে পারে না: " + ids + "।";
            },
            errNotice: "নোটিশ সম্পর্কে অন্তত এক-দুই লাইন লিখুন।",
            errFill: "কিছু ঘর এখনো পূরণ করা হয়নি।",
            savedResult: function (id) {
                return "সংরক্ষিত। " + id + " শিক্ষার্থীর নম্বর শ্রেণি খাতায় যোগ হয়েছে।";
            },
            savedAttendance: function (cls) {
                return "সংরক্ষিত। " + cls + " শ্রেণির হাজিরা রেকর্ড হয়েছে।";
            },
            savedNotice: "প্রকাশিত। নোটিশটি এখন প্রতিষ্ঠানের নোটিশ বোর্ডে দেখা যাচ্ছে।",
            discard: "ঠিক আছে, বাতিল করেছি। কী বদলাতে চান বলুন।",
            titleResult: function (id) {
                return "ফলাফল — " + id;
            },
            detailResult: "সংরক্ষণের আগে প্রতিটি নম্বর দেখে নিন",
            headSubject: "বিষয়",
            headMarks: "নম্বর",
            headStudent: "শিক্ষার্থী",
            headDate: "তারিখ",
            headStatus: "অবস্থা",
            headField: "বিবরণ",
            headValue: "মান",
            titleAttendance: function (cls) {
                return "হাজিরা — " + cls + " শ্রেণি";
            },
            detailAttendance: "সংরক্ষণের আগে প্রতিটি অবস্থা দেখে নিন",
            titleNotice: "নোটিশের খসড়া",
            detailNotice: "প্রকাশের আগে ভাষা ঠিক করে নিন",
            labelTitle: "শিরোনাম",
            labelDate: "তারিখ",
            labelTime: "সময়",
            labelMessage: "বার্তা",
            confirm: "নিশ্চিত করে সংরক্ষণ",
            discardBtn: "বাতিল",
            savedBtn: "সংরক্ষিত"
        }
    };

    var LABELS = {
        result: {
            en: 'Update results',
            bn: 'ফলাফল এন্ট্রি'
        },
        attendance: {
            en: 'Update attendance',
            bn: 'হাজিরা এন্ট্রি'
        },
        notice: {
            en: 'Draft a notice',
            bn: 'নোটিশ তৈরি'
        },
        help: {
            en: 'How it works',
            bn: 'কীভাবে কাজ করে'
        }
    };

    var PLACEHOLDER = {
        '': {
            en: 'Type a message…',
            bn: 'বার্তা লিখুন…'
        },
        result: {
            en: 'Student 1201 Bengali 100…',
            bn: 'শিক্ষার্থী 1201 বাংলা 100…'
        },
        attendance: {
            en: 'Class 8 Present 1201, 1202…',
            bn: 'শ্রেণি 8 উপস্থিত 1201, 1202…'
        },
        notice: {
            en: 'Parent meeting on 20 November at 10 AM…',
            bn: '২০ নভেম্বর সকাল ১০টায় অভিভাবক সভা…'
        },
        help: {
            en: 'Ask me anything…',
            bn: 'যা জানতে চান লিখুন…'
        }
    };

    var SAMPLE = {
        result: {
            en: 'Student 1201 Bengali 100 English 50 Mathematics 50',
            bn: 'শিক্ষার্থী 1201 বাংলা 100 ইংরেজি 50 গণিত 50'
        },
        attendance: {
            en: 'Class 8 Present 1201, 1202 Absent 1203',
            bn: 'শ্রেণি 8 উপস্থিত 1201, 1202 অনুপস্থিত 1203'
        },
        notice: {
            en: 'Parent meeting for Class 8 on 20 November at 10 AM.',
            bn: '২০ নভেম্বর সকাল ১০টায় ৮ম শ্রেণির অভিভাবক সভা।'
        }
    };

    function boot() {
        var $ = function (id) {
            return document.getElementById(id);
        };

        var launcher = $('wyz-ai-launcher');
        var dialog = $('wyz-ai-dialog');
        var shade = $('wyz-ai-shade');
        var closeBtn = $('wyz-ai-close');
        var feed = $('wyz-ai-feed');
        var options = $('wyz-ai-options');
        var form = $('wyz-ai-form');
        var input = $('wyz-ai-input');
        var sampleWrap = $('wyz-ai-sample');
        var exampleBtn = $('wyz-ai-example');

        if (!launcher || !dialog || !feed || !form || !input) {
            if (window.console && console.warn) {
                console.warn('[Kolom] Missing DOM elements. Make sure kolom.blade.php is included in your page.');
            }
            return;
        }

        /* ------------------------------------------------------------------ *
         *  Safety: an ancestor with `transform` or `filter` breaks
         *  `position: fixed` — move our nodes straight onto <body> so the
         *  launcher/dialog always sit above the rest of the page.
         * ------------------------------------------------------------------ */
        [launcher, dialog, shade].forEach(function (n) {
            if (n && n.parentNode !== document.body) {
                document.body.appendChild(n);
            }
        });

        var task = '';
        var lang = 'en';
        var token = 0;
        var pending = false;
        var lastFocus = null;
        var greeted = false;

        /* ------------------------- helpers ------------------------- */
        function t() {
            return COPY[lang];
        }

        function scrollFeed() {
            feed.scrollTop = feed.scrollHeight;
        }

        function addMessage(text, who) {
            var wrap = document.createElement('div');
            wrap.className = 'wyz-ai-msg ' + (who === 'user' ? 'wyz-ai-msg-user' : 'wyz-ai-msg-bot');
            var bubble = document.createElement('span');
            bubble.className = 'wyz-ai-bubble';
            bubble.textContent = text;
            wrap.appendChild(bubble);
            feed.appendChild(wrap);
            scrollFeed();
            return wrap;
        }

        function showTyping() {
            var wrap = document.createElement('div');
            wrap.className = 'wyz-ai-msg wyz-ai-msg-bot';
            var bubble = document.createElement('span');
            bubble.className = 'wyz-ai-bubble wyz-ai-typing';
            for (var i = 0; i < 3; i++) bubble.appendChild(document.createElement('span'));
            wrap.appendChild(bubble);
            feed.appendChild(wrap);
            scrollFeed();
            return wrap;
        }

        function reply(text, after) {
            var own = ++token;
            pending = true;
            var dots = showTyping();
            var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            window.setTimeout(function () {
                dots.remove();
                if (own !== token) return;
                pending = false;
                addMessage(text, 'bot');
                if (after) after();
            }, reduced ? 40 : 520);
        }

        function resizeInput() {
            input.style.height = 'auto';
            input.style.height = Math.min(input.scrollHeight, 120) + 'px';
        }

        function updateBotName() {
            var name = lang === 'bn' ? 'কলম' : 'Kolom';
            var tagline = lang === 'bn' ? 'যা খুশি জিজ্ঞেস করুন' : 'Ask me anything';
            document.querySelectorAll('[data-bot-name]').forEach(function (el) {
                el.textContent = name;
            });
            document.querySelectorAll('[data-bot-tagline]').forEach(function (el) {
                el.textContent = tagline;
            });
        }

        function updatePlaceholder() {
            input.placeholder = PLACEHOLDER[task] ? PLACEHOLDER[task][lang] : PLACEHOLDER[''][lang];

            var hint = sampleWrap && sampleWrap.querySelector('[data-label="sampleHint"]');
            if (hint) hint.textContent = lang === 'bn' ? 'উদাহরণ দরকার?' : 'Need an example?';
            if (exampleBtn) exampleBtn.textContent = lang === 'bn' ? 'নমুনা ব্যবহার করুন' : 'Use sample';

            options.querySelectorAll('button').forEach(function (btn) {
                var span = btn.querySelector('[data-label]');
                if (span) span.textContent = LABELS[btn.dataset.task][lang];
            });
        }

        function setLang(next) {
            lang = next;
            document.querySelectorAll('.wyz-ai-lang button').forEach(function (b) {
                b.classList.toggle('is-on', b.dataset.lang === next);
            });
            updateBotName();
            updatePlaceholder();
        }

        /* ------------------------- parsers ------------------------- */
        function parseDate(text) {
            var m = text.match(/(\d{1,2})\s*(jan|feb|mar|apr|may|jun|jul|aug|sep|oct|nov|dec)[a-z]*/i);
            var d = m ?
                new Date(new Date().getFullYear(), MONTHS.indexOf(m[2].toLowerCase()), parseInt(m[1], 10)) :
                new Date();
            return d.toLocaleDateString('en-GB', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });
        }

        function parseResults(raw) {
            var text = ascii(raw);
            var idm = text.match(/(?:student|id|roll|শিক্ষার্থী|রোল)\s*(?:no\.?|#|:)?\s*(\d{2,8})/i) ||
                text.match(/\b(\d{4,8})\b/);
            if (!idm) return {
                error: t().errId
            };

            var id = idm[1];
            var found = {};

            function canon(word) {
                var w = word.toLowerCase();
                if (/beng|bangla|বাংলা/.test(w)) return 'Bengali';
                if (/engl|ইংরেজি/.test(w)) return 'English';
                if (/math|গণিত/.test(w)) return 'Mathematics';
                return null;
            }

            var SUBJ = '(bengali|bangla|english|mathematics|maths|math|বাংলা[^\\s,;]*|ইংরেজি[^\\s,;]*|গণিত[^\\s,;]*)';
            var m;

            var before = new RegExp('(\\d{1,3})\\s*(?:marks?|নম্বর)?\\s*(?:in|for|on|:|—|-)?\\s*' + SUBJ, 'gi');
            while ((m = before.exec(text))) {
                var s1 = canon(m[2]);
                if (s1 && found[s1] === undefined) found[s1] = m[1];
            }

            var after = new RegExp(SUBJ + '\\s*(?:scored|marks?|:|—|-|পেয়েছে|নম্বর)?\\s*(\\d{1,3})', 'gi');
            while ((m = after.exec(text))) {
                var s2 = canon(m[1]);
                if (s2 && found[s2] === undefined) found[s2] = m[2];
            }

            var rows = ['Bengali', 'English', 'Mathematics'].map(function (s) {
                return {
                    subject: s,
                    marks: found[s] === undefined ? '' : found[s]
                };
            });

            if (rows.every(function (r) {
                    return r.marks === '';
                })) return {
                error: t().errMarks
            };

            for (var i = 0; i < rows.length; i++) {
                if (rows[i].marks !== '' && (+rows[i].marks < 0 || +rows[i].marks > 100)) {
                    return {
                        error: t().errRange
                    };
                }
            }

            return {
                kind: 'results',
                id: id,
                title: t().titleResult(id),
                detail: t().detailResult,
                heads: [t().headSubject, t().headMarks],
                rows: rows
            };
        }

        function parseAttendance(raw) {
            var text = ascii(raw);
            var cm = text.match(/(?:class|শ্রেণি|শ্রেণী)\s*(?:no\.?|:)?\s*([0-9]{1,2}\s*[A-Za-z]?)/i);
            if (!cm) return {
                error: t().errClass
            };

            var cls = cm[1].replace(/\s+/g, '').toUpperCase();
            var map = {
                present: 'Present',
                absent: 'Absent',
                late: 'Late',
                'উপস্থিত': 'Present',
                'অনুপস্থিত': 'Absent',
                'বিলম্ব': 'Late',
                'বিলম্বে': 'Late',
                'দেরি': 'Late'
            };

            var re = /(present|absent|late|উপস্থিত|অনুপস্থিত|বিলম্বে?|দেরি)\s*[:=\-]?\s*((?:\d{2,8}[\s,;]*)+)/gi;
            var statuses = {};
            var conflicts = [];
            var m;

            while ((m = re.exec(text))) {
                var status = map[m[1].toLowerCase()] || 'Present';
                var ids = m[2].match(/\d{2,8}/g) || [];
                ids.forEach(function (sid) {
                    if (statuses[sid] && statuses[sid] !== status && conflicts.indexOf(sid) === -1) {
                        conflicts.push(sid);
                    }
                    statuses[sid] = status;
                });
            }

            var sidList = Object.keys(statuses);
            if (!sidList.length) return {
                error: t().errStudents
            };
            if (conflicts.length) return {
                error: t().errConflict(conflicts.join(', '))
            };

            return {
                kind: 'attendance',
                cls: cls,
                date: parseDate(text),
                title: t().titleAttendance(cls),
                detail: t().detailAttendance,
                heads: [t().headStudent, t().headDate, t().headStatus],
                rows: sidList.map(function (sid) {
                    return {
                        id: sid,
                        status: statuses[sid]
                    };
                })
            };
        }

        function parseNotice(raw) {
            var text = raw.trim();
            if (text.length < 6) return {
                error: t().errNotice
            };

            var probe = ascii(text);
            var tm = probe.match(/(\d{1,2})(?::(\d{2}))?\s*(am|pm)/i);
            var time = tm ? tm[1] + ':' + (tm[2] || '00') + ' ' + tm[3].toUpperCase() : '10:00 AM';

            var title = 'General notice';
            if (/parent|guardian|অভিভাবক/i.test(text)) title = 'Parent meeting';
            else if (/exam|test|পরীক্ষা/i.test(text)) title = 'Examination notice';
            else if (/holiday|ছুটি/i.test(text)) title = 'Holiday notice';
            else if (/fee|payment|ফি/i.test(text)) title = 'Fee reminder';
            else if (/admission|ভর্তি/i.test(text)) title = 'Admission notice';
            else if (/meeting|সভা/i.test(text)) title = 'Meeting notice';

            return {
                kind: 'notice',
                title: t().titleNotice,
                detail: t().detailNotice,
                heads: [t().headField, t().headValue],
                rows: [{
                        label: t().labelTitle,
                        value: title,
                        control: 'text'
                    },
                    {
                        label: t().labelDate,
                        value: parseDate(probe),
                        control: 'text'
                    },
                    {
                        label: t().labelTime,
                        value: time,
                        control: 'text'
                    },
                    {
                        label: t().labelMessage,
                        value: text,
                        control: 'area'
                    }
                ]
            };
        }

        /* ------------------------- preview card ------------------------- */
        function makeField(type) {
            var el = document.createElement(type === 'area' ? 'textarea' : 'input');
            if (type !== 'area') el.type = 'text';
            else el.rows = 3;
            el.className = 'wyz-ai-field';
            return el;
        }

        function buildTable(data) {
            var table = document.createElement('table');
            table.className = 'wyz-ai-table';

            var thead = document.createElement('thead');
            var htr = document.createElement('tr');
            data.heads.forEach(function (label) {
                var th = document.createElement('th');
                th.textContent = label;
                htr.appendChild(th);
            });
            thead.appendChild(htr);
            table.appendChild(thead);

            var tbody = document.createElement('tbody');

            if (data.kind === 'results') {
                data.rows.forEach(function (r) {
                    var tr = document.createElement('tr');
                    var td1 = document.createElement('td');
                    td1.textContent = r.subject;
                    var td2 = document.createElement('td');
                    var inp = makeField('text');
                    inp.value = r.marks;
                    inp.inputMode = 'numeric';
                    inp.setAttribute('data-field', 'marks');
                    inp.setAttribute('aria-label', r.subject + ' marks');
                    td2.appendChild(inp);
                    tr.appendChild(td1);
                    tr.appendChild(td2);
                    tbody.appendChild(tr);
                });
            } else if (data.kind === 'attendance') {
                data.rows.forEach(function (r) {
                    var tr = document.createElement('tr');
                    var td1 = document.createElement('td');
                    td1.textContent = r.id;
                    var td2 = document.createElement('td');
                    td2.textContent = data.date;
                    var td3 = document.createElement('td');
                    var sel = document.createElement('select');
                    sel.className = 'wyz-ai-field';
                    sel.setAttribute('data-field', 'status');
                    sel.setAttribute('aria-label', 'Status for ' + r.id);
                    ['Present', 'Absent', 'Late'].forEach(function (o) {
                        var opt = document.createElement('option');
                        opt.value = o;
                        opt.textContent = o;
                        if (o === r.status) opt.selected = true;
                        sel.appendChild(opt);
                    });
                    td3.appendChild(sel);
                    tr.appendChild(td1);
                    tr.appendChild(td2);
                    tr.appendChild(td3);
                    tbody.appendChild(tr);
                });
            } else {
                data.rows.forEach(function (r) {
                    var tr = document.createElement('tr');
                    var td1 = document.createElement('td');
                    td1.textContent = r.label;
                    var td2 = document.createElement('td');
                    var ctl = makeField(r.control);
                    ctl.value = r.value;
                    ctl.setAttribute('data-field', 'value');
                    ctl.setAttribute('aria-label', r.label);
                    td2.appendChild(ctl);
                    tr.appendChild(td1);
                    tr.appendChild(td2);
                    tbody.appendChild(tr);
                });
            }

            table.appendChild(tbody);
            return table;
        }

        function validate(card, data) {
            if (data.kind === 'results') {
                var bad = false;
                card.querySelectorAll('[data-field="marks"]').forEach(function (f) {
                    var v = f.value.trim();
                    var ok = v !== '' && /^\d{1,3}$/.test(v) && +v <= 100;
                    f.classList.toggle('is-invalid', !ok);
                    if (!ok) bad = true;
                });
                if (bad) return t().errRange;
            }
            if (data.kind === 'notice') {
                var empty = false;
                card.querySelectorAll('[data-field="value"]').forEach(function (f) {
                    var ok = !!f.value.trim();
                    f.classList.toggle('is-invalid', !ok);
                    if (!ok) empty = true;
                });
                if (empty) return t().errFill;
            }
            return null;
        }

        function createCard(data) {
            var card = document.createElement('section');
            card.className = 'wyz-ai-card';

            var head = document.createElement('div');
            head.className = 'wyz-ai-card-head';
            var h3 = document.createElement('h3');
            h3.textContent = data.title;
            var p = document.createElement('p');
            p.textContent = data.detail;
            head.appendChild(h3);
            head.appendChild(p);

            var body = document.createElement('div');
            body.className = 'wyz-ai-card-body';
            body.appendChild(buildTable(data));

            var foot = document.createElement('div');
            foot.className = 'wyz-ai-card-foot';

            var discardBtn = document.createElement('button');
            discardBtn.type = 'button';
            discardBtn.className = 'wyz-ai-btn wyz-ai-btn-ghost';
            discardBtn.textContent = t().discardBtn;

            var confirmBtn = document.createElement('button');
            confirmBtn.type = 'button';
            confirmBtn.className = 'wyz-ai-btn wyz-ai-btn-primary';
            confirmBtn.textContent = t().confirm;

            foot.appendChild(discardBtn);
            foot.appendChild(confirmBtn);

            card.appendChild(head);
            card.appendChild(body);
            card.appendChild(foot);
            feed.appendChild(card);
            scrollFeed();

            card.querySelectorAll('.wyz-ai-field').forEach(function (f) {
                f.addEventListener('input', function () {
                    f.classList.remove('is-invalid');
                });
                f.addEventListener('change', function () {
                    f.classList.remove('is-invalid');
                });
            });

            discardBtn.addEventListener('click', function () {
                card.remove();
                reply(t().discard);
            });

            confirmBtn.addEventListener('click', function () {
                var err = validate(card, data);
                if (err) {
                    reply(err);
                    return;
                }

                confirmBtn.disabled = true;
                confirmBtn.classList.add('is-done');
                confirmBtn.textContent = t().savedBtn;
                discardBtn.remove();
                card.classList.add('is-saved');
                card.querySelectorAll('input, select, textarea').forEach(function (f) {
                    f.disabled = true;
                });

                var msg = data.kind === 'results' ?
                    t().savedResult(data.id) :
                    data.kind === 'attendance' ?
                    t().savedAttendance(data.cls) :
                    t().savedNotice;

                reply(msg);
            });
        }

        /* ------------------------- conversation ------------------------- */
        function choose(next) {
            token++;
            pending = false;
            task = next;

            options.querySelectorAll('button').forEach(function (b) {
                var on = b.dataset.task === next;
                b.classList.toggle('is-on', on);
                b.setAttribute('aria-pressed', String(on));
            });

            if (sampleWrap) sampleWrap.hidden = next === 'help';
            updatePlaceholder();

            addMessage(LABELS[next][lang], 'user');
            reply(t()[next], function () {
                if (next !== 'help') input.focus({
                    preventScroll: true
                });
            });
        }

        function submit() {
            if (pending) return;
            var raw = input.value.trim();
            if (!raw) return;

            addMessage(raw, 'user');
            input.value = '';
            resizeInput();

            if (!task) {
                reply(t().pick);
                return;
            }
            if (task === 'help') {
                reply(t().help);
                return;
            }

            var data = task === 'result' ?
                parseResults(raw) :
                task === 'attendance' ?
                parseAttendance(raw) :
                parseNotice(raw);

            if (data.error) {
                reply(data.error);
                return;
            }

            reply(t().review, function () {
                createCard(data);
            });
        }

        /* ------------------------- open / close ------------------------- */
        function open() {
            lastFocus = document.activeElement;
            dialog.hidden = false;
            if (shade) shade.hidden = false;
            launcher.setAttribute('aria-expanded', 'true');

            if (!greeted) {
                greeted = true;
                addMessage(t().greet, 'bot');
            }

            if (window.innerWidth > 640) input.focus({
                preventScroll: true
            });
            scrollFeed();
        }

        function close() {
            token++;
            pending = false;
            dialog.hidden = true;
            if (shade) shade.hidden = true;
            launcher.setAttribute('aria-expanded', 'false');
            if (lastFocus && lastFocus.focus) lastFocus.focus();
        }

        /* ------------------------- events ------------------------- */
        launcher.addEventListener('click', function () {
            if (dialog.hidden) open();
            else close();
        });

        if (closeBtn) closeBtn.addEventListener('click', close);
        if (shade) shade.addEventListener('click', close);

        document.addEventListener('keydown', function (event) {
            if (dialog.hidden) return;

            if (event.key === 'Escape') {
                close();
                return;
            }

            if (event.key === 'Tab') {
                var focusable = Array.prototype.slice
                    .call(dialog.querySelectorAll('button:not([disabled]), textarea:not([disabled]), input:not([disabled]), select:not([disabled])'))
                    .filter(function (el) {
                        return el.getClientRects().length > 0;
                    });
                if (!focusable.length) return;
                var first = focusable[0];
                var last = focusable[focusable.length - 1];
                if (event.shiftKey && document.activeElement === first) {
                    event.preventDefault();
                    last.focus();
                } else if (!event.shiftKey && document.activeElement === last) {
                    event.preventDefault();
                    first.focus();
                }
            }
        });

        options.addEventListener('click', function (event) {
            var btn = event.target.closest('button[data-task]');
            if (btn) choose(btn.dataset.task);
        });

        if (exampleBtn) {
            exampleBtn.addEventListener('click', function () {
                if (!SAMPLE[task]) return;
                input.value = SAMPLE[task][lang];
                resizeInput();
                input.focus();
            });
        }

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            submit();
        });

        input.addEventListener('input', resizeInput);

        input.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                form.requestSubmit();
            }
        });

        document.querySelectorAll('.wyz-ai-lang button').forEach(function (btn) {
            btn.addEventListener('click', function () {
                setLang(btn.dataset.lang);
            });
        });

        /* Existing sidebar button: open the same chat dialog, without navigation. */
        document.addEventListener('click', function (event) {
            var entry = event.target.closest('[data-wyz-open-ai]');
            if (!entry) return;
            event.preventDefault();
            document.dispatchEvent(new CustomEvent('wyzeek:close-mobile-drawer'));
            open();
        });
        document.addEventListener('wyzeek:open-ai', open);

        /* ------------------------- sidebar entry ------------------------- */
        function addSidebarLink() {
            var menu = document.querySelector('#aside [data-wyzeek-module-menu]');
            if (!menu || menu.querySelector('[data-wyz-module="ai"]')) return;

            var li = document.createElement('li');
            li.className = 'wyz-module-container';
            li.dataset.wyzModule = 'ai';

            var details = document.createElement('details');
            details.className = 'wyz-module-group';

            var summary = document.createElement('summary');
            summary.className = 'wyz-module-header';
            summary.textContent = 'Kolom Assistant';

            var ul = document.createElement('ul');
            ul.className = 'wyz-module-items';

            var inner = document.createElement('li');
            var button = document.createElement('button');
            button.type = 'button';
            button.className = 'wyz-demo-menu-btn';
            button.textContent = 'Open assistant';
            button.addEventListener('click', open);

            inner.appendChild(button);
            ul.appendChild(inner);
            details.appendChild(summary);
            details.appendChild(ul);
            li.appendChild(details);

            var account = menu.querySelector('[data-wyz-module="account"]');
            if (account) menu.insertBefore(li, account);
            else menu.appendChild(li);
        }

        /* ------------------------- boot ------------------------- */
        updateBotName();
        updatePlaceholder();
        addSidebarLink();
        document.addEventListener('wyzeek:modules-ready', addSidebarLink);
        document.dispatchEvent(new CustomEvent('wyzeek:ai-ready'));
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot, {
            once: true
        });
    } else {
        boot();
    }
})();
