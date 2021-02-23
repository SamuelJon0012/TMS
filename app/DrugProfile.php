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

    /**
     * @return mixed
     */
    public function getNdcPackageCode()
    {
        return $this->ndc_package_code;
    }

    /**
     * @param mixed $ndc_package_code
     * @return DrugProfile
     */
    public function setNdcPackageCode($ndc_package_code): DrugProfile
    {
        $this->ndc_package_code = $ndc_package_code;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNdcProductCode()
    {
        return $this->ndc_product_code;
    }

    /**
     * @param mixed $ndc_product_code
     * @return DrugProfile
     */
    public function setNdcProductCode($ndc_product_code): DrugProfile
    {
        $this->ndc_product_code = $ndc_product_code;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStrength()
    {
        return $this->strength;
    }

    /**
     * @param mixed $strength
     * @return DrugProfile
     */
    public function setStrength($strength)
    {
        $this->strength = $strength;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDoseageForm()
    {
        return $this->doseage_form;
    }

    /**
     * @param mixed $doseage_form
     * @return DrugProfile
     */
    public function setDoseageForm($doseage_form)
    {
        $this->doseage_form = $doseage_form;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param mixed $route
     * @return DrugProfile
     */
    public function setRoute($route)
    {
        $this->route = $route;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNonproprietaryName()
    {
        return $this->nonproprietary_name;
    }

    /**
     * @param mixed $nonproprietary_name
     * @return DrugProfile
     */
    public function setNonproprietaryName($nonproprietary_name)
    {
        $this->nonproprietary_name = $nonproprietary_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabelerName()
    {
        return $this->labeler_name;
    }

    /**
     * @param mixed $labeler_name
     * @return DrugProfile
     */
    public function setLabelerName($labeler_name)
    {
        $this->labeler_name = $labeler_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubstanceName()
    {
        return $this->substance_name;
    }

    /**
     * @param mixed $substance_name
     * @return DrugProfile
     */
    public function setSubstanceName($substance_name)
    {
        $this->substance_name = $substance_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPackageDescription()
    {
        return $this->package_description;
    }

    /**
     * @param mixed $package_description
     * @return DrugProfile
     */
    public function setPackageDescription($package_description)
    {
        $this->package_description = $package_description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDaysBetweenDoses()
    {
        return $this->days_between_doses;
    }

    /**
     * @param mixed $days_between_doses
     * @return DrugProfile
     */
    public function setDaysBetweenDoses($days_between_doses)
    {
        $this->days_between_doses = $days_between_doses;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getManufacturerName()
    {
        return $this->manufacturer_name;
    }

    /**
     * @param mixed $manufacturer_name
     * @return DrugProfile
     */
    public function setManufacturerName($manufacturer_name)
    {
        $this->manufacturer_name = $manufacturer_name;
        return $this;
    }


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
