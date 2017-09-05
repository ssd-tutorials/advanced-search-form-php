<?php

trait BookStore
{
    use ModelData;
    
    /**
     * @var int
     */
    protected $lastInsertId;

    /**
     * Adds book record.
     *
     * @param array $user_data
     * @return bool
     */
    protected function addBook(array $user_data = [])
    {
        if ($this->db->insert(
            'books',
            $this->bookData($user_data)
        )) {

            $this->lastInsertId = $this->db->lastInsertId();

            return true;

        }

        return false;
    }
}