<?php
/**
 * Convert plain-text lyrics format to HTML.
 *
 * Format rules:
 * - Lines ending with : are section headings → <h5>Heading</h5>
 * - Other non-empty lines are lyrics → wrapped in <p> with <br/> between lines
 * - Blank lines end the current paragraph
 */
function convertLyricsToHtml($plainText) {
    $lines = explode("\n", str_replace("\r\n", "\n", trim($plainText)));
    $html = '';
    $inParagraph = false;

    foreach ($lines as $line) {
        $trimmed = trim($line);

        if ($trimmed === '') {
            if ($inParagraph) {
                $html .= "\n</p>\n";
                $inParagraph = false;
            }
            continue;
        }

        // Section heading: line ending with colon
        if (preg_match('/^(.+):$/', $trimmed, $matches)) {
            if ($inParagraph) {
                $html .= "\n</p>\n";
                $inParagraph = false;
            }
            $html .= '<h5>' . htmlspecialchars($matches[1], ENT_QUOTES, 'UTF-8') . "</h5>\n";
            continue;
        }

        // Regular lyric line
        if (!$inParagraph) {
            $html .= "<p>\n";
            $inParagraph = true;
        } else {
            $html .= "<br/>\n";
        }
        $html .= htmlspecialchars($trimmed, ENT_QUOTES, 'UTF-8');
    }

    if ($inParagraph) {
        $html .= "\n</p>\n";
    }

    return $html;
}

/**
 * Render a song file as an accordion item.
 * Supports both new plain-text format and legacy PHP/HTML format.
 */
function renderSong($filepath) {
    $filename = basename($filepath, '.php');
    $identifier = str_replace(array('\'', '"', ',', ';', '<', '>', ' '), '_', $filename);
    $content = file_get_contents($filepath);

    // Detect legacy format (starts with PHP tag)
    if (strpos(trim($content), '<?php') === 0) {
        include($filepath);
        return;
    }

    // New plain-text format
    $lyricsHtml = convertLyricsToHtml($content);
    $safeId = htmlspecialchars($identifier, ENT_QUOTES, 'UTF-8');
    $safeTitle = htmlspecialchars(strtoupper($filename), ENT_QUOTES, 'UTF-8');
    ?>
				<div class="accordion-item">
					<h2 class="accordion-header" id="heading-<?= $safeId ?>">
						<button
							class="accordion-button collapsed"
							type="button"
							data-mdb-toggle="collapse"
							data-mdb-target="#collapse-<?= $safeId ?>"
							aria-expanded="false"
							aria-controls="collapse-<?= $safeId ?>"
						>
							<strong><?= $safeTitle ?></strong>
						</button>
					</h2>
					<div id="collapse-<?= $safeId ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?= $safeId ?>" data-mdb-parent="#accordionExample">
						<div class="accordion-body">
							<?= $lyricsHtml ?>
						</div>
					</div>
				</div>
    <?php
}
