<?php

namespace Ppro\Hw15\Cli;

use League\CLImate\TerminalObject\Dynamic\Confirm;
use League\CLImate\TerminalObject\Dynamic\InputAbstract;

/** вспомогательный класс для работы с выводом в консоль / форматирование результатов
 *
 */
class Climate
{
    private $climate;

    public function __construct()
    {
        $this->climate = new \League\CLImate\CLImate;
    }

    public function renderRadio(array $options = [],string $prompt = "",bool $lineBreak = false): InputAbstract
    {
        if($lineBreak)
            $this->climate->br();
        $input = $this->climate->radio($prompt, $options);
        return $input;
    }

    public function renderInput($prompt,$notEmpty = true,bool $lineBreak = false): InputAbstract
    {
        if($lineBreak)
            $this->climate->br();
        $input = $this->climate->input('<dim>'.$prompt.'</dim>');
        if($notEmpty)
            $input->accept(function($response) {
                return !empty($response);
            });
        return $input;
    }

    public function renderMultilineInput($prompt,$notEmpty = true,bool $lineBreak = false): InputAbstract
    {
        if($lineBreak)
            $this->climate->br();
        $input = $this->climate->input('<dim>'.$prompt.'</dim>')->multiline();
        if($notEmpty)
            $input->accept(function($response) {
                return !empty($response);
            });
        return $input;
    }

    public function renderInputInt($prompt,bool $lineBreak = false): InputAbstract
    {
        if($lineBreak)
            $this->climate->br();
        $input = $this->climate->input('<dim>'.$prompt.'</dim>');
        $input->accept(function($response) {
            return ctype_digit($response);
        });
        return $input;
    }

    public function renderConfirmation(string $msg = 'Continue?'): Confirm
    {
        return $this->climate->confirm($msg);
    }

    public function renderColumns(array $data = []): mixed
    {
        return $this->climate->columns($data);
    }

    public function renderTable(array $data = []): mixed
    {
        return $this->climate->table($data);
    }

    public function setHeader(string $header): void
    {
        $this->climate->br();
        $this->climate->whiteUnderlineBold()->out($header);
    }

    public function setSuccess(string $result,bool $lineBreak = false): void
    {
        if($lineBreak)
            $this->climate->br();
        $this->climate->info($result);
    }

    public function setError(string $result,bool $lineBreak = false): void
    {
        if($lineBreak)
            $this->climate->br();
        $this->climate->error($result);
    }

    public function setComment(string $msg): void
    {
        $this->climate->comment($msg);
    }

}