<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Aviso de renovación de servicios</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
	<style>
		body
		{
			font-family: "Source Sans 3", sans-serif;
			font-optical-sizing: auto;
			font-weight: 400;
			font-style: normal;
		}
	</style>
</head>
<body>
{{-- Wrapper --}}
<div style="max-width: 800px; margin: 0 auto">
	<h1><img src="https://www.isolperu.com/wp-content/uploads/2018/10/logo-isolperu.png" alt="ISOL Perú" /></h1>
	<p><strong>Hola {{ $contactName }}:</strong></p>
	<p>Este mensaje es para recordarte que se debe hacer la renovación de los siguientes servicios:</p>

	{{-- Detail --}}
	<table>
		{{-- Hosting accounts --}}
		@foreach($renewal->hostingAccounts as $hostingAccount)
			<tr>
				<td>Renovación de cuenta de hosting {{ $hostingAccount->plan->name }}</td>
				<td style="text-align: right">S/&nbsp;{{ number_format($hostingAccount->pivot->amount, 2) }}</td>
			</tr>
		@endforeach
		{{-- Domains --}}
		@foreach($renewal->domains as $domain)
			<tr>
				<td>Dominio {{ $domain->name }}</td>
				<td style="text-align: right">S/&nbsp;{{ number_format($domain->pivot->amount, 2) }}</td>
			</tr>
		@endforeach
		{{-- Totals --}}
		<tr>
			<td style="font-weight: bold">Total renovación</td>
			<td style="font-weight: bold; text-align: right">S/&nbsp;{{ number_format($renewal->amount, 2) }}</td>
		</tr>
	</table>

	{{-- Due date --}}
	<p>La fecha de vencimiento es el <time datetime="{{ $renewal->due_at->toDateString() }}" style="font-weight: bold">{{ $renewal->due_at->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}</time>.</p>

	{{-- Payment methods --}}
	<p>Te recordamos además las forma de pago disponibles:</p>

	<ul>
		@foreach($bankAccounts as $bankAccount)
			<li>
				<strong>Depósito en la cuenta {{ $bankAccount->bank->name }} (ahorro en soles)</strong>
				<br />N&ordm; {{ $bankAccount->number }}
				<br />(CCI N&ordm; {{ $bankAccount->cci }})
				<br />A nombre de: Danilo Alejandro Quispe Lucana
			</li>
		@endforeach
	</ul>

	<p>Sugerimos realizar la renovación con anticipación para evitar una posible desactivación del servicio si es que no se renueva hasta la fecha indicada.</p>

	<p>Saludos</p>

	<p><strong>ISOL Perú</strong></p>
</div>
</body>
</html>
