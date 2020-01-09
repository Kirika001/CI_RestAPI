<?php

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


class Product extends REST_Controller {


    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model('product_model','product');
        $this->methods['index_get']['limit'] = 10000;
    }
    
    public function index_get()
    {
        $productCode = $this->get('PRODUCTCODE');
        if($productCode == null ){
            $product = $this->product->getProduct();
        }else {
            $product = $this->product->getProduct($productCode);
        }

        
        
        if($product){
            $this->response ([
                'status'=>true,
                'data'=>$product
            ],REST_controller::HTTP_OK);
        } else{
            $this->response ([
                'status'=>false,
                'message'=>'Product Code is not Found'
            ],REST_controller::HTTP_NOT_FOUND);
        }
    }



    public function index_delete()
    {
        $productCode = $this->delete('PRODUCTCODE');
        if($productCode == null ){
            $this->response ([
                'status'=>false,
                'message'=>'Provide an Product Code'
            ],REST_controller::HTTP_BAD_REQUEST);
        }else {
            if($this->product->deleteProduct($productCode)>0){
                $this->response ([
                    'status'=>true,
                    'productCode'=>$productCode,
                    'message'=>'deleted.'
                ],REST_controller::HTTP_NO_CONTENT);
            }
            else{
                $this->response ([
                    'status'=>false,
                    'message'=>'code Not Found'
                ],REST_controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_post()
    {
        $data = [
            'PRODUCTCODE'=>$this->post('PRODUCTCODE'),
            'PRODUCTDESC'=>$this->post('PRODUCTDESC'),
            'REGULERPRICE'=>$this->post('REGULERPRICE'),
            'BARCODE'=>$this->post('BARCODE'),
            'PRODUCTSHORTDESC'=>$this->post('PRODUCTSHORTDESC')
        ];
        if($this->product->createProduct($data)>0){
            $this->response ([
                'status'=>true,
                'message'=>'Data has been created'
            ],REST_controller::HTTP_CREATED);
        }
        else{
            $this->response ([
                'status'=>false,
                'message'=>'Failde to create new data'
            ],REST_controller::HTTP_BAD_REQUEST);
        }
    }


    public function index_put()
    {
        $productCode = $this->put('PRODUCTCODE');
        $data = [
            'PRODUCTCODE'=>$this->put('PRODUCTCODE'),
            'PRODUCTDESC'=>$this->put('PRODUCTDESC'),
            'REGULERPRICE'=>$this->put('REGULERPRICE'),
            'BARCODE'=>$this->put('BARCODE'),
            'PRODUCTSHORTDESC'=>$this->put('PRODUCTSHORTDESC')
        ]; 
       
        if($this->product->updateProduct($data,$productCode)==0){
            $this->response ([
                'status'=>true,
                'message'=>'Data has been updated'
            ],REST_controller::HTTP_CREATED ); 
        }
        else{
             $this->response ([
                'status'=>false,
                'message'=>'Failde to update new data'
            ],REST_controller::HTTP_BAD_REQUEST);
        }
    }

}
