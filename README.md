# Laravel 6 上傳圖片 CKEditor 整合

整合 CKEditor 上傳圖片讓編輯器可上傳檔案甚至直瀏覽伺器服中的檔案。

## 使用方式
- 把整個專案複製一份到你的電腦裡，這裡指的「內容」不是只有檔案，而是指所有整個專案的歷史紀錄、分支、標籤等內容都會複製一份下來。
```sh
$ git clone
```
- 將 __.env.example__ 檔案重新命名成 __.env__，如果應用程式金鑰沒有被設定的話，你的使用者 sessions 和其他加密的資料都是不安全的！
- 當你的專案中已經有 composer.lock，可以直接執行指令以讓 Composer 安裝 composer.lock 中指定的套件及版本。
```sh
$ composer install
```
- 產⽣ Laravel 要使用的一組 32 字元長度的隨機字串 APP_KEY 並存在 .env 內。
```sh
$ php artisan key:generate
```
- 在瀏覽器中輸入已定義的路由 URL 來訪問，例如：http://127.0.0.1:8000。
- 你可以經由 `/ckeditor` 來進行 CKEditor 編輯。

----

## 畫面截圖
![](https://i.imgur.com/PLPsJeZ.png)
> 選擇你要上傳的檔案

![](https://i.imgur.com/QAnAcEn.png)
> 一旦文件上傳成功，使用者就會看到上傳成功訊息

![](https://i.imgur.com/YDulxkU.png)
> 寬度設定可以透過寬度屬性來處理，通常寬度還會搭配高度來制定圖片的大小，單純的只用寬度，瀏覽器會保持圖片的長寬比例呈現，但如果加上高度屬性，則圖片比例可能會有所改變
