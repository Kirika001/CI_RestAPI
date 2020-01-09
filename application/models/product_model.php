<?php

class Product_model extends CI_model 
{
    public function getProduct($productCode = null){
     
        if($productCode==null){
            return $this->db->get('product')->result_array();
        } else{
            return $this->db->get_where('product',['PRODUCTCODE'=> $productCode])->result_array();
        }
    }



    public function deleteProduct($productCode){
        $this->db->delete('product', ['PRODUCTCODE'=>$productCode]);
        return $this->db->affected_rows();
        
    }


    public function createProduct($data){
        $this->db->insert('product',$data);
        return $this->db->affected_rows();
        
    }


    public function updateProduct($data, $productCode){
        $this->db->update('product',$data, ['PRODUCTCODE'=>$productCode]);
        return $this->db->affected_rows();
        
    }









}