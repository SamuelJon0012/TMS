<?php

namespace App;
use Illuminate\Http\Request;

/*
 * drug_profile
ndc_package_code
ndc_product_code
strength
doseage_form
route
nonproprietary_name
labeler_name
substance_name
package_description
days_between_doses
manufacturer_name
 */

class DrugProfile extends BurstIq
{

    # base class methods

    # $this->status()
    # $this->login()
    # $this->query(chain, query)
    # $this->upsert(chain, json) accepts object or json_encoded object
    # see BurtIqTestController for examples

    protected $chain = 'drug_profile';
    protected $view = 'biq/drug_profile';

    # List all of the private vars here (id and other common ones are in the base class

    private $ndc_package_code;
    private $ndc_product_code;
    private $strength;
    private $doseage_form;
    private $route;
    private $nonproprietary_name;
    private $labeler_name;
    private $substance_name;
    private $package_description;
    private $days_between_doses;
    private $manufacturer_name;


    # Generate fluent getters and setters here


    # custom functions here

    public function make($record) {

        # example

        # get the full asset object

        $asset = $record->asset;

        # populate id and all the other properties

        $this->id = $asset->id;
        $this->ndc_package_code = $asset->ndc_package_code;
        $this->ndc_product_code = $asset->ndc_product_code;
        $this->strength = $asset->strength;
        $this->doseage_form = $asset->doseage_form;
        $this->route = $asset->route;
        $this->nonproprietary_name = $asset->nonproprietary_name;
        $this->labeler_name = $asset->labeler_name;
        $this->substance_name = $asset->substance_name;
        $this->package_description = $asset->package_description;
        $this->days_between_doses = $asset->days_between_doses;
        $this->manufacturer_name = $asset->manufacturer_name;


        # make a useful array of this row, for example:

        $array = [

            'id' => $asset->id,
            'ndc_package_code' => $asset->ndc_package_code,
            'ndc_product_code' => $asset->ndc_product_code,
            'strength' => $asset->strength,
            'doseage_form' => $asset->doseage_form,
            'route' => $asset->route,
            'nonproprietary_name' => $asset->nonproprietary_name,
            'labeler_name' => $asset->labeler_name,
            'substance_name' => $asset->substance_name,
            'package_description' => $asset->package_description,
            'days_between_doses' => $asset->days_between_doses,
            'manufacturer_name' => $asset->manufacturer_name,

        ];

        # and APPEND this row's array to the object's array[] array

        $this->array[] = $array;

        return $array;

    }
}
