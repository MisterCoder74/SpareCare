<?php
require_once __DIR__ . '/constants.php';

class Database {
    private $filePath;

    public function __construct($filename = 'professionals.json') {
        $this->filePath = DATA_PATH . '/' . $filename;
        if (!file_exists($this->filePath)) {
            $this->save(['professionals' => []]);
        }
    }

    public function load() {
        if (!file_exists($this->filePath)) {
            return ['professionals' => []];
        }

        $content = file_get_contents($this->filePath);
        $data = json_decode($content, true);

        return $data ?: ['professionals' => []];
    }

    public function save($data) {
        $jsonContent = json_encode($data, JSON_PRETTY_PRINT);
        
        // Use a temporary file for atomic write
        $tempFile = $this->filePath . '.tmp';
        
        $fp = fopen($this->filePath, 'c+');
        if (flock($fp, LOCK_EX)) {
            ftruncate($fp, 0);
            fwrite($fp, $jsonContent);
            fflush($fp);
            flock($fp, LOCK_UN);
        }
        fclose($fp);
    }

    public function getProfessionals() {
        $data = $this->load();
        return $data['professionals'];
    }

    public function findProfessionalByEmail($email) {
        $professionals = $this->getProfessionals();
        foreach ($professionals as $p) {
            if ($p['email'] === $email) {
                return $p;
            }
        }
        return null;
    }

    public function findProfessionalById($id) {
        $professionals = $this->getProfessionals();
        foreach ($professionals as $p) {
            if ($p['id'] === $id) {
                return $p;
            }
        }
        return null;
    }

    public function updateProfessional($updatedProfessional) {
        $data = $this->load();
        foreach ($data['professionals'] as &$p) {
            if ($p['id'] === $updatedProfessional['id']) {
                $p = array_merge($p, $updatedProfessional);
                $p['updated_at'] = date('c');
                $this->save($data);
                return true;
            }
        }
        return false;
    }

    public function addProfessional($professional) {
        $data = $this->load();
        $professional['id'] = bin2hex(random_bytes(16));
        $professional['created_at'] = date('c');
        $professional['updated_at'] = date('c');
        $professional['is_active'] = true;
        $data['professionals'][] = $professional;
        $this->save($data);
        return $professional['id'];
    }
}
?>
