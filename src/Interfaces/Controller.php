<?php

namespace Source\Interfaces;

interface Controller{

      public function index(): void;
      public function store(array $data): void;
      public function show(array $data): void;
      public function update(array $data): void;
      public function destroy(array $data): void;

}
