# Blog index redesign — two-column post cards + reusable sidebar widgets

## Context

The blog listing ([templates/index.html](jorriss-theme/templates/index.html)) is currently a full-width **3-column grid** of small post cards with no sidebar. The user wants it redesigned to match a provided mockup: a **two-column layout** — a single, vertically-stacked column of large post cards on the left, and a **sidebar** on the right with **search, categories, recent posts, and tag cloud** widgets. The sidebar widgets must be **reusable anywhere on the site**. The header (sticky nav) and footer stay unchanged; the dark masthead band keeps the site's existing styling.

Decisions confirmed with the user:
- **Masthead**: same dark-band style, eyebrow `// the blog`, heading `Notes from the query planner`, plus an **empty lede** placeholder paragraph (a single space) so the structure exists to fill later.
- **Widgets**: **dynamic WordPress core blocks** (Search, Categories, Latest Posts, Tag Cloud), styled to match. Real counts, auto-updating. Minor deviations from the mockup are acceptable (e.g. no highlighted "All posts" row).
- **Reusable via**: **template parts** (synced, edit-once in the Site Editor), registered as general/`uncategorized` parts.
- **Sticky pin**: **dropped** — every card just gets its category badge.

The main design focus is the **post card**.

## Files to change / add

### 1. `theme.json` — register the new template parts
Add to the `templateParts` array (after the header/footer entries):
```json
{ "name": "sidebar",            "title": "Blog Sidebar",       "area": "uncategorized" },
{ "name": "sidebar-search",     "title": "Widget: Search",     "area": "uncategorized" },
{ "name": "sidebar-categories", "title": "Widget: Categories", "area": "uncategorized" },
{ "name": "sidebar-recent",     "title": "Widget: Recent Posts","area": "uncategorized" },
{ "name": "sidebar-tags",       "title": "Widget: Tag Cloud",  "area": "uncategorized" }
```

### 2. `functions.php` — add a comment-count block binding
The card meta line needs "12 comments". There's no clean core block for a per-post comment count inside a query loop, so add a binding alongside the existing `jorriss/reading-time` and `jorriss/primary-term` sources (same file, same pattern, reusing `jorriss_binding_post_id()`):
- New helper `jorriss_comment_count( $post_id )` → returns e.g. `"12 comments"` / `"1 comment"` / `"No comments"` via `get_comments_number()`.
- Register source `jorriss/comment-count` in `jorriss_register_bindings()`.

### 3. New template-part files in `jorriss-theme/parts/`
Each widget wraps a core block in a `jr-widget` group with a `jr-eyebrow` label. All dynamic.

- **`parts/sidebar-search.html`** — `jr-eyebrow` "// search" + `core/search` (label hidden, placeholder "Search posts…", button text "Go").
- **`parts/sidebar-categories.html`** — "// categories" + `core/categories` with `showPostCounts:true`.
- **`parts/sidebar-recent.html`** — "// recent posts" + `core/latest-posts` (`displayPostDate:true`, `postsToShow:4`).
- **`parts/sidebar-tags.html`** — "// tag cloud" + `core/tag-cloud` (`numberOfTags` ~12, counts off).
- **`parts/sidebar.html`** — a `jr-sidebar` group that pulls the four widgets in via `wp:template-part` references, so it can be dropped onto any template/page as one unit (and each widget is still individually insertable).

### 4. `templates/index.html` — rebuild as two-column
New structure:
- `header` template part (unchanged).
- `main` > dark **masthead** group (`jr-masthead`, `align:full`, `backgroundColor:dark`, contentSize `1180px`) containing: `jr-eyebrow` "// the blog", `<h1 xx-large>` "Notes from the query planner", and an empty-lede paragraph `jr-lede` with a single space.
- A `jr-section` wide group (1180px) wrapping a **`jr-blog-layout`** group (the CSS grid):
  - **Left column** — a `core/query` (`className:"jr-postlist"`, `perPage:9`, `inherit:true`) containing, in order:
    - a "Showing posts" count line — use `core/query-total` if available (WP 6.7+), otherwise a static `jr-count` eyebrow paragraph as fallback;
    - `post-template` with the **new card markup** (below);
    - `query-pagination` (centered — see CSS);
    - `query-no-results` (reuse the existing `jr-empty` block).
  - **Right column** — a `<aside>` group referencing the `sidebar` template part.
