<?php

namespace App\Traits;

trait Filterable
{
    public function scopeFilter($builder, $filters = [])
    {
        if(!$filters) {
            return $builder;
        }
        $tableName = $this->getTable();

        foreach ($filters as $field => $value) {
            if (in_array($field, $this->betweenFilterFields)) {
                $value = explode(',', $value);

                if ($field == 'price') {
                    $builder->whereRaw('CAST(CASE WHEN discount > 0 THEN price * (1-discount) ELSE price END AS UNSIGNED) >= ?', [(int) $value[0]]);
                    $builder->whereRaw('CAST(CASE WHEN discount > 0 THEN price * (1-discount) ELSE price END AS UNSIGNED) <= ?', [(int) $value[1]]);
                } else {
                    $builder->where($field, '>=', (int) $value[0]);
                    $builder->where($field, '<=', (int) $value[1]);
                }
            }
            if(in_array($field, $this->likeFilterFields)) {
                $builder->where($tableName.'.'.$field, 'LIKE', "%$value%");
            }
            if(in_array($field, $this->specificBetweenFilterFields)) {
                $value = explode(',', $value);

                $builder->whereRaw('CAST(json_extract(specification, "$.' . $field . '") AS UNSIGNED) >= ?', [(int)$value[0]]);
                $builder->whereRaw('CAST(json_extract(specification, "$.' . $field . '") AS UNSIGNED) <= ?', [(int)$value[1]]);
            }
            if($field == 'color') {
                $colors = explode(',', $value);
                $builder->whereIn($field, $colors);
            }
            if($field == 'sale') {
                if ($value == 'true') $builder->where('discount', '>' ,0);
            }
            if($field == 'in-warehouse') {
                if ($value == 'stock') $builder->where('discount', '>' ,0);
            }
            if ($field == 'sortBy') {
                $value = explode(',', $value);
                $value = [$value[0] => $value[1]];

                foreach ($value as $key => $order) {
                    if ($key == "price") {
                        $builder->orderByRaw('CASE WHEN discount > 0 THEN price * (1-discount) ELSE price END ' . $order);
                    } elseif ($key != "featured") {
                        $builder->orderBy($key, $order);
                    } else {
                        $builder->orderBy('id', $order);
                    }
                }
            }

        }

        return $builder;
    }
}
