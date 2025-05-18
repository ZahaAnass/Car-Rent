document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('addCarForm');

    form.addEventListener('submit', function(e) {
        // Get form values
        const name = document.getElementById('carName').value.trim();
        const type = document.getElementById('carType').value;
        const rate = document.getElementById('carRate').value.trim();
        const license = document.getElementById('carLicense').value.trim();
        const status = document.getElementById('carStatus').value;
        const year = document.getElementById('carYear').value.trim();
        const make = document.getElementById('carMake').value.trim();
        const model = document.getElementById('carModel').value.trim();
        const color = document.getElementById('carColor').value.trim();
        const seats = document.getElementById('carSeats').value.trim();
        const fuel = document.getElementById('carFuel').value.trim();
        const features = document.getElementById('carFeatures').value.trim();

        // Validation regexes
        const nameRegex = /^[a-zA-Z ]{2,}$/;
        const typeRegex = /^(Electric|SUV|Luxury|Economy)$/;
        const rateRegex = /^[0-9]+(\.[0-9]{1,2})?$/;
        const licenseRegex = /^[a-zA-Z0-9]{5,20}$/;
        const statusRegex = /^(Available|Unavailable)$/;
        const yearRegex = /^[0-9]{4}$/;
        const carRegex = /^[a-zA-Z ]+$/;
        const seatsRegex = /^[1-9]$/;
        const fuelRegex = /^[a-zA-Z ]+$/;
        const featuresRegex = /^[a-zA-Z0-9 ,]*$/;

        // Validate fields 
        if (!nameRegex.test(name)) {
            document.getElementById('carName').setCustomValidity('Name must be at least 2 characters and contain only letters and spaces.');
            e.preventDefault(); return false;
        } else {
            document.getElementById('carName').setCustomValidity('');
        }
        
        if (!typeRegex.test(type)) {
            document.getElementById('carType').setCustomValidity('Type must be a valid car type.');
            e.preventDefault(); return false;
        } else {
            document.getElementById('carType').setCustomValidity('');
        }
        
        if (!rateRegex.test(rate)) {
            document.getElementById('carRate').setCustomValidity('Please enter a valid price.');
            e.preventDefault(); return false;
        } else {
            document.getElementById('carRate').setCustomValidity('');
        }
        
        if (!licenseRegex.test(license)) {
            document.getElementById('carLicense').setCustomValidity('License plate must be between 5 and 20 characters and contain only letters and numbers.');
            e.preventDefault(); return false;
        } else {
            document.getElementById('carLicense').setCustomValidity('');
        }
        
        if (!statusRegex.test(status)) {
            document.getElementById('carStatus').setCustomValidity('Please select a valid status.');
            e.preventDefault(); return false;
        } else {
            document.getElementById('carStatus').setCustomValidity('');
        }
        
        if (!yearRegex.test(year)) {
            document.getElementById('carYear').setCustomValidity('Year must be a valid 4-digit year.');
            e.preventDefault(); return false;
        } else {
            document.getElementById('carYear').setCustomValidity('');
        }
        
        if (!carRegex.test(make)) {
            document.getElementById('carMake').setCustomValidity('Make must be a valid car make.');
            e.preventDefault(); return false;
        } else {
            document.getElementById('carMake').setCustomValidity('');
        }
        
        if (!carRegex.test(model)) {
            document.getElementById('carModel').setCustomValidity('Model must be a valid car model.');
            e.preventDefault(); return false;
        } else {
            document.getElementById('carModel').setCustomValidity('');
        }
        
        if (!carRegex.test(color)) {
            document.getElementById('carColor').setCustomValidity('Color must be a valid color.');
            e.preventDefault(); return false;
        } else {
            document.getElementById('carColor').setCustomValidity('');
        }
        
        if (!seatsRegex.test(seats)) {
            document.getElementById('carSeats').setCustomValidity('Seats must be between 1 and 9.');
            e.preventDefault(); return false;
        } else {
            document.getElementById('carSeats').setCustomValidity('');
        }
        
        if (!fuelRegex.test(fuel)) {
            document.getElementById('carFuel').setCustomValidity('Fuel type must be valid.');
            e.preventDefault(); return false;
        } else {
            document.getElementById('carFuel').setCustomValidity('');
        }
        
        if (features && !featuresRegex.test(features)) {
            document.getElementById('carFeatures').setCustomValidity('Features can be empty or contain only letters, numbers, commas, and spaces.');
            e.preventDefault(); return false;
        } else {
            document.getElementById('carFeatures').setCustomValidity('');
        }

        // If all validations pass, allow form submission
        return true;
    });

    // Add input event listeners to clear custom validity on input
    const inputs = [
        'carName', 'carType', 'carRate', 'carLicense', 'carStatus', 
        'carYear', 'carMake', 'carModel', 'carColor', 'carSeats', 
        'carFuel', 'carFeatures'
    ];

    inputs.forEach(id => {
        document.getElementById(id).addEventListener('input', function() {
            this.setCustomValidity('');
        });
    });
});