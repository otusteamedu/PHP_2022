<?php

namespace Api;

class EmailsAnalyzer extends AbstractApi {

    private array $emailsFound = [
        'all' => [],
        'domain' => [],
        'mx' => [],
    ];

    protected function analyze(): void
    {
        $pattern = '/([a-zA-Z\d._-]+@[a-zA-Z\d._-]+\.[a-zA-Z]+)/';

        preg_match_all($pattern, $this->data, $matches);
        $matches[0] = array_values(array_unique($matches[0]));

        $this->emailsFound['all'] = $matches[0];

        foreach ($matches[0] as $email) {
            $domain = explode('@', $email)[1];
            if (checkdnsrr($domain, 'A')) {
                $this->emailsFound['domain'][] = $email;
            }
            if (checkdnsrr($domain, 'MX')) {
                $this->emailsFound['mx'][] = $email;
            }
        }
    }

    public function respond(): void
    {
        $this->analyze();
        echo json_encode($this->emailsFound);
    }
}

