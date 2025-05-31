// function to populate states dropdown
function getProvState(countryCode) {
    let provstateDropdown = document.forms["my-form"].provstate;

    if (countryCode.trim() === "") {
        provstateDropdown.disabled = true;
        provstateDropdown.selectedIndex = 0;
        return false;
    }

    fetch(`functions.php?country_code=${countryCode}`)
    .then(response => response.json())
    .then(function(provstates) {
        let out = "";
        out += `<option value="">Choose a Province/State</option>`;

        for(let provstate of provstates) {
            out += `<option value="${provstate['state']}">${provstate['state_name']}</option>`;
        }

    provstateDropdown.innerHTML = out;
    provstateDropdown.disabled = false;

    });
}

// function to populate Regions dropdown
function getRegions(stateCode) {
    let regionsDropdown = document.forms["my-form"].regions;

    if (stateCode.trim() === "") {
        regionsDropdown.disabled = true;
        regionsDropdown.selectedIndex = 0;
        return false;
    }

    fetch(`functions.php?state_code=${stateCode}`)
    .then(response => response.json())
    .then(function(regions) {
        let out = "";
        out += `<option value="">Choose a Region</option>`;

        for(let region of regions) {
            out += `<option value="${region['region']}">${region['region_name']}</option>`;
        }

    regionsDropdown.innerHTML = out;
    regionsDropdown.disabled = false;

    });
}