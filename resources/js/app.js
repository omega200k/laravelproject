// Mobile navigation toggle
const toggle = document.getElementById('nav-toggle');
const sidebar = document.getElementById('sidebar');
const backdrop = document.getElementById('nav-backdrop');

function setNav(open) {
    if (!toggle || !sidebar) return;
    sidebar.classList.toggle('-translate-x-full', !open);
    backdrop?.classList.toggle('hidden', !open);
    toggle.setAttribute('aria-expanded', String(open));
}

toggle?.addEventListener('click', () => setNav(toggle.getAttribute('aria-expanded') !== 'true'));
backdrop?.addEventListener('click', () => setNav(false));
document.addEventListener('keydown', (e) => e.key === 'Escape' && setNav(false));
