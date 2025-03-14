<?php

namespace App\Traits;

use App\Models\Address;
use App\Models\AddressType;

trait Addressable
{
    /**
     * Get all addresses for this model
     */
    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    /**
     * Add a new address to this model
     * 
     * @param array $addressData
     * @param int $addressTypeId
     * @return Address
     */
    public function addAddress(array $addressData, int $addressTypeId)
    {
        $addressData['address_type_id'] = $addressTypeId;
        return $this->addresses()->create($addressData);
    }

    /**
     * Get billing addresses for this model
     */
    public function billingAddresses()
    {
        return $this->addresses()->where('address_type_id', AddressType::BILLING);
    }

    /**
     * Get shipping addresses for this model
     */
    public function shippingAddresses()
    {
        return $this->addresses()->where('address_type_id', AddressType::SHIPPING);
    }

    /**
     * Add a billing address
     * 
     * @param array $addressData
     * @return Address
     */
    public function addBillingAddress(array $addressData)
    {
        return $this->addAddress($addressData, AddressType::BILLING);
    }

    /**
     * Add a shipping address
     * 
     * @param array $addressData
     * @return Address
     */
    public function addShippingAddress(array $addressData)
    {
        return $this->addAddress($addressData, AddressType::SHIPPING);
    }
} 