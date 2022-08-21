<h1>Demonstration of the work of the balancer</h1>

<span>Host name: {{ $server_hostname }}</span>
<br>
<span>Host IP: {{ $server_ip }}</span>
<br>
<span>Host port: {{ $server_host_port }}</span>
<br>

<span>Session ID: {{ $session_id }}</span>
<br>
<hr>

<span>Server hostname added in session, you can reload of page.</span>

<br>

<span>Checking of session in the Memcached:</span>
<br>
@if (! empty($session_server_hostname))
    <span>Value from session: {{ $session_server_hostname }}</span>
@endif
