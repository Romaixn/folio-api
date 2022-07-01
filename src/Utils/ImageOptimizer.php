<?php

declare(strict_types=1);

namespace App\Utils;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;

class ImageOptimizer
{
    private const MAX_WIDTH = 200;
    private const MAX_HEIGHT = 150;

    private Imagine $imagine;

    public function __construct()
    {
        $this->imagine = new Imagine();
    }

    public function resize(string $filename): void
    {
        /** @phpstan-ignore-next-line */
        [$iwidth, $iheight] = getimagesize($filename);

        $ratio = $iwidth / $iheight;
        $width = self::MAX_WIDTH;
        $height = self::MAX_HEIGHT;

        if ($width / $height > $ratio) {
            $width = $height * $ratio;
        } else {
            $height = $width / $ratio;
        }

        $photo = $this->imagine->open($filename);
        /** @phpstan-ignore-next-line */
        $photo->resize(new Box($width, $height))->save($filename);
    }
}
