<?php

namespace Classes;

class Paginacion{

    public $pagina_actual;
    public $registros_por_pagina;
    public $total_registros;


    public function __construct($pagina_actual = 1, $registros_por_pagina = 10, $total_registros = 0){
        $this->pagina_actual = (int) $pagina_actual; // Casteo al valor, cambiar el valor de string a int si es posible
        $this->registros_por_pagina = (int) $registros_por_pagina;
        $this->total_registros = (int) $total_registros;
    }

    // Establece el offset (Salto de registros por pagina)
    public function offset() {
        return $this->registros_por_pagina * ($this->pagina_actual -1);
    }

    // Establece la cantidad de paginas, dividiendo la totalidad de registros entre el offset por pagina
    public function total_paginas() {
        return ceil($this->total_registros / $this->registros_por_pagina);
    }

    // Establece la pagina anterior restando 1 a la actual
    public function pagina_anterior() {
        $anterior = $this->pagina_actual - 1;
        return ($anterior > 0) ? $anterior : false; // return, si la pagina anterior es mayor a 0, retorna $anterior. En caso contrario retorna false
    }

    // Establece la pagina anterior sumando 1 a la actual
    public function pagina_siguiente() {
        $siguiente = $this->pagina_actual + 1;
        return ($siguiente <= $this->total_paginas()) ? $siguiente : false; // Si siguiente es menor o igual al total de paginas, retorna $siguiente. En caso contrario retorna false
    }


    public function enlace_anterior() {
        $html = '';
        if($this->pagina_anterior()){
        $html .= "<a class=\"paginacion_enlace texto\" href=\"?pagina={$this->pagina_anterior()}\">&laquo; Anterior</a>";
        }
        return $html;
    }

    public function enlace_siguiente() {
        $html = '';
        if($this->pagina_siguiente()){
        $html .= "<a class=\"paginacion_enlace texto\" href=\"?pagina={$this->pagina_siguiente()}\">Siguiente &raquo;</a>";
        }
        return $html;
    }

    // Paginacion por números
    public function numeros_paginas() {
        $html = '';

        for($i = 1; $i <= $this->total_paginas(); $i++){

            if($i === $this->pagina_actual){  // Si estamos en una pagina, se demarcará
                $html .= "<span class=\"paginacion_enlace actual\" >{$i}</span>";
            } else{
                $html .= "<a class=\"paginacion_enlace numero\" href=\"?pagina={$i}\">{$i}</a>";
            }

        }


        return $html;
    }

    // Paginacion
    public function paginacion() {
        $html = '';

        if($this->total_registros > 1){
            $html .= '<div class="paginacion">';
            $html .= $this->enlace_anterior();
            $html .= $this->numeros_paginas();
            $html .= $this->enlace_siguiente();
            $html .= '</div>';
        }

        return $html;
    }


}