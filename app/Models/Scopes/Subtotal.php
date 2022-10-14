<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class Subtotal implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $sql = 
        'select 
          reservations.id as id
        , item_reservation.id as pivot_id
        , items.price * item_reservation.quantity as subtotal
        , reservations.name as customer_name
        , reservations.customer_id as customer_id
        , items.name as item_name
        , items.price as item_price
        , reservations.name as reservation_name
        , reservations.status as status
        , reservations.time as time
        , item_reservation.quantity as quantity
        , reservations.created_at
        , reservations.updated_at
        , reservations.deleted_at
        from reservations
        left join item_reservation on reservations.id = item_reservation.reservation_id
        left join items on item_reservation.item_id = items.id
        ';

         $builder->fromSub($sql, 'order_subtotals'); 
    }
}
