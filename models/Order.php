<?php


class Order implements MongoDB\BSON\Serializable, MongoDB\BSON\Unserializable
{
    // proprietés
    private $_id;
    private $submitted_at;
    private $total_ht;
    private $total_ttc;
    private $user_id;
    private $order_details = [];

    public function bsonSerialize()
    {
        return [
            'submitted_at' => $this->submitted_at,
            'total_ht' => (float) $this->total_ht,
            'total_ttc' => (float) $this->total_ttc,
            'user_id' => $this->user_id,
            'order_details' => $this->order_details
        ];
    }

    public function bsonUnserialize(array $data)
    {
        foreach ($data as $key => $value) {
            if ($key == "order_details") {
                foreach ($data["order_details"] as $order_details) {
                    $o = new OrderDetails();
                    $o->set_id($order_details->_id);
                    $o->setPrice_each($order_details->price_each);
                    $o->setProduct_id($order_details->product_id);
                    $o->setQuantity_ordered($order_details->quantity_ordered);
                    $o->setTotal_price($order_details->total_price);
                    $this->order_details[] = $o;
                }
            } else {
                $this->$key = $value;
            }
        }
    }

    // getter et setter

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Get the value of created_at
     */
    public function getCreated_at()
    {
        $id_object = $this->_id;
        $timestamp = $id_object->getTimestamp();
        $date = new DateTime();
        $date->setTimestamp($timestamp);
        return $date->format('d/m/Y H:i:s');
    }



    /**
     * Get the value of submitted_at
     */
    public function getSubmitted_at()
    {
        return ($this->submitted_at);
    }

    /**
     * Set the value of submitted_at
     *
     * @return  self
     */
    public function setSubmitted_at($submitted_at)
    {
        $this->submitted_at = $submitted_at;

        return $this;
    }



    /**
     * Get the value of user_id
     */
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get the value of total_ht
     */
    public function getTotal_ht()
    {
        return $this->total_ht;
    }

    /**
     * Set the value of total_ht
     *
     * @return  self
     */
    public function setTotal_ht($total_ht)
    {
        $this->total_ht = $total_ht;

        return $this;
    }

    /**
     * Get the value of total_ttc
     */
    public function getTotal_ttc()
    {
        return $this->total_ttc;
    }

    /**
     * Set the value of total_ttc
     *
     * @return  self
     */
    public function setTotal_ttc($total_ttc)
    {
        $this->total_ttc = $total_ttc;

        return $this;
    }




    // méthode d'insertion dans la base de données
    public function save()
    {
        $cnx = new Connexion();
        $id = $cnx->addToDb('order', $this);
        return $id;
    }


    public static function editSubmittedAt($id)
    {
        $cnx = new Connexion();
        $cnx->update(
            'order',
            ['_id' => new MongoDB\BSON\ObjectId($id)],
            ['submitted_at' => new MongoDB\BSON\UTCDateTime()]
        );
    }

    // méthode de récupération d'une seule commande AVEC ses orderDetails 

    public static function getOrderById($id)
    {
        $cnx = new Connexion();
        $order = $cnx->findOne(["_id" => new MongoDB\BSON\ObjectId($id)], 'order');

        $order_string = MongoDB\BSON\fromPHP($order);
        $order = MongoDB\BSON\toPHP($order_string, ['root' => 'Order']);

        return $order;
    }

    public static function getOrderByUserId($id)
    {
        $cnx = new Connexion();
        $orders = $cnx->findMany('order', ['user_id' => $id]);
        $orders_formatted = [];
        foreach ($orders as $order) {
            $order_string = MongoDB\BSON\fromPHP($order);
            $orders_formatted[] = MongoDB\BSON\toPHP($order_string, ['root' => 'Order']);
        }
        return $orders_formatted;
    }

    public static function getAllOrders()
    {
        $cnx = new Connexion();
        $orders = $cnx->findMany('order');
        $orders_formatted = [];
        foreach ($orders as $order) {
            $order_string = MongoDB\BSON\fromPHP($order);
            $orders_formatted[] = MongoDB\BSON\toPHP($order_string, ['root' => 'Order']);
        }
        return $orders_formatted;
    }

    /**
     * Get the value of order_details
     */
    public function getOrder_details()
    {
        return $this->order_details;
    }

    /**
     * Set the value of order_details
     *
     * @return  self
     */
    public function setOrder_details($order_details)
    {
        $this->order_details[] = $order_details;

        return $this;
    }
}
