// Theme: apply saved preference immediately (also in inline <script> to prevent flash)
(function() {
	var t = localStorage.getItem('nsc-theme') || 'dark';
	document.documentElement.setAttribute('data-theme', t);
})();

document.addEventListener('DOMContentLoaded', function() {

	// --- Theme toggle ---
	var themeSwitch = document.getElementById('themeSwitch');
	if (themeSwitch) {
		var current = document.documentElement.getAttribute('data-theme') || 'dark';
		themeSwitch.checked = (current === 'dark');
		themeSwitch.addEventListener('change', function() {
			var theme = this.checked ? 'dark' : 'light';
			document.documentElement.setAttribute('data-theme', theme);
			localStorage.setItem('nsc-theme', theme);
		});
	}

	// --- Hamburger menu ---
	var menuBtn = document.getElementById('menuBtn');
	var menuDropdown = document.getElementById('menuDropdown');
	if (menuBtn && menuDropdown) {
		menuBtn.addEventListener('click', function(e) {
			e.stopPropagation();
			menuDropdown.classList.toggle('show');
		});
		document.addEventListener('click', function(e) {
			if (!menuDropdown.contains(e.target)) {
				menuDropdown.classList.remove('show');
			}
		});
	}

	// --- Accordion scroll: scroll song title to top when expanded ---
	document.querySelectorAll('.accordion-collapse').forEach(function(el) {
		el.addEventListener('shown.mdb.collapse', function() {
			var item = this.closest('.accordion-item');
			if (item) {
				setTimeout(function() {
					item.scrollIntoView({ behavior: 'smooth', block: 'start' });
				}, 150);
			}
		});
	});

	// --- Font size controls ---
	var MIN_SIZE = 14, MAX_SIZE = 28, DEFAULT_SIZE = 16;

	function getFontSize() {
		return parseInt(localStorage.getItem('nsc-font-size')) || DEFAULT_SIZE;
	}

	function applyFontSize(size) {
		document.querySelectorAll('.accordion-body').forEach(function(el) {
			el.style.fontSize = size + 'px';
		});
	}

	window.changeFontSize = function(delta) {
		var size = getFontSize() + delta * 2;
		size = Math.max(MIN_SIZE, Math.min(MAX_SIZE, size));
		localStorage.setItem('nsc-font-size', size);
		applyFontSize(size);
	};

	applyFontSize(getFontSize());
});
