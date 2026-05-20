<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;
use Framework\Session;
use Framework\Authorization;


class ListingController
{
    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    public function index()
    {

        $listings = $this->db->query('SELECT * FROM listings ORDER BY created_at DESC')->fetchAll();

        loadView('listings/index', ['listings' => $listings]);
    }

    public function create()
    {
        loadView('listings/create');
    }

    public function show($params)
    {
        $id = $params['id'] ?? '';
        $params = [
            'id' => $id
        ];
        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

        //check if listig exists
        if (!$listing) {
            ErrorController::notFound('Listing not found');
            return;
        }
        loadView('listings/show', ['listing' => $listing]);
    }

    /**
     * store data in database
     *
     * @return void
     */
    public function store()
    {
        $allowedFields = ['title', 'description', 'salary', 'tags', 'company', 'address', 'city', 'state', 'email', 'requirements', 'benefits'];


        $newListingData = array_intersect_key($_POST, array_flip($allowedFields));

        $newListingData['user_id'] = Session::get('user')['id'];; // Assuming user_id is 1 for demonstration
        $newListingData = array_map('sanitize', $newListingData);

        $requiredFields = ['title', 'description', 'salary', 'email', 'city', 'state'];

        $errors = [];
        foreach ($requiredFields as $field) {
            $value = $newListingData[$field] ?? '';
            if (empty(trim($value)) || !Validation::string($value)) {
                $errors[$field] = ucfirst($field) . ' is required';
            }
        }
        if (!empty($errors)) {
            //Reload view with errors
            loadView('listings/create', [
                'errors' => $errors,
                'listing' => $newListingData
            ]);
        } else {
            //Submit data

            $fields = [];

            foreach ($newListingData as $field => $value) {
                $fields[] = $field;
            }
            $fields = implode(',', $fields);

            $value = [];

            foreach ($newListingData as $field => $value) {
                //concert empty string to null
                if ($value === '') {
                    $newListingData[$field] = null;
                }
                $values[] = ':' . $field;
            }
            $values = implode(',', $values);

            $query = "INSERT INTO listings ({$fields}) VALUES ({$values})";

            $this->db->query($query, $newListingData);

            Session::setFlashMessage('success_message', 'Listing created successfully');

            redirect('/listings');
        }
    }
    /**
     * Delete a listing
     * 
     * @param array $params
     * @return void
     */
    public function destroy($params)
    {
        $id = $params['id'] ?? '';
        $params = [
            'id' => $id
        ];

        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

        //check if listig exists
        if (!$listing) {
            ErrorController::notFound('Listing not found');
            return;
        }
        // Authorization
        if (!Authorization::isOwner($listing->user_id)) {
            Session::setFlashMessage('error_message', 'You are not authorized to delete this listing');
            return redirect('/listings/' . $listing->id);
        }


        $this->db->query('DELETE FROM listings WHERE id = :id', $params);

        //set flash message
        Session::setFlashMessage('success_message', 'Listing deleted successfully');

        redirect('/listings');
    }

    public function edit($params)
    {
        $id = $params['id'] ?? '';
        $params = [
            'id' => $id
        ];

        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

        //check if listig exists
        if (!$listing) {
            ErrorController::notFound('Listing not found');
            return;
        }
        // Authorization
        if (!Authorization::isOwner($listing->user_id)) {
            Session::setFlashMessage('error_message', 'You are not authorized to update this listing');
            return redirect('/listings/' . $listing->id);
        }

        loadView('listings/edit', ['listing' => $listing]);
    }
    /**
     * Update a listing
     * 
     * @param array $params
     * @return variant
     */
    public function update($params)
    {
        $id = $params['id'] ?? '';  // ✅ kunin muna ang $id dito!

        $params = [
            'id' => $id
        ];

        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

        //check if listing exists
        if (!$listing) {
            ErrorController::notFound('Listing not found');
            return;
        }

        // Authorization
        if (!Authorization::isOwner($listing->user_id)) {
            Session::setFlashMessage('error_message', 'You are not authorized to update this listing');
            return redirect('/listings/' . $listing->id);
        }

        $allowedFields = ['title', 'description', 'salary', 'tags', 'company', 'address', 'city', 'state', 'email', 'requirements', 'benefits'];

        $updatedValues = [];
        $updatedValues = array_intersect_key($_POST, array_flip($allowedFields));

        $updatedValues = array_map('sanitize', $updatedValues);

        $requiredFields = ['title', 'description', 'salary', 'email', 'city', 'state'];

        $errors = [];

        foreach ($requiredFields as $field) {
            if (empty(trim($field)) || !Validation::string($updatedValues[$field])) {
                $errors[$field] = ucfirst($field) . ' is required';
            }
        }
        if (!empty($errors)) {
            loadView('listings/edit', [
                'listing' => $listing,
                'errors' => $errors
            ]);
        } else {
            //submit to database
            $updateFields = [];

            foreach (array_keys($updatedValues) as $field) {
                $updateFields[] = "{$field} = :{$field}";
            }
            $updateFields = implode(', ', $updateFields);

            $updateQuery = "UPDATE listings SET {$updateFields} WHERE id = :id";

            $updatedValues['id'] = $id;
            $this->db->query($updateQuery, $updatedValues);

            Session::setFlashMessage('success_message', 'Listing successfully updated');

            redirect('/listings/' . $id);
        }
    }
    /**
     * Search listings by keyword/location
     *
     * @return void
     */
    public function search()
    {
        $keywords = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';
        $location = isset($_GET['location']) ? trim($_GET['location']) : '';

        $query = "SELECT * FROM listings WHERE (title LIKE :keywords OR description LIKE :keywords OR tags LIKE :keywords OR company LIKE :keywords) AND (city LIKE :location OR state LIKE :location)";

        $params = [
            'keywords' => "%{$keywords}%",
            'location' => "%{$location}%"
        ];

        $listings = $this->db->query($query, $params)->fetchAll();

        loadView('/listings/index', [
            'listings' => $listings,
            'keywords' => $keywords,
            'location' => $location
        ]);
    }
}
