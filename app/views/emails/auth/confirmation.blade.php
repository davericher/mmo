<h1>Sudbury Swap and Buy</h1>
<h2>{{ $username }}</h2>
<h3>Please click the link to activate your account</h3>
<p>
	<a href="{{ URL::route('confirm.show', $token) }}">Click me!</a>
</p>