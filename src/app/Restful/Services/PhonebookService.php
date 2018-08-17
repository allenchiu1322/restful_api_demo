<?php
namespace App\Restful\Services;

use App\Restful\Repositories\PhonebookRepository;

class PhonebookService {

    protected $phonebookRepository;

    public function __construct() {
        $this->phonebookRepository = new phonebookRepository;
    }

    public function create($param) {
        return $this->phonebookRepository->create($param);
    }

    public function update($param) {
        return $this->phonebookRepository->update($param);
    }

    public function delete($param) {
        return $this->phonebookRepository->delete($param);
    }

    public function get_all_data() {
        return $this->phonebookRepository->get_all_phonebook();
    }

    public function get_by_id($id) {
        return $this->phonebookRepository->query_phonebook($id);
    }

}
