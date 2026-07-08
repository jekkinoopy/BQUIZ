# PROJECT_CONTEXT.md
> This file only grows. Never overwrite previous knowledge. Append new sections at the bottom.
> Last updated: 2026-06-25

---

## 1. Project Structure Overview

```
FallDevCourse/
├── 11501-BQUIZ01/          ← Teacher's complete reference project
│   ├── index.php           ← Front-end shell (includes api/db.php at top)
│   ├── admin.php           ← Back-end shell (includes api/db.php at top)
│   ├── front/              ← Front-end content panels (included by index.php)
│   │   ├── main.php        ← Homepage content
│   │   ├── login.php       ← Admin login form
│   │   └── news.php        ← News list with pagination
│   ├── back/               ← Back-end content panels (included by admin.php)
│   │   ├── title.php       ← Title management (DEFAULT back-end panel)
│   │   ├── ad.php          ← Marquee text ad management
│   │   ├── mvim.php        ← Animated image management
│   │   ├── image.php       ← Campus photo management
│   │   ├── news.php        ← News management
│   │   ├── admin.php       ← Admin account management
│   │   ├── menu.php        ← Menu management
│   │   ├── total.php       ← Visitor count management
│   │   └── bottom.php      ← Footer copyright management
│   ├── include/            ← Pop-up modal forms (loaded via AJAX into #cvr)
│   │   ├── marquee.php     ← Marquee ad bar (included in front/main.php, login.php, news.php)
│   │   ├── title.php       ← Add new title image form
│   │   ├── admin.php       ← Add new admin account form
│   │   ├── image.php       ← Add new campus image form
│   │   ├── mvim.php        ← Add new animated image form
│   │   ├── menu.php        ← Add new menu item form
│   │   ├── news.php        ← Add new news item form
│   │   ├── submenu.php     ← Add new submenu item form
│   │   ├── total.php       ← Total visitor management form
│   │   ├── update_title.php    ← Update existing title image
│   │   ├── update_image.php    ← Update existing campus image
│   │   └── update_mvim.php     ← Update existing animated image
│   ├── api/                ← Server-side logic (no HTML output)
│   │   ├── db.php          ← DB class + global object initialization + session_start()
│   │   ├── login.php       ← Login POST handler → sets $_SESSION['login'], redirects
│   │   ├── edit.php        ← Universal UPDATE/DELETE handler (?table=xxx)
│   │   ├── add.php         ← Universal INSERT handler
│   │   ├── update.php      ← Image/file update handler
│   │   ├── edit_bottom.php ← Bottom text edit handler
│   │   ├── edit_total.php  ← Total count edit handler
│   │   ├── edit_value.php  ← Generic value edit handler
│   │   └── submenu.php     ← Submenu handler
│   ├── css/css.css         ← Single shared stylesheet
│   ├── js/js.js            ← jQuery helpers: lo(), op(), cl()
│   ├── js/jquery-1.9.1.min.js
│   ├── icon/               ← Menu button images (menu.fw.png, menu2–4.fw.png, up.jpg, dn.jpg)
│   ├── upload/             ← User-uploaded images (B, C, D series)
│   ├── db21.sql            ← Database dump (MariaDB, dbname=db21)
│   └── 102201/             ← Official exam assets (source materials)
│       ├── 01A01.txt, 01A02.txt    ← Text content
│       ├── 01B01–04.jpg            ← Title images
│       ├── 01C01–06.gif            ← Animated images (mvim)
│       ├── 01D01–10.jpg            ← Campus photos (image)
│       ├── 01E01–02.jpg            ← Other images
│       └── 版型檔案/               ← Official layout HTML templates

└── BQUIZ/                  ← Student's learning workspace
    ├── CLAUDE.md           ← Context file for Claude (rules, progress, known bugs)
    ├── Dockerfile          ← Docker setup (not yet used in practice)
    ├── Q1-pra01/           ← Student's first practice attempt
    │   ├── index.php       ← Front-end shell (Commit 3 done, NO db.php yet)
    │   ├── admin.php       ← Back-end shell (Commit 3 has bug in else branch)
    │   ├── front/          ← Front-end content panels (static, no DB)
    │   │   ├── main.php
    │   │   ├── login.php
    │   │   └── news.php
    │   ├── back/           ← Back-end content panels (EMPTY — not created yet)
    │   │   └── admin.php   ← Only this one exists (copied from素材, static)
    │   ├── css/css.css
    │   ├── js/
    │   ├── icon/
    │   └── 資料/           ← Student's copy of exam assets
    ├── Q1官方素材/          ← Official exam assets (read-only reference)
    ├── note/               ← Study notes
    │   ├── note01-switch-case.md
    │   └── note02-dynamic-include.md
    ├── developer-rules/    ← Claude operating rules
    └── 練習時間記錄.md      ← Practice time log
```

