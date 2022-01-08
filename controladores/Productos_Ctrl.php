<?php

class Productos_Ctrl
{
    public $M_Producto = null;

    public function __construct()
    {
        $this->M_Producto = new M_Productos();


    }
    public function crear($f3)
    {
        $this->M_Producto->set('codigo',$f3->get('POST.codigo'));
        $this->M_Producto->set('nombre',$f3->get('POST.nombre'));
        $this->M_Producto->set('stock',$f3->get('POST.stock'));
        $this->M_Producto->set('status',$f3->get('POST.status'));
        $this->M_Producto->set('precio',$f3->get('POST.precio'));
        $this->M_Producto->save();
        echo json_encode([

            'mensaje' => 'Producto creado',
            'info' => [

                'id' => $this->M_Producto->get('id')

            ]





        ]);
      
        
    }
    public function actualizar($f3)
    {
        $producto_id = $f3->get('PARAMS.producto_id');
        $this->M_Producto->load(['id = ?',$producto_id]);

        $msg= "";
        $info = array();
        if($this->M_Producto->loaded() > 0)
        {
            $_producto = new M_Productos();
            $_producto->load(['nombre = ? AND id  <>? OR codigo = ? AND id  <>? ',$f3->get('POST.nombre'),$producto_id,$f3->get('POST.codigo'),$producto_id ]);
            if($_producto->loaded() > 0)
            {
                $msg = "el registro no se pudo modificar porque hay otro producto con el mismo nombre o codigo";
                $info['id'] = 0;
            }
            else{
                
                $this->M_Producto->set('codigo',$f3->get('POST.codigo'));
                $this->M_Producto->set('nombre',$f3->get('POST.nombre'));
                $this->M_Producto->set('stock',$f3->get('POST.stock'));
                $this->M_Producto->set('status',$f3->get('POST.status'));
                $this->M_Producto->set('precio',$f3->get('POST.precio'));
                $this->M_Producto->save();
                $msg = "producto modificado";
                $info['id'] = $this->M_Producto->get('id');
            }



        }
        else{
            $msg="el producto no existe";
            $info['id'] = 0;
        }
        echo json_encode([


            'mensaje' => $msg,
            'info' => $info
            
        ]);








    }

    public function consultar($f3){

        $producto_id = $f3->get('PARAMS.producto_id');
        
        $this->M_Producto->load(['id = ?',$producto_id]);
        $msg = "";
        $item = array();
        if ($this->M_Producto->loaded() > 0)
        {
            $msg = "Producto Encontrado";
            $item = $this->M_Producto->cast(); 
            $item['precio'] = round($item['precio']);
        }
        else{
            $msg = "El Producto no existe";
        }
        echo json_encode([

            'mensaje' => $msg,
            'info' => [

                'item' => $item

            ]
        ]);
      


    }
    // public function eliminar($f3){

    //     $producto_id = $f3->get('POST.producto_id');
        
    //     $this->M_Producto->load(['id = ?',$producto_id]);
    //     $msg = "";
      
    //     if ($this->M_Producto->loaded() > 0)
    //     {
    //         $msg = "Producto eliminado";
    //         $this->M_Producto->erase(); 
    //     }
    //     else{
    //         $msg = "El Producto no existe";
    //     }
    //     echo json_encode([

    //         'mensaje' => $msg,
    //         'info' => [     ]
    //     ]);
      


    // }
    public function eliminar($f3){

        $producto_id = $f3->get('PARAMS.producto_id');
        
        $this->M_Producto->load(['id = ?',$producto_id]);
        $msg = "";
      
        if ($this->M_Producto->loaded() > 0)
        {
            $msg = "Producto eliminado";
            $this->M_Producto->erase(); 
        }
        else{
            $msg = "El Producto no existe";
        }
        echo json_encode([

            'mensaje' => $msg,
            'info' => [     ]
        ]);
      


    }


    public function listado($f3)
    {
        
        $result = $this->M_Producto->find(['nombre LIKE ?','%'. $f3->get('POST.texto') .'%']);
        $items= array ();
        $uno = 1;
        foreach($result as $producto)
        {
            $items [] = $producto->cast();
  
        }
        $checkeo =  $this->M_Producto->find(['status = ?',$uno]);
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



    
    public function listado2($f3)
    {
        
        $result = $this->M_Producto->find(['nombre LIKE ?','%'. $f3->get('POST.texto') .'%']);
        $items= array ();
        foreach($result as $producto)
        {
            $items [] = $producto->cast();
  
        }
        $checkeo =  $this->M_Producto->find(['status = ?']);
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



    // public function listado2($f3)
    // {
    //     $texto = $f3->get('PARAMS.texto');
    //     $result = $this->M_Producto->find(['nombre LIKE ?','%'. $f3->get($texto) .'%']);
    //     $items= array ();
    //     foreach($result as $producto)
    //     {
    //         $items [] = $producto->cast();
  
    //     }

    //     echo json_encode([

    //         'mensaje' => count($items) > 0 ? '' : 'Aun no hay registros para mostrar',
    //         'info' => [

    //           'items' => $items,
    //             'total'=> count($items)
    //         ]

    //     ]);
    // }

    
}