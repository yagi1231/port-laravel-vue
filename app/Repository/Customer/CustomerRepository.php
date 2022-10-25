<?php

namespace App\Repository\Customer;

use App\Models\Customer;
use App\Servises\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerRepository implements CustomerService
{
    public function fetchAllCustomer(Request $query): LengthAwarePaginator
    {

        $customers = Customer::query()
            ->where(function ($q) use ($query) {
                if (($query['inputingName'])) {
                    $q->where('name', "LIKE", "%".$query['inputingName']."%");
                }
                if($query['inputingTel'] ) {
                    $q->where('tel', $query['inputingTel']);
                }
                if($query['inputingAddress']) {
                    $q->where('address', "LIKE", "%".$query['inputingAddress']."%");
                }
            })->paginate(10);

        return $customers;
    }

    public function storeCustomer(CustomerParams $params): Customer
    {
        return Customer::create($params->toArray());
    }

    public function updateCustomer(CustomerParams $params, Customer $customer): void
    {
        $customer->update($params->toArray());
    }

    public function deleteCustomer(Customer $customer): void
    {
        $customer->delete();
    }
}
