# Note 02 — 動態 include 與後台架構

## Commit 2 → Commit 3 的進化思路

Commit 2 的 switch 要手動列舉每個頁面，新增頁面就要加 case。
老師發現 `?do=news` 的 `news` 跟 `front/news.php` 的名字本來就一樣，所以改成自動拼路徑。

---

## GET 與 POST

| | 資料在哪 | 用途 |
|---|---|---|
| GET | 網址列 `?key=value` | 查詢、切換頁面 |
| POST | 看不到，在 HTTP body | 送敏感資料（密碼、表單） |

POST 範例：
```html
<form method="post" action="login.php">
    <input type="text" name="username">
    <input type="password" name="password">
    <button type="submit">登入</button>
</form>
```
```php
$username = $_POST['username'];  // name 屬性對應 key 名稱
```

---

## 三元運算子（Commit 2 用的）

```
條件 ? 成立時的值 : 不成立時的值
```

---

## ?? 空值合併運算子（Commit 3 用的）

完整格式：
```
變數 = 值A ?? 值B;
```
值A 存在且不為 null → 用值A，否則用值B。

是以下寫法的縮寫：
```php
if(isset($_GET['do'])){
    $do = $_GET['do'];
}else{
    $do = "main";
}
```

---

## Commit 3：動態 include 三個重點

**① 雙引號裡的變數替換**
```php
$path = "front/$do.php";
```
PHP 雙引號裡的變數自動替換成值。`$do` 是 `"news"` 的話 `$path` 就是 `"front/news.php"`。
用變數存起來是因為後面要用兩次，不用重複寫。

**② file_exists(路徑)**
PHP 內建函式，檢查路徑的檔案存不存在，回傳 true 或 false。
不加這個防護，網址亂打時 PHP 會噴致命錯誤。

**③ 組合起來（前台）**
```php
$do = $_GET['do'] ?? "main";
$path = "front/$do.php";
if(file_exists($path)){
    include $path;
}else{
    include "front/main.php";
}
```
新增頁面只要在 `front/` 加檔案，這段 code 完全不用動。

---

## 後台（admin.php）的動態 include

跟前台邏輯完全一樣，只有兩個差異：
- 路徑從 `"front/$do.php"` 換成 `"back/$do.php"`
- 預設值從 `"main"` 換成 `"title"`

```php
$do = $_GET['do'] ?? "title";  //  IS$_GET['do'] ? $_GET['do'] : "title"; 
$path = "back/$do.php";
if(file_exists($path)){
    include $path;
}else{
    include "back/title.php";
}
```

---

## back/title.php 的來源

素材的 `admin.php` 原本是一整頁，中間的內容區塊就是「標題管理」的表單。
老師把這個內容區塊抽出來存成 `back/title.php`，讓 `admin.php` 外殼透過動態 include 載入它。

跟前台做法完全一樣：
- 前台：素材各頁面的內容區塊 → `front/main.php`、`front/login.php`、`front/news.php`
- 後台：素材 `admin.php` 的內容區塊 → `back/title.php`

`"title"` 是老師自己取的預設頁名稱，後台一進來預設顯示這個頁面。
