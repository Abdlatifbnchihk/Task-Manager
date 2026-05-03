<x-app-layout>
    {{-- <x-slot name="header"> --}}
        {{-- We hide the default header — our design has its own title --}}
        {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2> --}}
    {{-- </x-slot> --}}

    {{-- ═══════════════════════════════════════════════════════
         profile/edit.blade.php — User profile page
         Layout: left column = user card, right column = 3 sections
         Sections:
           1. Update profile information (name + email)
           2. Update password
           3. Delete account (danger zone)
    ══════════════════════════════════════════════════════════ --}}

    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=DM+Mono:wght@400;500&display=swap');

        :root {
            --bg:        #F7F7F5;
            --surface:   #FFFFFF;
            --border:    #E8E8E4;
            --text:      #1C1C1A;
            --muted:     #888884;
            --accent:    #1C1C1A;
            --accent-fg: #FFFFFF;
            --danger:    #CC2222;
            --danger-bg: #FFF2F2;
            --danger-bd: #FFD0D0;
            --radius:    10px;
            --font:      'DM Sans', sans-serif;
            --mono:      'DM Mono', monospace;
        }

        *, *::before, *::after { box-sizing: border-box; }

        /* ── Page wrapper ── */
        .prof-page {
            background: var(--bg);
            min-height: 100vh;
            padding: 36px 44px;
            font-family: var(--font);
        }

        /* ── Back link ── */
        .prof-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--muted);
            text-decoration: none;
            margin-bottom: 24px;
            transition: color .12s;
        }
        .prof-back:hover { color: var(--text); }

        /* ── Two-column layout ── */
        .prof-grid {
            display: grid;
            grid-template-columns: 260px 1fr;
            gap: 24px;
            align-items: start;
        }

        /* ── LEFT: user identity card ── */
        .prof-id-card {
            /* background: var(--accent); */
            border-radius: var(--radius);
            padding: 28px 24px;
            color: var(--accent-fg);
            position: sticky;
            top: 32px;
            animation: slideIn .25s ease both;
        }

        /* Avatar circle with user initials ── */
        .prof-avatar {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: rgba(255,255,255,.12);
            border: 1.5px solid rgba(255,255,255,.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 16px;
            letter-spacing: -0.5px;
        }

        .prof-id-name {
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 4px;
        }

        .prof-id-email {
            font-size: 12px;
            color: rgba(255,255,255,.55);
            font-family: var(--mono);
            word-break: break-all;
        }

        /* Thin divider */
        .prof-id-divider {
            border: none;
            border-top: 1px solid rgba(255,255,255,.1);
            margin: 20px 0;
        }

        /* Small nav links inside the left card ── */
        .prof-nav a {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 8px 10px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 500;
            color: rgba(255,255,255,.6);
            text-decoration: none;
            transition: all .12s;
            cursor: pointer;
        }

        .prof-nav a:hover,
        .prof-nav a.active {
            background: rgba(255,255,255,.1);
            color: #fff;
        }

        .prof-nav-icon {
            width: 18px;
            height: 18px;
            opacity: .7;
        }

        /* Member since badge ── */
        .prof-since {
            margin-top: 20px;
            padding: 10px 12px;
            background: rgba(255,255,255,.07);
            border-radius: 7px;
            font-size: 11px;
            color: rgba(255,255,255,.4);
            font-family: var(--mono);
        }
        .prof-since strong {
            display: block;
            color: rgba(255,255,255,.7);
            font-size: 12px;
            margin-bottom: 2px;
        }

        /* ── RIGHT: sections stack ── */
        .prof-sections {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* ── Section card ── */
        .prof-section {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            animation: slideIn .25s ease both;
        }

        .prof-section:nth-child(2) { animation-delay: .05s; }
        .prof-section:nth-child(3) { animation-delay: .10s; }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Section header (clickable to expand/collapse) ── */
        .prof-section-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 24px;
            cursor: pointer;
            user-select: none;
            transition: background .12s;
        }

        .prof-section-head:hover { background: #FAFAF8; }

        .prof-section-head-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* Colored icon box ── */
        .prof-section-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .icon-info     { background: #EBF3FF; }
        .icon-password { background: #EAF3DE; }
        .icon-danger   { background: #FFF2F2; }

        .prof-section-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--text);
        }

        .prof-section-sub {
            font-size: 12px;
            color: var(--muted);
            margin-top: 2px;
        }

        /* Chevron arrow that rotates when section is open ── */
        .prof-chevron {
            font-size: 13px;
            color: var(--muted);
            transition: transform .2s;
        }

        .prof-chevron.open { transform: rotate(90deg); }

        /* ── Section body (shown/hidden) ── */
        .prof-section-body {
            border-top: 1px solid var(--border);
            padding: 24px 24px 28px;
            display: none;
        }

        .prof-section-body.open { display: block; }

        /* ── Danger section — red tinted header ── */
        .prof-section.danger .prof-section-head {
            background: #FFF8F8;
        }
        .prof-section.danger .prof-section-head:hover {
            background: #FFF2F2;
        }
        .prof-section.danger { border-color: var(--danger-bd); }

        /* ── Override Breeze form styles to match our design ── */
        .prof-section-body label {
            font-size: 13px !important;
            font-weight: 500 !important;
            color: var(--text) !important;
            font-family: var(--font) !important;
            display: block;
            margin-bottom: 6px;
        }

        .prof-section-body input[type="text"],
        .prof-section-body input[type="email"],
        .prof-section-body input[type="password"] {
            width: 100% !important;
            padding: 10px 13px !important;
            border: 1.5px solid var(--border) !important;
            border-radius: 8px !important;
            font-size: 14px !important;
            font-family: var(--font) !important;
            color: var(--text) !important;
            background: var(--surface) !important;
            outline: none !important;
            box-shadow: none !important;
            transition: border-color .15s !important;
            margin-bottom: 16px;
        }

        .prof-section-body input:focus {
            border-color: var(--accent) !important;
            box-shadow: 0 0 0 3px rgba(28,28,26,.07) !important;
        }

        /* Save / update buttons ── */
        .prof-section-body button[type="submit"],
        .prof-section-body .btn-submit {
            height: 40px;
            padding: 0 20px;
            background: var(--accent) !important;
            color: var(--accent-fg) !important;
            border: none !important;
            border-radius: 8px !important;
            font-size: 14px !important;
            font-family: var(--font) !important;
            font-weight: 500 !important;
            cursor: pointer !important;
            box-shadow: none !important;
            transition: opacity .15s !important;
        }

        .prof-section-body button[type="submit"]:hover { opacity: .82 !important; }

        /* Danger section button ── */
        .prof-section.danger .prof-section-body button[type="submit"] {
            background: var(--danger) !important;
            color: #fff !important;
        }

        /* Breeze error messages ── */
        .prof-section-body .text-red-600,
        .prof-section-body .text-red-500 {
            font-size: 12px !important;
            color: var(--danger) !important;
            margin-top: -10px;
            margin-bottom: 12px;
        }

        /* Breeze success message ── */
        .prof-section-body .text-green-600,
        .prof-section-body p.text-sm.text-gray-600 {
            font-size: 12px !important;
            color: #1A7040 !important;
        }

        /* Breeze section titles ── */
        .prof-section-body h2.text-lg,
        .prof-section-body header h2 {
            display: none !important; /* we use our own section titles */
        }

        .prof-section-body header p {
            font-size: 13px !important;
            color: var(--muted) !important;
            margin-bottom: 20px !important;
        }

        /* ── Responsive ── */
        @media (max-width: 680px) {
            .prof-page { padding: 20px 16px; }
            .prof-grid { grid-template-columns: 1fr; }
            .prof-id-card { position: static; }
        }
    </style>

    <div class="prof-page">

        {{-- Back to task list ── --}}
        <a href="{{ route('tasks.index') }}" class="prof-back">
            ← Back to tasks
        </a>

        <div class="prof-grid">

            {{-- ═══════════════════════════════
                 LEFT COLUMN — User identity card
            ════════════════════════════════ --}}
            <div>
                <div class="prof-id-card bg-indigo-600">

                    {{--
                        Avatar: shows the first two letters of the user's name.
                        strtoupper(substr(auth()->user()->name, 0, 1)) = first letter
                        We use two letters for a nicer look.
                    --}}
                    <div class="prof-avatar" id="avatar-initials">
                        {{-- Filled by JS below to avoid Blade/PHP complexity --}}
                    </div>

                    {{-- User name and email from the auth session ── --}}
                    <div class="prof-id-name">{{ auth()->user()->name }}</div>
                    <div class="prof-id-email">{{ auth()->user()->email }}</div>

                    <hr class="prof-id-divider">

                    {{-- Section quick-links that scroll/open the matching section ── --}}
                    <div class="prof-nav">
                        <a onclick="openSection('section-info')" class="active" id="nav-info">
                            <span class="prof-nav-icon">👤</span>
                            Profile Info
                        </a>
                        <a onclick="openSection('section-password')" id="nav-password">
                            <span class="prof-nav-icon">🔒</span>
                            Password
                        </a>
                        <a onclick="openSection('section-danger')" id="nav-danger">
                            <span class="prof-nav-icon">⚠️</span>
                            Delete Account
                        </a>
                    </div>

                    {{-- Member since date ── --}}
                    <div class="prof-since">
                        <strong>Member since</strong>
                        {{ auth()->user()->created_at->format('d M Y') }}
                    </div>

                </div>
            </div>

            {{-- ═══════════════════════════════
                 RIGHT COLUMN — Three sections
            ════════════════════════════════ --}}
            <div class="prof-sections">

                {{-- ── SECTION 1: Profile information ── --}}
                <div class="prof-section" id="section-info">
                    <div class="prof-section-head" onclick="toggleSection('section-info')">
                        <div class="prof-section-head-left">
                            <div class="prof-section-icon icon-info">👤</div>
                            <div>
                                <div class="prof-section-title">Profile Information</div>
                                <div class="prof-section-sub">Update your name and email address</div>
                            </div>
                        </div>
                        <span class="prof-chevron open" id="ch-section-info">›</span>
                    </div>
                    {{-- Open by default ── --}}
                    <div class="prof-section-body open" id="body-section-info">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                {{-- ── SECTION 2: Update password ── --}}
                <div class="prof-section" id="section-password">
                    <div class="prof-section-head" onclick="toggleSection('section-password')">
                        <div class="prof-section-head-left">
                            <div class="prof-section-icon icon-password">🔒</div>
                            <div>
                                <div class="prof-section-title">Change Password</div>
                                <div class="prof-section-sub">Use a strong password of at least 8 characters</div>
                            </div>
                        </div>
                        <span class="prof-chevron" id="ch-section-password">›</span>
                    </div>
                    <div class="prof-section-body" id="body-section-password">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                {{-- ── SECTION 3: Delete account (danger zone) ── --}}
                <div class="prof-section danger" id="section-danger">
                    <div class="prof-section-head" onclick="toggleSection('section-danger')">
                        <div class="prof-section-head-left">
                            <div class="prof-section-icon icon-danger">⚠️</div>
                            <div>
                                <div class="prof-section-title" style="color:#CC2222;">Delete Account</div>
                                <div class="prof-section-sub">Permanently delete your account and all data</div>
                            </div>
                        </div>
                        <span class="prof-chevron" id="ch-section-danger">›</span>
                    </div>
                    <div class="prof-section-body" id="body-section-danger">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>

            </div>{{-- end prof-sections --}}
        </div>{{-- end prof-grid --}}
    </div>{{-- end prof-page --}}

    <script>
        /*
         * toggleSection(id)
         * Opens a section if it is closed, closes it if it is open.
         * Also rotates the chevron arrow.
         */
        function toggleSection(id) {
            const body    = document.getElementById('body-' + id);
            const chevron = document.getElementById('ch-' + id);
            const isOpen  = body.classList.contains('open');

            body.classList.toggle('open', !isOpen);
            chevron.classList.toggle('open', !isOpen);
        }

        /*
         * openSection(id)
         * Called by the left nav links.
         * Opens the target section, scrolls to it, and highlights the nav link.
         */
        function openSection(id) {
            // Open the target section
            const body    = document.getElementById('body-' + id);
            const chevron = document.getElementById('ch-' + id);
            body.classList.add('open');
            chevron.classList.add('open');

            // Scroll smoothly to the section
            document.getElementById(id).scrollIntoView({ behavior: 'smooth', block: 'start' });

            // Update active state on nav links
            document.querySelectorAll('.prof-nav a').forEach(a => a.classList.remove('active'));
            const navMap = { 'section-info': 'nav-info', 'section-password': 'nav-password', 'section-danger': 'nav-danger' };
            const navEl = document.getElementById(navMap[id]);
            if (navEl) navEl.classList.add('active');
        }

        /*
         * Avatar initials — take first letter of each word in the name.
         * Example: "Alice Martin" → "AM"
         */
        (function() {
            const nameEl = document.querySelector('.prof-id-name');
            const avatarEl = document.getElementById('avatar-initials');
            if (nameEl && avatarEl) {
                const words    = nameEl.textContent.trim().split(' ');
                const initials = words.map(w => w[0]).join('').substring(0, 2).toUpperCase();
                avatarEl.textContent = initials;
            }
        })();
    </script>

</x-app-layout>