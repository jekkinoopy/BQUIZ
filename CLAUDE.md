# 乙級檢定練習 — 上下文 (更新: 2026-06-16)

## 給明天的指令（直接複製貼給 Claude）
> 讀這個資料夾的 CLAUDE.md，繼續昨天的 PHP 乙級備考進度。

## 現在在做什麼
PHP 乙級檢定考試備考。正在從老師的示範專案學習，理解架構思路後自己重建。
老師專案路徑：`D:\Developer\projects\FallDevCourse\11501-BQUIZ01`
練習專案路徑：`D:\Developer\projects\FallDevCourse\BQUIZ\Q1-pra01`

## 資料夾結構
```
BQUIZ/
├── Q1-pra01/
│   ├── index.php      ← 前台主頁（已完成 Commit 2）
│   ├── front/         ← include 的子頁面：login.php, main.php, news.php
│   ├── back/          ← 後台（獨立，不走前台 switch）
│   ├── css/, js/, icon/, 資料/
└── 練習時間記錄.md
```

## 老師的架構思路（已學到）

老師的目標：用一個 `index.php` 搞定所有前台頁面，避免頁首/選單重複寫四次。

### Commit 1 版本（硬寫死）✅
```php
<?php include "front/main.php"; ?>
```

### Commit 2 版本（switch 判斷）✅ 已完成
```php
$do = (!empty($_GET['do'])) ? $_GET['do'] : "main";
switch($do){
    case "admin": include "front/login.php"; break;
    case "main":  include "front/main.php";  break;
    case "news":  include "front/news.php";  break;
    default:      include "front/main.php";
}
```
注意：用戶的素材按鈕是 `?do=admin`，所以 case 是 `"admin"` 而非 `"login"`。

| 程式碼 | 誰定義的 | 意思 |
|--------|---------|------|
| `$_GET` | PHP 內建 | 接收網址 `?xxx=yyy` 的資料 |
| `?do=xxx` 的 key `do` | **素材**（考題本來就有） | 連結裡切換頁面用的參數名 |
| `$_GET['do']` | **老師**的解法 | 配合素材的 `do`，用 PHP 接過來 |
| `$do` | **老師取的**變數名 | 存「目前要顯示哪頁」（命名呼應素材的 `do`） |
| `empty()` | PHP 內建 | 判斷是否為空 |
| `switch/case/break` | PHP 內建 | 多重條件 |
| `include` | PHP 內建 | 嵌入另一個檔案 |
| `"main"/"login"/"news"` | **素材本身定義的** | 連結中 `?do=` 的值 |
| `"front/login.php"` | **老師取的** | 資料夾和檔名對應 |

**釐清規則：**
- `?do=xxx` 的 key 名稱 `do` → **素材**（乙級考題 HTML 裡本來就有）
- `$_GET['do']` 去接它 → **老師**的解法（配合素材）
- `$_GET` 本身 → **PHP 內建**

### Commit 3 版本（動態 include）⬜ 進行中
```php
$do = $_GET['do'] ?? "main";
$file = "front/$do.php";
if(file_exists($file)){
    include $file;
}else{
    include "front/main.php";
}
```

## 下次繼續的起點（更新: 2026-06-16）
- ✅ Commit 1：硬寫死 `include "front/main.php"`
- ✅ Commit 2：switch/case 路由
- ⬜ Commit 3：動態 include + file_exists（**現在在這裡**，觀念已講，尚未實作）
- ⬜ 串資料庫，動態產生內容

**下次從這裡開始：** Commit 3 的三個新語法都講解完畢後，讓用戶自己動手改 index.php。

## 用戶偏好與教學規範（重要）

- **不喜歡猜測性回答** — 不確定的事不要說
- **簡短直接** — 不要囉嗦，但要完整，不能零散
- **要區分「素材」vs「老師取的」vs「PHP 內建的」** — 每次提到語法都要明確
- **嚴禁直接給答案或叫他複製貼上** — 用戶在備考，考場要自己寫，必須學會思考
- **進入新進度前必須先說清楚**：原本寫法有什麼問題、新寫法解決什麼
- **新語法要打包講完整**：相關聯的語法（如 `??`、`$file`、`file_exists`）要一次作為完整邏輯主題講清楚，包含格式、是什麼縮寫、為什麼需要它
- **引導步驟**：① 原理說明 → ② 出題讓他自己講邏輯 → ③ 他寫完再檢查，不幫他重寫
- **不要跑太快** — 當前 commit 沒做完不談下一個

## Claude 自己的犯錯記錄（勿犯）

### 2026-06-16：更新 CLAUDE.md 沒有先整合，直接貼在最下面
更新規範前必須先讀完整份檔案，把新規範融合進既有結構，並同步更新進度，不能只是 append。

### 2026-06-16：使用者給了檔名卻叫他貼內容
使用者提到檔名就等於已經給了，直接用 Read 工具自己去讀。

### 2026-06-16：教法零散，一次只丟一個片段
Commit 3 的 `??`、`$file`、`file_exists` 被拆成好幾次才講完，讓用戶覺得資訊混亂。應該打包成一個完整邏輯主題一次講清楚。

### 2026-06-16：直接給答案叫用戶複製貼上
說「把這段刪掉換成這段」，完全失去備考意義。必須引導思路，讓用戶自己寫。

### 2026-06-15：改檔後沒有主動附 commit 指令
**規則：** 只要有改任何檔案，回覆結尾必須主動附 commit 指令，不准等人開口。

### 2026-06-15：沒有確實套用「釐清規則」
說明 `$do` 時漏掉 `do` 這個 key 來自**素材**的區分。
**規則：** 被問到哪個就講哪個的來源，不要主動把三個都拉進來。
