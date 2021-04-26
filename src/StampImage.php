<?php

namespace StampPDF\Watermark;

use Intervention\Image\Image;
use Intervention\Image\ImageManagerStatic;

class StampImage
{
    private const RESOURCES_FONTS_ROBOTO_ROBOTO_BOLD = './resources/fonts/Roboto/Roboto-Bold.ttf';
    private const PATH_RESOURCES_IMAGES = './resources/images';

    private $image;

    /**
     * StampImage constructor.
     * @param string ...$texts
     * @throws \Exception
     */
    public function __construct(string ...$texts)
    {
        ImageManagerStatic::configure(array('driver' => 'imagick'));
        $this->setCustomImage(self::PATH_RESOURCES_IMAGES . '/stamp_base.png');

        if (!empty($texts)) {
            $this->createStampText(...$texts);
        }
    }

    /**
     * @param string ...$texts
     * @return Image|null
     */
    public function createStampText(string ...$texts): ?Image
    {
        if (empty($texts)) {
            return null;
        }

        $x = 260;
        $y = 180;
        for ($i = 0; $i < count($texts); $i++) {
            if ($i > 0) {
                $y += 30;
            }

            $this->image->text($texts[$i], $x, $y, function ($font) {
                $font->file(self::RESOURCES_FONTS_ROBOTO_ROBOTO_BOLD);
                $font->size(24);
                $font->color([41, 41, 41, 0.15]);
                $font->align('center');
                $font->valign('middle');
                $font->angle(35);
            });
        }

        $this->image->save(self::PATH_RESOURCES_IMAGES . '/stamp.png');
        return $this->image;
    }

    /**
     * @param string $filePathToImage
     * @return Image
     * @throws \Exception
     */
    public function setCustomImage(string $filePathToImage): Image
    {
        if (!file_exists($filePathToImage) && !is_file($filePathToImage)) {
            throw new \Exception('Arquivo informado não existe.');
        }

        $this->image = ImageManagerStatic::make($filePathToImage);
        return $this->image;
    }

    /**
     * @return Image
     */
    private function getImage(): Image
    {
        return $this->image;
    }

    /**
     * @return string
     */
    public function basePathImage(): string
    {
        return $this->getImage()->basePath();
    }
}
