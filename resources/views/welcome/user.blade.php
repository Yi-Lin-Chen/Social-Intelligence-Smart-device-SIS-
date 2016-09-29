@extends('welcome/layout')

@section('content')
<div id="main">
    <div class="inner">
    	<h1>Notes to User</h1>


    	<!-- Text -->
    		<section>
    			<h2>Basic Functions</h2>
    			<p><div class="row">
    				<div class="6u 12u$(medium)">
    					<ul>
    						<li>Login/Logout</li>
    						<li>Request Permission</li>
    						<li>Use QRCode</li>
    						<li>Access Sensor Data</li
    					</ul>

    				</div>
    			</div></p>
    			<hr />

    			<h2>Basic Processes</h2>
    			<div class="6u$ 12u$(medium)">
    					<ol>
    						<li>訪客到達房屋前，將被要求先連接Wi-Fi，然後再進入物聯網平台。</li>
    						<li>進入平台後登入Facebook或屋主給的帳號密碼才能正確進入網站，訪客再來進行進屋的要求，接著等候屋主的審核。</li>
    						<li>當屋主按下同意或拒絕審核後，會傳送一封Email給訪客，如同意會經由server產生一組亂數加密後，再產生QRcode，時效預設為一天，並將顯示QRcode的網址放在Email上。</li>
    						<li>訪客點擊網址後即可看到QRcode，訪客於時效內對屋前的相象機掃描QRcode即可進屋，並可依權限來使用屋內設備。</li>
    					</ol>

    			</div>

    		</section>
    </div>
</div>
@endsection
