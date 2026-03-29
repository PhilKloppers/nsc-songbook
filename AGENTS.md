# AI Agent Instructions for NSC Songbook

## Project Overview

This is a PHP-based songbook website for mobile use at an outdoor pre-sunrise church service. It uses MDB 5 (Material Design for Bootstrap) for UI components, with no database — all state is stored in flat files. The site defaults to dark mode for pre-sunrise visibility.

## Key Architecture Decisions

- **No database.** Song configuration is stored in `config/active-songs.json`. Song content lives in individual plain-text files (with `.php` extension) under `songs-library/`.
- **Songs are plain-text files** with a simple format: lines ending with `:` are section headings, everything else is lyrics. The `includes/song-renderer.php` converts this to HTML accordion items at render time.
- **The admin page (`admin.php`) is a single-page app** that communicates with `api/save-config.php` and `api/song.php` via fetch. It uses vanilla JavaScript with no additional libraries beyond MDB.
- **The main page (`index.php`) is server-rendered PHP** that reads song files and renders them using `renderSong()` from the song renderer.
- **Authentication** is session-based. The password hash is stored in `config/.admin_password`. All admin pages and API endpoints require auth.
- **Dark mode by default**, with a light mode toggle via the hamburger menu. Theme preference is stored in `localStorage`.
- **Mobile-first for the main page**, desktop-oriented for the admin page.

## File Conventions

### Song files (`songs-library/*.php`)
- Filename = song title (lowercase, `.php` extension). Example: `goodness of god.php`
- Files starting with `_` are templates/utilities and should be excluded from song listings.
- **File content is plain text** with this format:
  ```
  VERSE 1:
  First line of lyrics
  Second line of lyrics

  CHORUS:
  Chorus lyrics here
  ```
- Lines ending with `:` become `<h5>` headings.
- Other non-empty lines become lyrics wrapped in `<p>` with `<br/>` between lines.
- Blank lines separate paragraphs.
- The song renderer (`includes/song-renderer.php`) also supports legacy PHP/HTML format files for backward compat.

### Authentication (`includes/auth.php`, `login.php`)
- `includes/auth.php` provides session-based auth functions.
- `config/.admin_password` stores the bcrypt password hash (gitignored).
- On first admin visit, the user is prompted to set a password.
- `nscRequireAuth()` gates page access; `nscRequireApiAuth()` gates API access.

### Song Renderer (`includes/song-renderer.php`)
- `convertLyricsToHtml($plainText)` — converts plain-text lyrics to HTML.
- `renderSong($filepath)` — outputs a full accordion item. Detects format (legacy PHP/HTML vs plain text) automatically.

### Config (`config/active-songs.json`)
- JSON array of filenames: `["song name.php", "another song.php"]`
- Order in the array = display order on the main page.
- Managed via the admin page; can also be edited manually.

### API (`api/save-config.php`)
- **All methods require authentication.**
- GET: Returns `{ library: [...], active: [...] }`
- POST: Accepts `{ active: [...] }`, validates filenames, saves to config.
- Uses `basename()` to prevent directory traversal attacks.
- Excludes `_template.php` from valid song lists.

### API (`api/song.php`)
- **All methods require authentication.**
- GET `?song=filename.php`: Returns `{ song, lyrics }` — the plain-text content of the song file.
- POST `{ action: "save", song, lyrics }`: Writes plain text directly to the song file.
- POST `{ action: "create", name }`: Creates a new song with default plain-text content.
- POST `{ action: "delete", song }`: Deletes a song file from the library.
- Uses `basename()` on all filenames to prevent directory traversal.
- Supports legacy PHP/HTML format on read (converts to plain text for the editor).

### Theme & UI
- `css/style.css` defines CSS custom properties for dark/light themes.
- Dark mode is the default; `[data-theme="light"]` overrides for light mode.
- `js/script.js` handles theme toggle, accordion scroll-to-top, and font size controls.
- Both `index.php` and `admin.php` have a hamburger menu with a dark/light toggle.
- Font size controls (A+/A−) are floating buttons on the main page.

## Common Tasks

### Adding a new song
1. Use the "New Song" button on `admin.php`, or create a new file in `songs-library/` with plain-text lyrics.
2. Edit the lyrics using the admin editor (plain text with live preview) or directly in the file.
3. The song will automatically appear in the admin page's library panel.

### Changing which songs are active
Edit `config/active-songs.json` directly, or use the admin page at `admin.php`.

### Modifying styles
- Theme variables and shared styles: `css/style.css`
- Admin-specific styles: inline `<style>` block in `admin.php`
- MDB framework: `css/mdb.min.css` (do not edit)

### Resetting the admin password
Delete `config/.admin_password` from the server. The next visit to `admin.php` will prompt for a new password.

## Important Notes

- **Do not modify `css/mdb.min.css`, `css/mdb.rtl.min.css`, or `js/mdb.min.js`** — these are third-party MDB framework files.
- **The `songs-active/` directory is legacy.** It is kept for backward compatibility but is no longer used. The config file takes precedence.
- **The `index.html` file is a legacy static version** from 2022 and is not actively used.
- **Security:** The admin page and all API endpoints are protected by session-based authentication. For production, ensure HTTPS is enabled.
- **File encoding:** Song files use UTF-8. Special characters in lyrics are stored as plain text and HTML-escaped at render time.
- **No build step.** This is plain PHP served directly. No compilation, transpilation, or package management is involved.
