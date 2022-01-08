<?php

class Usuarios_Ctrl
{
    public $M_Usuario = null;

    public function __construct()
    {
        $this->M_Usuario = new M_Usuarios();


    }
    public function crear($f3)
    {
        $this->M_Usuario->set('usuario',$f3->get('POST.usuario'));
        $this->M_Usuario->set('password',$f3->get('POST.password'));
        $this->M_Usuario->set('nombre',$f3->get('POST.nombre'));
        $this->M_Usuario->set('telefono',$f3->get('POST.telefono'));
        $this->M_Usuario->set('correo',$f3->get('POST.correo'));
        $this->M_Usuario->set('status',$f3->get('POST.status'));

        $this->M_Usuario->save();
        echo json_encode([

            'mensaje' => 'usuario creado',
            'info' => [

                'id' => $this->M_Usuario->get('id')

            ]





        ]);
      
        
    }

    public function actualizar($f3){
        $usuario_id = $f3->get('PARAMS.usuario_id');
        $this->M_Usuario->load(['id = ?',$usuario_id]);


        $msg = "";
        $info = array();
        if ($this->M_Usuario->loaded() > 0) 
        
        {
            $_usuario = new M_Usuarios();
            $_usuario->load(['usuario = ? AND id <>?',$f3->get('POST.usuario'),$usuario_id]);
            
            if ($_usuario->loaded() > 0) {
                $msg = "registro no se pudo modificar debido a que este nickname se encuentra en uso por otro usuario";
                $info['id'] = 0; 
            }
            else{
                $msg = "El usuario fue modificado con exito";
                $this->M_Usuario->set('usuario',$f3->get('POST.usuario'));
                $this->M_Usuario->set('password',$f3->get('POST.password'));
                $this->M_Usuario->set('nombre',$f3->get('POST.nombre'));
                $this->M_Usuario->set('telefono',$f3->get('POST.telefono'));
                $this->M_Usuario->set('correo',$f3->get('POST.correo'));
                $this->M_Usuario->set('status',$f3->get('POST.status'));
        
                $this->M_Usuario->save();
                $info['id'] = $this->M_Usuario->get('id');

            }

        }
        else{

            $msg = "El usuario no existe";
            $info['id'] = 0; 

        }
        echo json_encode([
            'mensaje' => $msg,
            'info' => $info



            ]);


        


    }


    public function consultar($f3){

        $usuario_id = $f3->get('PARAMS.usuario_id');
        
        $this->M_Usuario->load(['id = ?',$usuario_id]);
        $msg = "";
        $item = array();
        if ($this->M_Usuario->loaded() > 0)
        {
            $msg = "usuario Encontrado";
            $item = $this->M_Usuario->cast(); 
        }
        else{
            $msg = "El usuario no existe";
        }
        echo json_encode([

            'mensaje' => $msg,
            'info' => [

                'item' => $item

            ]
        ]);
      


    }
    public function eliminar($f3){

        $usuario_id = $f3->get('PARAMS.usuario_id');
        
        $this->M_Usuario->load(['id = ?',$usuario_id]);
        $msg = "";
      
        if ($this->M_Usuario->loaded() > 0)
        {
            $msg = "usuario eliminado";
            $this->M_Usuario->erase(); 
        }
        else{
            $msg = "El usuario no existe";
        }
        echo json_encode([

            'mensaje' => $msg,
            'info' => [     ]
        ]);
      


    }

    public function listado($f3)
    {
        
        $result = $this->M_Usuario->find();
        $items= array ();
        foreach($result as $usuario)
        {
            $items [] = $usuario->cast();
  
        }
        $checkeo =  $this->M_Usuario->find(['status LIKE ?','%'.'1'.'%']);
        foreach($checkeo as $counter)
        {
            $contador[] = $counter->cast();

        }

        echo json_encode([

            'mensaje' => count($items) > 0 ? '' : 'Aun no hay registros para mostrar',
            'info' => [

              'items' => $items,
                'total'=> count($items),
                'totalActivo'=> count($contador)
            ]

        ]);
    }



    
}