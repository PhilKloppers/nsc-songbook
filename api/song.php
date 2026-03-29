<?php
require_once __DIR__ . '/../includes/auth.php';
nscRequireApiAuth();

header('Content-Type: application/json');

$baseDir = dirname(__DIR__);
$libraryDir = $baseDir . '/songs-library';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
	// Read song content — return plain text for the editor
	$song = isset($_GET['song']) ? basename($_GET['song']) : '';

	if (!$song || !file_exists($libraryDir . '/' . $song) || $song === '_template.php') {
		http_response_code(404);
		echo json_encode(['error' => 'Song not found']);
		exit;
	}

	$content = file_get_contents($libraryDir . '/' . $song);

	// Support legacy HTML format: convert to plain text for editor
	if (strpos(trim($content), '<?php') === 0) {
		$content = convertLegacyToPlainText($content);
	}

	echo json_encode(['song' => $song, 'lyrics' => $content]);

} elseif ($method === 'POST') {
	$input = json_decode(file_get_contents('php://input'), true);
	$action = $input['action'] ?? '';

	if ($action === 'save') {
		// Save plain-text lyrics directly to the song file
		$song = basename($input['song'] ?? '');
		$lyrics = $input['lyrics'] ?? '';

		if (!$song || !file_exists($libraryDir . '/' . $song) || $song === '_template.php') {
			http_response_code(404);
			echo json_encode(['error' => 'Song not found']);
			exit;
		}

		if (file_put_contents($libraryDir . '/' . $song, $lyrics) !== false) {
			echo json_encode(['success' => true]);
		} else {
			http_response_code(500);
			echo json_encode(['error' => 'Failed to write song file']);
		}

	} elseif ($action === 'create') {
		// Create a new song with default plain-text content
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

		$defaultContent = "VERSE 1:\nLyrics here\n";
		if (file_put_contents($targetPath, $defaultContent) !== false) {
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
 * Convert a legacy-format song file (PHP/HTML with comment markers) to plain text.
 */
function convertLegacyToPlainText($content) {
	$marker = '<!-------------------------->';
	$parts = explode($marker, $content);
	if (count($parts) < 5) return '';

	$html = $parts[2];

	// Convert headings
	$text = preg_replace_callback('/<h5[^>]*>(.*?)<\/h5>/i', function($m) {
		return "\n" . strtoupper(trim($m[1])) . ":\n";
	}, $html);

	// Remove paragraph tags
	$text = preg_replace('/<\/p>/i', "\n", $text);
	$text = preg_replace('/<p[^>]*>/i', '', $text);

	// Remove br tags
	$text = preg_replace('/<br\s*\/?>/i', '', $text);

	// Remove any remaining tags
	$text = strip_tags($text);

	// Decode HTML entities
	$text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');

	// Clean up
	$lines = explode("\n", $text);
	$lines = array_map('trim', $lines);
	while (!empty($lines) && $lines[0] === '') array_shift($lines);
	while (!empty($lines) && end($lines) === '') array_pop($lines);

	// Collapse multiple blank lines
	$cleaned = [];
	$prevBlank = false;
	foreach ($lines as $line) {
		if ($line === '') {
			if (!$prevBlank) $cleaned[] = '';
			$prevBlank = true;
		} else {
			$cleaned[] = $line;
			$prevBlank = false;
		}
	}

	return implode("\n", $cleaned) . "\n";
}
