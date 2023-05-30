<?php 
namespace SOURCE;
use SOURCE\Config;


class Product{
    public $id ;
    public $name ;
    public $type ;
    public $category;
    public $description;
    public $costPrice ;
    public $sellPrice;
    public $img ;
    public $esale ;
    public $outdoor ;
    private $data;



    public function __construct(){
        $dataProducts = file_get_contents(Config::datasource().'products.json');
        $this->data = json_decode($dataProducts);
        // dd( $this->jsonFormat);
        
    }


    //reading all
    public function index()
    {
        // $dataProducts = file_get_contents(Config::datasource().'products.json');
        // $products = json_decode($dataProducts);
        return $this->data;
    }

    public function create()
    {

    }
    
    public function store($data)
    {
        $result = false;
        $productData = $this->prepare($data);
        // dd($productData);
        // $dataProducts = file_get_contents(Config::datasource().'products.json');
        // $products = json_decode($dataProducts);
        $this->data[] = (object)(array)$productData;
        // if(file_exists(Config::datasource().'products.json')){
        //     $result = file_put_contents(Config::datasource().'products.json',json_encode($this->data));
        // }else{
        //     echo "file not found";
        // }
        return $this->insert(); //$result;

    }

    public function show($id)
    {
        // $this->data
        // $dataProducts = file_get_contents(Config::datasource().'products.json');
        // $products = json_decode($dataProducts);
        $productView = null;
        foreach($this->data  as $product){
            if($product->id == $id ){
                $productView = $product;
                break;
            }
        }
        return $productView;
    }
    public function highestId()
    {
        $currentId = null;
        // $dataProducts = file_get_contents(Config::datasource().'products.json');
        // $products= json_decode($dataProducts);
        if(count($this->data)>0){
            $id = [];
            foreach($this->data as $product){
                $id[]= $product->id;
            }
            sort($id);
            $lastIndex = count($id)-1;
            $highestId = $id[$lastIndex];
            $currentId = $highestId+1;
           

        }else{
            $currentId = 1;
        }
        return $currentId;
    }
    public function prepare($data)
    {
       if(is_null($data->id)  || empty($data->id)){
        $data->id = $this->highestId();
       }
        return $data;
    }
    public function edit($id)
    {
        // $dataProducts = file_get_contents(Config::datasource().'products.json');
        // $products = json_decode($dataProducts);
        $productData;
        foreach($this->data as $product){
            if($product->id == $id){
                $productData = $product;
                break;
            }
        }
        // dd($productData);
        return $productData;
    }
    public function update($data)
    {
        $result = false;

        // $dataProducts = file_get_contents(Config::datasource().'products.json');
        // $products = json_decode($dataProducts);
        foreach($this->data as $key=> $product){
            if($product->id == $data->id){
                break;
            }
        }
        $this->data[$key]= $data;
        // if(file_exists(Config::datasource().'products.json')){
        //     $result = file_put_contents(Config::datasource().'products.json',json_encode($this->data));
        // }else{
        //     echo "File not found";
        // }
        return $this->insert();
    }
    // public function edit_data($id,$name,$type,$category,$description,$costPrice,$sellPrice,$img,$esale,$outdoor)
    // {
       
    //     $product = new Product();
    //     $product->id = $id;
    //     $product->name = $name;
    //     $product->type = $type;
    //     $product->category = $category;
    //     $product->description = $description;
    //     $product->costPrice = $costPrice;
    //     $product->sellPrice = $sellPrice;
    //     $product->img = $img;
    //     $product->esale = $esale;
    //     $product->outdoor = $outdoor;

    //     return $product;

    // }
    public function find($id = null)
    {
        if(is_null($id) || empty($id) ){
            return false;
        }
        // $dataProducts = file_get_contents(Config::datasource().'products.json');
        // $products = json_decode($dataProducts);
        // var_dump($products);
        // die();
        $productData = null;
        foreach($this->data as  $product){
            if($product->id == $id){
                $productData = $product;
                break;
            }
        }
        return $productData;
    }
    public function trash()
    {

    }
    public function destroy($id = null)
    {
        if(empty($id)){
            return;
        }
        foreach($this->data as $key=>$product){
            if($product->id == $id){
                break;
            }
        }
        unset($this->data[$key]);
        $this->data = array_values($this->data);

       return $this->insert($this->data);
    }
    public function delete()
    {

    }
    public function insert()
    {
        if(file_exists(Config::datasource().'products.json')){
             file_put_contents(Config::datasource().'products.json',json_encode($this->data));
             return true;
        }else{
            echo "file not found";
            return false;
        }
    }
    
}