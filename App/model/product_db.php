<?php
include('connection.php');

$product_name="";
$product_price="";
$id=0;
$edit_state=false;




if(isset($_POST['product_save'])){

    $product_name=$_POST['product_name'];
    $product_price=$_POST['product_price'];
    $cat_id=mysqli_real_escape_string($db,$_POST['cat']);
    
    $query="INSERT INTO PRODUCTS(PRODUCT_NAME,PRODUCT_PRICE,PRODUCT_CAT_ID) VALUES ('$product_name','$product_price','$cat_id')";
    mysqli_query($db,$query);
    header('location:../views/main.php#products');

    };

if(isset($_POST['product_update'])){
    $product_name = mysqli_real_escape_string($db, $_POST['product_name']);
    
    $product_price=mysqli_real_escape_string($db,$_POST['product_price']);
    $id=mysqli_real_escape_string($db,$_POST['product_id']);
    $cat_id=mysqli_real_escape_string($db,$_POST['cat']);

    mysqli_query($db, "UPDATE PRODUCTS SET PRODUCT_NAME='$product_name', PRODUCT_PRICE='$product_price',PRODUCT_CAT_ID='$cat_id' WHERE PRODUCT_ID=$id");
    header('location:../views/main.php#products');
   
}
if(isset($_GET['product_del'])){
    $id=$_GET['product_del'];
    mysqli_query($db,"DELETE FROM PRODUCTS WHERE PRODUCT_ID=$id");
    header('location:../views/main.php#products');
    
}
if(isset($_POST['cat_save'])){

    $cat_desc=$_POST['cat_desc'];
    
    
    $query="INSERT INTO CATEGORIES(CAT_DESC) VALUES ('$cat_desc')";
    mysqli_query($db,$query);
    header('location:../views/main.php#products');

    };
    if(isset($_POST['cat_update'])){
        $cat_desc=$_POST['cat_desc'];
        $cat_id=mysqli_real_escape_string($db,$_POST['cat']);
    
        mysqli_query($db, "UPDATE CATEGORIES SET CAT_DESC='$cat_desc'WHERE CAT_ID=$cat_id");
        header('location:../views/main.php#products');
       
    }
    if(isset($_POST['cat_del'])){
        $cat_id=mysqli_real_escape_string($db,$_POST['cat']);
        
        mysqli_query($db,"DELETE FROM CATEGORIES WHERE CAT_ID=$cat_id");
        header('location:../views/main.php#products');
        
    }

$products="SELECT PRODUCT_ID, PRODUCT_NAME,PRODUCT_PRICE,CAT_DESC FROM PRODUCTS JOIN CATEGORIES ON CATEGORIES.CAT_ID=PRODUCTS.PRODUCT_CAT_ID";
$results=mysqli_query($db,$products);
?>
