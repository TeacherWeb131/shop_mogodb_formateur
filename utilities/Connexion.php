<?php



class Connexion
{
    private $db;

    public function __construct()
    {

        try {
            $client = new MongoDB\Client("mongodb://" . DB_HOST . ":" . DB_PORT);
            $this->db = $client->{DB_NAME};
        } catch (MongoDB\Driver\Exception\AuthenticationException  $e) {
            echo $e->getMessage();

            die;
        }
    }


    public function addToDb($collection, $document)
    {
        $result = $this->db->$collection->insertOne($document);
        return $result->getInsertedId();
    }

    public function findOne($query, $collection)
    {
        $result = $this->db->$collection->findOne($query);
        return $result;
    }

    public function findMany($collection, $query = [])
    {
        $result = $this->db->$collection->find($query);
        return $result->toArray();
    }

    public function update($collection, array $query, array $edited_data)
    {
        $this->db->$collection->updateOne(
            $query,
            [ '$set' => $edited_data]
        );
    }

    public function replace($collection, $query, $data_to_replace)
    {
        $this->db->$collection->replaceOne(
            $query, 
            $data_to_replace
        );
    }
}
