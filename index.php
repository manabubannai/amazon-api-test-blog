<!DOCTYPE html>
<html lang="ja">
<head>
<title>Amazon APIを使って商品検索するサンプルコード</title>
<meta charset="utf-8">
<!-- Bootstrap読み込み（スタイリングのため） -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
</head>
<body>

<?php

// Amazon APIのアクセスキーとシークレットキーを入力
define("Access_Key_ID", "XXXXXXXXXXXXXXXXXXXXXXXXXX");
define("Secret_Access_Key", "XXXXXXXXXXXXXXXXXXXXXXXXXX");

// アソシエイトIDの入力
define("Associate_tag", "XXXXXXXXXXXXXXXXXXXXXXXXXX");

// 本のカテゴリから「東野圭吾」で検索
ItemSearch("Books", "東野圭吾");

//Set up the operation in the request
function ItemSearch($SearchIndex, $Keywords){

	// Amazon APIの仕様に沿ったリクエスト出力用のPHPスクリプト
	include("base_request.php");

	$amazon_xml = simplexml_load_string(file_get_contents($base_request));

	foreach($amazon_xml->Items->Item as $item) {

		$item_title = $item->ItemAttributes->Title; // 商品名
		$item_author = $item->ItemAttributes->Author; // 著者
		$item_publicationdate = $item->ItemAttributes->PublicationDate; // 発売日
		$item_publisher = $item->ItemAttributes->Publisher; // 出版社
		$item_url = $item->DetailPageURL; // 商品のURL
		$item_image	 = $item->LargeImage->URL; // 商品の画像	?>

		<div class="container">
			<div class="row">
				<div class="col-xs-4 col-xs-offset-4">
					<div class="col-xs-6">
						<!-- 商品の画像を表示 -->
						<img class="img-responsive" src="<?php
							if (isset($item_image)) {
								echo $item_image; // サムネイル画像がある場合
							} else {
								echo "http://bit.ly/29Ikwlm"; // サムネイル画像がない場合
							}
						?>">
					</div>
					<div class="col-xs-6">
						<ul>
							<!-- 商品情報をリストで表示 -->
							<li><a href="<?php echo $item_url; ?>"><?php echo $item_title; ?></a></li>
							<li><?php echo $item_author; ?></li>
							<li><?php echo $item_publicationdate; ?></li>
							<li><?php echo $item_publisher; ?>）</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

	<?php } // foreach end

} ?>

</body>
</html>