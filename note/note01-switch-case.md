# Note 01 — switch/case 與 ?do= 路由

## 三個來源的區分（重要）

| 東西 | 來源 |
|------|------|
| `?do=admin`、HTML 結構 | **素材**（乙級考題提供） |
| switch/case、`$_GET['do']` 這個解法 | **老師**（示範怎麼解題） |
| `Q1-pra01/` 裡的程式碼 | **自己**（照著學） |

---

## 為什麼要用 switch/case？

`index.php` 要用一個檔案處理所有前台頁面，避免頁首/選單重複寫多次。
素材裡已有 `?do=admin`、`?do=news` 等連結，所以 `index.php` 要能根據 `do` 的值決定 include 哪個片段。

---

## ?do= 的流程

```
連結/按鈕 → 網址變成 ?do=news
→ PHP 用 $_GET['do'] 接到 "news"
→ switch/case 決定 include front/news.php
```

- `do` 這個名字來自**素材本身**，老師的 switch/case 是配合素材寫的
- `$_GET` 是 PHP 內建；`'do'` 是素材定義的 key，兩邊要一致

---

## 接收參數

```php
$do = (!empty($_GET['do'])) ? $_GET['do'] : "main";
```

- 網址有 `?do=xxx` → 用那個值
- 沒有 → 預設 `"main"`

---

## switch/case 語法

```php
switch($do){
    case "main":  include "front/main.php";  break;
    case "news":  include "front/news.php";  break;
    default:      include "front/main.php";
}
```

| 語法 | 說明 |
|------|------|
| `switch($do)` | 拿 `$do` 來判斷 |
| `case "news"` | 如果 `$do` 等於 `"news"` |
| `break` | 執行完跳出，不繼續往下比對 |
| `default` | 都不符合時的預設行為 |

---

## 目前進度（2026-06-14）

- ✅ Commit 1：`index.php` 寫死 `include "front/main.php"`（已完成）
- ⬜ Commit 2：switch/case 路由（理解中，尚未實作）
- ⬜ Commit 3：動態 include + file_exists
- ⬜ 串資料庫，動態產生內容
