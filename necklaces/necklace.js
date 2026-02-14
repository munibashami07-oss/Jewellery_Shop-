document.addEventListener("DOMContentLoaded", () => {

    const searchInput = document.getElementById("search");
    const products = document.querySelectorAll(
        ".necklaces1_1, .necklaces2_1, .necklaces3_1, .necklaces4_1, .necklaces5_1, .necklaces6_1"
    );

    searchInput.addEventListener("keyup", function () {
        const value = this.value.toLowerCase();

        products.forEach(product => {
            const name = product.dataset.name.toLowerCase();

            if (name.includes(value)) {
                product.style.display = "block";   // keep layout intact
            } else {
                product.style.display = "none";
            }
        });
    });

});
