<?php


class Transaction
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function addTransaction($data)
    {
        // Prepare Query
        $this->db->query('insert into transactions (id, customer_id, product, amount, currency, status) values (:id, :customer_id, :product, :amount, :currency, :status)');

        // Bind Values
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':customer_id', $data['customer_id']);
        $this->db->bind(':product', $data['product']);
        $this->db->bind(':amount', $data['amount']);
        $this->db->bind(':currency', $data['currency']);
        $this->db->bind(':status', $data['status']);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getTransactions()
    {
        $this->db->query('select * from transactions order by created_at desc');

        $results = $this->db->resultset();
        return $results;
    }
}