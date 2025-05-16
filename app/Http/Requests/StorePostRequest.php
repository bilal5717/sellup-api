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
        return [
            'title' => 'required|string|max:255|min:10',
            'description' => 'required|string|min:20|max:2000',
            'category' => 'required|string|max:255|exists:categories,name',
            'subCategory' => 'required|string|max:255',
            'price' => 'required|numeric|min:0|max:9999999',
            'location' => 'required|string|max:255',
            'contactName' => 'required|string|max:100',

            // Mobile fields
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

            // Property fields
            'subType' => 'nullable|string|max:255',
            'furnish' => 'nullable|string|in:Furnished,Unfurnished,Semi-Furnished',
            'bedrooms' => 'nullable|integer|min:0|max:100',
            'bathrooms' => 'nullable|integer|min:0|max:100',
            'storeys' => 'nullable|integer|min:0|max:100',
            'floorlevel' => 'nullable|integer|min:0|max:100',
            'area' => 'nullable|numeric|min:0|max:999999',
            'areaUnit' => 'nullable|string|max:50',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string|max:255',
            'otherFeature' => 'nullable|string|max:255',
            'pricePeriod' => 'nullable|string|in:monthly,yearly,total',
            'utilitiesIncluded' => 'nullable|boolean',

            // Electronics fields
            'type' => 'nullable|string|max:255',
            'sub_type' => 'nullable|string|max:255',
            'doors' => 'nullable|string|max:255',
            'no_taps' => 'nullable|string|max:255',
            'water_dispensers' => 'nullable|string|max:255',
            'sensor_size' => 'nullable|string|max:255',
            'wifi' => 'nullable|string|max:255',
            'capacity' => 'nullable|string|max:255',
            'functionType' => 'nullable|string|max:100',
            'generatorType' => 'nullable|string|max:100',
            'fuelType' => 'nullable|string|max:100',
            'wattage' => 'nullable|string|max:100',
            'power' => 'nullable|string|max:100',
            'heaterType' => 'nullable|string|max:100',
            'dryerLoad' => 'nullable|string|max:100',
            'warranty' => 'nullable|string|max:100',
            'age' => 'nullable|string|max:100',
            'kilowatt' => 'nullable|string|max:100',
            'wattageups' => 'nullable|string|max:100',

            //bikes 
            'make' => 'nullable|string|max:100',
'model' => 'nullable|string|max:100',
'year' => 'nullable|integer|min:1900|max:2100',
'engineType' => 'nullable|string|max:50',
'engineCapacity' => 'nullable|string|max:100',
'kmsDriven' => 'nullable|string|max:100',
'ignitionType' => 'nullable|string|max:50',
'origin' => 'nullable|string|max:50',
'registrationCity' => 'nullable|string|max:100',
'kind' => 'nullable|string|max:100',

/* businness and agriculture  */
'businessType' => 'nullable|string|max:255',
            'specialField' => 'nullable|string|max:255',
            'subCategoryType' => 'nullable|string|max:255',
            'companyName' => 'nullable|string|max:255',
            'sellerType' => 'nullable|string|in:business,individual',
            'condition' => 'nullable|string|in:New,Used,Refurbished',
            'operationScale' => 'nullable|string|in:Small,Medium,Large',
            'specifications' => 'nullable|string|max:2000',


            /* Services */

            'serviceType' => 'nullable|string|max:255',
            'businessName' => 'nullable|string|max:255|required_if:businessType,company',
            'availability' => 'nullable|string|max:255',
            'experienceLevel' => 'nullable|string|max:255',
            'specialField' => 'nullable|string|max:255',
            'specialTypeField' => 'nullable|string|max:255',
            'typeforCatering' => 'nullable|string|in:Catering,Cooked Food,Others',
            'typeforCarPool' => 'nullable|string|in:Male,Female,Both',

            /* Jobs  */
            'jobType' => 'nullable|string|max:255',
            'hiringType' => 'nullable|string|in:company,individual,agency',
            'companyName' => 'nullable|string|max:255|required_if:hiringType,company,agency',
            'salaryFrom' => 'nullable|numeric|min:0',
            'salaryTo' => 'nullable|numeric|min:0|gte:salaryFrom',
            'careerLevel' => 'nullable|string|max:255',
            'salaryPeriod' => 'nullable|string|max:50',
            'positionType' => 'nullable|string|max:50',

            /* Animals */
            'animalType' => 'nullable|string|max:255',
        'subAnimalType' => 'nullable|string|max:255',
        'breed' => 'nullable|string|max:255',
        'gender' => 'nullable|string|in:Male,Female',
        'age' => 'nullable|string|max:50',
        'isVaccinated' => 'nullable|boolean',

        /* Books ,Sports and Hobbies */
        'subType' => 'nullable|string|max:255',
        'condition' => 'nullable|string|in:New,Used,Refurbished',
        'language' => 'nullable|string|max:255',
        'author' => 'nullable|string|max:255',

       // In StorePostRequest
'furnitureType' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:255',
            'dimensions' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:100',
            'condition' => 'nullable|string|in:New,Used,Refurbished',
            'warranty' => 'nullable|string|max:100',
            'folding' => 'nullable|string|in:Yes,No',
            'age' => 'nullable|string|max:50',
            'length' => 'nullable|numeric',
            'width' => 'nullable|numeric',
           'handmade' => 'nullable|string|in:Yes,No',
            'origin' => 'nullable|string|max:100',

            /* fasion and beauty */
            'type' => 'nullable|string|max:255',
'gender' => 'nullable|string|in:Male,Female,Unisex,Girl,Boy',
'fabric' => 'nullable|string|max:100',
'material' => 'nullable|string|max:100',
'Footcategory' => 'nullable|string|max:100',
'language' => 'nullable|string|max:100',
'age' => 'nullable|string|max:50',

/* kids */
'type' => 'nullable|string|max:255',
'condition' => 'nullable|string|max:100',
'age' => 'nullable|string|max:100',
'gender' => 'nullable|string|in:Male,Female',

            // Media
            'imageUrls' => 'sometimes|string',
        'videoFile' => 'sometimes|json', // 50MB max
        ];
    }
}
