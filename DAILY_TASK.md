# DAILY_TASK.md
> One task per day. Always overwritten with today's task.
> Generated: 2026-06-25

---

## Today's Task — Fix admin.php Commit 3 bug

**Estimated time:** 15–20 minutes

**Files to open:**
1. `BQUIZ/Q1-pra01/admin.php`
2. `BQUIZ/note/note02-dynamic-include.md` (for reference)

---

### Background (read this before touching code)

In `index.php`, the dynamic include logic looks like this:

```php
$do = $_GET['do'] ?? "main";
$path = "front/$do.php";
if(file_exists($path)){
    include $path;
} else {
    include "front/main.php";   // ← fallback = the DEFAULT front-end page
}
```

The `else` branch answers: **"if the file doesn't exist, which page should I show instead?"**
For the front-end, the default is `front/main.php`. That's the homepage.

Now think about the back-end (`admin.php`). The default back-end page is **標題管理 (title management)**.
- It lives at `back/title.php`
- The default `$do` value is already `"title"` (set by `?? "title"`)
- So the fallback should logically also be `back/title.php`

---

### What to do

Open `Q1-pra01/admin.php`. Find the PHP block with the dynamic include logic.

Ask yourself:
1. What does the `else` branch currently say?
2. What *should* it say, and why?
3. Is there anything else in that PHP block that also needs checking?

Fix it yourself. Don't copy-paste from the teacher's project.

---

### What "finished" means

- [ ] The `else` branch in `admin.php` correctly falls back to `back/title.php`
- [ ] You can explain in one sentence *why* `back/title.php` is the right fallback (not `back/admin.php`)
- [ ] Run the commit below

```bash
git add .
git commit -m "fix: admin.php else fallback 改為 title.php"
```
