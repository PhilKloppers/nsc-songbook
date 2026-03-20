<?php
header('Content-Type: application/json');

$baseDir = dirname(__DIR__);
$libraryDir = $baseDir . '/songs-library';
$templateFile = $libraryDir . '/_template.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
	// Read song content — extract the lyrics section between the comment markers
	$song = isset($_GET['song']) ? basename($_GET['song']) : '';

	if (!$song || !file_exists($libraryDir . '/' . $song) || $song === '_template.php') {
		http_response_code(404);
		echo json_encode(['error' => 'Song not found']);
		exit;
	}

	$content = file_get_contents($libraryDir . '/' . $song);
	$lyrics = extractLyrics($content);

	echo json_encode(['song' => $song, 'lyrics' => $lyrics]);

} elseif ($method === 'POST') {
	$input = json_decode(file_get_contents('php://input'), true);
	$action = $input['action'] ?? '';

	if ($action === 'save') {
		// Save edited lyrics back into the song file
		$song = basename($input['song'] ?? '');
		$lyrics = $input['lyrics'] ?? '';

		if (!$song || !file_exists($libraryDir . '/' . $song) || $song === '_template.php') {
			http_response_code(404);
			echo json_encode(['error' => 'Song not found']);
			exit;
		}

		$content = file_get_contents($libraryDir . '/' . $song);
		$newContent = replaceLyrics($content, $lyrics);

		if ($newContent === false) {
			http_response_code(500);
			echo json_encode(['error' => 'Could not locate lyrics markers in song file']);
			exit;
		}

		if (file_put_contents($libraryDir . '/' . $song, $newContent) !== false) {
			echo json_encode(['success' => true]);
		} else {
			http_response_code(500);
			echo json_encode(['error' => 'Failed to write song file']);
		}

	} elseif ($action === 'create') {
		// Create a new song from the template
		$name = trim($input['name'] ?? '');

		if (!$name) {
			http_response_code(400);
			echo json_encode(['error' => 'Song name is required']);
			exit;
		}

		// Sanitise: lowercase, remove path separators, ensure .php extension
		$name = strtolower($name);
		$name = preg_replace('/[\/\\\\]/', '', $name);
		if (substr($name, 0, 1) === '_') {
			http_response_code(400);
			echo json_encode(['error' => 'Song name cannot start with underscore']);
			exit;
		}
		if (pathinfo($name, PATHINFO_EXTENSION) !== 'php') {
			$name .= '.php';
		}
		$name = basename($name);

		$targetPath = $libraryDir . '/' . $name;
		if (file_exists($targetPath)) {
			http_response_code(409);
			echo json_encode(['error' => 'A song with this name already exists']);
			exit;
		}

		if (!file_exists($templateFile)) {
			http_response_code(500);
			echo json_encode(['error' => 'Template file not found']);
			exit;
		}

		$template = file_get_contents($templateFile);
		// Replace template placeholder lyrics with an empty verse
		$newContent = replaceLyrics($template,
			"\t\t\t\t\t\t<h5>Verse 1</h5>\n\t\t\t\t\t\t\t<p>\nLyrics here\n\t\t\t\t\t\t\t</p>"
		);
		if ($newContent === false) {
			$newContent = $template;
		}

		if (file_put_contents($targetPath, $newContent) !== false) {
			echo json_encode(['success' => true, 'song' => $name]);
		} else {
			http_response_code(500);
			echo json_encode(['error' => 'Failed to create song file']);
		}

	} elseif ($action === 'delete') {
		// Delete a song file
		$song = basename($input['song'] ?? '');

		if (!$song || !file_exists($libraryDir . '/' . $song) || $song === '_template.php') {
			http_response_code(404);
			echo json_encode(['error' => 'Song not found']);
			exit;
		}

		if (unlink($libraryDir . '/' . $song)) {
			echo json_encode(['success' => true]);
		} else {
			http_response_code(500);
			echo json_encode(['error' => 'Failed to delete song file']);
		}

	} else {
		http_response_code(400);
		echo json_encode(['error' => 'Invalid action']);
	}

} else {
	http_response_code(405);
	echo json_encode(['error' => 'Method not allowed']);
}

/**
 * Extract lyrics content between the comment markers.
 */
function extractLyrics($content) {
	$marker = '<!-------------------------->';
	$parts = explode($marker, $content);
	// Structure: [before] marker [edit this section only] marker [LYRICS] marker marker marker [after]
	// So lyrics are in $parts[3] (0-indexed) if we split by the marker
	if (count($parts) >= 5) {
		//return trim($parts[3]);
		return $parts[2];
	}
	return '';
}

/**
 * Replace lyrics content between the comment markers.
 */
function replaceLyrics($content, $newLyrics) {
	$marker = '<!-------------------------->';
	$parts = explode($marker, $content);
	if (count($parts) >= 6) {
		$parts[3] = "\n" . $newLyrics . "\n\t\t\t\t\t\t";
		return implode($marker, $parts);
	}
	return false;
}
