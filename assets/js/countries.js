document.addEventListener('DOMContentLoaded', function() {
    const countrySelect = document.getElementById('country');
    const citySelect = document.getElementById('city');
    const countriesDataUrl = '../assets/js/countries-cities.json'; 

    // Initially disable city select until a country is chosen
    citySelect.disabled = true;

    fetch(countriesDataUrl)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            data.forEach(country => {
                const option = document.createElement('option');
                option.value = country.code;
                option.textContent = country.name;
                countrySelect.appendChild(option);
            });

            countrySelect.addEventListener('change', function() {
                // Clear previous city options
                citySelect.innerHTML = '<option value="" selected disabled>Select City</option>';
                citySelect.disabled = true;

                const selectedCountryCode = this.value;
                const selectedCountry = data.find(country => country.code === selectedCountryCode);

                if (selectedCountry && selectedCountry.cities && selectedCountry.cities.length > 0) {
                    selectedCountry.cities.forEach(cityName => {
                        const cityOption = document.createElement('option');
                        cityOption.value = cityName;
                        cityOption.textContent = cityName;
                        citySelect.appendChild(cityOption);
                    });
                    citySelect.disabled = false;
                } else if (selectedCountryCode) {
                    // Handle case where a country might be listed but has no cities in the JSON
                    citySelect.innerHTML = '<option value="" selected disabled>No cities listed</option>';
                } else {
                     // "Select Country" is chosen, keep city disabled with default message
                    citySelect.disabled = true;
                }
            });
        })
        .catch(error => {
            console.error('Error fetching or processing countries data:', error);
            countrySelect.innerHTML = '<option value="" selected disabled>Error loading countries</option>';
            citySelect.innerHTML = '<option value="" selected disabled>Error loading cities</option>';
        });
});