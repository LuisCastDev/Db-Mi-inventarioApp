<?php

class Clientes_Ctrl
{
    public $M_Cliente = null;

    public function __construct()
    {
        $this->M_Cliente = new M_Clientes();


    }
    public function crear($f3)
    {

        $this->M_Cliente->load(['identificacion = ? OR correo = ?', $f3->get('POST.identificacion'),$f3->get('POST.correo')]);
        if  ($this->M_Cliente->loaded() >0)
        {

            echo json_encode([

                'mensaje' => 'Ya existe un cliente con la identificacion o correo que intenta registrar',
               
    
                'info' => [ 
                    'id'=>'0'
                ]
                
    
    
                ]);


        }
        else
        {
                $this->M_Cliente->set('identificacion',$f3->get('POST.identificacion'));
                $this->M_Cliente->set('nombre',$f3->get('POST.nombre'));
                $this->M_Cliente->set('telefono',$f3->get('POST.telefono'));
                $this->M_Cliente->set('correo',$f3->get('POST.correo'));
                $this->M_Cliente->set('direccion',$f3->get('POST.direccion'));
                $this->M_Cliente->set('pais',$f3->get('POST.pais'));
                $this->M_Cliente->set('ciudad',$f3->get('POST.ciudad'));
                $this->M_Cliente->save();
        echo json_encode([

            'mensaje' => 'cliente creado',
            'info' => [

                'id' => $this->M_Cliente->get('id')

            ]





            ]);
        }
      
        
    }

    public function consultar($f3){

        $cliente_id = $f3->get('PARAMS.cliente_id');
        
        $this->M_Cliente->load(['id = ?',$cliente_id]);
        $msg = "";
        $item = array();
        if ($this->M_Cliente->loaded() > 0)
        {
            $msg = "cliente Encontrado";
            $item = $this->M_Cliente->cast(); 
        }
        else{
            $msg = "El cliente no existe";
        }
        echo json_encode([

            'mensaje' => $msg,
            'info' => [

                'item' => $item

            ]
        ]);
      


    }
    public function eliminar($f3){

        $cliente_id = $f3->get('PARAMS.cliente_id');
        
        $this->M_Cliente->load(['id = ?',$cliente_id]);
        $msg = "";
      
        if ($this->M_Cliente->loaded() > 0)
        {
            $msg = "cliente eliminado";
            $this->M_Cliente->erase(); 
        }
        else{
            $msg = "El cliente no existe";
        }
        echo json_encode([

            'mensaje' => $msg,
            'info' => [     ]
        ]);
      


    }

    public function actualizar($f3){

        $cliente_id = $f3->get('PARAMS.cliente_id');        
        $this->M_Cliente->load(['id = ?',$cliente_id]);

        $msg = "";
      
        if ($this->M_Cliente->loaded() > 0)
        {   
            $_cliente = new M_Clientes();
            $_cliente->load(['correo = ? AND id <>?',$f3->get('POST.correo'),$cliente_id]);
            if($_cliente->loaded() > 0){

                $msg = "registro no se pudo modificar debido a que el correo se encuentra en uso por otro cliente";
                $info['id'] = 0;            }
            else
            {
            $msg = "cliente actualizado";
            $this->M_Cliente->set('nombre',$f3->get('POST.nombre'));
            $this->M_Cliente->set('telefono',$f3->get('POST.telefono'));
            $this->M_Cliente->set('direccion',$f3->get('POST.direccion'));
            $this->M_Cliente->set('pais',$f3->get('POST.pais'));
            $this->M_Cliente->set('ciudad',$f3->get('POST.ciudad'));
            $this->M_Cliente->set('correo',$f3->get('POST.correo'));
            $this->M_Cliente->save();
            $info['id'] = $this->M_Cliente->get('id');
            } 
        }
        else{
            $msg = "El cliente no existe";
            $info['id'] = 0;
        }
        echo json_encode([

            'mensaje' => $msg,
            'info' => [     ]
        ]);
      


    }
    public function listado($f3)
    {
        
        $result = $this->M_Cliente->find();
        $items= array ();
        foreach($result as $cliente)
        {
            $items [] = $cliente->cast();
  
        }
        

        echo json_encode([

            'mensaje' => count($items) > 0 ? '' : 'Aun no hay registros para mostrar',
            'info' => [

              'items' => $items,
                'total'=> count($items)
            ]

        ]);
    }



    
}