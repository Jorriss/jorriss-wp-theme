# Jorriss — a WordPress block theme

A bold, developer-forward theme for **jorriss.com**: a dark techy hero, an
editorial writing grid, readable article typography, and one confident green
accent. Built for the **Site Editor** (full-site editing) on WordPress 6.7–7.0.

## Why this is nice to edit

Unlike the earlier child theme, everything here is native to WordPress's visual
editor:

- **Nav and footer** are template parts — edit them in **Appearance → Editor →
  Patterns → Template Parts** (or right on the page). The nav is a real
  **Navigation** menu; add/reorder links visually.
- **Hero** and **About** are **block patterns** ("Jorriss" category in the
  inserter) — click any text to edit it, swap the photo with the media picker.
- **Posts** flow through the **Query Loop**, so the homepage grid and the blog
  fill from your real posts automatically. Featured images become card covers;
  posts without one get a tasteful striped placeholder.
- **Colors & fonts** live in **theme.json**, so **Appearance → Editor → Styles**
  lets you tweak the whole palette (including the green) and type globally.

## Install

1. Zip the `jorriss-theme` folder (so the zip contains `style.css`,
   `theme.json`, `functions.php`, `templates/`, `parts/`, `patterns/`,
   `assets/`).
2. **Appearance → Themes → Add New → Upload Theme** → choose the zip →
   **Install Now** → **Activate**.
3. **Settings → Reading → Your homepage displays → Your latest posts** (the
   theme's `front-page.html` handles the homepage either way).

## Set up the pages

**Menu** — **Appearance → Editor → Navigation**, add links (e.g. Writing → your
Posts page, About → the About page). The last item automatically gets the green
"button" treatment.

**Blog page (optional)** — create an empty Page called "Blog", then
**Settings → Reading → Posts page → Blog**. The hero's "read the blog" button and
the "all posts" links point at `/blog/` (change them in the pattern/templates if
you use a different slug).

**About page** — **Pages → Add New**, title it "About", write as much detail as
you like in the editor. Under **Page → Template**, choose **"About Me"**. Set a
**Featured Image** for the masthead portrait. (The nav "about" link expects the
slug `about`.)

## Customize

- **Photo** — the hero/about photo lives in the *Hero* and *About* patterns; click
  the image and replace it. It currently points at your existing upload.
- **Accent green** — **Appearance → Editor → Styles → Colors**, or edit the
  `accent` / `accent-ink` values in `theme.json` and the matching `--jr-*`
  variables at the top of `assets/theme.css`.
- **Reading time & tags** on posts are generated automatically (via block
  bindings + the post's first category/tag).
- **Fonts** — Space Grotesk / IBM Plex Sans / IBM Plex Mono load from Google
  Fonts in `functions.php`; swap there to self-host.

## What's included

```
jorriss-theme/
├─ style.css              theme header
├─ theme.json             colors, fonts, spacing, layout, template parts
├─ functions.php          fonts + stylesheet, reading-time/term block bindings
├─ assets/theme.css       all bespoke styling (also loaded in the editor)
├─ parts/                 header.html, footer.html
├─ patterns/              hero.php, about.php
└─ templates/             front-page, single, page, about, index, archive, search, 404
```

## Requirements

- WordPress 6.7+ (tested through 7.0), PHP 7.4+.
- No parent theme needed — this is standalone.
