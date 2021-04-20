<?php


namespace App\Service;


use App\Entity\Product;

class SearchService
{
    public function search(array $contents, int $id)
    {
        foreach ($contents as $content) {
            if ($id === $content->getId()) {
                return $content;
            }
        }

        return null;
    }
}