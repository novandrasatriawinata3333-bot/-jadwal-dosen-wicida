<div class="dropdown dropdown-end">
    <label tabindex="0" class="btn btn-ghost btn-circle">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
        </svg>
    </label>
    <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
        <li><a data-set-theme="cupcake">🧁 Cupcake</a></li>
        <li><a data-set-theme="dark">🌙 Dark</a></li>
        <li><a data-set-theme="light">☀️ Light</a></li>
        <li><a data-set-theme="synthwave">🌃 Synthwave</a></li>
    </ul>
</div>

<script>
    document.querySelectorAll('[data-set-theme]').forEach(button => {
        button.addEventListener('click', function() {
            const theme = this.getAttribute('data-set-theme');
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
        });
    });
</script>
