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

        $select = "SELECT consecutivo,descripcion,path_imagen,color,modulo FROM actividad WHERE modulo = 1 AND consecutivo != 1 AND display = 1 ORDER BY orden";

        $result = $this->DbFetchAll($select, $Conex);

        return $result;

    }

    public function getChildren($modulos, $Conex)
    {

        $i = 0;
        $children = Array();

        foreach ($modulos as $modulo) {

            $nivel_superior = $modulo[consecutivo];
            
            $select = "SELECT consecutivo,nivel_superior,descripcion,path_imagen,modulo FROM actividad WHERE nivel_superior = $nivel_superior ORDER BY orden;";
            $result = $this->DbFetchAll($select, $Conex);

            foreach (array_filter($result) as $item) {
                
                $children[$i][consecutivo] = $item[consecutivo];
                $children[$i][nivel_superior] = $item[nivel_superior];
                $children[$i][descripcion] = $item[descripcion];
                $children[$i][path_imagen] = $item[path_imagen];

                $i++;

            }

        }

        return $children;

    }

}
