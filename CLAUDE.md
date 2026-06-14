# 乙級檢定練習 — 上下文 (更新: 2026-06-14)

## 給明天的指令（直接複製貼給 Claude）
> 讀這個資料夾的 CLAUDE.md，繼續昨天的 PHP 乙級備考進度。

## 現在在做什麼
PHP 乙級檢定考試備考。正在從老師的示範專案學習，理解架構思路後自己重建。

## 資料夾結構
```
BQUIZ/
├── Q1-pra01/          ← 第一題第一次練習（今天從暫存資料夾複製過來）
│   ├── index.php      ← 前台主頁（目前還在整理，是從瀏覽器存下來的版型）
│   ├── admin.php      ← 後台
│   ├── login.php
│   ├── news.php
│   ├── front/         ← include 的子頁面放這裡
│   ├── css/, js/, icon/, 資料/
└── 練習時間記錄.md     ← 各題組練習時間記錄表（今天建立）
```

## 今天卡住的問題

### HTML 版型結構問題
`Q1-pra01/index.php` 目前是從瀏覽器存下來的靜態 HTML，**縮排完全混亂**，
找不到 `<div class="di">` 對應的 `</div>` 關閉位置。

- 這個 div 是**中間內容區**（`width:53.2%`），要把它整段換成 `<?php include "front/main.php"; ?>`
- 它的結束位置在 `<div id="alt"` 的**正上方那一行**

### VSCode 的 PHP 標籤配對
考場電腦是否有設定 `"files.associations": {"*.php": "html"}` 不確定，
需要問老師。設定了之後點 `<div` 標籤就能反白對應的 `</div>`。

**注意：** `Ctrl+Shift+\` 對 HTML 標籤**沒用**，那是跳括號 `{}` 的快捷鍵。

## 老師的架構思路（已學到）

老師的目標：用一個 `index.php` 搞定所有前台頁面，避免頁首/選單重複寫四次。

### Commit 1 版本（硬寫死）
```php
<?php include "front/login.php"; ?>
```

### Commit 2 版本（switch 判斷）
```php
$do = (!empty($_GET['do'])) ? $_GET['do'] : "main";
switch($do){
    case "login":  include "front/login.php";  break;
    case "main":   include "front/main.php";   break;
    case "news":   include "front/news.php";   break;
    default:       include "front/main.php";
}
```

| 程式碼 | 誰定義的 | 意思 |
|--------|---------|------|
| `$_GET` | PHP 內建 | 接收網址 `?xxx=yyy` 的資料 |
| `empty()` | PHP 內建 | 判斷是否為空 |
| `switch/case/break` | PHP 內建 | 多重條件 |
| `include` | PHP 內建 | 嵌入另一個檔案 |
| `$do` | **老師取的** | 存「目前要顯示哪頁」 |
| `"main"/"login"/"news"` | **素材本身定義的** | 連結中 `?do=` 的值 |
| `"front/login.php"` | **老師取的** | 資料夾和檔名對應 |

**釐清規則：**
- `?do=xxx` 的 key 名稱 `do` → **素材**（乙級考題 HTML 裡本來就有）
- `$_GET['do']` 去接它 → **老師**的解法（配合素材）
- `$_GET` 本身 → **PHP 內建**

### Commit 3 版本（動態 include，尚未學到）
```php
$do = $_GET['do'] ?? "main";
$file = "front/$do.php";
if(file_exists($file)){
    include $file;
}else{
    include "front/main.php";
}
```
**下次繼續**：要讓用戶先思考 switch 版本和這個版本新增頁面時的差異。

## 下次繼續的起點（更新: 2026-06-14）
- ✅ Commit 1：`index.php` 已寫死 `include "front/main.php"`
- ⬜ Commit 2：switch/case 路由（今天理解概念，尚未實作）
- ⬜ Commit 3：動態 include + file_exists
- ⬜ 串資料庫，動態產生內容

**四個頁面說明：**
- `front/main.php`, `front/login.php`, `front/news.php` ← 前台 include 片段
- `back/admin.php` ← 後台（獨立，不走前台 switch）

**下次從這裡開始：** 實作 index.php 的 switch/case（Commit 2）

## 用戶偏好（重要）
- **不喜歡猜測性回答** — 不確定的事不要說，說錯了他會很直接表達不滿
- **要先講老師的思路再引導** — 不要直接給答案，要帶著他理解為什麼
- **要區分「老師自己取名的」vs「PHP 內建的」** — 他明確要求這樣
- **不要跑太快** — 他還沒做完 commit 1 就不要講 commit 3
- **簡短直接** — 不要囉嗦
