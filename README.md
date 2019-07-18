
# 功能：改寫了summernote的圖片上傳到伺服器路徑伺服器上刪除圖片的功能<br>
## <br>教學文部落格在此：https://otherwherebeours.com
<br><br>
### 1，首先，聲明，先去自行了解什麼是summernote所見即所得編譯器：https：//summernote.org/
個人看法：主要是為了後台可以進行編輯，就好比你在fookbook上po文，也是基於所見即所得編譯器編譯器來寫的。
<br><br>
### 2，為什麼選用summernote？原因有幾點
（2.1）summernote支持bootstrap前端框架：http://www.bootcss.com/ ,現在bootstrap使用非常普遍了，最主要的亮點就是響應式佈局，而且手機（移動設備）優先。非常適合現在龐大的手機用戶瀏覽。所以summernote也非常適合在手機進行文本編輯

（2.2）自舉也有自帶的所見即所得編譯器：？？自舉所見即所得，但是為什麼不用這個呢原因是summernote可以插入視頻但是其他很多所見即所得編譯器也可以插入視頻啊我說的是國內的視頻，其他國外所見即所得編譯器大多數只能插入YouTube上了，而summernote很神奇，其他網站也行的也行，所以非常推薦編輯文本時候需要插入視頻的小編使用summernote。


（2.3）summernote真的非常簡潔，但是功能卻很完善，還可以自定義工具欄，表情符號也不例外，但是由於關於summernote插入表情符號的文章用法大部分都是在本地加載表情符號，可以參考一下：http://github.com/summernote/awesome-summernote 和https://github.com/nilobarp/summernote-ext-emoji
,但是對於在本地加載表情符號，會跟我刪除圖片發生衝突了，所以我就沒有加上的表情符號功能，還有一種方法是通過AJAX獲取api.github.emoji伺服器的鏈接，再通過鏈接添加，不過這個啊俊真不會用了。

（2.4）summernote可以直接通過summernote（“code”）獲取文本框的值，即是HTML的體代碼，可以直接上傳到數據庫或者提交給後台。
<br><br>

### 3，為什麼要改寫onImageUpload呢？
（3.1）因為summernote自帶的函數只會將圖片轉為的base64格式保存起來，所以如果保存在數據庫裡，將會非常吃力，一張隨隨便便的圖片都要幾個男，吃不消啊，所以改寫成保存在伺服器上，再上傳圖片在伺服器上的地址給數據庫就好多了

（3.2）在很多其他博客都看到有summernote的圖片上傳的改寫保存到伺服器中，但是很可惜，都是貼上代碼就不管了，而且，基本都是只保存，沒有刪除的，我想假如插入圖片錯誤，但是又不能刪除，那就太遺憾了，所以我就打算寫一個即可上傳也可刪除圖片的summernote版本其實跟我上一篇的思路一樣，只是有些地方注意一下就行： jQuery的ajax（）與PHP後台交互，利用MutationObserver進行圖片刪除

（3.3）會用AJAX的應該都沒有問題了，所以改寫onImageUpload也是利用了的jQuery的AJAX（）來與後台交互的，因為AJAX（）也支持文件類型，所以就用FORMDATA類型進行交互。

（3.4）會改寫的就沒問題，我只是為了方便不會改寫的，後台我是用PHP寫的，但是其他類型的後台寫起來也比較簡單，代碼就10來行。
<br><br>


### 4，PS：插入圖片經常出現的問題
（4.1）插入一張比較大的圖可能會有報錯，原因在於php.ini的文件，第一個原因主要是圖片大小超出允許的範圍，這個問題可以通過修改的php.ini的的max_execution_time或者的post_max_size又或者的upload_max_filesize可以解決，我就不多說了，參考一下別人的經驗http://blog.csdn.net/anan890624/article/details/51859863

（4.2）第二個原因也是在php.ini的文件，不過不是大小限制，而是文件的臨時存儲文件找不到，在php.ini中的upload_tmp_dir裡可能原本沒有定義，所以需要修改，下面就是我在此基礎上作的修改。

（4.3）修改完php.ini文件後一定要重啟伺服器，否則即使改了也會出錯
（4.4)linux主機下上傳資料夾權限問題：一定要保證伺服器帳號對此資料夾有讀寫之權，如在測試環境建議使用777,以避免不必要的bug
(4.5)權限修改為777方法 [sudo chmod 777 資料夾路徑 -R]
### 5，為什麼要轉成WebP,Webp的好處？
(5.1) 在各大互聯網公司已經使用得很多了，國外的有Google（自家的東西肯定要用啦，Chrome Store 甚至已全站使用WebP）、Facebook 和ebay
(5.2)WebP 的優勢體現在它具有更優的圖像數據壓縮算法，能帶來更小的圖片體積，而且擁有肉眼識別無差異的圖像質量；同時具備了無損和有​​損的壓縮模式、Alpha 透明以及動畫的特性，在JPEG 和PNG 上的轉化效果都相當優秀、穩定和統一。
(5.3)PNG 轉WebP 的壓縮率要高於PNG 原圖壓縮率，同樣支持有損與無損壓縮轉換後的WebP 體積大幅減少，圖片質量也得到保障（同時肉眼幾乎無法看出差異）轉換後的WebP 支持Alpha 透明和24-bit 顏色數，不存在PNG8 色彩不夠豐富和在瀏覽器中可能會出現毛邊的問題
(5.4)JPEG轉WebP的效果更佳。13年底Google正式推出Animated WebP，即動態WebP，既支持GIF轉WebP，同時也支持將多張WebP圖片生成Animated WebP。但是壓縮效果未能達到宣傳的那樣。如果你在使用Chrome32以上的瀏覽器，可以點這裡查看官方提供的實例
(5.5)科技博客Gig‍‍‍aOM 曾報導：YouTube 的視頻略縮圖採用WebP 格式後，網頁加載速度提升了10%；谷歌的Chrome 網上應用商店採用WebP 格式圖片後，每天可以節省幾TB 的帶寬，頁面平均加載時間大約減少1/3；Google+ 移動應用採用WebP 圖片格式後，每天節省了50TB 數據存儲空間。
(5.6)至於WebP的兼容性，在國內，WebP已經得到半數用戶的支持了,同時在Android 和iOS 平台中同樣有官方的解析庫提供。如果你的網站以圖片為主，或者你的產品基於Chromium 內核，建議體驗嘗試。
(5.7)關於webp相關資訊，資訊來源：https://www.zhihu.com/question/27201061/answer/35637827


