<?php

require_once "../../../framework/clases/DbClass.php";
require_once "../../../framework/clases/PermisosFormClass.php";

final class ModulosModel extends Db
{

    public function SetUsuarioId($usuario_id, $oficina_id)
    {
        $this->Permisos = new PermisosForm();
        $this->Permisos->SetUsuarioId($usuario_id, $oficina_id);
    }

    public function getPermiso($ActividadId, $Permiso, $Conex)
    {
        return $this->Permisos->getPermiso($ActividadId, $Permiso, $Conex);
    }

    public function Save($Campos, $Conex)
    {
        //

    }

    public function getEmpresasTree($Conex)
    {

        $select = "SELECT 
            consecutivo,
            nivel_superior,
            descripcion,
            path_imagen,
            IF((modulo IS NULL) || (modulo = 0), 0, 1) AS modulo,
            url_destino,
            estado,
            IF((url_destino != '') && (url_destino IS NOT NULL), 1, 0) AS es_formulario
        FROM 
            actividad
        WHERE 
            consecutivo != 1
        ORDER BY orden";

        $result = $this->DbFetchAll($select, $Conex);

        return $result;

    }

    public function updateModule($consecutivo, $Conex){

        $select = "SELECT
            estado
        FROM
            actividad
        WHERE
            consecutivo = $consecutivo";
        $result = $this->DbFetchAll($select, $Conex);

        if ($result[0][estado] == 1) {
            $estado = '0';
            $update = "UPDATE actividad SET estado = $estado WHERE consecutivo = $consecutivo";
        } else {
            $estado = '1';
            $update = "UPDATE actividad SET estado = $estado WHERE consecutivo = $consecutivo";
        }

        $this -> query($update,$Conex,true);

        return $estado;

    }

}
