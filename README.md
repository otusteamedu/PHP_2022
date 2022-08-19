Run `docker-compose.yml`

From `code/backend` run `composer install`

Add `frontend.local` to hosts

Open http://frontend.local/

Analyze emails.

##
Alternately,

from `frontend.local` send a post request to `http://mysite.local/`

with `route` and `string` parameters.

E.g.:

`curl_setopt(
    $ch,
    CURLOPT_POSTFIELDS,
    http_build_query(
        array(
            'route' => 'emails',
            'string' => 'email1@domain1 email2@domain2'
        )
    )
);`
