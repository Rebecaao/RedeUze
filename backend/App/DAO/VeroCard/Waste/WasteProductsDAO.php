<?php

namespace App\DAO\VeroCard\Waste;

use App\DAO\VeroCard\Connection;

class WasteProductsDAO extends Connection
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllWasteProducts(): array
{
    $query = "SELECT * FROM view_dmcard_relatorio_waste WHERE desc_produto LIKE '%- UZE'";

    $wasteProducts = $this->pdo
        ->query($query)
        ->fetchAll(\PDO::FETCH_ASSOC);

    foreach ($wasteProducts as &$product) {
        $product['dt_perda'] = date('d/m/Y', strtotime($product['dt_perda']));
    }

    return $wasteProducts;
}

public function searchWasteProducts($searchTerm): array
{
    $searchTerm = '%' . $searchTerm . '%';
    $searchTermWithSuffix = $searchTerm . '- UZE%';

    $query = "SELECT * FROM view_dmcard_relatorio_waste 
              WHERE (cod_produto LIKE :searchTerm 
              OR desc_produto LIKE :searchTerm)
              AND desc_produto LIKE :searchTermWithSuffix";

    $statement = $this->pdo->prepare($query);
    $statement->bindParam(':searchTerm', $searchTerm, \PDO::PARAM_STR);
    $statement->bindParam(':searchTermWithSuffix', $searchTermWithSuffix, \PDO::PARAM_STR);
    $statement->execute();

    $results = $statement->fetchAll(\PDO::FETCH_ASSOC);

    return $results;
}
}