---

## 2. Folder Relationships

```
index.php / admin.php
    │
    ├── include_once "api/db.php"    ← FIRST LINE — starts session, creates DB objects
    │       └── Creates: $Title, $Ad, $Mvim, $Image, $News, $Admin, $Menu, $Total, $Bottom
    │
    ├── HTML shell (header, left nav, right column)
    │       └── Uses $Title, $Menu, $Total, $Bottom, $Image from DB objects directly
    │
    └── Dynamic include → front/$do.php  OR  back/$do.php
            └── These panels inherit all DB objects from parent scope
```

The `$do` variable flows from parent → child. Back-end panels like `back/title.php` use `$do` directly (e.g., `action="./api/edit.php?table=<?= $do ?>"`) because they inherit it from `admin.php`.

---

## 3. Purpose of Every Important PHP File

### api/db.php
- `session_start()` — must be called first, handles visit counting and login state
- `class DB` — custom ORM with methods: `all()`, `find()`, `count()`, `save()`, `del()`, `q()`
- Global helper functions: `dd($array)` (debug print), `to($url)` (redirect)
- Instantiates 9 global DB objects: `$Title`, `$Ad`, `$Mvim`, `$Image`, `$News`, `$Admin`, `$Menu`, `$Total`, `$Bottom`
- Visitor counter logic: if `$_SESSION['visit']` not set → increment `total` table

### api/login.php
- Receives POST `acc` + `pw` from `front/login.php` form
- Uses `$Admin->count($_POST)` to check credentials
- On success: `$_SESSION['login']=1` → redirect to `admin.php`
- On failure: JS alert + redirect back to `?do=login`

### api/edit.php
- Universal UPDATE/DELETE handler for all back-end management forms
- `?table=xxx` → uses `${ucfirst($table)}` to get the right DB object dynamically
- Loops through `$_POST['id'][]`, deletes checked items, saves others
- Redirects to `../admin.php?do=$table` when done

### front/news.php
- Pagination logic: reads `?p=` from GET, calculates `$start` offset
- Shows 5 items per page with prev/next/numbered links

### back/title.php (and other back/ panels)
- Inherits `$do` from admin.php — used in form action URL and include paths
- Uses `${ucfirst($do)}` to dynamically select DB object (e.g., `$do="title"` → `$Title`)
- "更新圖片" button calls `op('#cover','#cvr','include/update_title.php?id=...')` — loads update form into modal

---

## 4. Commit Progression (Q1-pra01)

