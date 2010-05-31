<?php
function setOderBYAction($modulo,$sortType,$orderBy,$orden = '',$ordenes = '')
   {
       if ($orden!='') {
                $this->orderBy = $this->getRequestParameter('sort');
                $this->sortType = $this->getRequestParameter('type')=='asc' ? 'desc' : 'asc';
                $this->orderBYSql = $this->orderBy . ' ' . $this->sortType;
                $this->getUser()->setAttribute($modulo.'_noworderBY', $this->orderBYSql);
        }else {
            if($ordenes!='')
            {
               $this->orderBYSql = $ordenes;
               $ordenacion = explode(' ', $this->orderBYSql);
               $this->orderBy = $ordenacion[0];
               $this->sortType = $ordenacion[1];
            }
            else
            {
                $this->orderBy = $orderBy;
                $this->sortType = $sortType;
                $this->orderBYSql = $this->orderBy . ' ' . $this->sortType;
                $this->getUser()->setAttribute($modulo.'_noworderBY', $this->orderBYSql);
            }

        }

        return $this->orderBYSql;
   }
?>
