<?php

namespace Source\Controllers\Api;

use Source\Interfaces\Controller;
use Source\Models\CryptList;
use Source\Models\Deck;
use Source\Models\LibraryList;

class WantListCryptController implements Controller
{
    
    public function index(): void
    {
    }

    public function store(array $data): void
    {
        echo json_encode($data);
    }

    public function show(array $data): void
    {
    }

    public function update(array $data): void
    {
    }

    public function destroy(array $data): void
    {
    }
}
