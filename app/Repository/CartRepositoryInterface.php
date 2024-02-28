<?php
namespace App\Repository;

interface CartRepositoryInterface
{
    
    
    public function search(array $data);

    public function doedit(array $data);

    public function doAdd(array $data);

    public function dodelete(array $data);
    
    public function doDetail(array $data);



}