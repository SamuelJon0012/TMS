    <div class="search-modal modals">

        <div class="search-modal-inner">

            <div class="breadcrumbs"><span class="go_home"><- Home</span></div>

            <form name="search-form" onsubmit="return doPatientSearch('search-input');">

                <input id="search-input" value="jeff" type="search" class="form-control" name="search-input" placeholder="{{ __('Search by name, Email or phone number') }}" >

            </form>

            <div id="search-results"></div>

        </div>

    </div>
     <div class="provider-search-modal modals">

        <div class="provider-search-modal-inner">

            <-- USES THE SAME SEARCH CODE, PASS input_id TO /biq/find -->

            <div class="breadcrumbs"><span class="go_home"><- Home</span></div>

            <form name="provider-search-form" onsubmit="return doPatientSearch('provider-search-input');">

                <input id="provider-search-input" type="search" class="form-control" name="provider-search-input" placeholder="{{ __('Search by name, Email or phone number') }}" >

            </form>

            <div id="search-results"></div>

        </div>

    </div>
     <div class="set-vaccine-location-modal modals">

         <!-- SEARCH FOR SITES AND SET THE DEFAULT SITE(s?) FOR THE CURRENT USER -->

        <div class="set-vaccine-location-search-modal-inner">

            <div class="breadcrumbs"><span class="go_home"><- Home</span></div>

            <form name="vaccine-location-search-form" onsubmit="return doVaccineLocationSearch();">

                <input id="vaccine-location-search-input" type="search" class="form-control" name="vaccine-location-search-input" placeholder="{{ __('Search by Name, Address, City, Zip or County') }}" >

            </form>

            <div id="search-results"></div>

        </div>

    </div>
    <div class="patient-form-modal modals">

        <div class="patient-form-modal-inner">

            <div class="breadcrumbs"><span class="go_home go_link"><- Home</span> <span class="go_search go_link"> <- Search</span></div>

            <div id="patient-data">

                <div class="leftside">
                    <table class="patient-show">
                        <tr>
                            <td colspan="2" style="text-align:center;color:blue;">Personal Data</td>
                        </tr>
                        <tr>
                            <th class="flabel">First Name</th>
                            <td class="fvalue" id="first_name"></td>
                        </tr>
                        <tr>
                            <th class="flabel">Last Name</th>
                            <td class="fvalue" id="last_name"></td>
                        </tr>
                        <tr>
                            <th class="flabel">Date of Birth</th>
                            <td class="fvalue" id="date_of_birth"></td>
                        </tr>
                        <tr>
                            <th class="flabel">SSN</th>
                            <td class="fvalue" id="ssn"></td>
                        </tr>
                        <tr>
                            <th class="flabel">Driver's License</th>
                            <td class="fvalue" id="dl_number"></td>
                        </tr>
                        <tr>
                            <th class="flabel">Address Line 1</th>
                            <td class="fvalue" id="address1"></td>
                        </tr>
                        <tr>
                            <th class="flabel">Address Line 2</th>
                            <td class="fvalue" id="address2"></td>
                        </tr>
                        <tr>
                            <th class="flabel">City</th>
                            <td class="fvalue" id="city"></td>
                        </tr>
                        <tr>
                            <th class="flabel">State</th>
                            <td class="fvalue" id="state"></td>
                        </tr>
                        <tr>
                            <th class="flabel">Zipcode</th>
                            <td class="fvalue" id="zipcode"></td>
                        </tr>
                    </table>
                </div>
                <div class="rightside">
                    <table class="patient-show">
                        <tr>
                            <td colspan="2" style="text-align:center;color:blue;">Demographic Data</td>
                        </tr>
                        <tr>
                            <th class="flabel">Email Address</th>
                            <td class="fvalue" id="email"></td>
                        </tr>
                        <tr>
                            <th class="flabel">Mobile Phone Number</th>
                            <td class="fvalue" id="mphone"></td>
                        </tr>
                        <tr>
                            <th class="flabel">Home Phone Number</th>
                            <td class="fvalue" id="hphone"></td>
                        </tr>
                        <tr>
                            <th class="flabel">Birth Sex</th>
                            <td class="fvalue" id="birth_sex"></td>
                        </tr>
                        <tr>
                            <th class="flabel">Race</th>
                            <td class="fvalue" id="race"></td>
                        </tr>
                        <tr>
                            <th class="flabel">Ethnicity</th>
                            <td class="fvalue" id="ethnicity"></td>
                        </tr>
                    </table>

                    <table class="patient-show">
                        <tr>
                            <td colspan="2" style="text-align:center;color:blue;">Vaccine Schedule</td>
                        </tr>
                        <tr>
                            <th class="flabel">Location</th>
                            <td class="fvalue" id="location"></td>
                        </tr>
                        <tr>
                            <th class="flabel">Date</th>
                            <td class="fvalue" id="date"></td>
                        </tr>
                        <tr>
                            <th class="flabel">Time</th>
                            <td class="fvalue" id="time"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div style="clear:both;"></div>
            <form name="patient-form" onsubmit="return doPatientForm();">
                <input type="hidden" value="0" id="patient_id" name="id">
                <input type="submit" value="Confirm Patient" class="btn btn-primary">
            </form>
        </div>
    </div>