| Commit | File | Change | Status |
|--------|------|--------|--------|
| 1 | index.php | Hard-coded `include "front/main.php"` | ✅ Done |
| 2 | index.php | switch/case routing with `$_GET['do']` | ✅ Done |
| 3 | index.php | Dynamic include with `??`, `$path`, `file_exists()` | ✅ Done |
| 3 | admin.php | Dynamic include — has bug in else branch | ⚠️ Bug |
| 4 | index.php + admin.php | Add `include_once "api/db.php"` at top | ⬜ Next |
| 4 | api/db.php | Create DB class, connect to database | ⬜ Next |
| — | back/*.php | Create all back-end panels | ⬜ Future |
| — | include/*.php | Create modal forms | ⬜ Future |
| — | api/edit.php etc. | Create API handlers | ⬜ Future |

---

## 5. Differences: Q1-pra01 vs 11501-BQUIZ01

| Item | Q1-pra01 (Student) | 11501-BQUIZ01 (Teacher) |
|------|--------------------|------------------------|
| api/db.php | ❌ Missing | ✅ Complete |
| index.php top | No db.php include | `include_once "api/db.php"` |
| admin.php top | No db.php include | `include_once "./api/db.php"` |
| front/main.php | Static HTML, no DB data | Dynamic: marquee, mvim slideshow, news list |
| front/login.php | Static HTML form | Includes marquee.php, form POSTs to api/login.php |
| front/news.php | Static placeholder | Full pagination, news from DB |
| back/ directory | Only back/admin.php (static) | All 9 panels (title, ad, mvim, image, news, admin, menu, total, bottom) |
| include/ directory | ❌ Missing entirely | All modal forms + update forms + marquee.php |
| api/ directory | ❌ Missing | Complete (login, edit, add, update, etc.) |
| Database | ❌ Not connected | ✅ MariaDB db21, 9 tables |
| admin.php else branch | `include "back/admin.php"` ❌ | `include "back/title.php"` ✅ |

---

## 6. Current Known Bugs (Q1-pra01)

### Bug 1 — admin.php else branch (Commit 3, as of 2026-06-25)
**File:** `Q1-pra01/admin.php`
**Location:** Inside the dynamic include PHP block, `else` branch
**Current code:** `include "back/admin.php";`
**Should be:** `include "back/title.php";`
**Why:** The default back-end page is "title management" (`back/title.php`), not admin.php itself. The `else` branch triggers when `$path` doesn't exist, so it should fall back to the intended default — same logic as front-end falling back to `front/main.php`.

---

## 7. Database

### db21 Tables (from db21.sql)
| Table | Columns | Purpose |
|-------|---------|---------|
| title | id, img, text, sh | Site title image + alt text |
| ad | id, text, sh | Marquee text ads |
| mvim | id, img, sh | Animated images for main panel |
| image | id, img, sh | Campus photos (right column) |
| news | id, text, sh | News items |
| admin | id, acc, pw | Admin accounts |
| menu | id, href, text, sh, main_id | Nav menu (main_id=0 is top-level) |
| total | id, total | Visitor count (only 1 row, id=1) |
| bottom | id, bottom | Footer copyright text |

### DB class methods
| Method | Usage | Returns |
|--------|-------|---------|
| `all(array/string, string)` | `$News->all(['sh'=>1], " limit 5")` | Array of rows |
| `find(id/array)` | `$Title->find(['sh'=>1])` | Single row |
| `count(array/string)` | `$News->count(['sh'=>1])` | Integer |
| `save(array)` | `$db->save($row)` | Has `id` → UPDATE, no `id` → INSERT |
| `del(id/array)` | `$db->del($id)` | Executes DELETE |
| `q(sql)` | Raw query fallback | Array of rows |

### Student DB Status
- ⬜ db21 database not created in student environment yet
- ⬜ api/db.php not written yet
- ⬜ index.php and admin.php not yet connected to DB

---

## 8. JS Helper Functions (js/js.js)

| Function | Signature | Purpose |
|----------|-----------|---------|
| `lo(x)` | `lo('?do=login')` | `location.replace(x)` — navigate |
| `op(x,y,url)` | `op('#cover','#cvr','include/title.php')` | Fade in modal, AJAX load URL into #cvr |
| `cl(x)` | `cl('#cover')` | Fade out / close modal |

Modal structure: `#cover` (overlay) → `#coverr` (white box) → `#cvr` (content div loaded via `.load(url)`)

---
