<?php

namespace App\Core;
/**
 * Interface Entity
 */
interface Entity 
{
    /**
     * @return mixed
     */
    public function toArray(): array;
}