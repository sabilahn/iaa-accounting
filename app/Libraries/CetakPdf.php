<?php

namespace App\Libraries;

use Dompdf\Dompdf;

class CetakPdf extends Dompdf
{
    public string $filename = 'document.pdf';

    public function loadView(string $view, array $data = []): void
    {
        $html = view($view, $data);
        $this->loadHtml($html);
        $this->render();
        $this->stream($this->filename, ['Attachment' => false]);
    }
}

