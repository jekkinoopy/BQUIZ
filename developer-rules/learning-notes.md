# 學習重點記錄（最後更新: 2026-06-14）

## 老師的架構思路
老師的目標：用一個 `index.php` 搞定所有前台頁面，避免頁首/選單重複寫四次。

## 三個來源的區分（重要）

| 東西 | 來源 |
|------|------|
| `?do=admin`、HTML 結構 | **素材**（乙級考題提供） |
| switch/case、`$_GET['do']` 這個解法 | **老師**（示範怎麼解題） |
| `Q1-pra01/` 裡的程式碼 | **自己**（照著學） |

釐清規則：
- `?do=xxx` 的 key 名稱 `do` → **素材**（乙級考題 HTML 裡本來就有）
- `$_GET['do']` 去接它 → **老師**的解法（配合素材）
- `$_GET` 本身 → **PHP 內建**

## Commit 1 版本（硬寫死）
```php
<?php include "front/main.php"; ?>
```

## Commit 2 版本（switch 判斷）
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

## Commit 3 版本（動態 include，尚未教）
```php
$do = $_GET['do'] ?? "main";
$file = "front/$do.php";
if(file_exists($file)){
    include $file;
}else{
    include "front/main.php";
}
```
**待教重點**：帶用戶思考 switch 版本和這個版本新增頁面時的差異。
