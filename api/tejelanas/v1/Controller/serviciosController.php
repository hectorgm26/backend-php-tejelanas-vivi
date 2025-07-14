<?php

require_once __DIR__ . '/../Models/ServiciosModel.php';

class serviciosController {

    private $model;

    public function __construct() {
        $this->model = new ServiciosModel();
    }

    public function getServicios() {
        return $this->model->getServicios();
    }

    public function postServicio($titulo, $descripcion, $fecha, $ubicacion, $cupos) {
        return $this->model->postServicio($titulo, $descripcion, $fecha, $ubicacion, $cupos);
    }

    public function putServicio($id, $titulo, $descripcion, $fecha, $ubicacion, $cupos) {
        return $this->model->putServicio($id, $titulo, $descripcion, $fecha, $ubicacion, $cupos);
    }

    public function deleteServicio($id) {
        return $this->model->deleteServicio($id);
    }

    public function patchServicio($id, $cupos) {
    return $this->model->patchServicio($id, $cupos);
}

}
