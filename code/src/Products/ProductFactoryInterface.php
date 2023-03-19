<?php
/**
 * @author PozhidaevPro
 * @email pozhidaevpro@gmail.com
 * @Date 14.03.2023 20:56
 */

declare(strict_types=1);

namespace Ppro\Hw20\Products;

interface ProductFactoryInterface
{
    public function create(): ProductInterface;
}