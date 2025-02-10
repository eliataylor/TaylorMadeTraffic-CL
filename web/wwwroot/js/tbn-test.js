(function() {
    // Load the Google Maps API dynamically
    const script = document.createElement('script');
    script.src = `https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap`;
    script.async = true;
    document.head.appendChild(script);

    // Callback to initialize the map
    window.initMap = function() {
        // Create a div for the map
        const gmap = document.createElement('div');
        gmap.style.width = '100%';
        gmap.style.height = '300px';
        gmap.id = 'gmap';

        // Append the map div to the desired element
        const targetElement = document.querySelector("#hero-logged-in-user");
        if (targetElement) {
            targetElement.appendChild(gmap);

            // Initialize the Google Map
            const map = new google.maps.Map(gmap, {
                center: { lat: 37.7749, lng: -122.4194 }, // Example: San Francisco coordinates
                zoom: 12,
            });
        } else {
            console.error("Target element #hero-logged-in-user not found.");
        }
    };

    // Add a click event listener to the specified <h1> element
    const headerElement = document.querySelector("h1");
    if (headerElement) {
        headerElement.addEventListener("click", () => {
            const button = document.querySelector("#home-header-client button.css-wsvuba");
            if (button) {
                button.click();
            } else {
                console.error("Button with selector #home-header-client button.css-wsvuba not found.");
            }
        });
    } else {
        console.error("Header element <h1> not found.");
    }
})();