<?php

class Pedidos_Detalle_Ctrl
{
    public $M_Pedidos_Detalle = null;

    public function __construct()
    {
        $this->M_Pedidos_Detalle = new M_Pedidos_Detalles();


    }
    public function crear($f3)
    {
        $this->M_Pedidos_Detalle->set('pedido_id',$f3->get('POST.pedido_id'));
        $this->M_Pedidos_Detalle->set('producto_id',$f3->get('POST.producto_id'));
        $this->M_Pedidos_Detalle->set('cantidad',$f3->get('POST.cantidad'));
        $this->M_Pedidos_Detalle->set('precio',$f3->get('POST.precio'));
        $this->M_Pedidos_Detalle->save();
        echo json_encode([

            'mensaje' => 'Pedidos_Detalle creado',
            'info' => [

                'id' => $this->M_Pedidos_Detalle->get('id')

            ]





        ]);
      
        
    }

    public function consultar($f3){

        $Pedidos_Detalle_id = $f3->get('PARAMS.Pedidos_Detalle_id');
        
        $this->M_Pedidos_Detalle->load(['id = ?',$Pedidos_Detalle_id]);
        $msg = "";
        $item = array();
        if ($this->M_Pedidos_Detalle->loaded() > 0)
        {
            $msg = "Pedidos_Detalle Encontrado";
            $item = $this->M_Pedidos_Detalle->cast(); 
        }
        else{
            $msg = "El Pedidos_Detalle no existe";
        }
        echo json_encode([

            'mensaje' => $msg,
            'info' => [

                'item' => $item

            ]
        ]);
      


    }
    public function eliminar($f3){

        $Pedidos_Detalle_id = $f3->get('POST.Pedidos_Detalle_id');
        
        $this->M_Pedidos_Detalle->load(['id = ?',$Pedidos_Detalle_id]);
        $msg = "";
      
        if ($this->M_Pedidos_Detalle->loaded() > 0)
        {
            $msg = "Pedidos_Detalle eliminado";
            $this->M_Pedidos_Detalle->erase(); 
        }
        else{
            $msg = "El Pedidos_Detalle no existe";
        }
        echo json_encode([

            'mensaje' => $msg,
            'info' => [     ]
        ]);
      


    }

    public function listado($f3)
    {
        
        $result = $this->M_Pedidos_Detalle->find();
        $items= array ();
        foreach($result as $Pedidos_Detalle)
        {
            $items [] = $Pedidos_Detalle->cast();
  
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