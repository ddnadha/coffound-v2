class PhotoSubmission {
    constructor() {
        const inputs = document.querySelectorAll(".js-photo_submit-input");

        for (var i = 0; i < inputs.length; i++) {
            // if (window.CP.shouldStopExecution(0)) break;
            inputs[i].addEventListener("change", this.uploadImage);
        }
        // window.CP.exitedLoop(0);
    }

    uploadImage(e) {
        const fileInput = e.target;
        const uploadBtn = fileInput.parentNode;
        console.log(uploadBtn);
        const deleteBtn = uploadBtn.childNodes[5];
        const reader = new FileReader();

        reader.onload = function (e) {
            uploadBtn.setAttribute(
                "style",
                `background-image: url('${e.target.result}');`
            );
            uploadBtn.classList.add("photo_submit--image");
            fileInput.setAttribute("readonly", "readonly");
        };

        reader.readAsDataURL(e.target.files[0]);
        console.log(uploadBtn.childNodes);
        deleteBtn.addEventListener("click", () => {
            uploadBtn.removeAttribute("style");
            uploadBtn.classList.remove("photo_submit--image");
            e.target.value = "";
            setTimeout(() => {
                fileInput.removeAttribute("disabled", "disabled");
            }, 200);
        });
    }
}
new PhotoSubmission();
