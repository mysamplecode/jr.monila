<?php

use LongHaulConfig\LongHaulCentral;
use LongHaulConfig\LongHaulConstants;

class LongHaulShoppingCart implements \rocketsled\Runnable
{

    private $central;
    private $esc;
    private $profile = "shoppingcart";

    public function __construct()
    {
        @session_start();
        if(!isset($_SESSION[LongHaulConstants::SHOPPING_CART]))
        {
            $_SESSION[LongHaulConstants::SHOPPING_CART] = array();
        }
        LongHaulCentral::pr("Getting the central");
        $this->central = LongHaulCentral::instance();
        $this->central->set_alias_connection( $this->profile );
        LongHaulCentral::pr("Got the central");
    }
    
    //escape function
    public function __call( $closure, $args )
    {
        $f = Plusql::escape( $this->profile );
        return $f( $args[ 0 ] );
    }

    public function run()
    {
        try
        {
            LongHaulCentral::pr("Shopping cart run function call");
            $this->update_main_contents();
        }
        catch ( Exception $e )
        {
            throw $e;
        }
    }

    //update main contents
    private function update_main_contents()
    {
        LongHaulCentral::pr("In the update main contents");
        try
        {//used mainly to handle the AJAX calls from the index_template.
            LongHaulCentral::pr("Getting the token");
            $token = $this->central->getargs( 'rocket_sled', $_GET, $this->corrupt );
            LongHaulCentral::pr("Got the token");
            if ( !$this->corrupt )
            {
                LongHaulCentral::pr("token processed");
                if ( $this->central->validate_csrf_token( $token ) )
                {
                    LongHaulCentral::pr("token passed.... ");
                    $selection = $this->central->getargs( 'selection', $_GET, $this->corrupt );
                    LongHaulCentral::pr($selection);
                    $sel  = json_decode(utf8_encode($selection),true);
                    LongHaulCentral::pr($sel);
                    LongHaulCentral::pr("Getting the selection");
                    if ( !$this->corrupt && !empty($sel))
                    {
                        $this -> update_shopping_cart( $sel , true, $sel['product_id'] );
                    }
                    else
                    {
                        $this -> corrupt = false;
                        $product_id = $this->central->getargs( 'product_id', $_GET, $this->corrupt );
                        if ( !$this->corrupt )
                        {
                            $this -> update_shopping_cart( null , true, $product_id );
                        }
                        else
                        {
                            $this -> update_shopping_cart( null , true, null );
                        }
                    }
                }
                else
                    throw new Exception( "CSRF attack" );
            }
            else
                throw new Exception( "CSRF attack" );
        }
        catch ( Exception $e )
        {
            throw $e;
        }
    }
    //update the session based shopping cart
    public function update_shopping_cart ($selection = null/*updates*/, $as_json = false/*return value*/, $product_id = null/*filters*/)
    {
        LongHaulCentral::pr("In the update shopping cart");
        $data = array( );
        $path = LongHaulCentral::get_instant_server_path() . '/' . LongHaulConstants::PRODUCT_IMAGES_PATH . '/';
        try
        {
            $data[ 'rocket_sled' ] = $this->central->add_csrf_token();
            $data[ 'color_size' ] = array( );
            if(!is_null($selection) && !empty($selection))
            {
               $_SESSION[LongHaulConstants::SHOPPING_CART][] = $selection; 
            }
            //now adjust the quantity some where - no clue where !!!!
            //This is just the precautionary measure - avoiding an un-usual impossible case if it ever happens
            foreach($_SESSION[LongHaulConstants::SHOPPING_CART] as $k => $sc)
            {
                if(empty($_SESSION[LongHaulConstants::SHOPPING_CART][$k]))
                {
                    unset($_SESSION[LongHaulConstants::SHOPPING_CART][$k]);
                }
            }
            $data['selections'] = $_SESSION[LongHaulConstants::SHOPPING_CART];
            try
            {
                if(!is_null($product_id))
                {
                    $product_text = "product_id = {$this->esc( $product_id )} and ";
                    $product = PluSQL::from( $this->profile )->product->image_factory->select( '*' )->where( "product_id = {$this->esc( $product_id )}" )->run()->product;
                    $image = $product->image_factory;
                    $data[ 'product_id' ] = $product_id;
                    $data[ 'product_name' ] = $product->name;
                    $data[ 'price' ] = $product->price;
                    $data[ 'product_image' ] = $path . $image->image_path;
                }
                LongHaulCentral::pr("product text = ".$product_text);
                $Inventory = PluSQL::from( $this->profile )->inventory->size_factory( 'inventory' )->color_factory( 'inventory' )->select( '*' )->where( $product_text." quantity > 0" )->run()->inventory;
                LongHaulCentral::pr("Stage 3");
                foreach ( $Inventory as $inventory )
                {
                    foreach ( $inventory->size_factory as $size )
                    {
                        foreach ( $size->color_factory as $color )
                        {
                            //somehow match the existing inventory with the session inventory
                            $cart_quantity = 0;
                            foreach($_SESSION[LongHaulConstants::SHOPPING_CART] as $sel)
                            {
                              if($sel['inventory_id'] == $inventory -> inventory_id)
                              {
                                  $cart_quantity += $sel['quantity'];
                              }
                            }
                            $data[ 'color_size' ][ ] = array( 'inventory_id' => $inventory -> inventory_id,'quantity' => $inventory->quantity - $cart_quantity, 'size' => $size->size_code, 'size_sorting' => $size->size_extra1, 'color' => $color->color_code, 'color_sorting' => $color->color_extra1, 'bgcolor' => $color->color_hex, 'fgcolor' => $color->color_extra3 );
                        }
                    }
                }
            }
            catch ( EmptySetException $e )
            {
                throw $e;
            }
            if($as_json)
                echo json_encode( $data );
            else
                return $data;
        }
        catch ( Exception $e )
        {
            if($as_json)
                echo json_encode( $data );
            else
                return $data;
        }
    }
    //destroys the cart - set to zero;
    public function reset_shopping_cart()
    {
        //simple
        unset($_SESSION[LongHaulConstants::SHOPPING_CART]);
        $_SESSION[LongHaulConstants::SHOPPING_CART] = array();
    }
    //gets the cart total
    public function get_cart_total($products = array()/*optional array to apply product specific filter*/)
    {
        $total = 0;
        foreach($_SESSION[LongHaulConstants::SHOPPING_CART] as $item)
        {
            if(!empty($products))
            {
                if(in_array( $item['product_id'], $products ))
                {
                    $total += $item['quantity'] * $item['price'];
                }
            }
            else
            {
                $total += $item['quantity'] * $item['price'];
            }
        }
        return $total;
    }
}
?>