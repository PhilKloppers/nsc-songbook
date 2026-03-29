<?php
require_once __DIR__ . '/includes/auth.php';
nscRequireAuth();
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<title>NSC Songbook - Admin</title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
	<link rel="stylesheet" href="css/mdb.min.css" />
	<link rel="stylesheet" href="css/style.css" />
	<script>(function(){var t=localStorage.getItem('nsc-theme')||'dark';document.documentElement.setAttribute('data-theme',t);})();</script>
	<style>
		body { font-family: 'Roboto', sans-serif; }
		.panel {
			background: var(--bg-card);
			border: 2px solid var(--border-color);
			border-radius: 8px;
			min-height: 500px;
			display: flex;
			flex-direction: column;
		}
		.panel-header {
			background: #1266f1;
			color: #fff;
			padding: 12px 16px;
			border-radius: 6px 6px 0 0;
			font-weight: 500;
			font-size: 1.1rem;
		}
		.panel-header.active-header { background: #00b74a; }
		.song-list {
			flex: 1;
			overflow-y: auto;
			padding: 8px;
			min-height: 400px;
		}
		.song-item {
			display: flex;
			align-items: center;
			padding: 10px 12px;
			margin: 4px 0;
			background: var(--bg-card-hover);
			border: 1px solid var(--border-color);
			border-radius: 6px;
			cursor: grab;
			user-select: none;
			color: var(--text-primary);
			transition: background-color 0.15s, box-shadow 0.15s;
		}
		.song-item:hover {
			background: var(--accent);
			color: #fff;
			box-shadow: 0 2px 4px var(--shadow);
		}
		.song-item:hover .song-name { color: #fff; }
		.song-item:hover .btn-group-actions button { color: rgba(255,255,255,0.8); }
		.song-item:hover .btn-edit-song { color: #fff; }
		.song-item.dragging { opacity: 0.5; }
		.song-item .song-name {
			flex: 1;
			text-transform: capitalize;
			font-size: 0.95rem;
		}
		.song-item .order-num {
			background: #00b74a;
			color: #fff;
			border-radius: 50%;
			width: 26px;
			height: 26px;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 0.8rem;
			font-weight: 700;
			margin-right: 10px;
			flex-shrink: 0;
		}
		.song-item .btn-group-actions {
			display: flex;
			gap: 4px;
			margin-left: 8px;
		}
		.song-item .btn-group-actions button {
			border: none;
			background: none;
			cursor: pointer;
			padding: 4px 6px;
			border-radius: 4px;
			color: var(--text-secondary);
			font-size: 0.85rem;
		}
		.song-item .btn-group-actions button:hover {
			background: rgba(255,255,255,0.15);
			color: #fff;
		}
		.song-list.drag-over {
			background: rgba(0,183,74,0.1);
			border: 2px dashed #00b74a;
			border-radius: 0 0 6px 6px;
		}
		.song-list.drag-over-remove {
			background: rgba(249,49,84,0.1);
			border: 2px dashed #f93154;
			border-radius: 0 0 6px 6px;
		}
		#status-bar {
			position: fixed;
			bottom: 0;
			left: 0;
			right: 0;
			padding: 10px 20px;
			text-align: center;
			font-weight: 500;
			z-index: 1000;
			transition: transform 0.3s;
			transform: translateY(100%);
		}
		#status-bar.show { transform: translateY(0); }
		#status-bar.success { background: #00b74a; color: #fff; }
		#status-bar.error { background: #f93154; color: #fff; }
		.search-box {
			padding: 8px;
			border-bottom: 1px solid var(--border-color);
		}
		.search-box input {
			width: 100%;
			padding: 8px 12px;
			border: 1px solid var(--border-color);
			border-radius: 6px;
			font-size: 0.9rem;
			background: var(--bg-body);
			color: var(--text-primary);
		}
		.search-box input:focus {
			outline: none;
			border-color: var(--accent);
			box-shadow: 0 0 0 2px rgba(74,158,255,0.2);
		}
		.empty-message {
			color: var(--text-secondary);
			text-align: center;
			padding: 40px 20px;
			font-style: italic;
		}
		.toolbar {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 20px;
			flex-wrap: wrap;
			gap: 10px;
		}
		.toolbar p { color: var(--text-secondary); }
		.song-count {
			font-size: 0.85rem;
			color: rgba(255,255,255,0.7);
			padding: 4px 8px;
		}
		/* Editor modal */
		.modal-overlay {
			display: none;
			position: fixed;
			top: 0; left: 0; right: 0; bottom: 0;
			background: rgba(0,0,0,0.6);
			z-index: 2000;
			align-items: center;
			justify-content: center;
		}
		.modal-overlay.active { display: flex; }
		.editor-modal {
			background: var(--bg-card);
			border-radius: 12px;
			width: 95%;
			max-width: 1100px;
			max-height: 90vh;
			display: flex;
			flex-direction: column;
			box-shadow: 0 20px 60px rgba(0,0,0,0.4);
		}
		.editor-header {
			padding: 16px 20px;
			background: #1266f1;
			color: #fff;
			border-radius: 12px 12px 0 0;
			display: flex;
			justify-content: space-between;
			align-items: center;
		}
		.editor-header h5 { margin: 0; font-weight: 500; text-transform: capitalize; }
		.editor-header button {
			background: none; border: none; color: #fff;
			font-size: 1.4rem; cursor: pointer; padding: 0 4px; opacity: 0.8;
		}
		.editor-header button:hover { opacity: 1; }
		.editor-body {
			padding: 20px;
			flex: 1;
			overflow-y: auto;
			display: flex;
			flex-direction: column;
		}
		.editor-grid {
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 16px;
			flex: 1;
			min-height: 350px;
		}
		@media (max-width: 768px) {
			.editor-grid { grid-template-columns: 1fr; }
		}
		.editor-pane, .preview-pane {
			display: flex;
			flex-direction: column;
		}
		.pane-label {
			font-weight: 500;
			margin-bottom: 8px;
			color: var(--text-secondary);
			font-size: 0.85rem;
			text-transform: uppercase;
			letter-spacing: 0.5px;
		}
		.editor-body textarea {
			width: 100%;
			flex: 1;
			min-height: 350px;
			padding: 12px;
			border: 1px solid var(--border-color);
			border-radius: 6px;
			font-family: 'Courier New', Courier, monospace;
			font-size: 0.9rem;
			line-height: 1.5;
			resize: vertical;
			background: var(--bg-body);
			color: var(--text-primary);
		}
		.editor-body textarea:focus {
			outline: none;
			border-color: var(--accent);
			box-shadow: 0 0 0 2px rgba(74,158,255,0.2);
		}
		.preview-content {
			flex: 1;
			overflow-y: auto;
			padding: 12px;
			border: 1px solid var(--border-color);
			border-radius: 6px;
			background: var(--bg-body);
			color: var(--text-primary);
			line-height: 1.7;
			min-height: 350px;
		}
		.preview-content h5 {
			color: var(--accent);
			margin-top: 1em;
			margin-bottom: 0.3em;
			font-size: 1.05em;
			font-weight: 600;
		}
		.preview-content h5:first-child { margin-top: 0; }
		.preview-content p { margin-bottom: 0.8em; }
		.editor-footer {
			padding: 12px 20px;
			border-top: 1px solid var(--border-color);
			display: flex;
			justify-content: space-between;
			align-items: center;
			flex-wrap: wrap;
			gap: 10px;
		}
		.editor-help {
			font-size: 0.8rem;
			color: var(--text-secondary);
		}
		.editor-help code {
			background: var(--bg-card-hover);
			padding: 1px 5px;
			border-radius: 3px;
			color: var(--accent);
		}
		.btn-edit-song {
			border: none;
			background: none;
			cursor: pointer;
			padding: 4px 6px;
			border-radius: 4px;
			color: var(--accent);
			font-size: 0.85rem;
			margin-left: 4px;
		}
		.btn-edit-song:hover { background: rgba(74,158,255,0.15); }
		.new-song-input {
			width: 100%;
			padding: 10px 14px;
			border: 1px solid var(--border-color);
			border-radius: 6px;
			font-size: 1rem;
			margin-bottom: 12px;
			background: var(--bg-body);
			color: var(--text-primary);
		}
		.new-song-input:focus {
			outline: none;
			border-color: var(--accent);
			box-shadow: 0 0 0 2px rgba(74,158,255,0.2);
		}
	</style>
</head>
<body>
	<header>
		<nav class="navbar navbar-dark">
			<div class="container-fluid">
				<div style="position:relative;">
					<button class="btn btn-link text-white p-2" id="menuBtn" aria-label="Menu">
						<i class="fas fa-bars fa-lg"></i>
					</button>
					<div class="theme-dropdown" id="menuDropdown">
						<div class="menu-item">
							<span><i class="fas fa-moon"></i> Dark Mode</span>
							<div class="form-check form-switch mb-0">
								<input class="form-check-input" type="checkbox" id="themeSwitch" checked>
							</div>
						</div>
						<a class="menu-item" href="login.php?logout=1" style="text-decoration:none;">
							<span><i class="fas fa-sign-out-alt"></i> Logout</span>
						</a>
					</div>
				</div>
				<span class="navbar-brand mb-0 h1">NSC Songbook - Admin</span>
				<a href="index.php" class="btn btn-outline-light btn-sm">
					<i class="fas fa-eye"></i> View Songbook
				</a>
			</div>
		</nav>
	</header>

	<main class="container-fluid py-4">
		<div class="toolbar">
			<p class="mb-0">Drag songs between panels. Double-click to add/remove. Click <i class="fas fa-edit"></i> to edit lyrics.</p>
			<div>
				<button class="btn btn-primary btn-lg me-2" onclick="openNewSongModal()">
					<i class="fas fa-plus"></i> New Song
				</button>
				<button id="btn-save" class="btn btn-success btn-lg" onclick="saveConfig()">
					<i class="fas fa-save"></i> Save
				</button>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="panel">
					<div class="panel-header">
						<i class="fas fa-music"></i> Song Library
						<span id="library-count" class="song-count"></span>
					</div>
					<div class="search-box">
						<input type="text" id="library-search" placeholder="Search songs..." oninput="filterLibrary()">
					</div>
					<div class="song-list" id="library-list"
						ondragover="handleDragOver(event, 'library')"
						ondragleave="handleDragLeave(event, 'library')"
						ondrop="handleDrop(event, 'library')">
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel">
					<div class="panel-header active-header">
						<i class="fas fa-list-ol"></i> Active Songs (Service Order)
						<span id="active-count" class="song-count"></span>
					</div>
					<div class="song-list" id="active-list"
						ondragover="handleDragOver(event, 'active')"
						ondragleave="handleDragLeave(event, 'active')"
						ondrop="handleDrop(event, 'active')">
					</div>
				</div>
			</div>
		</div>
	</main>

	<!-- Song Editor Modal -->
	<div class="modal-overlay" id="editor-overlay" onclick="editorOverlayClick(event)">
		<div class="editor-modal">
			<div class="editor-header">
				<h5 id="editor-title">Edit Song</h5>
				<button onclick="closeEditor()">&times;</button>
			</div>
			<div class="editor-body">
				<div class="editor-grid">
					<div class="editor-pane">
						<div class="pane-label">Edit</div>
						<textarea id="editor-textarea" spellcheck="true" oninput="updatePreview()"></textarea>
					</div>
					<div class="preview-pane">
						<div class="pane-label">Preview</div>
						<div id="editor-preview" class="preview-content"></div>
					</div>
				</div>
			</div>
			<div class="editor-footer">
				<span class="editor-help">
					<strong>Format:</strong> Lines ending with <code>:</code> become section headings (e.g. <code>VERSE 1:</code> or <code>CHORUS:</code>). Everything else is lyrics. Blank lines separate paragraphs.
				</span>
				<div>
					<button class="btn btn-outline-secondary me-2" onclick="closeEditor()">Cancel</button>
					<button class="btn btn-primary" id="btn-save-song" onclick="saveSong()">Save Song</button>
				</div>
			</div>
		</div>
	</div>

	<!-- New Song Modal -->
	<div class="modal-overlay" id="new-song-overlay" onclick="newSongOverlayClick(event)">
		<div class="editor-modal" style="max-width: 500px;">
			<div class="editor-header" style="background: #00b74a;">
				<h5>Create New Song</h5>
				<button onclick="closeNewSongModal()">&times;</button>
			</div>
			<div class="editor-body">
				<p style="color:var(--text-secondary);" class="mb-3">Enter the song title. This will become the filename (lowercase). You can edit the lyrics after creation.</p>
				<input type="text" class="new-song-input" id="new-song-name" placeholder="e.g. amazing grace" onkeydown="if(event.key==='Enter') createNewSong()">
			</div>
			<div class="editor-footer">
				<span></span>
				<div>
					<button class="btn btn-outline-secondary me-2" onclick="closeNewSongModal()">Cancel</button>
					<button class="btn btn-success" onclick="createNewSong()">Create Song</button>
				</div>
			</div>
		</div>
	</div>

	<div id="status-bar"></div>

	<script>
		// === Theme toggle ===
		(function() {
			var menuBtn = document.getElementById('menuBtn');
			var menuDropdown = document.getElementById('menuDropdown');
			if (menuBtn && menuDropdown) {
				menuBtn.addEventListener('click', function(e) {
					e.stopPropagation();
					menuDropdown.classList.toggle('show');
				});
				document.addEventListener('click', function(e) {
					if (!menuDropdown.contains(e.target)) menuDropdown.classList.remove('show');
				});
			}
			var sw = document.getElementById('themeSwitch');
			if (sw) {
				var cur = document.documentElement.getAttribute('data-theme') || 'dark';
				sw.checked = (cur === 'dark');
				sw.addEventListener('change', function() {
					var theme = this.checked ? 'dark' : 'light';
					document.documentElement.setAttribute('data-theme', theme);
					localStorage.setItem('nsc-theme', theme);
				});
			}
		})();

		// === Data ===
		var librarySongs = [];
		var activeSongs = [];
		var draggedSong = null;
		var dragSource = null;
		var hasUnsavedChanges = false;

		document.addEventListener('DOMContentLoaded', loadConfig);

		window.addEventListener('beforeunload', function(e) {
			if (hasUnsavedChanges) { e.preventDefault(); e.returnValue = ''; }
		});

		function apiFetch(url, opts) {
			return fetch(url, opts).then(function(r) {
				if (r.status === 401) { window.location.href = 'login.php'; throw new Error('Session expired'); }
				return r;
			});
		}

		function loadConfig() {
			apiFetch('api/save-config.php')
				.then(function(r) { return r.json(); })
				.then(function(data) {
					librarySongs = data.library || [];
					activeSongs = data.active || [];
					renderLists();
				})
				.catch(function(err) { showStatus('Failed to load configuration: ' + err.message, 'error'); });
		}

		function getAvailableSongs() {
			return librarySongs.filter(function(s) { return activeSongs.indexOf(s) === -1; });
		}

		function songDisplayName(filename) { return filename.replace('.php', ''); }

		function renderLists() { renderLibrary(); renderActive(); }

		function renderLibrary() {
			var list = document.getElementById('library-list');
			var searchTerm = document.getElementById('library-search').value.toLowerCase();
			var available = getAvailableSongs().filter(function(s) {
				return songDisplayName(s).toLowerCase().indexOf(searchTerm) !== -1;
			});
			document.getElementById('library-count').textContent = '(' + available.length + ' songs)';
			if (available.length === 0) {
				list.innerHTML = '<div class="empty-message">' + (searchTerm ? 'No songs match your search' : 'All songs are in the active list') + '</div>';
				return;
			}
			list.innerHTML = available.map(function(song) {
				var esc = song.replace(/'/g, "\\'");
				return '<div class="song-item" draggable="true" data-song="' + song + '" ' +
					'ondragstart="startDrag(event, \'' + esc + '\', \'library\')" ondragend="endDrag(event)" ' +
					'ondblclick="addToActive(\'' + esc + '\')">' +
					'<span class="song-name">' + songDisplayName(song) + '</span>' +
					'<button class="btn-edit-song" onclick="event.stopPropagation(); openEditor(\'' + esc + '\')" title="Edit lyrics"><i class="fas fa-edit"></i></button>' +
					'<button class="btn btn-sm btn-outline-primary" onclick="addToActive(\'' + esc + '\')" title="Add to active"><i class="fas fa-plus"></i></button>' +
					'</div>';
			}).join('');
		}

		function renderActive() {
			var list = document.getElementById('active-list');
			document.getElementById('active-count').textContent = '(' + activeSongs.length + ' songs)';
			if (activeSongs.length === 0) {
				list.innerHTML = '<div class="empty-message">Drag songs here from the library, or double-click them</div>';
				return;
			}
			list.innerHTML = activeSongs.map(function(song, index) {
				var esc = song.replace(/'/g, "\\'");
				return '<div class="song-item" draggable="true" data-song="' + song + '" data-index="' + index + '" ' +
					'ondragstart="startDrag(event, \'' + esc + '\', \'active\')" ondragend="endDrag(event)" ' +
					'ondblclick="removeFromActive(\'' + esc + '\')">' +
					'<span class="order-num">' + (index + 1) + '</span>' +
					'<span class="song-name">' + songDisplayName(song) + '</span>' +
					'<span class="btn-group-actions">' +
					'<button onclick="moveUp(' + index + ')" title="Move up"' + (index === 0 ? ' disabled style="opacity:0.3"' : '') + '><i class="fas fa-arrow-up"></i></button>' +
					'<button onclick="moveDown(' + index + ')" title="Move down"' + (index === activeSongs.length - 1 ? ' disabled style="opacity:0.3"' : '') + '><i class="fas fa-arrow-down"></i></button>' +
					'<button onclick="event.stopPropagation(); openEditor(\'' + esc + '\')" title="Edit lyrics" style="color:var(--accent)"><i class="fas fa-edit"></i></button>' +
					'<button onclick="removeFromActive(\'' + esc + '\')" title="Remove" style="color:#f93154"><i class="fas fa-times"></i></button>' +
					'</span></div>';
			}).join('');
		}

		function filterLibrary() { renderLibrary(); }

		// === Drag and drop ===
		function startDrag(event, song, source) {
			draggedSong = song; dragSource = source;
			event.target.closest('.song-item').classList.add('dragging');
			event.dataTransfer.effectAllowed = 'move';
			event.dataTransfer.setData('text/plain', song);
		}

		function endDrag(event) {
			var el = event.target.closest('.song-item');
			if (el) el.classList.remove('dragging');
			document.querySelectorAll('.song-list').forEach(function(el) {
				el.classList.remove('drag-over', 'drag-over-remove');
			});
			draggedSong = null; dragSource = null;
		}

		function handleDragOver(event, target) {
			event.preventDefault();
			var list = event.currentTarget;
			if (target === 'active') {
				list.classList.add('drag-over');
			} else if (target === 'library' && dragSource === 'active') {
				list.classList.add('drag-over-remove');
			}
		}

		function handleDragLeave(event) {
			if (!event.currentTarget.contains(event.relatedTarget)) {
				event.currentTarget.classList.remove('drag-over', 'drag-over-remove');
			}
		}

		function handleDrop(event, target) {
			event.preventDefault();
			event.currentTarget.classList.remove('drag-over', 'drag-over-remove');
			if (!draggedSong) return;
			if (target === 'active' && dragSource === 'library') {
				var idx = getDropIndex(event, event.currentTarget);
				activeSongs.splice(idx, 0, draggedSong);
				markChanged(); renderLists();
			} else if (target === 'active' && dragSource === 'active') {
				var oldIdx = activeSongs.indexOf(draggedSong);
				var dropIdx = getDropIndex(event, event.currentTarget);
				if (oldIdx !== -1 && oldIdx !== dropIdx) {
					activeSongs.splice(oldIdx, 1);
					var newIdx = dropIdx > oldIdx ? dropIdx - 1 : dropIdx;
					activeSongs.splice(newIdx, 0, draggedSong);
					markChanged(); renderLists();
				}
			} else if (target === 'library' && dragSource === 'active') {
				removeFromActive(draggedSong);
			}
		}

		function getDropIndex(event, list) {
			var items = list.querySelectorAll('.song-item');
			for (var i = 0; i < items.length; i++) {
				var rect = items[i].getBoundingClientRect();
				if (event.clientY < rect.top + rect.height / 2) return i;
			}
			return items.length;
		}

		// === Actions ===
		function addToActive(song) {
			if (activeSongs.indexOf(song) === -1) { activeSongs.push(song); markChanged(); renderLists(); }
		}
		function removeFromActive(song) {
			var idx = activeSongs.indexOf(song);
			if (idx !== -1) { activeSongs.splice(idx, 1); markChanged(); renderLists(); }
		}
		function moveUp(index) {
			if (index > 0) {
				var tmp = activeSongs[index - 1]; activeSongs[index - 1] = activeSongs[index]; activeSongs[index] = tmp;
				markChanged(); renderActive();
			}
		}
		function moveDown(index) {
			if (index < activeSongs.length - 1) {
				var tmp = activeSongs[index]; activeSongs[index] = activeSongs[index + 1]; activeSongs[index + 1] = tmp;
				markChanged(); renderActive();
			}
		}

		function markChanged() {
			hasUnsavedChanges = true;
			var btn = document.getElementById('btn-save');
			btn.classList.remove('btn-success'); btn.classList.add('btn-warning');
			btn.innerHTML = '<i class="fas fa-save"></i> Save *';
		}

		function saveConfig() {
			var btn = document.getElementById('btn-save');
			btn.disabled = true;
			btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
			apiFetch('api/save-config.php', {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify({ active: activeSongs })
			})
			.then(function(r) {
				if (!r.ok) throw new Error('Server error: ' + r.status);
				return r.json();
			})
			.then(function(data) {
				if (data.success) {
					hasUnsavedChanges = false;
					btn.classList.remove('btn-warning'); btn.classList.add('btn-success');
					btn.innerHTML = '<i class="fas fa-save"></i> Save';
					showStatus('Configuration saved successfully!', 'success');
				} else { throw new Error(data.error || 'Unknown error'); }
			})
			.catch(function(err) { showStatus('Failed to save: ' + err.message, 'error'); })
			.finally(function() { btn.disabled = false; });
		}

		function showStatus(message, type) {
			var bar = document.getElementById('status-bar');
			bar.textContent = message;
			bar.className = type + ' show';
			setTimeout(function() { bar.classList.remove('show'); }, 3000);
		}

		// === Live preview conversion ===
		function escapeHtml(text) {
			var d = document.createElement('div'); d.textContent = text; return d.innerHTML;
		}

		function convertLyricsToHtml(plainText) {
			var lines = plainText.split('\n');
			var html = '';
			var inP = false;
			for (var i = 0; i < lines.length; i++) {
				var trimmed = lines[i].trim();
				if (trimmed === '') {
					if (inP) { html += '</p>'; inP = false; }
					continue;
				}
				var m = trimmed.match(/^(.+):$/);
				if (m) {
					if (inP) { html += '</p>'; inP = false; }
					html += '<h5>' + escapeHtml(m[1]) + '</h5>';
					continue;
				}
				if (!inP) { html += '<p>'; inP = true; }
				else { html += '<br/>'; }
				html += escapeHtml(trimmed);
			}
			if (inP) html += '</p>';
			return html;
		}

		function updatePreview() {
			var text = document.getElementById('editor-textarea').value;
			document.getElementById('editor-preview').innerHTML = convertLyricsToHtml(text);
		}

		// === Song Editor ===
		var currentEditSong = null;

		function openEditor(song) {
			currentEditSong = song;
			document.getElementById('editor-title').textContent = 'Edit: ' + songDisplayName(song);
			document.getElementById('editor-textarea').value = 'Loading...';
			document.getElementById('editor-preview').innerHTML = '';
			document.getElementById('editor-overlay').classList.add('active');

			apiFetch('api/song.php?song=' + encodeURIComponent(song))
				.then(function(r) { return r.json(); })
				.then(function(data) {
					document.getElementById('editor-textarea').value = data.lyrics || '';
					updatePreview();
				})
				.catch(function(err) {
					showStatus('Failed to load song: ' + err.message, 'error');
					closeEditor();
				});
		}

		function closeEditor() {
			document.getElementById('editor-overlay').classList.remove('active');
			currentEditSong = null;
		}

		function editorOverlayClick(event) {
			if (event.target === event.currentTarget) closeEditor();
		}

		function saveSong() {
			var btn = document.getElementById('btn-save-song');
			btn.disabled = true; btn.textContent = 'Saving...';

			apiFetch('api/song.php', {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify({
					action: 'save',
					song: currentEditSong,
					lyrics: document.getElementById('editor-textarea').value
				})
			})
			.then(function(r) {
				if (!r.ok) return r.json().then(function(d) { throw new Error(d.error || 'Server error'); });
				return r.json();
			})
			.then(function(data) {
				if (data.success) { showStatus('Song saved successfully!', 'success'); closeEditor(); }
				else { throw new Error(data.error || 'Unknown error'); }
			})
			.catch(function(err) { showStatus('Failed to save song: ' + err.message, 'error'); })
			.finally(function() { btn.disabled = false; btn.textContent = 'Save Song'; });
		}

		// === New Song ===
		function openNewSongModal() {
			document.getElementById('new-song-name').value = '';
			document.getElementById('new-song-overlay').classList.add('active');
			setTimeout(function() { document.getElementById('new-song-name').focus(); }, 100);
		}

		function closeNewSongModal() {
			document.getElementById('new-song-overlay').classList.remove('active');
		}

		function newSongOverlayClick(event) {
			if (event.target === event.currentTarget) closeNewSongModal();
		}

		function createNewSong() {
			var name = document.getElementById('new-song-name').value.trim();
			if (!name) { showStatus('Please enter a song name', 'error'); return; }

			apiFetch('api/song.php', {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify({ action: 'create', name: name })
			})
			.then(function(r) {
				if (!r.ok) return r.json().then(function(d) { throw new Error(d.error || 'Server error'); });
				return r.json();
			})
			.then(function(data) {
				if (data.success) {
					showStatus('Song created! Opening editor...', 'success');
					closeNewSongModal();
					librarySongs.push(data.song);
					librarySongs.sort();
					renderLists();
					setTimeout(function() { openEditor(data.song); }, 300);
				} else { throw new Error(data.error || 'Unknown error'); }
			})
			.catch(function(err) { showStatus('Failed to create song: ' + err.message, 'error'); });
		}
	</script>
</body>
</html>
