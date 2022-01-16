<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use App\Models\ProductModel;
use CodeIgniter\HTTP\RequestTrait;

class productController extends ResourceController{
    use RequestTrait;
    // Method GET
    // Get all product
    public function index(){
        $model = new ProductModel();
        $data['products'] = $model->orderBy('_id',"ASC")->findAll();
        return $this->respond($data['products']);
    }

    public function getProductById($id = null){
        $model = new ProductModel();
        $data = $model->where('_id',$id)->first();
        if($data){
            return $this->respond($data);
        }
        else{
            return $this->failNotFound('No product found!');
        }
    }

    // Methot POST
    public function create(){
        $model = new  ProductModel();
        $data =[
            'name'=> $this->request->getVar('name'),
            'category'=> $this->request->getVar('category'),
            'price'=> $this->request->getVar('price'),
            'tags'=> $this->request->getVar('tags'),
        ];
        $model->insert($data);
        $myRespond =[
            "status"=>201,
            "error" => null,
            "message"=> "Product inserted successfully !!"
        ];
        return $this->respond($myRespond);
    }
    

    // Methot PUT
    public function update($id=null){
        $model = new  ProductModel();
        $data =[
            'name'=> $this->request->getVar('name'),
            'category'=> $this->request->getVar('category'),
            'price'=> $this->request->getVar('price'),
            'tags'=> $this->request->getVar('tags'),
        ];
        $checkId = $model->where('_id',$id)->first();
        if($checkId){
              $model->where('_id',$id)->set($data)->update();
                $myRespond =[
            "status"=>201,
            "error" => null,
            "message"=> "Product inserted successfully !!"
        ];
        return $this->respond($myRespond);
        }
        else{
             return $this->failNotFound("No product found");
        }
      
      
    }

    // Methot DELETE
    public function delete($id=null)
    {
 $model = new  ProductModel();
  $checkId = $model->where('_id',$id)->first();
        if($checkId){
              $model->delete($id);
                $myRespond =[
            "status"=>201,
            "error" => null,
            "message"=> "Product deleted successfully !!"
        ];
        return $this->respond($myRespond);
        }
        else{
             return $this->failNotFound("No product found");
        }
    }
}