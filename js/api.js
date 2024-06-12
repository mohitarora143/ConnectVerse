async function populateCountryDropdown() {
    try {
        const response = await fetch('https://restcountries.com/v3.1/all');
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        console.log('Data fetched successfully:', data);  // Debugging line
        const countrySelect = document.getElementById('country');

        data.forEach(country => {
            if (country.name && country.name.common) {
                const option = document.createElement('option');
                option.value = country.name.common;
                option.textContent = country.name.common;
                countrySelect.appendChild(option);
            }
        });
    } catch (error) {
        console.error('Error fetching country data:', error);
    }
}

document.addEventListener('DOMContentLoaded', populateCountryDropdown);
