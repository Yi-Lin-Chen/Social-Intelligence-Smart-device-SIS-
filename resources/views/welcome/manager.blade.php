@extends('welcome/layout')

@section('content')
<div id="main">
    <div class="inner">
    	<h1>Notes to Manager</h1>

    	<!-- Text -->
		<section>
			<h2>Basic Functions</h2>
			<p><div class="row">
				<div class="6u 12u$(medium)">
					<ul>
						<li>Login/Logout</li>
						<li>Sensor Control</li>
						<li>Home Control</li>
						<li>User Management</li>
					</ul>

				</div>
			</div></p>
			<hr />

			<h2>Basic Processes</h2>
			<div class="6u$ 12u$(medium)">
					<ol>
						<li>當屋主布置系統時，須於門口放置一個QRcode及Wi-Fi帳密，Wi-Fi系統需要用到內網，另一個是用於進入物聯網平台。</li>
						<li>安裝好設備後，屋主需要認證Gateway綁定屋主手機，屋主下載app後，會被要求長按該gateway附上的按鈕，成功驗證後，屋主即可控制屋內所有BLE設備，屋主進入裝置頁面後，可以對設備進行管理。</li>
						<li>屋主需要對於設備內部設定該設備所需提供的屬性有哪些，設定完畢後即可將整個系統安置完成。</li>
						<li>當訪客要求權限時，網站一開始會提示訪客對屋主要求權限，按下後會透過Email傳送URL通知屋主，屋主接到通知即可透過web去看使用者資訊來審核進入的使用者。</li>
						<li>當屋主按下同意或拒絕審核後，會傳送一封Email給訪客，如同意會經由server產生一組亂數加密後，再產生QRcode，時效預設為一天，並將顯示QRcode的網址放在Email上，訪客點擊網址後即可看到QRcode，訪客於時效內對象機掃描QRcode即可進屋。</li>

					</ol>

			</div>

		</section>
    </div>
</div>
@endsection
