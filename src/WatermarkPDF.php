<?php

namespace StampPDF\Watermark;

use Uvinum\PDFWatermark\FpdiPdfWatermarker;
use Uvinum\PDFWatermark\Pdf;
use Uvinum\PDFWatermark\Watermark;

class WatermarkPDF
{
    /**
     * @var Pdf
     */
    protected $pdf;

    /**
     * WatermarkPDF constructor.
     * @param string $filename
     */
    public function __construct($filename, string ...$texts)
    {
        $this->pdf = new Pdf($filename);

        if (! empty($texts)) {
            $this->watermarked(...$texts);
        }
    }

    /**
     * @param string ...$texts
     * @return StampImage
     * @throws \Exception
     */
    public function stampImage(string ...$texts): StampImage
    {
        return new StampImage(...$texts);
    }

    public function watermarked(string ...$texts): FpdiPdfWatermarker
    {
        $watermark = new Watermark($this->stampImage(...$texts)->basePathImage());
        return new FpdiPdfWatermarker($this->pdf, $watermark);
    }
}
