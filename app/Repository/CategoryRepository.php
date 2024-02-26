<?php
namespace App\Repository;

use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{

    public function search(array $data)
    {
        $category = Category::query();

        if(!empty($data["id"])) {
            $category->where('id', 'like', '%' . $data["id"] . '%' );
        }
        if(!empty($data["name"])) {
            $category->where('name', 'like', '%' . $data["name"] . '%' );
        }
        if(!empty($data["introduction"])) {
            $category->where('introduction', 'like', '%' . $data["introduction"] . '%' );
        }

        $categories = $category->get();

        return $categories;
    }


}