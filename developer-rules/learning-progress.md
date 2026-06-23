# 主要學習進度（最後更新: 2026-06-23）

## 目前進度
- ✅ Commit 1：`index.php` 已寫死 `include "front/main.php"`（2026-06-11 完成）
- ✅ Commit 2：switch/case 路由（index.php 完成）
- ✅ Commit 3：動態 include — `index.php` 完成
- ⚠️ Commit 3：動態 include — `admin.php` 有 bug 未修
  - else 裡是 `include "back/admin.php"` ❌ 應為 `include "back/title.php"` ✅
- ⬜ 串資料庫，動態產生內容

## 下次從這裡開始
修 `admin.php` 的 else bug：把 `"back/admin.php"` 改成 `"back/title.php"`

## 四個頁面說明
- `front/main.php`, `front/login.php`, `front/news.php` ← 前台 include 片段
- `back/title.php` ← 後台預設頁（老師定義，對應 `?do=title`）