- `footer` template part (unchanged).

**New post card markup** (inside `post-template`), a group `jr-postcard`:
- `jr-card-cover` group holding an absolutely-positioned category badge — `core/post-terms {"term":"category"}` styled as a green pill (`jr-card-badge`) — plus `core/post-featured-image {"isLink":true}`.
- `jr-card-body` group holding:
  - `core/post-title {"level":2,"isLink":true,"className":"jr-post-title-link"}`;
  - a `jr-meta` group: a "By" text + `core/post-author-name`, then `core/post-date {"format":"F j, Y"}`, then a paragraph bound to `jorriss/comment-count`;
  - `core/post-excerpt {"className":"jr-post-excerpt"}`;
  - `core/read-more {"content":"Continue reading →","className":"jr-read"}`.

### 5. `assets/main.css` — new styles (append near the writing-section block)
Reuse existing tokens/classes (`--jr-accent`, `.jr-eyebrow`, `.jr-meta`, `.jr-card-cover`, `.jr-card-body`, `.jr-post-title-link`, `.jr-read`, `.jr-badge`). New rules:
- `.jr-blog-layout` — `display:grid; grid-template-columns: minmax(0,1fr) 300px; gap: clamp(32px,5vw,56px);` collapses to one column under ~900px (sidebar moves below).
- `.jr-postlist .wp-block-post-template` — flex column, `gap:22px`, no list bullets; `.jr-postcard` — white card, `1px var(--jr-line)` border, radius 16px, hover lifts `translateY(-3px)` + accent border (mirrors existing `.jr-post-grid li`).
- `.jr-postcard .jr-card-cover` — taller cover (~180px) with the existing hatched placeholder background.
- `.jr-card-badge` — green pill over the cover, top-left (mirror `.jr-featured-badge` positioning/colors).
- `.jr-meta` "By …" separators — pipe/dot between author · date · comments (extend the existing `::before` separator rule).
- `.jr-count` — mono eyebrow "Showing N posts" line above the list.
- `.jr-sidebar`/`.jr-widget` — spacing between widgets, optional `position:sticky; top:88px` on desktop; each `.jr-widget .jr-eyebrow` as the label with a hairline divider.
- Widget internals: `core/search` (rounded input + green "Go" button reusing `.jr-btn` colors), `core/categories` list (mono, hairline rows, accent counts), `core/latest-posts` list (title links + muted mono dates), `core/tag-cloud` (pills reusing `.jr-tags a`).
- `.jr-pagination` — center the numbers and style them as pill buttons with an accent "current" (mockup shows centered numbered pagination vs. today's space-between).

## Reuse notes
- Card visuals lean entirely on existing card/meta/badge CSS — mostly new *layout* wrappers, not new visual language.
- The comment-count binding follows the exact shape of the two existing bindings in [functions.php](jorriss-theme/functions.php) (`jorriss_binding_post_id` + `register_block_bindings_source`).
- The masthead group is copied from [page.html](jorriss-theme/templates/page.html)/current [index.html](jorriss-theme/templates/index.html) styling; only the text and the added empty lede differ.

## Verification
1. Activate the theme locally (or in the current WP install) and open the blog posts page (`/` or the assigned Posts page). Confirm: dark masthead with eyebrow + "Notes from the query planner", two-column layout, stacked cards with category badge / title / "By author · date · N comments" / excerpt / "Continue reading →", and a right sidebar showing all four widgets with real data.
2. Resize to mobile width — sidebar should stack below the cards; cards remain readable.
3. In the Site Editor → Patterns/Template Parts, confirm the five new parts appear and can be inserted onto another page (e.g. drop `Blog Sidebar` into a page) — verifying reusability.
4. Confirm the category badge shows the real category name, comment counts render correctly (0, 1, many), pagination navigates, and the no-results state still shows.
5. Sanity-check that the header and footer are visually unchanged from before.
