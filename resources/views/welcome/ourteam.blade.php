@extends('welcome/layout')

@section('content')
<div id="main">
	<div class="inner">
		<h1>Introduce Our Team</h1>
		<h2>Social Intelligence Smartlock(SIS)</h2>
        <h2>Team Member</h2>
		<div align="center">
	        <table>
				<thead>
					<tr>
						<th>Avatar</th>
						<th>Name</th>
						<th>Position</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><img src="/img/jeremy.jpg" width="100" </td>
						<td>顏敬柏</td>
						<td>SIS 系統開發</td>
						</tr>
					<tr>
						<td><img src="/img/jenny.jpg" width="100"</td>
						<td>陳儀玲</td>
						<td>SIS 網頁建置</td>
					</tr>
					<tr>
						<td><img src="/img/meisin.jpg" width="100"</td>
						<td>林美馨</td>
						<td>SIS 系統測試評估</td>
					</tr>
					<tr>
                        <td><img src="/img/sam.jpg" width="100"</td>
						<td>李昕</td>
						<td>SIS 系統測試評估</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
