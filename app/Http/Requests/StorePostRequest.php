<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return array_merge(
            $this->commonRules(),
            $this->mobileRules(),
            $this->vehicleRules(),
            $this->propertyRules(),
            $this->electronicsRules(),
            $this->bikeRules(),
            $this->businessRules(),
            $this->serviceRules(),
            $this->jobRules(),
            $this->animalRules(),
            $this->furnitureRules(),
            $this->fashionBeautyRules(),
            $this->kidsRules(),
            $this->mediaRules()
        );
    }

    private function commonRules(): array
    {
        return [
            'title' => 'required|string|max:255|min:10',
            'description' => 'required|string|min:20|max:2000',
            'category' => 'required|string|max:255|exists:categories,name',
            'subCategory' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0|max:9999999',
            'location' => 'required|string|max:255',
            'contactName' => 'required|string|max:100',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string|max:255',
        ];
    }

    private function mobileRules(): array
    {
        return [
            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'condition' => 'nullable|string|max:255',
            'ptaStatus' => 'nullable|string|in:PTA Approved,Non PTA,JV,Factory Lock',
            'storage' => 'nullable|string|max:20',
            'memory' => 'nullable|string|max:20',
            'batteryStatus' => 'nullable|integer|min:0|max:100',
            'accessoryType' => 'nullable|string|max:255',
            'chargingCableType' => 'nullable|string|max:255',
            'deviceType' => 'nullable|string|max:255',
            'chargerType' => 'nullable|string|max:255',
            'headphoneType' => 'nullable|string|max:255',
        ];
    }

    private function vehicleRules(): array
    {
        return [
            'vehicleType' => 'nullable|string|max:100',
            'make' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'year' => 'nullable|string|max:10',
            'fuelType' => 'nullable|string|max:50',
            'kmsDriven' => 'nullable|string|max:50',
            'transmission' => 'nullable|string|max:50',
            'assembly' => 'nullable|string|max:50',
            'condition' => 'nullable|string|max:50',
            'registrationCity' => 'nullable|string|max:100',
            'docType' => 'nullable|string|max:100',
            'numberOfOwners' => 'nullable|integer|min:0',
        ];
    }

    private function propertyRules(): array
    {
        return [
            'subType' => 'nullable|string|max:255',
            'furnish' => 'nullable|string|in:Furnished,Unfurnished,Semi-Furnished',
            'bedrooms' => 'nullable|integer|min:0|max:100',
            'bathrooms' => 'nullable|integer|min:0|max:100',
            'storeys' => 'nullable|integer|min:0|max:100',
            'floorlevel' => 'nullable|integer|min:0|max:100',
            'area' => 'nullable|numeric|min:0|max:999999',
            'areaUnit' => 'nullable|string|max:50',
            'pricePeriod' => 'nullable|string|in:monthly,yearly,total',
            'utilitiesIncluded' => 'nullable|boolean',
            'otherFeature' => 'nullable|string|max:255',
        ];
    }

    private function electronicsRules(): array
    {
        return [
            'type' => 'nullable|string|max:255',
            'sub_type' => 'nullable|string|max:255',
            'doors' => 'nullable|string|max:255',
            'sensor_size' => 'nullable|string|max:255',
            'wifi' => 'nullable|string|max:255',
            'capacity' => 'nullable|string|max:255',
            'functionType' => 'nullable|string|max:100',
            'fuelType' => 'nullable|string|max:100',
            'wattage' => 'nullable|string|max:100',
            'power' => 'nullable|string|max:100',
            'warranty' => 'nullable|string|max:100',
        ];
    }

    private function bikeRules(): array
    {
        return [
            'engineType' => 'nullable|string|max:50',
            'engineCapacity' => 'nullable|string|max:100',
            'kmsDriven' => 'nullable|string|max:100',
            'ignitionType' => 'nullable|string|max:50',
            'origin' => 'nullable|string|max:50',
        ];
    }

    private function businessRules(): array
    {
        return [
            'businessType' => 'nullable|string|max:255',
            'companyName' => 'nullable|string|max:255',
            'sellerType' => 'nullable|string|in:business,individual',
            'operationScale' => 'nullable|string|in:Small,Medium,Large',
        ];
    }

    private function serviceRules(): array
    {
        return [
            'serviceType' => 'nullable|string|max:255',
            'businessName' => 'nullable|string|max:255',
            'availability' => 'nullable|string|max:255',
            'experienceLevel' => 'nullable|string|max:255',
        ];
    }

    private function jobRules(): array
    {
        return [
            'jobType' => 'nullable|string|max:255',
            'salaryFrom' => 'nullable|numeric|min:0',
            'salaryTo' => 'nullable|numeric|min:0',
        ];
    }

    private function animalRules(): array
    {
        return [
            'animalType' => 'nullable|string|max:255',
            'breed' => 'nullable|string|max:255',
            'age' => 'nullable|string|max:50',
            'gender' => 'nullable|string|in:Male,Female',
        ];
    }

    private function furnitureRules(): array
    {
        return [
            'furnitureType' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:255',
            'dimensions' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:100',
        ];
    }

    private function mediaRules(): array
    {
        return [
            'imageUrls' => 'sometimes|string',
            'videoFile' => 'sometimes|json',
        ];
    }

    private function fashionBeautyRules(): array
    {
        return [
            'type' => 'nullable|string|max:255',
            'gender' => 'nullable|string|in:Male,Female,Unisex,Girl,Boy',
        ];
    }

    private function kidsRules(): array
    {
        return [
            'type' => 'nullable|string|max:255',
            'age' => 'nullable|string|max:100',
            'gender' => 'nullable|string|in:Male,Female',
        ];
    }
}
