<?php

require_once __DIR__ . '/../Models/ProductosModel.php';
// El require_once __DIR__ se utiliza para evitar errores de rutas al mover archivos o cambiar de directorio de ejecución.
// Y Funciona de manera predecible sin importar desde qué lugar del proyecto se está ejecutando el script

class productosController {

    private $model;

    public function __construct()
    {
        $this->model = new ProductosModel();
    }

    public function getallProductos() {
        return $this->model->getProductos();
    }

    public function postProducto($nombre, $descripcion, $precio, $stock, $tipo) {
        return $this->model->postProducto($nombre, $descripcion, $precio, $stock, $tipo);
    }

    public function putProducto($id, $nombre, $descripcion, $precio, $stock, $tipo) {
        return $this->model->updateProducto($id, $nombre, $descripcion, $precio, $stock, $tipo);
    }

    public function deleteProducto($id) {
        return $this->model->deleteProducto($id);
    }

    public function patchProducto($id, $stock) {
        return $this->model->patchProducto($id, $stock);
    }
}

?>