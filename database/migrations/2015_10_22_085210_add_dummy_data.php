<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\Products;
use App\Models\Suppliers;
use App\Models\Product_categories;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Invoice;

class AddDummyData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Suppliers::create(array(
                        "supplier_company_name"=>"sup 1","supplier_alias"=>"sup alias1","supplier_address"=>"sup 1","supplier_city"=>"surabaya",
                        "supplier_province"=>"jawa timur","supplier_phone"=>"083838383",
                        ));
      Suppliers::create(array(
                        "supplier_company_name"=>"sup 2","supplier_alias"=>"sup alias2","supplier_address"=>"jln coba","supplier_city"=>"jakarta",
                        "supplier_province"=>"DKI jkt","supplier_phone"=>"0213838383",
                        ));
      Suppliers::create(array(
                        "supplier_company_name"=>"sup 3","supplier_alias"=>"sup alias3","supplier_address"=>"jln merak","supplier_city"=>"medan",
                        "supplier_province"=>"sumatera","supplier_phone"=>"0712222113",
                        ));
                        
      Order::create(array(
                      "no_order"=>"001", "order_total"=>100000, "order_subtotal"=>75000, "order_shipment_fee"=>25000,"customer_id"=>1,"shipping_number"=>"jne-1232123",
                      "invoice_id"=>1,"referral_id"=>1,"order_payment_status"=>"success","order_shipping_status"=>"on the way","shipping_method"=>"JNE","payment_method"=>"bank_transfer",
                        ));
      Order::create(array(
                      "no_order"=>"002", "order_total"=>150000, "order_subtotal"=>100000, "order_shipment_fee"=>50000,"customer_id"=>2,"shipping_number"=>"",
                      "invoice_id"=>2,"referral_id"=>0,"order_payment_status"=>"pending","order_shipping_status"=>"","shipping_method"=>"","payment_method"=>"bank_transfer",
                        ));
      Order::create(array(
                      "no_order"=>"003", "order_total"=>100000, "order_subtotal"=>75000, "order_shipment_fee"=>25000,"customer_id"=>1,"shipping_number"=>"",
                      "invoice_id"=>0,"referral_id"=>1,"order_payment_status"=>"pending","order_shipping_status"=>"","shipping_method"=>"","payment_method"=>"veritrans",
                        ));
      
      Order_detail::create(array(
                         "order_id"=>1, "product_id"=>1, "product_name"=>"laptop", "product_slug"=>"laptop", "product_price"=>5000000, "product_quantity"=>10, "product_filename"=>"laptop.jpg", 
                        ));
      Order_detail::create(array(
                         "order_id"=>1, "product_id"=>2, "product_name"=>"pc", "product_slug"=>"pc", "product_price"=>5000000, "product_quantity"=>10, "product_filename"=>"pc.jpg", 
                        ));
      Order_detail::create(array(
                         "order_id"=>2, "product_id"=>1, "product_name"=>"laptop", "product_slug"=>"laptop", "product_price"=>5000000, "product_quantity"=>10, "product_filename"=>"laptop.jpg", 
                        ));
      Order_detail::create(array(
                         "order_id"=>2, "product_id"=>2, "product_name"=>"pc", "product_price"=>5000000, "product_quantity"=>10, "product_filename"=>"pc.jpg", 
                        ));
      Order_detail::create(array(
                         "order_id"=>3, "product_id"=>1, "product_name"=>"laptop", "product_price"=>5000000, "product_quantity"=>10, "product_filename"=>"laptop.jpg", 
                        ));
                        
      Products::create(array(
                          "product_name"=>"laptop", "product_price"=>5000000, "product_condition"=>"new", "product_location"=>"surabaya", "product_stock"=>500, "product_weight"=>50, "product_categories_id"=>1, "product_catalog_id"=>1, "supplier_id"=>1, 
                        ));
      Products::create(array(
                          "product_name"=>"pc", "product_price"=>5000000, "product_condition"=>"new", "product_location"=>"surabaya", "product_stock"=>500, "product_weight"=>50, "product_categories_id"=>1, "product_catalog_id"=>1, "supplier_id"=>1, 
                        ));
                        
      Invoice::create(array(
                          "total"=>100000 ,"no_invoice"=>"iaxm12312312312",
                        ));
                        
      Product_categories::create(array(
                          "category_name"=>"pc", "category_slug"=>"pc", "category_description"=>"pc", "category_type"=>"category", 
                        ));
      Product_categories::create(array(
                          "category_name"=>"pc", "category_slug"=>"pc", "category_description"=>"pc", "category_type"=>"catalog", 
                        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
