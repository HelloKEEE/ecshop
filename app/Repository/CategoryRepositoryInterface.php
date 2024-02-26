<?php
namespace App\Repository;

interface CategoryRepositoryInterface
{
    
    // category一覧を取得する
    /**
     * parameter
     * $date = array("id" => "1", "name" => "a")
     * $date = array("name" => "a")
     * return
     * Categoryのcollection
     */
    public function search(array $data);





}