# ポートフォリオ「情報共有アプリ」説明

 これは、私が働いていたデリバリー店で使用するために作成したアプリになります
 デリバリー店員は配達が基本業務なので基本的にお店にいることは少なく忙しくなればなるほど一回で配達する件数も必然的に増えていきます。
 そうなるとその日いるメンバー(平均4.5人)で時間に合わせるように効率が求められます。
 そこで使用するのがこの情報共有アプリです。
 時間順で並んでいるのでひと目で時間・場所の把握ができ、レスポンシブに対応しているのでスマホから確認することも可能です。
　　
<br>

# ER図
<img width="1680" alt="スクリーンショット 2021-12-20 3 37 13" src="https://user-images.githubusercontent.com/77727362/197749830-40bd515e-c10a-4fcb-96c0-ae13ba149f0e.png">  

<br>  

# アプリの使用方法
##  顧客情報(https://kouch-fooddelivery.com/customers)
お客様情報を登録、編集、削除、注文回数や最終注文日を確認することができる。  
2回目以降注文する際、顧客詳細から予約情報登録画面へ、情報を渡すことができる。  
これによって、2度以上注文する方には、同じことを聞く必要がなくなることで  
「お客様のストレス軽減、電話位受付の時間短縮」などができる。

<img width="1428" alt="スクリーンショット 2022-10-26 16 31 15" src="https://user-images.githubusercontent.com/77727362/197963049-d62e8b1c-6efb-48c1-b8d6-0e69f0a92311.png">

<br>  

##  予約状況(https://kouch-fooddelivery.com/reservations)
注文についての情報を登録、編集、削除、注文内容、注文時間等を確認することができる。  
検索フォームで、日付を入力することでその日の配達状況を確認することができ、日付は降順、配達時間は昇順で並んでいる。  
このページの役割は、「配達員と店舗従業員での円滑な情報共有」ができる

<br>

##  商品一覧(https://kouch-fooddelivery.com/items)
予約登録で表示されるメニュー登録を行うページ。  
ステータスの「販売中・販売停止」を変えることで予約登録で表示を切り変えることができる

<img width="1680" alt="スクリーンショット 2022-10-27 14 19 30" src="https://user-images.githubusercontent.com/77727362/198198340-6e6124e5-c05f-464a-acc7-12019aa5fc12.png">


<br> 

## 購入履歴(https://kouch-fooddelivery.com/purchases)
予約一覧で登録した情報を購入履歴として表示することができる。

<img width="1680" alt="スクリーンショット 2022-10-27 14 36 24" src="https://user-images.githubusercontent.com/77727362/198200465-48a3e48c-4c42-4787-ac74-eb03a55fcbbb.png">

<br>

## 集計(https://kouch-fooddelivery.com/analysis)
予約情報から、「日別、月別、年別」で「売上、平均、件数」を棒グラフで表示することができる。

<img width="1680" alt="スクリーンショット 2022-10-27 14 44 08" src="https://user-images.githubusercontent.com/77727362/198201541-1b6d0ee5-a2a6-4900-b1b3-9a753740bd2c.png">

<br>

# 機能一覧

* ユーザー登録、ログイン機能
* 検索機能
* CRUD機能
* ページネーション
* 集計機能 

<br>  

 # 使用技術

* PHP 8.1.11 
* Laravel Framework 9.34.0
* vue @3.2.40 
* MySQL 5.7 
* AWS EC2等
* Docker/docker-compose
* npm 8.19.2
* node v16.18.0
