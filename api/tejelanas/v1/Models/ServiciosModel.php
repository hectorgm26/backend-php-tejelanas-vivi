<?php

require_once __DIR__ . '/../Config/Conexion.php';

class ServiciosModel extends Conexion {

    public function __construct() {
        parent::__construct();
    }

    public function getServicios() {
        try {
            $query = $this->con->prepare("SELECT * FROM servicios WHERE estado = ?");
            $activo = 1;
            $query->bind_param("i", $activo);
            $query->execute();
            $resultado = $query->get_result();

            $servicios = [];
            while ($fila = $resultado->fetch_assoc()) {
                $servicios[] = $fila;
            }
            return $servicios;

        } catch (Exception $ex) {
            return $ex;
        } finally {
            $this->con->close();
        }
    }

    public function postServicio($titulo, $descripcion, $fecha, $ubicacion, $cupos) {
        try {
            $query = $this->con->prepare("INSERT INTO servicios (titulo, descripcion, fecha, ubicacion, cupos) VALUES (?, ?, ?, ?, ?)");
            $query->bind_param("ssssi", $titulo, $descripcion, $fecha, $ubicacion, $cupos);
            $query->execute();

            return $this->con->insert_id;

        } catch (Exception $ex) {
            return $ex;
        } finally {
            $this->con->close();
        }
    }

    public function putServicio($id, $titulo, $descripcion, $fecha, $ubicacion, $cupos) {
        try {
            $query = $this->con->prepare("UPDATE servicios SET titulo = ?, descripcion = ?, fecha = ?, ubicacion = ?, cupos = ? WHERE id = ?");
            $query->bind_param("ssssii", $titulo, $descripcion, $fecha, $ubicacion, $cupos, $id);
            $query->execute();

            return true;

        } catch (Exception $ex) {
            return $ex;
        } finally {
            $this->con->close();
        }
    }

    public function deleteServicio($id) {
        try {
            $estado = 0;
            $query = $this->con->prepare("UPDATE servicios SET estado = ? WHERE id = ?");
            $query->bind_param("ii", $estado, $id);
            $query->execute();

            return true;

        } catch (Exception $ex) {
            return $ex;
        } finally {
            $this->con->close();
        }
    }

    public function patchServicio($id, $cupos) {
    try {
        $query = $this->con->prepare("UPDATE servicios SET cupos = ? WHERE id = ?");
        $query->bind_param("ii", $cupos, $id);
        $query->execute();

        return true;

    } catch (Exception $ex) {
        return $ex;
    } finally {
        $this->con->close();
    }
}

}
