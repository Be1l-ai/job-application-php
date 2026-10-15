<?php
// includes/Application.php
// CRUD operations for job applications

require_once __DIR__ . '/../config/database.php';

class Application {
    private $db;
    private $table = 'job_applications';
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    // CREATE - Insert a new application
    public function create($data) {
        $sql = "INSERT INTO {$this->table} 
                (first_name, last_name, email, phone, position_applied, years_experience, skills, expected_salary) 
                VALUES 
                (:first_name, :last_name, :email, :phone, :position_applied, :years_experience, :skills, :expected_salary)";
        
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindValue(':first_name', $data['first_name'], PDO::PARAM_STR);
        $stmt->bindValue(':last_name', $data['last_name'], PDO::PARAM_STR);
        $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindValue(':phone', $data['phone'], PDO::PARAM_STR);
        $stmt->bindValue(':position_applied', $data['position_applied'], PDO::PARAM_STR);
        $stmt->bindValue(':years_experience', $data['years_experience'], PDO::PARAM_INT);
        $stmt->bindValue(':skills', $data['skills'], PDO::PARAM_STR);
        $stmt->bindValue(':expected_salary', $data['expected_salary'], PDO::PARAM_STR);
        
        return $stmt->execute();
    }
    
    // READ - Get all applications
    public function readAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY date_added DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    // READ - Get single application by ID
    public function readOne($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    // UPDATE - Update an application
    public function update($id, $data) {
        $sql = "UPDATE {$this->table} SET 
                first_name = :first_name,
                last_name = :last_name,
                email = :email,
                phone = :phone,
                position_applied = :position_applied,
                years_experience = :years_experience,
                skills = :skills,
                expected_salary = :expected_salary
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':first_name', $data['first_name'], PDO::PARAM_STR);
        $stmt->bindValue(':last_name', $data['last_name'], PDO::PARAM_STR);
        $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindValue(':phone', $data['phone'], PDO::PARAM_STR);
        $stmt->bindValue(':position_applied', $data['position_applied'], PDO::PARAM_STR);
        $stmt->bindValue(':years_experience', $data['years_experience'], PDO::PARAM_INT);
        $stmt->bindValue(':skills', $data['skills'], PDO::PARAM_STR);
        $stmt->bindValue(':expected_salary', $data['expected_salary'], PDO::PARAM_STR);
        
        return $stmt->execute();
    }
    
    // DELETE - Delete an application
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
