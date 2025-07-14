<?php

require_once __DIR__ . '/../Config/Conexion.php';

class ProductosModel extends Conexion {

    public function __construct()
    {
        parent::__construct();
    }

    public function getProductos() {
        try {
            $parametrizacion = $this->con->prepare("SELECT * FROM productos WHERE estado = (?)");
            $parametrizacion->bind_param('i', $a);
            $a = 1;

            $parametrizacion->execute();
            $resultado = $parametrizacion->get_result();

            $r = array();
            while ($fila = $resultado->fetch_assoc()) {
                $producto = array(
                    'id' => $fila['id'],
                    'nombre' => $fila['nombre'],
                    'descripcion' => $fila['descripcion'],
                    'precio' => $fila['precio'],
                    'stock' => $fila['stock'],
                    'tipo' => $fila['tipo'],
                    'estado' => $fila['estado']
                );
                $r[] = $producto;
            }
            return $r;

        } catch (Exception $ex) {
            return $ex;
        } finally {
            $this->con->close();
        }
    }

    public function postProducto($nombre, $descripcion, $precio, $stock, $tipo) {
        try {
            $parametrizacion = $this->con->prepare("INSERT INTO productos (nombre, descripcion, precio, stock, tipo) VALUES (?, ?, ?, ?, ?)");
            $parametrizacion->bind_param('ssdis', $a, $b, $c, $d, $e);
            $a = $nombre;
            $b = $descripcion;
            $c = $precio;
            $d = $stock;
            $e = $tipo;

            $parametrizacion->execute();
            $resultado = $parametrizacion->get_result();
            return $resultado;

        } catch (Exception $ex) {
            return $ex;
        } finally {
            $this->con->close();
        }
    }

    // PUT
    public function updateProducto($id, $nombre, $descripcion, $precio, $stock, $tipo) {
        try {
            $parametrizacion = $this->con->prepare("UPDATE productos SET nombre = (?), descripcion = (?), precio = (?), stock = (?), tipo = (?) WHERE id = (?)");

            $parametrizacion->bind_param('ssdisi', $a, $b, $c, $d, $e, $f);
            $a = $nombre;
            $b = $descripcion;
            $c = $precio;
            $d = $stock;
            $e = $tipo;
            $f = $id;

            $parametrizacion->execute();
            $resultado = $parametrizacion->get_result();
            return $resultado;

        } catch (Exception $ex) {
            return $ex;
        } finally {
            $this->con->close();
        }
    }

    public function deleteProducto($id) {
        try {
            $parametrizacion = $this->con->prepare("UPDATE productos SET estado = (?) WHERE id = (?)");
            $parametrizacion->bind_param('ii', $a, $b);
            $a = 0;
            $b = $id;

            $parametrizacion->execute();
            $resultado = $parametrizacion->get_result();
            return $resultado;

        } catch (Exception $ex) {
            return $ex;
        } finally {
            $this->con->close();
        }
    }

    // PATCH - Permite modificar solo el campo stock sin afectar los demás, a diferencia de PUT que modifica todos los campos
    public function patchProducto($id, $stock) {
        try {
            $parametrizacion = $this->con->prepare("UPDATE productos SET stock = (?) WHERE id = (?)");
            $parametrizacion->bind_param('ii', $a, $b);
            $a = $stock;
            $b = $id;

            $parametrizacion->execute();
            $resultado = $parametrizacion->get_result();
            return $resultado;

        } catch (Exception $ex) {
            return $ex;
        } finally {
            $this->con->close();
        }
    }
}
?>