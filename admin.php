<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<title>NSC Songbook - Admin</title>
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
	<!-- Google Fonts Roboto -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
	<!-- MDB -->
	<link rel="stylesheet" href="css/mdb.min.css" />
	<style>
		body {
			background-color: #f5f5f5;
			font-family: 'Roboto', sans-serif;
		}
		.panel {
			background: #fff;
			border: 2px solid #dee2e6;
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
		.panel-header.active-header {
			background: #00b74a;
		}
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
			background: #f8f9fa;
			border: 1px solid #dee2e6;
			border-radius: 6px;
			cursor: grab;
			user-select: none;
			transition: background-color 0.15s, box-shadow 0.15s;
		}
		.song-item:hover {
			background: #e3f2fd;
			box-shadow: 0 2px 4px rgba(0,0,0,0.1);
		}
		.song-item.dragging {
			opacity: 0.5;
			background: #bbdefb;
		}
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
			color: #666;
			font-size: 0.85rem;
		}
		.song-item .btn-group-actions button:hover {
			background: #dee2e6;
			color: #333;
		}
		.song-list.drag-over {
			background: #e8f5e9;
			border: 2px dashed #00b74a;
			border-radius: 0 0 6px 6px;
		}
		.song-list.drag-over-remove {
			background: #ffebee;
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
		#status-bar.show {
			transform: translateY(0);
		}
		#status-bar.success {
			background: #00b74a;
			color: #fff;
		}
		#status-bar.error {
			background: #f93154;
			color: #fff;
		}
		.search-box {
			padding: 8px;
			border-bottom: 1px solid #dee2e6;
		}
		.search-box input {
			width: 100%;
			padding: 8px 12px;
			border: 1px solid #dee2e6;
			border-radius: 6px;
			font-size: 0.9rem;
		}
		.search-box input:focus {
			outline: none;
			border-color: #1266f1;
			box-shadow: 0 0 0 2px rgba(18,102,241,0.2);
		}
		.empty-message {
			color: #999;
			text-align: center;
			padding: 40px 20px;
			font-style: italic;
		}
		.toolbar {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 20px;
		}
		.song-count {
			font-size: 0.85rem;
			color: #666;
			padding: 4px 8px;
		}
		/* Editor modal */
		.modal-overlay {
			display: none;
			position: fixed;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background: rgba(0,0,0,0.5);
			z-index: 2000;
			align-items: center;
			justify-content: center;
		}
		.modal-overlay.active {
			display: flex;
		}
		.editor-modal {
			background: #fff;
			border-radius: 12px;
			width: 90%;
			max-width: 800px;
			max-height: 90vh;
			display: flex;
			flex-direction: column;
			box-shadow: 0 20px 60px rgba(0,0,0,0.3);
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
		.editor-header h5 {
			margin: 0;
			font-weight: 500;
			text-transform: capitalize;
		}
		.editor-header button {
			background: none;
			border: none;
			color: #fff;
			font-size: 1.4rem;
			cursor: pointer;
			padding: 0 4px;
			opacity: 0.8;
		}
		.editor-header button:hover {
			opacity: 1;
		}
		.editor-body {
			padding: 20px;
			flex: 1;
			overflow-y: auto;
			display: flex;
			flex-direction: column;
		}
		.editor-body textarea {
			width: 100%;
			flex: 1;
			min-height: 350px;
			padding: 12px;
			border: 1px solid #dee2e6;
			border-radius: 6px;
			font-family: 'Courier New', Courier, monospace;
			font-size: 0.9rem;
			line-height: 1.5;
			resize: vertical;
		}
		.editor-body textarea:focus {
			outline: none;
			border-color: #1266f1;
			box-shadow: 0 0 0 2px rgba(18,102,241,0.2);
		}
		.editor-footer {
			padding: 12px 20px;
			border-top: 1px solid #dee2e6;
			display: flex;
			justify-content: space-between;
			align-items: center;
		}
		.editor-help {
			font-size: 0.8rem;
			color: #999;
		}
		.btn-edit-song {
			border: none;
			background: none;
			cursor: pointer;
			padding: 4px 6px;
			border-radius: 4px;
			color: #1266f1;
			font-size: 0.85rem;
			margin-left: 4px;
		}
		.btn-edit-song:hover {
			background: #e3f2fd;
		}
		/* New song modal */
		.new-song-input {
			width: 100%;
			padding: 10px 14px;
			border: 1px solid #dee2e6;
			border-radius: 6px;
			font-size: 1rem;
			margin-bottom: 12px;
		}
		.new-song-input:focus {
			outline: none;
			border-color: #1266f1;
			box-shadow: 0 0 0 2px rgba(18,102,241,0.2);
		}
	</style>
</head>
<body>
	<header>
		<nav class="navbar navbar-dark bg-dark">
			<div class="container-fluid">
				<span class="navbar-brand mb-0 h1">NSC Songbook - Admin</span>
				<a href="index.php" class="btn btn-outline-light btn-sm">
					<i class="fas fa-eye"></i> View Songbook
				</a>
			</div>
		</nav>
	</header>

	<main class="container-fluid py-4">
		<div class="toolbar">
			<p class="mb-0 text-muted">Drag songs between panels. Double-click to add/remove. Click <i class="fas fa-edit"></i> to edit lyrics.</p>
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
			<!-- Library Panel -->
			<div class="col-md-6">
				<div class="panel">
					<div class="panel-header">
						<i class="fas fa-music"></i> Song Library
						<span id="library-count" class="song-count" style="color: rgba(255,255,255,0.8);"></span>
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

			<!-- Active Panel -->
			<div class="col-md-6">
				<div class="panel">
					<div class="panel-header active-header">
						<i class="fas fa-list-ol"></i> Active Songs (Service Order)
						<span id="active-count" class="song-count" style="color: rgba(255,255,255,0.8);"></span>
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
				<textarea id="editor-textarea" spellcheck="true"></textarea>
			</div>
			<div class="editor-footer">
				<span class="editor-help">Use &lt;h5&gt; for section headings (Verse, Chorus, Bridge). Use &lt;p&gt; for lyric blocks and &lt;br/&gt; for line breaks.</span>
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
				<p class="text-muted mb-3">Enter the song title. This will become the filename (lowercase). You can edit the lyrics after creation.</p>
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
		let librarySongs = [];
		let activeSongs = [];
		let draggedSong = null;
		let dragSource = null; // 'library' or 'active'
		let hasUnsavedChanges = false;

		// Load data on page load
		document.addEventListener('DOMContentLoaded', loadConfig);

		// Warn about unsaved changes
		window.addEventListener('beforeunload', function(e) {
			if (hasUnsavedChanges) {
				e.preventDefault();
				e.returnValue = '';
			}
		});

		function loadConfig() {
			fetch('api/save-config.php')
				.then(r => r.json())
				.then(data => {
					librarySongs = data.library || [];
					activeSongs = data.active || [];
					renderLists();
				})
				.catch(err => showStatus('Failed to load configuration: ' + err.message, 'error'));
		}

		function getAvailableSongs() {
			// Songs in library that are NOT in the active list
			return librarySongs.filter(s => !activeSongs.includes(s));
		}

		function songDisplayName(filename) {
			return filename.replace('.php', '');
		}

		function renderLists() {
			renderLibrary();
			renderActive();
		}

		function renderLibrary() {
			const list = document.getElementById('library-list');
			const searchTerm = document.getElementById('library-search').value.toLowerCase();
			const available = getAvailableSongs().filter(s =>
				songDisplayName(s).toLowerCase().includes(searchTerm)
			);

			document.getElementById('library-count').textContent = '(' + available.length + ' songs)';

			if (available.length === 0) {
				list.innerHTML = '<div class="empty-message">' +
					(searchTerm ? 'No songs match your search' : 'All songs are in the active list') +
					'</div>';
				return;
			}

			list.innerHTML = available.map(song =>
				'<div class="song-item" draggable="true" data-song="' + song + '" ' +
				'ondragstart="startDrag(event, \'' + song.replace(/'/g, "\\'") + '\', \'library\')" ' +
				'ondragend="endDrag(event)" ' +
				'ondblclick="addToActive(\'' + song.replace(/'/g, "\\'") + '\')">' +
				'<span class="song-name">' + songDisplayName(song) + '</span>' +
				'<button class="btn-edit-song" onclick="event.stopPropagation(); openEditor(\'' + song.replace(/'/g, "\\'") + '\')" title="Edit lyrics">' +
				'<i class="fas fa-edit"></i></button>' +
				'<button class="btn btn-sm btn-outline-primary" onclick="addToActive(\'' + song.replace(/'/g, "\\'") + '\')" title="Add to active list">' +
				'<i class="fas fa-plus"></i></button>' +
				'</div>'
			).join('');
		}

		function renderActive() {
			const list = document.getElementById('active-list');
			document.getElementById('active-count').textContent = '(' + activeSongs.length + ' songs)';

			if (activeSongs.length === 0) {
				list.innerHTML = '<div class="empty-message">Drag songs here from the library, or double-click them</div>';
				return;
			}

			list.innerHTML = activeSongs.map((song, index) =>
				'<div class="song-item" draggable="true" data-song="' + song + '" data-index="' + index + '" ' +
				'ondragstart="startDrag(event, \'' + song.replace(/'/g, "\\'") + '\', \'active\')" ' +
				'ondragend="endDrag(event)" ' +
				'ondblclick="removeFromActive(\'' + song.replace(/'/g, "\\'") + '\')">' +
				'<span class="order-num">' + (index + 1) + '</span>' +
				'<span class="song-name">' + songDisplayName(song) + '</span>' +
				'<span class="btn-group-actions">' +
				'<button onclick="moveUp(' + index + ')" title="Move up"' + (index === 0 ? ' disabled style="opacity:0.3"' : '') + '><i class="fas fa-arrow-up"></i></button>' +
				'<button onclick="moveDown(' + index + ')" title="Move down"' + (index === activeSongs.length - 1 ? ' disabled style="opacity:0.3"' : '') + '><i class="fas fa-arrow-down"></i></button>' +
				'<button onclick="event.stopPropagation(); openEditor(\'' + song.replace(/'/g, "\\'") + '\')" title="Edit lyrics" style="color:#1266f1"><i class="fas fa-edit"></i></button>' +
				'<button onclick="removeFromActive(\'' + song.replace(/'/g, "\\'") + '\')" title="Remove" style="color:#f93154"><i class="fas fa-times"></i></button>' +
				'</span>' +
				'</div>'
			).join('');
		}

		function filterLibrary() {
			renderLibrary();
		}

		// Drag and drop
		function startDrag(event, song, source) {
			draggedSong = song;
			dragSource = source;
			event.target.closest('.song-item').classList.add('dragging');
			event.dataTransfer.effectAllowed = 'move';
			event.dataTransfer.setData('text/plain', song);
		}

		function endDrag(event) {
			event.target.closest('.song-item')?.classList.remove('dragging');
			document.querySelectorAll('.song-list').forEach(el => {
				el.classList.remove('drag-over', 'drag-over-remove');
			});
			draggedSong = null;
			dragSource = null;
		}

		function handleDragOver(event, target) {
			event.preventDefault();
			const list = event.currentTarget;

			if (target === 'active') {
				if (dragSource === 'library') {
					list.classList.add('drag-over');
				} else if (dragSource === 'active') {
					// Reorder within active list
					list.classList.add('drag-over');
					handleActiveReorder(event);
				}
			} else if (target === 'library' && dragSource === 'active') {
				list.classList.add('drag-over-remove');
			}
		}

		function handleDragLeave(event, target) {
			// Only handle if we're leaving the list element itself
			if (!event.currentTarget.contains(event.relatedTarget)) {
				event.currentTarget.classList.remove('drag-over', 'drag-over-remove');
			}
		}

		function handleDrop(event, target) {
			event.preventDefault();
			const list = event.currentTarget;
			list.classList.remove('drag-over', 'drag-over-remove');

			if (!draggedSong) return;

			if (target === 'active' && dragSource === 'library') {
				// Add song to active list
				const dropIndex = getDropIndex(event, list);
				activeSongs.splice(dropIndex, 0, draggedSong);
				markChanged();
				renderLists();
			} else if (target === 'active' && dragSource === 'active') {
				// Reorder within active list
				const oldIndex = activeSongs.indexOf(draggedSong);
				const dropIndex = getDropIndex(event, list);
				if (oldIndex !== -1 && oldIndex !== dropIndex) {
					activeSongs.splice(oldIndex, 1);
					const newIndex = dropIndex > oldIndex ? dropIndex - 1 : dropIndex;
					activeSongs.splice(newIndex, 0, draggedSong);
					markChanged();
					renderLists();
				}
			} else if (target === 'library' && dragSource === 'active') {
				// Remove from active
				removeFromActive(draggedSong);
			}
		}

		function getDropIndex(event, list) {
			const items = list.querySelectorAll('.song-item');
			for (let i = 0; i < items.length; i++) {
				const rect = items[i].getBoundingClientRect();
				if (event.clientY < rect.top + rect.height / 2) {
					return i;
				}
			}
			return items.length;
		}

		function handleActiveReorder(event) {
			// Visual indicator for drop position could be added here
		}

		// Actions
		function addToActive(song) {
			if (!activeSongs.includes(song)) {
				activeSongs.push(song);
				markChanged();
				renderLists();
			}
		}

		function removeFromActive(song) {
			const index = activeSongs.indexOf(song);
			if (index !== -1) {
				activeSongs.splice(index, 1);
				markChanged();
				renderLists();
			}
		}

		function moveUp(index) {
			if (index > 0) {
				[activeSongs[index - 1], activeSongs[index]] = [activeSongs[index], activeSongs[index - 1]];
				markChanged();
				renderActive();
			}
		}

		function moveDown(index) {
			if (index < activeSongs.length - 1) {
				[activeSongs[index], activeSongs[index + 1]] = [activeSongs[index + 1], activeSongs[index]];
				markChanged();
				renderActive();
			}
		}

		function markChanged() {
			hasUnsavedChanges = true;
			document.getElementById('btn-save').classList.remove('btn-success');
			document.getElementById('btn-save').classList.add('btn-warning');
			document.getElementById('btn-save').innerHTML = '<i class="fas fa-save"></i> Save *';
		}

		function saveConfig() {
			const btn = document.getElementById('btn-save');
			btn.disabled = true;
			btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

			fetch('api/save-config.php', {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify({ active: activeSongs })
			})
			.then(r => {
				if (!r.ok) throw new Error('Server error: ' + r.status);
				return r.json();
			})
			.then(data => {
				if (data.success) {
					hasUnsavedChanges = false;
					btn.classList.remove('btn-warning');
					btn.classList.add('btn-success');
					btn.innerHTML = '<i class="fas fa-save"></i> Save';
					showStatus('Configuration saved successfully!', 'success');
				} else {
					throw new Error(data.error || 'Unknown error');
				}
			})
			.catch(err => {
				showStatus('Failed to save: ' + err.message, 'error');
			})
			.finally(() => {
				btn.disabled = false;
			});
		}

		function showStatus(message, type) {
			const bar = document.getElementById('status-bar');
			bar.textContent = message;
			bar.className = type + ' show';
			setTimeout(() => { bar.classList.remove('show'); }, 3000);
		}

		// Song Editor
		let currentEditSong = null;

		function openEditor(song) {
			currentEditSong = song;
			document.getElementById('editor-title').textContent = 'Edit: ' + songDisplayName(song);
			document.getElementById('editor-textarea').value = 'Loading...';
			document.getElementById('editor-overlay').classList.add('active');

			fetch('api/song.php?song=' + encodeURIComponent(song))
				.then(r => r.json())
				.then(data => {
					document.getElementById('editor-textarea').value = data.lyrics || '';
				})
				.catch(err => {
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
			const btn = document.getElementById('btn-save-song');
			btn.disabled = true;
			btn.textContent = 'Saving...';

			fetch('api/song.php', {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify({
					action: 'save',
					song: currentEditSong,
					lyrics: document.getElementById('editor-textarea').value
				})
			})
			.then(r => {
				if (!r.ok) return r.json().then(d => { throw new Error(d.error || 'Server error'); });
				return r.json();
			})
			.then(data => {
				if (data.success) {
					showStatus('Song saved successfully!', 'success');
					closeEditor();
				} else {
					throw new Error(data.error || 'Unknown error');
				}
			})
			.catch(err => showStatus('Failed to save song: ' + err.message, 'error'))
			.finally(() => {
				btn.disabled = false;
				btn.textContent = 'Save Song';
			});
		}

		// New Song
		function openNewSongModal() {
			document.getElementById('new-song-name').value = '';
			document.getElementById('new-song-overlay').classList.add('active');
			setTimeout(() => document.getElementById('new-song-name').focus(), 100);
		}

		function closeNewSongModal() {
			document.getElementById('new-song-overlay').classList.remove('active');
		}

		function newSongOverlayClick(event) {
			if (event.target === event.currentTarget) closeNewSongModal();
		}

		function createNewSong() {
			const name = document.getElementById('new-song-name').value.trim();
			if (!name) {
				showStatus('Please enter a song name', 'error');
				return;
			}

			fetch('api/song.php', {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify({ action: 'create', name: name })
			})
			.then(r => {
				if (!r.ok) return r.json().then(d => { throw new Error(d.error || 'Server error'); });
				return r.json();
			})
			.then(data => {
				if (data.success) {
					showStatus('Song created! Opening editor...', 'success');
					closeNewSongModal();
					// Add to library list and open editor
					librarySongs.push(data.song);
					librarySongs.sort();
					renderLists();
					setTimeout(() => openEditor(data.song), 300);
				} else {
					throw new Error(data.error || 'Unknown error');
				}
			})
			.catch(err => showStatus('Failed to create song: ' + err.message, 'error'));
		}
	</script>
</body>
</html>
