document
    .getElementById("featuredImage")
    .addEventListener("change", function (e) {
        var file  = e.target.files;
        console.log(file)
        const reader = new FileReader();
        // console.log(reader.result);
        reader.addEventListener("load", () => {
            document.querySelector("#featuredImageDisplay").src = reader.result;
            featuredImageDisplay.classList.remove("hidden");
        });
        reader.readAsDataURL(this.files[0]);
        
    });