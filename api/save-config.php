<?php
require_once __DIR__ . '/../includes/auth.php';
nscRequireApiAuth();

header('Content-Type: application/json');

$baseDir = dirname(__DIR__);
$configFile = $baseDir . '/config/active-songs.json';
$libraryDir = $baseDir . '/songs-library';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
	// Return library songs and active songs
	$librarySongs = [];
	$files = array_diff(scandir($libraryDir), ['..', '.', '_template.php']);
	foreach ($files as $file) {
		if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
			$librarySongs[] = $file;
		}
	}
	sort($librarySongs);

	$activeSongs = [];
	if (file_exists($configFile)) {
		$activeSongs = json_decode(file_get_contents($configFile), true);
		if (!is_array($activeSongs)) {
			$activeSongs = [];
		}
		// Remove any songs that no longer exist in the library
		$activeSongs = array_values(array_filter($activeSongs, function($song) use ($libraryDir) {
			return file_exists($libraryDir . '/' . $song);
		}));
	}

	echo json_encode([
		'library' => $librarySongs,
		'active' => $activeSongs
	]);

} elseif ($method === 'POST') {
	// Save active songs list
	$input = json_decode(file_get_contents('php://input'), true);

	if (!isset($input['active']) || !is_array($input['active'])) {
		http_response_code(400);
		echo json_encode(['error' => 'Invalid request: "active" array required']);
		exit;
	}

	// Validate that all songs exist in the library
	$validSongs = [];
	foreach ($input['active'] as $song) {
		$song = basename($song); // Prevent directory traversal
		if (file_exists($libraryDir . '/' . $song) && pathinfo($song, PATHINFO_EXTENSION) === 'php' && $song !== '_template.php') {
			$validSongs[] = $song;
		}
	}

	// Ensure config directory exists
	$configDir = dirname($configFile);
	if (!is_dir($configDir)) {
		mkdir($configDir, 0755, true);
	}

	if (file_put_contents($configFile, json_encode($validSongs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) !== false) {
		echo json_encode(['success' => true, 'active' => $validSongs]);
	} else {
		http_response_code(500);
		echo json_encode(['error' => 'Failed to save configuration']);
	}

} else {
	http_response_code(405);
	echo json_encode(['error' => 'Method not allowed']);
}
