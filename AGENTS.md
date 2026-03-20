# AI Agent Instructions for NSC Songbook

## Project Overview

This is a PHP-based songbook website for mobile use at an outdoor pre-sunrise church service. It uses MDB 5 (Material Design for Bootstrap) for UI components, with no database — all state is stored in flat files.

## Key Architecture Decisions

- **No database.** Song configuration is stored in `config/active-songs.json`. Song content lives in individual PHP files under `songs-library/`.
- **Each song is a self-contained PHP file** that renders an accordion item. Songs derive their title from their filename and generate a unique HTML identifier from it.
- **The admin page (`admin.php`) is a single-page app** that communicates with `api/save-config.php` and `api/song.php` via fetch. It uses vanilla JavaScript with no additional libraries beyond MDB.
- **The main page (`index.php`) is server-rendered PHP** that includes song files in the order specified by the config.
- **Mobile-first for the main page**, desktop-oriented for the admin page.

## File Conventions

### Song files (`songs-library/*.php`)
- Filename = song title (lowercase, `.php` extension). Example: `goodness of god.php`
- Files starting with `_` are templates/utilities and should be excluded from song listings.
- Each file follows the structure in `_template.php`: PHP header (extracts filename, creates identifier) → accordion HTML with lyrics.
- Only the lyrics section between the `<!-------------------------->` comment markers should be edited.
- The `$identifier` variable is created by replacing special characters with underscores — this is used for unique HTML `id` attributes.

### Config (`config/active-songs.json`)
- JSON array of filenames: `["song name.php", "another song.php"]`
- Order in the array = display order on the main page.
- Managed via the admin page; can also be edited manually.

### API (`api/save-config.php`)
- GET: Returns `{ library: [...], active: [...] }`
- POST: Accepts `{ active: [...] }`, validates filenames, saves to config.
- Uses `basename()` to prevent directory traversal attacks.
- Excludes `_template.php` from valid song lists.

### API (`api/song.php`)
- GET `?song=filename.php`: Returns `{ song, lyrics }` — the lyrics HTML extracted from between the comment markers.
- POST `{ action: "save", song, lyrics }`: Replaces the lyrics section in a song file.
- POST `{ action: "create", name }`: Creates a new song from `_template.php` with placeholder lyrics.
- POST `{ action: "delete", song }`: Deletes a song file from the library.
- Uses `basename()` on all filenames to prevent directory traversal.

## Common Tasks

### Adding a new song
1. Use the "New Song" button on `admin.php`, or manually copy `songs-library/_template.php` to `songs-library/<song name>.php`.
2. Edit the lyrics between the comment markers (via the admin editor or directly in the file).
3. The song will automatically appear in the admin page's library panel.

### Changing which songs are active
Edit `config/active-songs.json` directly, or use the admin page at `admin.php`.

### Modifying styles
- Main page styles: `css/style.css`
- Admin page styles: inline `<style>` block in `admin.php`
- MDB framework: `css/mdb.min.css` (do not edit)

## Important Notes

- **Do not modify `css/mdb.min.css`, `css/mdb.rtl.min.css`, or `js/mdb.min.js`** — these are third-party MDB framework files.
- **The `songs-active/` directory is legacy.** It is kept for backward compatibility but is no longer the primary mechanism. The config file takes precedence.
- **The `index.html` file is a legacy static version** from 2022 and is not actively used.
- **Security:** The admin page and API have no authentication. If adding auth, protect both `admin.php` and `api/save-config.php`.
- **File encoding:** Song files use UTF-8. Special characters in lyrics should use HTML entities (e.g. `&apos;`) or UTF-8 directly.
- **No build step.** This is plain PHP served directly. No compilation, transpilation, or package management is involved.
