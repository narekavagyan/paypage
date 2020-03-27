<?php


class Customer
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function addCustomer($data)
    {
        // Prepare Query
        $this->db->query('insert into customers (id, first_name, last_name, email) values (:id, :first_name, :last_name, :email)');

        // Bind Values
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':email', $data['email']);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getCustomers()
    {
        $this->db->query('select * from customers order by created_at desc');

        $results = $this->db->resultset();
        return $results;
    }
}